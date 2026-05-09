<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OrganizerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
         // If user is not logged in → send to login page
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }



        // If logged in but not an organizer → deny access
        if (auth()->user()->role !== 'organizer') {
            return redirect()->route('home')->with('error', 'Access denied. Only organizers can view this page.');
            // Alternative: abort(403); for a proper forbidden page
        }

     // User is authenticated and is an organizer → proceed
        return $next($request);

    }
}
