<?php

namespace App\Http\Controllers\Organiser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Safaricom\Mpesa\Mpesa;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function initiateMpesaPayment(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'phone' => 'required|digits:10|starts_with:07',
        ]);

        $booking = Booking::findOrFail($request->booking_id);
        $phone = '254' . substr($request->phone, 1); // format to 2547...

        $mpesa = new Mpesa();
        $timestamp = now()->format('YmdHis');
        $password = base64_encode(env('MPESA_SHORTCODE') . env('MPESA_PASSKEY') . $timestamp);

        $response = $mpesa->STKPushSimulation(
            env('MPESA_SHORTCODE'),
            $password,
            $timestamp,
            'CustomerPayBillOnline',
            $booking->total_amount,
            $phone,
            env('MPESA_SHORTCODE'),
            $phone,
            env('MPESA_CALLBACK_URL'),
            'Booking-' . $booking->id,
            'Payment for event ticket'
        );

        $responseData = json_decode($response, true);

        if ($responseData['ResponseCode'] === '0') {
            $booking->update([
                'status' => 'pending',
                'checkout_id' => $responseData['CheckoutRequestID'],
            ]);
            return response()->json(['message' => 'STK Push sent! Check your phone.']);
        }

        return response()->json(['message' => 'Failed to initiate payment.'], 500);
    }

    public function mpesaCallback(Request $request)
    {
        Log::info('M-PESA Callback', $request->all());

        $data = $request->all()['Body']['stkCallback'] ?? null;
        if (!$data) return response()->json(['ResultCode' => 0]);

        if ($data['ResultCode'] != 0) return response()->json(['ResultCode' => 0]); // failed

        $metadata = collect($data['CallbackMetadata']['Item']);
        $amount = $metadata->firstWhere('Name', 'Amount')['Value'];
        $receipt = $metadata->firstWhere('Name', 'MpesaReceiptNumber')['Value'];
        preg_match('/Booking-(\d+)/', $data['AccountReference'], $matches);
        $booking = Booking::find($matches[1] ?? 0);

        if (!$booking) return response()->json(['ResultCode' => 0]);

        // Update booking as paid
        $booking->update([
            'status' => 'paid',
            'mpesa_receipt' => $receipt,
        ]);

        return response()->json(['ResultCode' => 0]);
    }
}
