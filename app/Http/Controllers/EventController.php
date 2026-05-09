<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use Illuminate\Support\Str; // at the top of your controller
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
  public function storeOnline(Request $request)
{
    $data = $request->validate([
         'title'=> 'required|string|min:3|max:255',
    'description'     => 'required|string|min:10',
    'event_date'      => 'required|date|after_or_equal:today',
    'event_time'      => 'required|date_format:H:i',
    'capacity'        => 'required|integer|min:1|max:100000',          // ← added
        'online_platform' => 'required',
        'meeting_link' => 'required',
         'payment_type' => 'required|in:free,paid',
         'price'=> 'nullable|numeric|min:0',
         'fee_handling' => 'required|in:pass,absorb',
          'banner'=> 'nullable|image|mimes:jpeg,png,jpg,webp|max:20480',

          // These must be here so they get included in $data after validate()
        'event_category'  => 'required|string|in:arts,business,concert,workshops,coaching,health,volunteer,sports,other',
        'tags'            => 'nullable|array',
        'tags.*'          => 'string|max:100',
    ]);

    if ($request->hasFile('banner')) {
        $data['banner'] = $request->file('banner')->store('banners', 'public');
    }


    $data['user_id'] = auth()->id();
    $data['event_type'] = 'online';
    // ADD THESE TWO LINES HERE
    $data['event_category'] = $request->event_category;
    $data['tags']           = $request->tags ? json_encode($request->tags) : null;

    $event = Event::create($data);

    // Redirect only if saving was successful
    if ($event) {
        return redirect()->route('home')
            ->with('success', 'Venue event created successfully!');
    }

    return back()->with('error', 'Event creation failed. Please try again.');

}
public function storeVenue(Request $request)
{


    $data = $request->validate([
   'title'=> 'required|string|min:3|max:255',
    'description'     => 'required|string|min:10',
    'event_date'      => 'required|date|after_or_equal:today',
    'event_time'      => 'required|date_format:H:i',          // ← fix this!
    'venue_name'      => 'required|string|max:255',
    'address_line1'   => 'required|string|max:255',
    'city'            => 'required|string|max:100',
    'county'          => 'required|string|max:100',           // ← ensure string
    'country'         => 'required|string|size:2',
    'google_maps_url' => 'nullable|url',
    'capacity'        => 'required|integer|min:1|max:100000', // ← change from nullable!
    'payment_type'    => 'required|in:free,paid',
    'price'           => 'nullable|numeric|min:0',
    'fee_handling'    => 'required|in:pass,absorb',
    'banner'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:20480', // 20MB max

    // NEW fields
            'event_category'  => 'required|string|in:arts,business,concert,workshops,coaching,health,volunteer,sports,other',
            'tags'            => 'nullable|array',
            'tags.*'          => 'string|max:100',
    ]);

    if ($request->hasFile('banner')) {
        $data['banner'] = $request->file('banner')->store('banners', 'public');
    }

    $data['user_id'] = auth()->id();
    $data['event_type'] = 'venue';

    // NEW: save category & tags
        $data['event_category'] = $request->event_category;
        $data['tags']  = $request->tags ? json_encode($request->tags) : null;

      $event = Event::create($data);



    // Redirect only if saving was successful
    if ($event) {
        return redirect()->route('home')
            ->with('success', 'Venue event created successfully!');
    }

    return back()->with('error', 'Event creation failed. Please try again.');
}

/*
public function show(Request $request, $id = null)
{

   $event = Event::with(['tickets', 'organiser'])
                 ->findOrFail($id);   // ← throws 404 automatically if not found

    $sold = Ticket::where('event_id', $id)->sum('quantity') ?? 0;
    $ticketsLeft = max(0, ($event->capacity ?? 0) - $sold);

    $status = match(true) {
        $ticketsLeft <= 0  => 'sold_out',
        $ticketsLeft <= 10 => 'low',
        default            => 'available',
    };

    return view('frontend.pages.venueevent', compact(
        'event',
        'ticketsLeft',
        'status'
    ));

}
*/


public function venueevent($id)
{
    $event = Event::withCount('tickets')           // This adds ->tickets_count automatically
                 ->with('organiser')
                 ->findOrFail($id);

                 $event->increment('views');
    $sold = $event->tickets_count;                 // ← this is the number of sold tickets

    $ticketsLeft = max(0, ($event->capacity ?? 0) - $sold);

    $status = match(true) {
        $ticketsLeft <= 0   => 'sold_out',
        $ticketsLeft <= 10  => 'low',
        default             => 'available',
    };

    return view('frontend.pages.venueevent', compact(
        'event',
        'ticketsLeft',
        'status'
    ));
}
public function checkout($event_id)
{
    $event = Event::findOrFail($event_id);

    return view('frontend.pages.checkout', compact('event'));
}

public function processPayment(Request $request)
{
     $request->validate([
        'event_id' => 'required|exists:events,id',
        'payment_method' => 'required|string',
    ]);

    $event = Event::findOrFail($request->event_id);

    // Generate a unique ticket code
    $ticketCode = strtoupper(Str::random(10)); // e.g., 'AB12CD34EF'

    // Create ticket
    $ticket = Ticket::create([
        'user_id' => Auth::id(),
        'event_id' => $event->id,
        'quantity' => 1,
        'payment_method' => $request->payment_method,
        'status' => 'paid', // or 'pending'
        'ticket_code' => $ticketCode,
        'type' => 'regular', // default ticket type
        'price' => $event->price ?? 0, // <-- use event price
    ]);

    // Redirect to booking confirmed
    return redirect()->route('booking.confirmed', $event->id)
                     ->with('success', 'Payment processed successfully.');
}

public function edit(Event $event)
    {
        // Security: only the owner can edit
        if ($event->user_id !== auth()->id()) {
            abort(403, 'You do not have permission to edit this event.');
        }

        // Pass the event to the edit view
        return view('frontend.pages.edit', compact('event'));
    }

   public function update(Request $request, Event $event)
{
    // Only owner can update
    if ($event->user_id !== auth()->id()) {
        abort(403, 'You do not have permission to update this event.');
    }

    $validated = $request->validate([
        'title'         => 'required|string|max:255',
        'event_date'    => 'required|date',
        'event_time'    => 'required',
        'price'         => 'nullable|numeric|min:0',
        'banner'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:20480',
    ]);

    // Handle banner upload
    if ($request->hasFile('banner')) {
        $validated['banner'] = $request->file('banner')->store('banners', 'public');
    }

    $event->update($validated);

    return back()->with('success', 'Event updated successfully!');
}
public function destroy(Event $event)
{
    // Security: only owner can delete
    if ($event->user_id !== auth()->id()) {
        abort(403, 'This event does not belong to you.');
    }

    // Delete associated banner/image if exists
    if ($event->banner && Storage::disk('public')->exists($event->banner)) {
        Storage::disk('public')->delete($event->banner);
    }

    // If you have tickets or other relations – delete them too or use cascade
    // $event->tickets()->delete();   // example

    $event->delete();

    return redirect()
        ->back()  // or ->back()
        ->with('success', 'Event deleted successfully.');

}

public function bookingConfirmed($event_id)
{
    $event = Event::findOrFail($event_id);

    $ticket = Ticket::where('event_id', $event->id)
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->first();

    if (!$ticket) {
        return redirect()->route('home')
                         ->with('error', 'No ticket found for this event.');
    }

    return view('frontend.pages.booking_confirmed', [
        'event' => $event,
        'ticket' => $ticket,
        'payment_method' => $ticket->payment_method ?? 'mpesa'
    ]);
}

}
