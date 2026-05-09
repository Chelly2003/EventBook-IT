<?php

namespace App\Services;

use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;
use Illuminate\Support\Facades\Log;

class TwilioVerify
{
    protected $client;
    protected $serviceSid;

    public function __construct()
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $this->serviceSid = env('TWILIO_VERIFY_SERVICE_SID');

        if (!$sid || !$token || !$this->serviceSid) {
            Log::error('Twilio Verify configuration missing');
            throw new \Exception('Twilio Verify is not configured properly.');
        }

        $this->client = new Client($sid, $token);
    }

    /**
     * Send OTP to a phone number (with retry)
     */
    public function sendOtp(string $phone)
    {
        $phone = $this->formatPhone($phone);

        for ($attempt = 1; $attempt <= 2; $attempt++) {
            try {
                $verification = $this->client->verify->v2->services($this->serviceSid)
                    ->verifications
                    ->create($phone, "sms");

                Log::info('Twilio OTP sent', [
                    'phone' => $phone,
                    'status' => $verification->status,
                    'attempt' => $attempt
                ]);

                return $verification;
            } catch (TwilioException $e) {
                Log::warning('Twilio send OTP failed (attempt ' . $attempt . ')', [
                    'phone' => $phone,
                    'error' => $e->getMessage(),
                ]);

                if ($attempt === 2) {
                    throw $e; // rethrow on final attempt
                }
            }
        }
    }

    /**
     * Check OTP entered by user
     */
    public function checkOtp(string $phone, string $code)
    {
        $phone = $this->formatPhone($phone);

        try {
            $check = $this->client->verify->v2->services($this->serviceSid)
                ->verificationChecks
                ->create([
                    'to' => $phone,
                    'code' => $code
                ]);

            Log::info('Twilio OTP check', [
                'phone' => $phone,
                'status' => $check->status,
                'valid' => $check->status === 'approved'
            ]);

            return $check;
        } catch (TwilioException $e) {
            Log::error('Twilio OTP check failed', [
                'phone' => $phone,
                'code' => $code,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * Format phone number to international format
     */
    protected function formatPhone(string $phone): string
    {
        $phone = trim($phone);

        // Remove any spaces, dashes, etc.
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // If starts with 0, replace with 254
        if (str_starts_with($phone, '0')) {
            $phone = '254' . substr($phone, 1);
        }

        // Ensure + prefix for Twilio
        if (!str_starts_with($phone, '+')) {
            $phone = '+' . $phone;
        }

        return $phone;
    }
}
