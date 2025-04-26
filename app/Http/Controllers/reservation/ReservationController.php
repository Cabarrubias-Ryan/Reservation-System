<?php

namespace App\Http\Controllers\reservation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReservationController extends Controller
{
    public function index()
    {
        return view('content.reservation.reservation');
    }
}
