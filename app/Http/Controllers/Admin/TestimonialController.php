<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
   public function pending()
{
    $testimonials = \App\Models\Testimonial::with('user')->where('approved', false)->latest()->get();
    return view('admin.testimonials.pending', compact('testimonials'));
}

public function approve($id)
{
    $testimonial = \App\Models\Testimonial::findOrFail($id);
    $testimonial->approved = true;
    $testimonial->save();
    return back()->with('success', 'Testimonial approved!');
}

public function reject($id)
{
    $testimonial = \App\Models\Testimonial::findOrFail($id);
    $testimonial->delete();
    return back()->with('success', 'Testimonial rejected and deleted!');
}
}