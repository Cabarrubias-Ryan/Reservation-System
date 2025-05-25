<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Analytics extends Controller
{
  public function index()
  {
    $amountReservation = Payment::orderBy('created_at', 'Desc')->get();
    $reservations = Reservation::with('venue')
            ->leftjoin('users', 'reservation.reserve_by', '=', 'users.id')
            ->whereNull('reservation.deleted_at')
            ->orderBy('reservation.updated_at', 'Desc')
            ->limit(8)
            ->get();
    $payment = Payment::orderBy('created_at', 'Desc')
            ->limit(3)
            ->get();
    $amount = Payment::sum('amount');
    return view('content.dashboard.dashboards-analytics', compact('reservations','payment', 'amount', 'amountReservation'));
  }
}
