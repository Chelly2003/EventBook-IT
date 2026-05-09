<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    // Show reset password form (called from reset link)
    public function showResetForm(Request $request, $token = null)
    {
        return view('frontend.login.reset_password', [     // ← changed view name
            'token' => $token,
            'email' => $request->email,                    // comes from ?email= in URL
        ]);
    }

    // Process the reset (POST)
    public function reset(Request $request)
    {
        $request->validate([
            'token'             => 'required',
            'email'             => 'required|email',
            'password'          => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);   // better to use Hash::make
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Password has been reset successfully!')
            : back()->withErrors(['email' => [__($status)]]);
            // ↑ nicer: shows Laravel's translated error message (e.g. "This password reset token is invalid.")
    }
}
