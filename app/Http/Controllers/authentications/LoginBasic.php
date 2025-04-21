<?php

namespace App\Http\Controllers\authentications;

use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-login-basic');
  }
  public function login(Request $request){
    $account = User::where('username', $request->email_username)->first();

    if (!$account || !Hash::check($request->password, $account->password)) {
        return response()->json(['Error' => 1, 'Message' => 'Invalid Email or Password.']);
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
    return response()->json(['Error' => 0, 'Redirect' => route('dashboard-analytics')]);
  }
  public function logoutAccount(Request $request)
  {
    $account = User::where('id', Auth::id())->first();
    $logData = [
      'users_id' => Auth::id(),
      'action' => 'Logout',
      'tablename' => 'Users',
      'description' => $account->firstname.' '.$account->lastname .' is Successfully logout',
      'ip_address' => '127.0.0.1:8000',
      'created_at' => now(),
    ];

    $resultLogs = Log::create($logData);
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
  }
}
