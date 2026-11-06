<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $title = 'Contact Us';
        $description = 'Get in touch with the FileNewer team. Send us your questions, feedback, or support requests and we will get back to you as soon as possible.';

        return view('contact.index', compact('title', 'description'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        Contact::create($validated);
        return back()->with('success', 'Message sent successfully!');
    }
}
