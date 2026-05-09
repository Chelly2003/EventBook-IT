<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Event;
use App\Models\Booking;
use App\Models\BookingItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function show(Event $event)
    {
        return view('frontend.pages.checkout', compact('event'));
    }

    public function process(Request $request, Event $event)
    {
       if (($event->price ?? 0) > 0) {
    $request->validate([
        'phone'    => 'required|digits:9|starts_with:7',
        'quantity' => 'required|integer|min:1|max:10',
    ]);
} else {
    $request->validate([
        'quantity' => 'required|integer|min:1|max:10',
    ]);
}
        $user = auth()->user();
        $phone = '254' . ltrim($request->phone, '0');
        $quantity = (int) $request->quantity;
        $unitPrice = $event->price ?? 0;
        $totalAmount = $quantity * $unitPrice;

        // Create or get pending booking
        $booking = Booking::firstOrCreate(
            [
                'user_id'  => $user->id,
                'event_id' => $event->id,
                'status'   => 'PENDING'
            ],
            [
                'booking_code'   => Str::upper(Str::random(10)),
                'total_amount'   => $totalAmount,
                'payment_method' => $unitPrice > 0 ? 'mpesa' : 'free',
                'quantity'       => $quantity,
                'heard_from'     => $request->heard_from
            ]
        );

        // FREE EVENT → redirect immediately
        if ($totalAmount <= 0) {
            BookingItem::firstOrCreate([
                'booking_id' => $booking->id,
                'item_name'  => 'Regular Ticket',
            ], [
                'ticket_type' => 'regular',
                'quantity'    => $quantity,
                'price'       => 0,
                'subtotal'    => 0,
                'heard_from'  => $request->heard_from
            ]);

            $booking->update(['status' => 'PAID']);

            return redirect()->route('booking.confirmed', $booking->id)
                             ->with('success', 'Free event booking confirmed!');
        }

        // PAID EVENT → initiate M-Pesa STK
               // PAID EVENT → initiate M-Pesa STK
        if (!$booking->mpesa_checkout_id) {
            $stk = $this->initiateStkPush($phone, $totalAmount, $booking->id);

            if (!($stk['success'] ?? false)) {
                return back()->with('error', 'Failed to initiate M-Pesa payment. Try again.');
            }

           $booking->update(['mpesa_checkout_id' => $stk['CheckoutRequestID']]);
        }

      // NEW - More reliable way
return redirect()->route('checkout.show', [
    'event' => $event,
    'booking_id' => $booking->id   // Pass directly in URL
])
->with('info', 'Please complete the payment on your phone. Check your phone for the M-Pesa prompt.');
    }

    private function initiateStkPush($phone, $amount, $bookingId)
    {
        $consumerKey    = env('MPESA_CONSUMER_KEY');
        $consumerSecret = env('MPESA_CONSUMER_SECRET');
        $shortcode      = env('MPESA_SHORTCODE');
        $passkey        = env('MPESA_PASSKEY');
        $callbackUrl    = env('MPESA_CALLBACK_URL');

        $credentials = base64_encode("$consumerKey:$consumerSecret");

        $tokenResp = Http::withHeaders(['Authorization' => "Basic $credentials"])
                         ->get('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');

        $accessToken = $tokenResp->json()['access_token'] ?? null;
        if (!$accessToken) {
            Log::error('M-Pesa token failed', (array) $tokenResp->json());
            return ['success' => false];
        }

        $timestamp = date('YmdHis');
        $password  = base64_encode($shortcode . $passkey . $timestamp);

        $stkResp = Http::withToken($accessToken)->post(
            'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest',
            [
                'BusinessShortCode' => $shortcode,
                'Password'          => $password,
                'Timestamp'         => $timestamp,
                'TransactionType'   => 'CustomerPayBillOnline',
                'Amount'            => round($amount),
                'PartyA'            => $phone,
                'PartyB'            => $shortcode,
                'PhoneNumber'       => $phone,
                'CallBackURL'       => $callbackUrl,
                'AccountReference'  => "Event-{$bookingId}",
                'TransactionDesc'   => 'Event Ticket',
            ]
        );

        $data = $stkResp->json() ?? [];
        Log::info('STK Push Response', (array) $data);

        return [
            'success' => ($data['ResponseCode'] ?? '') === '0',
            'CheckoutRequestID' => $data['CheckoutRequestID'] ?? null,
        ];
    }

    public function mpesaCallback(Request $request)
{
    $raw = $request->getContent();
    Log::info('M-Pesa Callback Received', ['raw' => $raw]);

    $data = json_decode($raw, true);
    $stk = $data['Body']['stkCallback'] ?? null;

    if (!$stk || empty($stk['CheckoutRequestID'])) {
        return response()->json(['ResultCode' => 0]);
    }

    $booking = Booking::where('mpesa_checkout_id', $stk['CheckoutRequestID'])->first();

    if (!$booking) {
        Log::warning('Booking not found for checkout ID', ['id' => $stk['CheckoutRequestID']]);
        return response()->json(['ResultCode' => 0]);
    }

    DB::transaction(function () use ($booking, $stk) {
        if (($stk['ResultCode'] ?? 1) == 0) {
            $items = collect($stk['CallbackMetadata']['Item'] ?? []);
            $receipt = $items->firstWhere('Name', 'MpesaReceiptNumber')['Value'] ?? null;

            $booking->update([
                'status'        => 'PAID',
                'mpesa_receipt' => $receipt,
            ]);

            BookingItem::firstOrCreate([
                'booking_id' => $booking->id,
                'item_name'  => 'Regular Ticket'
            ], [
                'ticket_type' => 'regular',
                'quantity'    => $booking->quantity,
                'price'       => $booking->total_amount / max($booking->quantity, 1),
                'subtotal'    => $booking->total_amount,
                'heard_from'  => $booking->heard_from ?? '',
            ]);
        } else {
            $booking->update(['status' => 'FAILED']);
        }
    });

    return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted']);
}

    public function checkPaymentStatus(Booking $booking)
    {
        $booking->refresh();
        return response()->json([
            'status'     => $booking->status,
            'booking_id' => $booking->id,
            'receipt'    => $booking->mpesa_receipt
        ]);
    }
}
