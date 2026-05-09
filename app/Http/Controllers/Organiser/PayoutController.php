<?php

namespace App\Http\Controllers\Organiser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PayoutMethod;
use SMSALES\API\Trigger; // Trigger imported directly
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Ticket;

class PayoutController extends Controller
{
    protected $trigger;

    public function __construct()
    {
        $this->trigger = new Trigger(); // Uses token from config/smsales.php
    }

    public function store(Request $request)
{
    $request->validate([
        'mpesa_phone' => 'required|digits:9'
    ]);

    $phone = '254' . $request->mpesa_phone; // international format
    $otp   = $this->generateOtp();

    try {
        $this->sendOtp($phone, $otp);
    } catch (\Exception $e) {
        Log::error('SMS sending failed', [
            'phone' => $phone,
            'error' => $e->getMessage()
        ]);
        return back()->withErrors('Failed to send OTP. Please try again.');
    }

    session([
        'pending_payout' => [
            'phone'      => $phone,
            'otp'        => $otp,
            'expires_at' => now()->addMinutes(5)
        ]
    ]);

    return redirect()->route('organiser.payout.verify-otp')
        ->with('info', "OTP sent to $phone. Expires in 5 minutes.");
}
/**
 * Resend the OTP for a pending payout
 */
public function resendOtp()
{
    $pending = session('pending_payout');

    if (!$pending) {
        return redirect()->route('organiser.payout')
            ->with('error', 'No pending OTP verification.');
    }

    try {
        $this->sendOtp($pending['phone'], $pending['otp']);
    } catch (\Exception $e) {
        return back()->withErrors('Failed to resend OTP.');
    }

    // extend expiration by 5 minutes
    session()->put('pending_payout.expires_at', now()->addMinutes(5));

    return back()->with('success', "New OTP sent to {$pending['phone']}");
}

    // Show payout form
  // Show Payouts Page
public function index()
{
    $user = Auth::user();

    $methods = $user->payoutMethods()->latest()->get();

    // === Calculate Revenue (Same logic as your dashboard) ===
    $events = $user->events()->get();
    $eventIds = $events->pluck('id');

    $totalRevenue     = \App\Models\Ticket::whereIn('event_id', $eventIds)->sum('price');
    $totalTicketsSold = \App\Models\Ticket::whereIn('event_id', $eventIds)->count();

    return view('frontend.dashboard.org_payout', compact(
        'methods',
        'totalRevenue',
        'totalTicketsSold'
    ));
}

    // Handle phone submission and send OTP
    public function requestOtp(Request $request)
    {
        $request->validate([
            'mpesa_phone' => 'required|digits:9'
        ]);

        $phone = '254' . $request->mpesa_phone; // Convert to international format
        $otp   = $this->generateOtp();

        try {
            $this->sendOtp($phone, $otp);
        } catch (\Exception $e) {
            Log::error('SMS sending failed', [
                'phone' => $phone,
                'error' => $e->getMessage()
            ]);

            return back()->withErrors('Failed to send OTP. Please try again.');
        }

        // Store pending payout & OTP in session
        session([
            'pending_payout' => [
                'phone'      => $phone,
                'otp'        => $otp,
                'expires_at' => now()->addMinutes(5)
            ]
        ]);

        return redirect()->route('organiser.payout.verify-otp')
            ->with('info', "OTP sent to $phone. Expires in 5 minutes.");
    }

    // Show OTP verification form
    public function showOtpForm()
    {
        $pending = session('pending_payout');

        if (!$pending || now()->gt($pending['expires_at'])) {
            session()->forget('pending_payout');
            return redirect()->route('organiser.payout')
                ->with('error', 'OTP session expired.');
        }

        return view('frontend.dashboard.payout-verify-otp');
    }

