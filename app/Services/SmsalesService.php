<?php

namespace App\Services;

use SMSALES\API\Trigger;

class SmsalesService
{
    protected $trigger;

    public function __construct()
    {
        // Initialize Trigger using token from config/smsales.php
        $this->trigger = new Trigger();
    }

    /**
     * Generate a random OTP
     *
     * @param int $length
     * @return int
     */
    public function generateOtp($length = 6)
    {
        return rand(pow(10, $length - 1), pow(10, $length) - 1);
    }

    /**
     * Send OTP via SMSALES Trigger
     *
     * @param string $phone
     * @param int $otp
     * @return array|null
     */
    public function sendOtp(string $phone, int $otp)
    {
        // IMPORTANT: Use a registered sender ID in your SMSALES account
        return $this->trigger->send([
            "api_sender"    => "SHIFTECH",        // must be registered on SMSALES
            "message"       => "Your OTP code is: {$otp}",
            "phone_numbers" => [$phone]
        ]);
    }

    /**
     * Verify OTP locally
     *
     * @param int|string $inputOtp
     * @param int|string $storedOtp
     * @return bool
     */
    public function verifyOtp($inputOtp, $storedOtp)
    {
        return $inputOtp == $storedOtp;
    }
}
