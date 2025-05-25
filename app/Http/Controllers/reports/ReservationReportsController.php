<?php

namespace App\Http\Controllers\reports;

use Barryvdh\DomPDF\PDF;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReservationReportsController extends Controller
{
    public function index() {
      $reservations = Reservation::with('venue')
            ->leftjoin('users', 'reservation.reserve_by', '=', 'users.id')
            ->where('reservation.status', '=', 1)
            ->whereNull('reservation.deleted_at')
            ->select('*', 'reservation.id as reservation_id')
            ->orderBy('reservation.updated_at', 'desc')
            ->get();

      return view('content.reports.reservationReport', compact('reservations'));
    }
}
