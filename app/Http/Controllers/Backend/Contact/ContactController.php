<?php

namespace App\Http\Controllers\Backend\Contact;

use App\Http\Controllers\Controller;
use App\Models\Backend\Contact\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::latest()->paginate(15);
        $unreadCount = Contact::where('is_read', false)->count();

        return view('backend.contact.index', compact('contacts', 'unreadCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
        ]);

        Contact::create($request->only('name', 'phone', 'message'));

        return back()->with('success', 'Your message has been sent successfully!');
    }

    public function show(Contact $contact)
    {
        if (! $contact->is_read) {
            $contact->update(['is_read' => true]); // auto-mark read on open
        }

        return view('backend.contact.view', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('dashboard.contact-list')->with('success', 'Message deleted successfully.');
    }
}
