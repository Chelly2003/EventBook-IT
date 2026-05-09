<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TeamInvitation extends Mailable
{
    use Queueable;

    public $team;
    public $invitedUser;
    public $inviter;
    public $role;

    public function __construct($team, $invitedUser, $inviter, $role)
    {
        $this->team = $team;
        $this->invitedUser = $invitedUser;
        $this->inviter = $inviter;
        $this->role = $role;
    }

    public function build()
    {
        return $this->subject('You’ve been invited to join a team on [Your Platform]')
                    ->view('emails.team-invitation')
                    ->with([
                        'inviter' => $this->inviter->name,
                        'team'    => $this->team->name ?? 'Your Team',
                        'role'    => ucfirst(str_replace('_', ' ', $this->role)),
                        'url'     => url('/dashboard'), // or accept invite link with token
                    ]);
    }
}
