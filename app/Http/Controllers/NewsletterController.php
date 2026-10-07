<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsletterController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:newsletter_subscribers,email'],
        ]);

        DB::table('newsletter_subscribers')->insert([
            'email' => $validated['email'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('newsletter_status', "You're on the list. Look out for something delicious!");
    }
}
