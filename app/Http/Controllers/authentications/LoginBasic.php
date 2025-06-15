<?php

namespace App\Http\Controllers\authentications;

use Throwable;
use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class LoginBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-login-basic');
  }
  public function login(Request $request){
    $account = User::where('username', $request->email_username)->whereNull('deleted_at')->first();

    if (!$account || !Hash::check($request->password, $account->password)) {
        $message = $account ? 'Invalid Email or Password.' : 'Account didn\'t exist.';
        return response()->json(['Error' => 1, 'Message' => $message]);
    }

    $logData = [
      'users_id' => $account->id,
      'action' => 'Login',
      'tablename' => 'Users',
      'description' => $account->firstname.' '.$account->lastname .' is Successfully login',
      'ip_address' => '127.0.0.1:8000',
      'created_at' => now(),
    ];

    $resultLogs = Log::create($logData);
    Auth::login($account);

    if(Auth::user()->role == 'Admin' || Auth::user()->role == 'Employee'){
      return response()->json(['Error' => 0, 'Message' => 'Successfully login', 'Redirect' => route('dashboard-analytics')]);
    }
    if(Auth::user()->role == 'User'){
      return response()->json(['Error' => 0, 'Message' => 'Successfully login', 'Redirect' => route('home')]);
    }
  }
  public function logoutAccount(Request $request)
  {
    $account = User::where('id', Auth::id())->first();
    $logData = [
      'users_id' => Auth::id(),
      'action' => 'Logout',
      'tablename' => 'Users',
      'description' => $account->firstname.' '.$account->lastname .' is Successfully logout',
      'ip_address' => request()->ip(),
      'created_at' => now(),
    ];

    $resultLogs = Log::create($logData);
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
  }

  public function redirect($provider)
  {
      return Socialite::driver($provider)->redirect();
  }

  public function callback($provider)
  {
    try {
        $user = Socialite::driver($provider)->stateless()->user();
    } catch (Throwable $e) {
      return redirect('/login')->with('error', 'Authentication failed.');
    }

    $fullName = $user->getName(); // e.g., "John Doe"
    $names = explode(' ', $fullName, 2); // Split into first and last name
    $firstname = $names[0] ?? '';
    $lastname = $names[1] ?? '';

    $existingUser = User::where('email', $user->getEmail())->first();

    if ($existingUser) {
        $logData = [
            'users_id' => $existingUser->id,
            'action' => 'Login using '.$provider,
            'tablename' => 'Users',
            'description' => $fullName.' successfully logged in.',
            'ip_address' => request()->ip(),
            'created_at' => now(),
        ];
        Log::create($logData);

        Auth::login($existingUser);
    } else {
        $newUser = User::updateOrCreate([
            'email' => $user->getEmail()
        ], [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'middlename' => '', // Optional: can be parsed separately
            'username' => $user->getNickname() ?? $user->getEmail(),
            'role' => 'User',
            'created_at' => now(),
        ]);

        $logData = [
            'users_id' => $newUser->id,
            'action' => 'Adding a user and login using '.$provider,
            'tablename' => 'Users',
            'description' => 'Added and logged in '.$fullName,
            'ip_address' => request()->ip(),
            'created_at' => now(),
        ];
        Log::create($logData);

        Auth::login($newUser);
    }

    if (Auth::user()->role === 'Admin' || Auth::user()->role === 'Employee') {
      return redirect('/admin/analytics')->with('login_success', 'You have successfully logged in.');
    }

    if (Auth::user()->role === 'User') {
      return redirect('/')->with('login_success', 'You have successfully logged in.');
    }
  }
}
