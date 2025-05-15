<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservationReportsController extends Controller
{
    public function index() {
      return view('content.reports.reservationReport');
    }
}
