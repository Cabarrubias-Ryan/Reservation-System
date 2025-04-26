<?php

namespace App\Http\Controllers\authentications;

use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterUser extends Controller
{
    public function index()
    {
        return view('content.authentications.auth-register-user');
    }
    public function store(Request $request)
    {
      $logData = [
        'users_id' => 1,
        'action' => 'Create a account',
        'tablename' => 'Users',
        'description' => 'Added a user account that name '.$request->firstname.' '.$request->lastname,
        'ip_address' => request()->ip(),
        'created_at' => now(),
      ];

      $resultLogs = Log::create($logData);
      $userData = [
        'firstname' => $request->firstname,
        'middlename' => $request->middlename,
        'lastname' => $request->lastname,
        'role' => 'User',
        'username' => $request->username,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'created_at' => now(),
        'logs_id' => $resultLogs->id
      ];

      $resultUser = User::insert($userData);

      if($resultUser){
        return response()->json(['Error' => 0, 'Message' => 'Successfully created a Account', 'Redirect' => route('login')]);
      }
    }
}
