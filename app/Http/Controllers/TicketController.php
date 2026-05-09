<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Event;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;   // ← REQUIRED FIX
use Illuminate\Support\Facades\DB;     // ← REQUIRED FIX
use Illuminate\Support\Facades\Storage; // ← REQUIRED FIX
use Illuminate\Support\Str;
use App\Models\Booking;

class TicketController extends Controller
{
   public function invoice($booking_id)
{
    $booking = Booking::with(['items', 'event', 'user'])->findOrFail($booking_id);

    if ($booking->user_id !== Auth::id()) {
        abort(403);
    }

    return view('frontend.pages.invoice', compact('booking'));
}

}
