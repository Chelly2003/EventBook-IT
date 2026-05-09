<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SocialclicksController extends Controller
{
     //Store a social click in the database
    
    public function store(Request $request)
    {
        SocialClick::create([
            'platform' => $request->platform,
            'user_id' => auth()->id(), // null if guest
            'location' => $request->location,
            'url' => $request->url,
            'ip_address' => $request->ip(),
            'device' => $request->header('User-Agent'),
        ]);

        return response()->json(['message' => 'Click logged successfully']);
    }
}
