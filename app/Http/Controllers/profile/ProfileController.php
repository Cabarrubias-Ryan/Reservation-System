<?php

namespace App\Http\Controllers\profile;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
      $data = User::where('id', auth()->user()->id)->first();
      return view('content.user-profile.profile', compact('data'));
    }
    public function reservation(Request $request)
    {
      Reservation::where('status', 0) // adjust status as needed
            ->where('created_at', '<', Carbon::now()->subHours(1))
            ->whereNull('deleted_at')
            ->update([
                'status' => 2,       // 0 = pending, 1 = approved, 2 = rejected, 3 = canceled
            ]);
        $reservations = Reservation::with('venue')
            ->leftjoin('users', 'reservation.reserve_by', '=', 'users.id')
            ->where('users.id', auth()->user()->id)
            ->whereNull('reservation.deleted_at')
            ->select('*', 'reservation.id as reservation_id')
            ->orderBy('reservation.updated_at', 'desc')
            ->get();

      return view('content.user-profile.user-reservation', compact('reservations'));
    }
}
