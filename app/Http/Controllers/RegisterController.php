<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use EragLaravelDisposableEmail\Rules\DisposableEmailRule;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('sign_up');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => [
                'required',
                'email:rfc,dns',
                'unique:users,email',
                new DisposableEmailRule(),
            ],
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:attendee,organizer',
            'phone'    => 'nullable|string|max:15',
        ], [
            'name.required'        => 'Please enter your full name.',
            'email.required'       => 'Please enter your email address.',
            'email.email'          => 'Please enter a valid email address.',
            'email.unique'         => 'This email is already registered. Please sign in instead.',
            'email.disposable_email' => 'Temporary or disposable email addresses are not allowed.',
            'password.required'    => 'Please create a password.',
            'password.min'         => 'Password must be at least 6 characters.',
            'password.confirmed'   => 'Passwords do not match. Please try again.',
            'role.required'        => 'Please select whether you are an Attendee or Organizer.',
            'role.in'              => 'Please select a valid role.',
            'phone.max'            => 'Phone number must not exceed 15 characters.',
        ]);

        // Return errors back to the form with old input
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'phone'    => $request->phone,
        ]);

        auth()->login($user);

        return redirect()->route('login')->with('success', 'Account created successfully! Please log in.');
    }

    public function upgradeToOrganizer(Request $request)
    {
        try {
            $request->validate([
                'organization_name' => 'required|string|max:255',
                'kra_pin'           => 'required|string|size:11',
            ]);

            $user                    = auth()->user();
            $user->organization_name = $request->organization_name;
            $user->kra_pin           = $request->kra_pin;
            $user->role              = 'organizer';
            $user->save();

            return response()->json([
                'success'  => true,
                'message'  => 'You have been upgraded to Organizer!',
                'redirect' => route('organiserdashboard')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ]);
        }
    }
}
