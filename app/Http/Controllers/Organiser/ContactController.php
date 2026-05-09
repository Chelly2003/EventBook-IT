<?php

namespace App\Http\Controllers\Organiser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactList;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;


class ContactController extends Controller
{
    public function index()
{
   $contacts = Auth::user()->contacts()->latest()->get();
    // or: $contacts = Auth::user()->contacts()->orderBy('created_at', 'desc')->get();

    return view('frontend.dashboard.org_contact_list', compact('contacts'));
}

public function store(Request $request)
{
    $user = Auth::user();

    if (!$user) {
        return redirect()->back()->with('error', 'You must be logged in to add a contact.');
    }

    $validated = $request->validate([
        'name'        => 'required|string|max:255',
        'email'       => 'required|email|unique:contacts,email',
        'phone'       => 'required|string|max:20',
        'description' => 'nullable|string|max:500',
    ]);

    // This automatically sets user_id for you!
    $user->contacts()->create($validated);

    return redirect()->route('organiser.contact_lists')
        ->with('success', 'Contact added successfully!');
}

public function destroy(Contact $contact)
{
    if ($contact->user_id !== Auth::id()) {
        abort(403);
    }

    $contact->delete();

    return redirect()->route('organiser.contact_lists')
        ->with('success', 'Contact deleted successfully!');
}
// Show edit form
public function edit(Contact $contact)
{
    return view('frontend.dashboard.contact_edit', compact('contact'));
}

// Update contact
public function update(Request $request, Contact $contact)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:contacts,email,' . $contact->id,
        'phone' => 'required|string|max:20',
           'description' => 'nullable|string|max:500',

    ]);

    $contact->update($validated);

    return redirect()->route('organiser.contact_lists')
        ->with('success', 'Contact updated successfully!');
}


}
