<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'ticket_code',
        'is_used',
        'used_at',
        'ticket_type',
        'price',
          'paid_out'
    ];

   protected $casts = [
        'is_used'  => 'boolean',
        'used_at'  => 'datetime',
        'price'    => 'decimal:2',
        'paid_out' => 'boolean',
    ];

    /**
     * The event this ticket belongs to
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * The attendee/user who owns this ticket
     */
    public function attendee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Helper: is this ticket still valid?
     */
    public function getIsValidAttribute()
    {
        return !$this->is_used;
    }
}
