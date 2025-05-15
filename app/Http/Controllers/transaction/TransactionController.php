<?php

namespace App\Http\Controllers\transaction;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function index(){
      $payments = Payment::
      leftjoin('users', 'users.id', '=', 'payment.users_id')->get();

      return view('content.transaction.transaction', compact('payments'));
    }
}
