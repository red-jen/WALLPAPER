<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the about page.
     *
     * @return \Illuminate\Http\Response
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Display the contact page.
     *
     * @return \Illuminate\Http\Response
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Process the contact form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Here you would process the contact form
        // For example, send an email or store in database

        return redirect()->route('contact')->with('success', 'Your message has been sent successfully. We will get back to you soon!');
    }

    /**
     * Display the FAQ page.
     *
     * @return \Illuminate\Http\Response
     */
    public function faq()
    {
        return view('faq');
    }

    /**
     * Display the services page.
     *
     * @return \Illuminate\Http\Response
     */
    public function services()
    {
        return view('public.services');
    }

    /**
     * Display the returns page.
     *
     * @return \Illuminate\Http\Response
     */
    public function returns()
    {
        return view('returns');
    }
}
