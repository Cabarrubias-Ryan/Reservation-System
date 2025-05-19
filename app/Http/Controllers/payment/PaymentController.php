<?php

namespace App\Http\Controllers\payment;

use App\Models\Log;
use App\Models\Payment;
use Stripe\StripeClient;
use App\Models\Reservation;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\VoucherDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
      $today = now()->toDateString();
        $reservation = Reservation::with('venue')
            ->where('reservation.id', $request->id)
            ->whereNull('reservation.deleted_at')
            ->first();

        $voucher = VoucherDetails::leftJoin('vouchers', 'vouchers.id', '=', 'vouchers_details.vouchers_id')
          ->whereNull('deleted_at')
          ->where('vouchers_details.users_id', '=', Auth::id())
          ->where('vouchers_details.use', '=', 0)
          ->select('vouchers.*', 'vouchers_details.*', 'vouchers_details.use as used')
          ->get()
          ->map(function ($item) use ($today) {
              $item->is_expired = $item->expire_date < $today;
              return $item;
          });

        return view('content.payment.payment-reservation', compact('reservation', 'voucher'));
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
        $discount = $request->discount;

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
                            'description' => "Date: " . $checkinDate . " - " . $checkoutDate,
                        ],
                        'unit_amount' => $pricePerDay * 100, // in cents
                    ],
                    'quantity' => $numberOfDays,
                ],
            ],
            'mode' => 'payment',
            'metadata' => [
                'reservation_id' => $reservationId,
                'venue_id' => $venueId,
                'checkin' => $checkinDate,
                'checkout' => $checkoutDate,
                'total_price' => $totalPrice,
                'discount' => $discount,
            ],
        ]);

        // Redirect the user to the Stripe payment page
        return redirect($response['url']);
    }

    public function success(Request $request)
    {
        // Retrieve session details
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $session = $stripe->checkout->sessions->retrieve($request->session_id);

        // Check if payment is successful
        if ($session->payment_status === 'paid') {
            // Retrieve metadata (reservation details)
            $metadata = $session->metadata;
            $metadata->discount == null ? $discount = 0 : $discount = $metadata->discount;

            $data = VoucherDetails::leftjoin('vouchers', 'vouchers.id', '=', 'vouchers_details.vouchers_id')->where('vouchers_details.id', '=', $metadata->discount)->first();
             VoucherDetails::where('id',$discount)->update([
                'use' => 1
              ]);
              empty($data->code)?  $code='' : $code = $data->code;
              empty($data->discount)? $discount=null : $discount = $data->discount;
            // Update reservation status
            Reservation::where('id', $metadata->reservation_id)->update([
                'status' => 1,
                'isConfirm' => 1,
                'amount' => $metadata->total_price,
            ]);

            // Log the payment
            Payment::insert([
                'payment_method' => 'Stripe',
                'payment_code' => Str::random(16),
                'vouchers_code' => $code,
                'discount' => $discount,
                'amount' => $metadata->total_price,
                'isCard' => 1,
                'created_at' => now(),
                'reservation_id' => $metadata->reservation_id,
                'users_id' => Auth::id(),
            ]);

            // Log user action
            Log::create([
                'users_id' => Auth::id(),
                'action' => 'Payment',
                'tablename' => 'Payment',
                'description' => 'Pay the reservation using online payment',
                'ip_address' => request()->ip(),
                'created_at' => now(),
            ]);

            return redirect()->route('profile-reservation', ['id' => $metadata->reservation_id])
                         ->with('success-payment', 'Payment successful! Your reservation is confirmed.');
        }
        // If payment is not successful, redirect back to the reservation page
        return redirect()->route('profile-reservation')->with('error-payment', 'Payment failed. Please try again.');
    }
    public function generateReceipt(Request $request)
    {
        // Fetch reservation, payment, and venue details
        $reservation = Reservation::leftJoin('payment', 'payment.reservation_id', '=', 'reservation.id')
                                    ->leftJoin('venues', 'venues.id', '=', 'reservation.venues_id')
                                    ->select('venues.*', 'payment.*', 'reservation.*', 'venues.name as VenueName')
                                    ->where('reservation.id', $request->id)
                                    ->first();

        // Check if reservation is found
        if (!$reservation) {
            return response()->json(['error' => 'Reservation not found.'], 404);
        }

        // Fetch the amenities as an array

        $pdf = PDF::loadView('pdf.reciept', compact('reservation'));
        $pdf->setPaper('A4', 'portrait');

        // Stream the generated PDF to the browser
        return $pdf->stream('reservation_receipt.pdf');
    }


}
