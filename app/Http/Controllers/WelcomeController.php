<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;

class WelcomeController extends Controller
{
    public function index()
 {
        $testimonials = Testimonial::with('user')
            ->where('approved', true)
            ->latest()
            ->limit(10)
            ->get();

        return view('welcome', compact('testimonials'));
    }
}