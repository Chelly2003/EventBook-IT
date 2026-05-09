<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KRAController extends Controller
{
    private $consumerKey;
    private $consumerSecret;
    private $sandbox;

    public function __construct()
    {
        $this->consumerKey    = env('KRA_CONSUMER_KEY');
        $this->consumerSecret = env('KRA_CONSUMER_SECRET');
        $this->sandbox        = env('KRA_ENV', 'sandbox') === 'sandbox';
    }

    private function getAccessToken()
    {
        $url = $this->sandbox
            ? 'https://sbx.kra.go.ke/v1/token/generate?grant_type=client_credentials'
            : 'https://api.kra.go.ke/v1/token/generate?grant_type=client_credentials';

        if (!$this->consumerKey || !$this->consumerSecret) {
            Log::error('KRA credentials missing in .env');
            return null;
        }

        $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $credentials
            ])->get($url);

            if ($response->successful()) {
                return $response->json()['access_token'] ?? null;
            } else {
                Log::error('KRA Access Token Error', [
                    'status' => $response->status(),
                    'body'   => $response->body()
                ]);
                return null;
            }
        } catch (\Exception $e) {
            Log::error('KRA Token Exception', ['message' => $e->getMessage()]);
            return null;
        }
    }

    public function validatePin(Request $request)
    {
        $kraPin = strtoupper(trim($request->kra_pin));

        // KRA PIN format: 1 letter + 9 digits + 1 letter = 11 chars
        if (!preg_match('/^[A-Z]\d{9}[A-Z]$/', $kraPin)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid PIN format. Expected format: A123456789B'
            ]);
        }

          // ✅ Sandbox mock — skip real KRA API call
    if ($this->sandbox) {
        return response()->json([
            'success' => true,
            'message' => 'Verification Successful',
            'data'    => [
                'KRAPIN'       => $kraPin,
                'TaxPayerName' => 'Test Organization Ltd',
                'TaxPayerType' => 'Company',
                'Status'       => 'Active',
            ]
        ]);
    }


        $token = $this->getAccessToken();
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to authenticate with KRA. Please try again later.'
            ]);
        }

        $url = $this->sandbox
            ? 'https://sbx.kra.go.ke/checker/v1/pinbypin'
            : 'https://api.kra.go.ke/checker/v1/pinbypin';

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type'  => 'application/json',
            ])->post($url, ['KRAPIN' => $kraPin]);

            $json = $response->json();

            // KRA returns: {"Message":"Valid PIN","Status":"OK","PINDATA":{...}}
            if ($response->successful() && isset($json['Message']) && $json['Message'] === 'Valid PIN') {
                return response()->json([
                    'success' => true,
                    'message' => 'Verification Successful',
                    'data'    => $json['PINDATA'] ?? []
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $json['Message'] ?? $json['ErrorMessage'] ?? 'Invalid or unregistered KRA PIN.'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('KRA PIN Validation Exception', ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error connecting to KRA. Please try again.'
            ]);
        }
    }
}
