<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingsController extends Controller
{
    public function bookEvent(Request $request, $event_id)
{
    $event = Event::findOrFail($event_id);

    // Prevent booking through this controller for paid events
    if (($event->price ?? 0) > 0) {
        return back()->with('error', 'Paid events must be booked through the Checkout page.');
    }

    $booking = Booking::create([
        'user_id'        => auth()->id(),
        'event_id'       => $event_id,
        'booking_code'   => Str::upper(Str::random(10)),
        'total_amount'   => 0,
        'payment_method' => 'none',
        'status'         => 'PAID',
        'quantity'       => $request->quantity ?? 1,
        'heard_from'     => $request->heard_from,
    ]);

    BookingItem::create([
        'booking_id'  => $booking->id,
        'item_name'   => 'Regular Ticket',
        'ticket_type' => 'regular',
        'quantity'    => $booking->quantity,
        'price'       => 0,
        'subtotal'    => 0,
        'heard_from'  => $request->heard_from,
    ]);

    return redirect()->route('booking.confirmed', $booking->id)
                     ->with('success', 'Booking confirmed!');
}


    public function confirmBooking($id)
{
    $booking = Booking::with(['items', 'event'])->findOrFail($id);

   if ((int)$booking->user_id !== (int)auth()->id()) {
        abort(403);
    }


    return view('frontend.pages.booking_confirmed', compact('booking'));
}
}
