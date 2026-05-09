<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function showProfile()
    {
        return view('frontend.pages.organiserprofile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'phone'       => 'nullable|string|max:20',
            'avatar'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',   // max 2MB
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',  // max 4MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput()
                             ->with('error', 'Please check the errors below.');
        }

        // Update text fields
        $user->name  = $request->name;
        $user->phone = $request->phone;

        // Upload Avatar
        if ($request->hasFile('avatar')) {
            $avatarName = time() . '_avatar.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('uploads/avatars'), $avatarName);
            $user->avatar = 'uploads/avatars/' . $avatarName;
        }

        // Upload Cover Image
        if ($request->hasFile('cover_image')) {
            $coverName = time() . '_cover.' . $request->cover_image->getClientOriginalExtension();
            $request->cover_image->move(public_path('uploads/covers'), $coverName);
            $user->cover_image = 'uploads/covers/' . $coverName;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function destroy()
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();

        return redirect('/')->with('success', 'Your account has been deleted successfully.');
    }
}
