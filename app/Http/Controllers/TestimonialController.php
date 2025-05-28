<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'testimonial' => 'required|string|max:1000',
        ]);

        Testimonial::create([
            'user_id' => $request->user()->id,
            'text' => $request->testimonial,
            'approved' => false,
        ]);

        return back()->with('success', 'Thank you for your feedback!');
    }
}