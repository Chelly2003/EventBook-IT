<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BookingItem;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'booking_code',
        'total_amount',
        'status',
        'payment_method',
        'qr_code',
        'mpesa_checkout_id',  // ADD
    'mpesa_receipt',       // ADD
    'quantity',            // ADD
    'heard_from',  
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function items()
    {
        return $this->hasMany(BookingItem::class, 'booking_id');
    }
}
