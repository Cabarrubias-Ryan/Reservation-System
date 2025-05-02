<?php

namespace App\Http\Controllers\authentications;

use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class RegisterBasic extends Controller
{
  public function index()
  {
    $users = User::orderBy('id', 'DESC')->whereNull('deleted_at')->get();
    return view('content.accounts.auth-register-basic', compact('users'));
  }
  public function store(Request $request){

    $logData = [
      'users_id' => Auth::id(),
      'action' => 'Add',
      'tablename' => 'Users',
      'description' => 'Added a admin user that name '.$request->firstname.' '.$request->lastname,
      'ip_address' => request()->ip(),
      'created_at' => now(),
    ];

    $resultLogs = Log::create($logData);
    $userData = [
      'firstname' => $request->firstname,
      'middlename' => $request->middlename,
      'lastname' => $request->lastname,
      'role' => 'Admin',
      'username' => $request->username,
      'email' => $request->email,
      'password' => bcrypt($request->password),
      'created_at' => now(),
      'logs_id' => $resultLogs->id
    ];

    $resultUser = User::insert($userData);

    if($resultUser){
      return response()->json(['Error' => 0, 'Message' => 'Successfully added a data']);
    }
  }
  public function update(Request $request){
    $logData = [
      'users_id' => Auth::id(),
      'action' => 'Update',
      'tablename' => 'Users',
      'description' => 'Update the account',
      'ip_address' => request()->ip(),
      'created_at' => now(),
    ];

    $resultLogs = Log::insert($logData);
    $userData = [
      'firstname' => $request->firstname,
      'middlename' => $request->middlename,
      'lastname' => $request->lastname,
      'username' => $request->username,
      'email' => $request->email,
    ];

    $resultUser = User::where('id', Crypt::decryptString($request->id))->update($userData);

    if($resultUser){
      return response()->json(['Error' => 0, 'Message' => 'Successfully update a data']);
    }
  }
  public function delete(Request $request){

    $logData = [
      'users_id' => Auth::id(),
      'action' => 'Delete',
      'tablename' => 'Users',
      'description' => 'Delete a account',
      'ip_address' => request()->ip(),
      'created_at' => now(),
    ];

    $resultLogs = Log::insert($logData);
    $userData = [
      'deleted_at' => now()
    ];

    $resultUser = User::where('id', Crypt::decryptString($request->id))->update($userData);

    if($resultUser){
      return response()->json(['Error' => 0, 'Message' => 'Successfully delete a data']);
    }
  }
}
