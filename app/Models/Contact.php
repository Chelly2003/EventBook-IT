<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    protected $fillable = [

        'name',
        'email',
         'phone',
           'user_id',
           'description', // to link to the org
        // add more later: phone, status, etc.
    ];

    public function contactList(): BelongsTo
    {
        return $this->belongsTo(ContactList::class);
    }
}
