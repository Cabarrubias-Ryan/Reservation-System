<?php

namespace App\Http\Controllers\calendar;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CalendarController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('venue')
        ->leftjoin('users', 'reservation.reserve_by', '=', 'users.id')
        ->whereNull('reservation.deleted_at')
        ->get()->map(function ($data) {
              return [
                  'title' => $data->venue->name, // customize title
                  'start' => date('Y-m-d', strtotime($data->check_in)),
                  'end'   => date('Y-m-d', strtotime($data->check_out . ' +1 day')), // optional +1 day for FullCalendar
              ];
          });
      return view('content.calendar.reservation_calendar', compact('reservations'));
    }
}
