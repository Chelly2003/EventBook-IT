<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payload extends Model
{

    protected $fillable = [
        'source',        // e.g., 'mpesa', 'stripe', 'booking'
        'reference_id',  // e.g., transaction ID or callback ID
        'payload',       // stores the raw JSON
        'status',        // 'received', 'processed', 'failed'
    ];

    // Cast payload column to array automatically
    protected $casts = [
        'payload' => 'array',
    ];
}
