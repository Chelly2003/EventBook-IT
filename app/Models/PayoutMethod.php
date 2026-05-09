<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayoutMethod extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'mpesa_phone',
        'mpesa_shortcode',
        'mpesa_name',
        'mpesa_account_ref',
        'paypal_email',
        'bank_account_name',
        'bank_account_number',
        'bank_name',
        'bank_swift',
        'is_default',
        'is_verified',
    ];

    protected $casts = [
        'is_default'  => 'boolean',
        'is_verified' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Optional helper: get formatted display name
    public function getDisplayNameAttribute(): string
    {
        return match ($this->type) {
            'mpesa'  => "M-Pesa • {$this->mpesa_name} ({$this->mpesa_shortcode})",
            'paypal' => "PayPal • {$this->paypal_email}",
            'bank'   => "Bank • {$this->bank_name} ({$this->bank_account_number})",
            default  => "Unknown Method",
        };
    }
}
