<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // organizer etc
        'phone',
         'organization_name',
    'kra_pin',
    'avatar',
    'cover_image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'user_id');
    }

    public function payoutMethods()
    {
        return $this->hasMany(PayoutMethod::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_user')
                    ->withPivot('role', 'invited_at', 'joined_at');
    }

    public function ownedTeams()
    {
        return $this->hasMany(Team::class, 'owner_id');
    }
    /**
 * Get the currently active team for the user.
 * (Fallback to first owned team or first attached team if no current_team_id)
 */
public function currentTeam()
{
    // Option 1: Use current_team_id column (recommended - add it to users table)
    if ($this->current_team_id) {
        return $this->teams()->find($this->current_team_id);
    }

    // Option 2: Fallback to first owned team (if user is owner)
    $owned = $this->ownedTeams()->first();
    if ($owned) {
        return $owned;
    }

    // Option 3: Fallback to first attached team
    return $this->teams()->first();
}

public function balance()
{
    return $this->hasOne(\App\Models\OrganiserBalance::class);
}

    /**
     * Get the avatar URL with fallback
     */
    public function getAvatarUrlAttribute()
    {
        return $this->avatar
            ? asset($this->avatar)
            : asset('images/profile-imgs/img-13.jpg'); // your default avatar
    }

    /**
     * Get the cover image URL with fallback
     */
    public function getCoverImageUrlAttribute()
    {
        return $this->cover_image
            ? asset($this->cover_image)
            : null; // or put a default cover image path
    }

}
