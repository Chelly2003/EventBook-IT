<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PayloadController extends Controller
{
     /**
     * Store incoming payload (webhooks, API callbacks)
     */
    public function store(Request $request)
    {
        // Save payload to the database
        Payload::create([
            'source' => $request->source ?? 'unknown',
            'reference_id' => $request->reference_id ?? null,
            'payload' => $request->all(),
            'status' => 'received',
        ]);

        return response()->json([
            'message' => 'Payload saved successfully'
        ]);
    }
}
