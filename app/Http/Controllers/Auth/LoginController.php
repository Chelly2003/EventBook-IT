<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Role-based redirect
            if (auth()->user()->role === 'organizer') {
                return redirect()->route('organiserdashboard');
            }

            return redirect()->route('home');
        }

        // Failed login
return redirect()->back()
                 ->with('error', 'Invalid email or password.')
                 ->withInput();
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();  // Clears the authenticated user from the session

        $request->session()->invalidate();  // Destroys all session data
        $request->session()->regenerateToken(); // Generates a new CSRF token (prevents fixation attacks)

        return redirect()->route('login');
    }
}
