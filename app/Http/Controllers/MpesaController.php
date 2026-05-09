<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Safaricom\Mpesa\Mpesa;

class MpesaController extends Controller
{
    public function stkPush()
    {
        $mpesa = new Mpesa([
            'consumerKey' => env('MPESA_CONSUMER_KEY'),    // from sandbox app
            'consumerSecret' => env('MPESA_CONSUMER_SECRET'),
            'environment' => 'sandbox',
        ]);

        // Timestamp in YYYYMMDDHHMMSS
        $timestamp = now()->format('YmdHis');

        // Your Lipa na Mpesa Online passkey from the sandbox
        $passkey = env('MPESA_PASSKEY');

        // Shortcode
        $shortcode = '174379'; // sandbox till number

        try {
           $stkPush = $mpesa->STKPushSimulation(
    $shortcode,                               // BusinessShortCode
    base64_encode($shortcode . $passkey . $timestamp), // Password
    $timestamp,                               // Timestamp
    'CustomerPayBillOnline',                   // TransactionType
    1,                                        // Amount
    '254711212971',                            // PartyA (phone sending money)
    $shortcode,                                // PartyB (till number)
    '254711212971',                            // PhoneNumber
    'https://arthrodiran-xochitl-unsued.ngrok-free.dev/mpesa/callback', // CallBackURL
    'Test123',                                 // AccountReference
    'Testing STK Push'                         // TransactionDesc
);

            return response()->json($stkPush);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function handleCallback(Request $request)
    {
        \Log::info('Mpesa Callback:', $request->all()); // logs payload to storage/logs/laravel.log
        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted']);
    }
}
