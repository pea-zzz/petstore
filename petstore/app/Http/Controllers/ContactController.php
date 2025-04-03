<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Show the contact form.
     *
     * @return \Illuminate\View\View
     */
    public function showContactForm()
    {
        return view('contact');
    }

    /**
     * Handle the contact form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Handle the form submission (you can send an email here, store the message in the database, etc.)
        // Example: sending an email to the admin

        // You can configure the email settings in .env and use Mail::to() to send an email.
        Mail::to('support@petstore.com')->send(new \App\Mail\ContactMessage($request));

        // Redirect back with a success message
        return redirect()->route('contact')->with('success', 'Your message has been sent successfully!');
    }
}
