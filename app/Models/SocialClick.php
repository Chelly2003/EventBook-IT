<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialClick extends Model
{
     protected $fillable = [
        'platform',
        'user_id',
        'location',
        'url',
        'ip_address',
        'device',
    ];
}
