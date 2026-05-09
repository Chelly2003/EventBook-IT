<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;  // ← Add this import

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('frontend.login.forgot_password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = $request->email;

        // Explicit check: does this email belong to a registered user?
        if (! User::where('email', $email)->exists()) {
            return redirect()
                ->route('register')  // or 'sign_up' — use whichever name your routes file uses
                ->with('error', "We couldn't find an account with the email '{$email}'. Please sign up to create one.");
        }

        // User exists → attempt to send reset link
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', __($status))  // "We have emailed your password reset link!"
            : back()->withErrors(['email' => __($status)]);
    }
}
