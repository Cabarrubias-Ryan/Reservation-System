<?php

namespace App\Http\Controllers\payment;

use Stripe\StripeClient;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $cancel_url = route('home');

        // Extract data from the form
        $venueId = $request->venueId;
        $venueName = $request->venueName;
        $checkinDate = $request->checkin;
        $checkoutDate = $request->checkout;
        $numberOfDays = $request->dayDifference;
        $pricePerDay = $request->price;
        $totalPrice = $request->totalPrice;

        // Create a new Stripe Checkout session
        $response = $stripe->checkout->sessions->create([
            'success_url' => $success_url,
            'cancel_url' => $cancel_url,
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'php',
                        'product_data' => [
                            'name' => 'Venue Reservation: ' . $venueName,
                            'description' => "Check-in:". $checkinDate ."| Check-out:". $checkoutDate,
                        ],
                        'unit_amount' => 100 * 100, // in cents
                    ],
                    'quantity' => 3,
                ],
            ],
            'mode' => 'payment',
            'metadata' => [
                'venue_id' => $venueId,
                'checkin' => $checkinDate,
                'checkout' => $checkoutDate,
                'total_price' => 3000,
            ],
        ]);

        // Redirect the user to the Stripe payment page
        return redirect($response['url']);
    }
    public function success(Request $request)
    {
      dd($request->all());
    }
}
