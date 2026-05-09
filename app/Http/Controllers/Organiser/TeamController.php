<?php

namespace App\Http\Controllers\Organiser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\Mail;
use App\Mail\TeamInvitation;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = auth()->user();

            // Allow organizers (old column) or account owners (Spatie role)
            if ($user->role !== 'organizer' && !$user->hasRole('account_owner')) {
                abort(403, 'Only account owners or organizers can manage team members.');
            }

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $tab = $request->query('tab', 'overview');

        $team = auth()->user()->teams()->first();

        if (!$team) {
            $teamMembers = collect();
        } else {
            $teamMembers = $team->users()
                ->with('roles')
                ->get()
                ->map(function ($user) {
                    // Prefer old role column, fallback to Spatie first role
                    $primaryRole = $user->role ?? $user->roles->first()?->name ?? 'basic_access';

                    return (object) [
                        'id'         => $user->id,
                        'name'       => $user->name,
                        'email'      => $user->email,
                        'role'       => $primaryRole,
                        'last_login' => $user->last_login_at?->format('d M y, h.i A') ?? 'Never',
                        'twofa'      => $user->two_factor_secret ? 'Yes' : 'No',
                        'can_delete' => $user->id !== auth()->id(),
                    ];
                });
        }

        return view('frontend.dashboard.org_my_team', compact('tab', 'teamMembers'));
    }

    public function invite(Request $request)
    {
        $request->validate([
            'email'       => 'required|email',
            'role'        => 'required|in:account_owner,basic_access,finance,power_user,producer_access',
            'send_emails' => 'boolean',
        ]);

        $email = $request->email;

        if ($email === auth()->user()->email) {
            return back()->withErrors(['email' => 'You cannot invite yourself.']);
        }

        // Get or create team
        $team = auth()->user()->teams()->first();

        if (!$team) {
            $team = Team::create([
                'name'     => auth()->user()->name . "'s Team",
                'owner_id' => auth()->user()->id,
            ]);

            auth()->user()->teams()->attach($team->id);
        }

        $existing = User::where('email', $email)->first();

        if ($existing && $team->users()->where('user_id', $existing->id)->exists()) {
            return back()->withErrors(['email' => 'This user is already in your team.']);
        }

        // Create or find user
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name'     => explode('@', $email)[0] ?? 'New User',
                'password' => bcrypt(Str::random(16)),
            ]
        );

        // Attach to team
        $team->users()->syncWithoutDetaching($user->id);

        // Assign Spatie role
        $user->assignRole($request->role);

        // Send invitation email if checked
        if ($request->boolean('send_emails')) {
            Mail::to($user)->send(new TeamInvitation($team, $user, auth()->user(), $request->role));
        }

        return back()->with('success', 'Invitation sent to ' . $email);
    }

    public function remove($userId)
    {
        $team = auth()->user()->teams()->first();

        if (!$team) {
            return back()->withErrors(['error' => 'No team found.']);
        }

        if ($userId == auth()->id()) {
            return back()->withErrors(['error' => 'You cannot remove yourself.']);
        }

        $team->users()->detach($userId);

        // Optional: remove Spatie roles if desired
        // $removedUser = User::find($userId);
        // if ($removedUser) {
        //     $removedUser->roles()->detach();
        // }

        return back()->with('success', 'Team member removed.');
    }
}
