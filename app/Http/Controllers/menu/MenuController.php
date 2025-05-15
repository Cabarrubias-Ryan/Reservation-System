<?php

namespace App\Http\Controllers\menu;

use App\Models\Venue;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $venues = Venue::with(['reservation', 'picture'])
            ->whereNull('venues.deleted_at');

        $startDate = $request->input('start');
        $endDate = $request->input('end');

        if ($startDate && $endDate) {
            $startDateFormatted = date('Y-m-d', strtotime($startDate));
            $endDateFormatted = date('Y-m-d', strtotime($endDate));

            $venues = $venues->whereDoesntHave('reservation', function ($query) use ($startDateFormatted, $endDateFormatted) {
                $query->where('status',1) // Only check confirmed reservations
                      ->where(function ($q) use ($startDateFormatted, $endDateFormatted) {
                          $q->whereRaw("
                              STR_TO_DATE(check_in, '%M %d, %Y') BETWEEN ? AND ?
                              OR STR_TO_DATE(check_out, '%M %d, %Y') BETWEEN ? AND ?
                              OR (? BETWEEN STR_TO_DATE(check_in, '%M %d, %Y') AND STR_TO_DATE(check_out, '%M %d, %Y'))
                              OR (? BETWEEN STR_TO_DATE(check_in, '%M %d, %Y') AND STR_TO_DATE(check_out, '%M %d, %Y'))
                          ", [
                              $startDateFormatted, $endDateFormatted,
                              $startDateFormatted, $endDateFormatted,
                              $startDateFormatted,
                              $endDateFormatted,
                          ]);
                      });
            });
        }


        if ($request->filter === 'highest') {
            $venues = $venues->orderBy('price', 'desc');
        } elseif ($request->filter === 'lowest') {
            $venues = $venues->orderBy('price', 'asc');
        }

        $venues = $venues->get();
        return view('content.menu.menu', compact('venues'));
    }
    public function viewDetails($id){
      $venue = Venue::with('picture')
      ->where('id',Crypt::decryptString($id))
      ->first();

      $reservations = Reservation::leftjoin('venues', 'venues.id', '=', 'reservation.venues_id')
        ->leftjoin('users', 'reservation.reserve_by', '=', 'users.id')
        ->where('venues.id',Crypt::decryptString($id))
        ->where('status', 1)
        ->whereNull('reservation.deleted_at')
        ->get()->map(function ($data) {
              return [
                  'title' => 'Reserve', // customize title
                  'start' => date('Y-m-d', strtotime($data->check_in)),
                  'end'   => date('Y-m-d', strtotime($data->check_out . ' +1 day')), // optional +1 day for FullCalendar
              ];
          });

      return view('content.menu.details',compact('venue','reservations'));
    }
}
