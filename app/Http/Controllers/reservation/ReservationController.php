<?php

namespace App\Http\Controllers\reservation;

use Carbon\Carbon;
use App\Models\Log;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        Reservation::where('status', 0) // adjust status as needed
            ->where('created_at', '<', Carbon::now()->subHours(2))
            ->whereNull('deleted_at')
            ->update([
                'status' => 2,       // 0 = pending, 1 = approved, 2 = rejected, 3 = canceled
            ]);
        $reservations = Reservation::with('venue')
            ->leftjoin('users', 'reservation.reserve_by', '=', 'users.id')
            ->where('status', 1)
            ->whereNull('reservation.deleted_at')
            ->orderBy('reservation.created_at', 'desc')
            ->get();
        return view('content.reservation.reservation', compact('reservations'));
    }
    public function store(Request $request)
    {
      $logData = [
        'users_id' => Auth::id(),
        'action' => 'Reserve',
        'tablename' => 'Reservation',
        'description' => 'Added a reservation',
        'ip_address' => request()->ip(),
        'created_at' => now(),
      ];

      $resultLogs = Log::create($logData);

      $reservationData = [
        'name' => Auth::user()->firstname . ' ' . Auth::user()->lastname,
        'email' => Auth::user()->email,
        'check_in' => $request->checkin,
        'check_out' => $request->checkout,
        'number_of_days' => $request->dayDifference,
        'amount' => $request->totalPrice,
        'status' => 0,
        'reserve_by' => Auth::id(),
        'isConfirm' => 0,
        'created_at' => now(),
        'updated_at' => now(),
        'logs_id' => $resultLogs->id,
        'venues_id' => $request->venueId
      ];

      $reservation = Reservation::create($reservationData);
      if ($reservation) {
        return response()->json(['Error' => 0, 'Message' => 'Successfully reserve a data', 'data' => $reservation->id]);
      }
    }
}
