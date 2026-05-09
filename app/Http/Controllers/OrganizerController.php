<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizerController extends Controller
{
    // Only authenticated users with 'organizer' role can reach this
    public function index()
    {
        $user = Auth::user(); // get the logged-in organizer

        // You can fetch organizer-specific events if needed
        $events = $user->events; // assuming you set up a relationship in User model

        return view('organiserdashboard', compact('user', 'events'));
    }
}
