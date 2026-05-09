<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttendeeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                             ->with('error', 'Please log in to access this page.');
        }

        if (auth()->user()->role !== 'attendee') {
            return redirect()->route('home')
                             ->with('error', 'This page is for attendees only.');
        }

        return $next($request);
    }
}
