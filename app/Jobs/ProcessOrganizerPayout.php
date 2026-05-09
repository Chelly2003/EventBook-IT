<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Safaricom\Mpesa\Mpesa;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class ProcessOrganizerPayout implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function handle()
    {
        $organizer = $this->booking->event->organizer;
        $payoutMethod = $organizer->payoutMethods()->where('type', 'mpesa')->first();

        if (!$payoutMethod) {
            Log::warning('No M-PESA payout method for organizer', ['organizer_id' => $organizer->id]);
            return;
        }

        $mpesa = new Mpesa();

        $timestamp = now()->format('YmdHis');
        $password = base64_encode(env('MPESA_B2C_SHORTCODE') . env('MPESA_B2C_PASSWORD') . $timestamp);

        $response = $mpesa->B2C(
            env('MPESA_B2C_INITIATOR'),
            $password,
            'BusinessPayment',
            $this->booking->organizer_amount,
            env('MPESA_B2C_SHORTCODE'),
            '254' . substr($payoutMethod->mpesa_phone, 1),
            'Payout for booking #' . $this->booking->id,
            env('MPESA_B2C_RESULT_URL'),
            env('MPESA_B2C_TIMEOUT_URL'),
            'Event Payout'
        );

        $responseData = json_decode($response, true);

        if ($responseData['ResponseCode'] === '0') {
            $this->booking->update(['payout_status' => 'sent']);
            Log::info('B2C Payout Initiated', ['response' => $responseData]);
        } else {
            $this->booking->update(['payout_status' => 'failed']);
            Log::error('B2C Payout Failed', ['response' => $responseData]);
        }
    }
}
