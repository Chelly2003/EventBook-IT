<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Event extends Model
{
    protected $fillable = [
        'user_id',
        'event_type',
        'title',
        'description',
        'event_date',
        'event_time',
        'online_platform',
        'meeting_link',
        'stream_key',
        'venue_name',
        'address_line1',
        'address_line2',
        'city',
        'county',
        'country',
        'google_maps_url',
        'capacity',
        'payment_type',
        'price',
        'fee_handling',
        'banner',
        'event_category' ,
        'tags',
           'tags.*' ,
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'event_date' => 'date',           // ← Makes $event->event_date a Carbon object
        'event_time' => 'datetime:H:i',   // ← Makes $event->event_time a Carbon object too
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // The organiser/creator of this event
    public function organiser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // All tickets for this event
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    // Number of tickets sold (not yet used/scanned)
    public function getTicketsSoldAttribute()
    {
        return $this->tickets()->where('is_used', false)->count();
    }

    // Number of tickets already used/scanned
    public function getTicketsUsedAttribute()
    {
        return $this->tickets()->where('is_used', true)->count();
    }

    // Total revenue from paid tickets
    public function getTotalRevenueAttribute()
    {
        return $this->tickets()->sum('price');
    }

    // Helper: is the event upcoming?
    public function getIsUpcomingAttribute()
    {
        return $this->event_date->isFuture();
    }
    public function show($id)
{
    $event = Event::with('tickets')->findOrFail($id);

    // Count sold tickets for all ticket types
    $sold = TicketPurchase::where('event_id', $id)->sum('quantity');

    $ticketsLeft = $event->capacity - $sold;

    // Status logic
    if ($ticketsLeft <= 0) {
        $status = "sold_out";
    } elseif ($ticketsLeft <= 10) {
        $status = "low";
    } else {
        $status = "available";
    }

    return view('frontend.event_detail', compact('event', 'ticketsLeft', 'status'));
}
}


