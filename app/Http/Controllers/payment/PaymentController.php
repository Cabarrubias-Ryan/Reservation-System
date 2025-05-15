<?php

namespace App\Http\Controllers\payment;

use App\Models\Log;
use App\Models\Payment;
use Stripe\StripeClient;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $reservation = Reservation::with('venue')
            ->where('reservation.id', $request->id)
            ->whereNull('reservation.deleted_at')
            ->first();

        return view('content.payment.payment-reservation', compact('reservation'));
    }
    public function payment(Request $request)
    {
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $success_url = route('payment-success').'?session_id={CHECKOUT_SESSION_ID}';
        $cancel_url = route('profile-reservation');

        // Extract data from the form
        $reservationId = $request->reservationId;
        $venueId = $request->venueId;
        $venueName = $request->venueName;
        $checkinDate = $request->checkin;
        $checkoutDate = $request->checkout;
        $numberOfDays = $request->dayDifferenceRaw;
        $pricePerDay = $request->priceRaw;
        $totalPrice = $request->totalPriceRaw;

        // Create a new Stripe Checkout session
        $response = $stripe->checkout->sessions->create([
            'success_url' => $success_url,
            'cancel_url' => $cancel_url,
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'php',
                        'product_data' => [
                            'name' => 'Venue Reservation: ' . $venueName,
                            'description' =>"Date: ". $checkinDate ." - ". $checkoutDate,
                        ],
                        'unit_amount' => $pricePerDay * 100, // in cents
                    ],
                    'quantity' => $numberOfDays,
                ],
            ],
            'mode' => 'payment',
            'metadata' => [
                'venue_id' => $venueId,
                'checkin' => $checkinDate,
                'checkout' => $checkoutDate,
                'total_price' => $totalPrice,
            ],
        ]);
        $logData = [
          'users_id' => Auth::id(),
          'action' => 'Payment',
          'tablename' => 'Payment',
          'description' => 'Pay the reservation using online payment',
          'ip_address' => request()->ip(),
          'created_at' => now(),
        ];
        $resultLogs = Log::create($logData);

        $reservationData = [
          'status' => 1,
          'isConfirm' => 1,
        ];
        Reservation::where('id', $request->reservationId)->update($reservationData);
        $paymentData = [
          'payment_method' => 'Stripe',
          'amount' => $totalPrice,
          'isCard' => 1,
          'created_at' => now(),
          'reservation_id' => $request->reservationId,
          'users_id' => Auth::id(),
        ];
        $resultPayment = Payment::insert($paymentData);
        // Redirect the user to the Stripe payment page
        return redirect($response['url']);
    }
    public function success(Request $request)
    {
      $stripe = new StripeClient(env('STRIPE_SECRET'));
      $response = $stripe->checkout->sessions->retrieve($request->session_id, []);
      return redirect()->route('profile-reservation')->with('success-payment', 'Payment successful! Your reservation is confirmed.');
    }
}