    // Verify OTP submission
    public function verifyOtpRequest(Request $request)
    {
        $pending = session('pending_payout');

        if (!$pending || now()->gt($pending['expires_at'])) {
            session()->forget('pending_payout');
            return redirect()->route('organiser.payout')
                ->with('error', 'OTP expired.');
        }

        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        if (!$this->verifyOtp($request->otp, $pending['otp'])) {
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        // Save payout method
        PayoutMethod::create([
            'user_id' => Auth::id(),
            'type'    => 'mpesa',
            'mpesa_phone' => substr($pending['phone'], 3),
        ]);

        session()->forget('pending_payout');

        return redirect()->route('organiser.payout')
            ->with('success', 'M-PESA payout verified successfully!');
    }

    /**
     * Generate OTP
     */
    public function generateOtp($length = 6)
    {
        return rand(pow(10, $length - 1), pow(10, $length) - 1);
    }

    /**
     * Send OTP via SMSALES Trigger
     */
    public function sendOtp(string $phone, int $otp)
    {
        return $this->trigger->send([
            "api_sender"    => "shiftech-6",        // must be a registered sender ID
            "message"       => "Your OTP code is: {$otp}",
            "phone_numbers" => [$phone]
        ]);
    }

    /**
     * Verify OTP locally
     */


public function verifyOtp(Request $request)
{
    $pending = session('pending_payout');

    if (!$pending || now()->gt($pending['expires_at'])) {
        session()->forget('pending_payout');
        return redirect()->route('organiser.payout')
            ->with('error', 'OTP expired or session missing.');
    }

    $request->validate([
        'otp' => 'required|digits:6',
    ]);

    if ($request->otp != $pending['otp']) {
        return back()->withErrors(['otp' => 'Invalid OTP.']);
    }

    // Save payout method here
    PayoutMethod::create([
        'user_id' => Auth::id(),
        'type'    => 'mpesa',
        'mpesa_phone' => substr($pending['phone'], 3), // remove country code
    ]);

    session()->forget('pending_payout');

    return redirect()->route('organiser.payout')
        ->with('success', 'M-PESA payout method verified successfully!');
}

    public function destroy(PayoutMethod $payoutMethod)
{
    // Ensure the payout belongs to the logged-in user
    if ($payoutMethod->user_id !== Auth::id()) {
        abort(403);
    }

    $payoutMethod->delete();

    return redirect()->route('organiser.payout')
        ->with('success', 'Payout method deleted successfully.');
}

    /**
     * Initiate M-Pesa B2C Payout (Sandbox)
     */

    public function requestPayout(Request $request)
{
    $user = Auth::user();

    // Get all events for this organiser
    $events = $user->events()->get();
    $eventIds = $events->pluck('id');

    // Calculate total available revenue (unpaid tickets)
    $totalAvailable = Ticket::whereIn('event_id', $eventIds)
                            ->where('paid_out', false)
                            ->sum('price');

    if ($totalAvailable <= 0) {
        return redirect()->route('organiser.payout')
                         ->with('error', 'You have no revenue to withdraw yet.');
    }

    // Get the organiser's latest M-Pesa payout method
    $method = PayoutMethod::where('user_id', $user->id)
                          ->where('type', 'mpesa')
                          ->latest()
                          ->first();

    if (!$method) {
        return redirect()->route('organiser.payout')
                         ->with('error', 'Please add an M-Pesa payout method first.');
    }

    $phone = '254' . ltrim($method->mpesa_phone, '0');
    $payoutAmount = round($totalAvailable * 0.90); // 90% payout

    if ($payoutAmount < 10) {
        return redirect()->route('organiser.payout')
                         ->with('error', 'Minimum payout amount is KES 10.');
    }

    // Initiate the M-Pesa B2C payout
    $result = $this->initiateB2CPayout($phone, $payoutAmount, $user->id);

    if ($result['success']) {
        // Mark tickets as paid out
        Ticket::whereIn('event_id', $eventIds)
              ->where('paid_out', false)
              ->update(['paid_out' => true]);

        // Redirect back to payout page with success message
        return redirect()->route('organiser.payout')
                         ->with('success', "Payout of KES " . number_format($payoutAmount, 2) . " has been initiated to +254" . $method->mpesa_phone . ". Revenue has been cleared.");
    }

    return redirect()->route('organiser.payout')
                     ->with('error', 'Failed to initiate payout. Please try again.');
}


    // ====================== B2C HELPER ======================
    private function initiateB2CPayout($phone, $amount, $userId)
    {
        $consumerKey    = env('MPESA_CONSUMER_KEY');
        $consumerSecret = env('MPESA_CONSUMER_SECRET');
        $shortcode      = env('MPESA_SHORTCODE');
        $initiatorName  = 'testapi';

        $credentials = base64_encode("$consumerKey:$consumerSecret");

        $tokenResponse = Http::withHeaders([
            'Authorization' => 'Basic ' . $credentials,
        ])->get('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');

        $accessToken = $tokenResponse->json()['access_token'] ?? null;

        if (!$accessToken) {
            return ['success' => false];
        }

        $response = Http::withToken($accessToken)->post(
            'https://sandbox.safaricom.co.ke/mpesa/b2c/v1/paymentrequest',
            [
                'InitiatorName'      => $initiatorName,
                'SecurityCredential' => env('MPESA_SECURITY_CREDENTIAL', 'Safaricom123!'),
                'CommandID'          => 'BusinessPayment',
                'Amount'             => $amount,
                'PartyA'             => $shortcode,
                'PartyB'             => $phone,
                'Remarks'            => 'Event ticket payout',
                'QueueTimeOutURL'    => url('/mpesa/b2c/timeout'),
                'ResultURL'          => url('/mpesa/b2c/result'),
                'Occasion'           => "Payout-{$userId}",
            ]
        );

        $data = $response->json();

        return [
            'success' => isset($data['ResponseCode']) && $data['ResponseCode'] === '0',
        ];
    }

}
