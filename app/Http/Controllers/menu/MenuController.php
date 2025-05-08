<?php

namespace App\Http\Controllers\menu;

use App\Models\Venue;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class MenuController extends Controller
{
    public function index(){
      $venues = Venue::with('picture')
      ->whereNull('deleted_at')
      ->get();

      $pricesRange = Venue::whereNull('deleted_at')
      ->select('price')
      ->get()
      ->map(function ($venue) {
          return [
              'min' => Venue::min('price'),
              'max' => Venue::max('price'),
          ];
      });
      $pricesRange = $pricesRange->first();

      return view('content.menu.menu',compact('venues', 'pricesRange'));
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
