<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Mail;

class ContactUsController extends Controller
{
    // Show the contact form
    public function show(){
        return view('contact');
    }

    // Send email (verwerken)
    public function sendEmail(Request $request){
        // Validate form
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required|min:10',
            'contact' => 'required'
        ]);

        // Remake the error array to personal text
        //$error = ["The name field is required.", "The email must be a valid email address.", "The message must be at least 10 characters."];

        // Send email
        $email = new ContactMail($request);
        \Illuminate\Support\Facades\Mail::to($request) // or Mail::to($request->email)
        ->send($email);

        // Flash filled-in form values to the session
        // Keep the old form values
        $request->flash();

        // Flash a success message to the session
        // error message zou ook kunnen
        // session() is a helper function that returns the current session object, on which the (non-static) flash() method can be called: session()->flash('success', 'Thank you ...')
        session()->flash('success', 'Thank you for your message.<br>We\'ll contact you as soon as possible.');

        // Redirect to the contact-us link ( NOT to view('contact')!!! )
        return redirect('contact-us');

    }
}
