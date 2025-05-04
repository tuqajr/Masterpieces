<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Toggle a product as favorite for the authenticated user
     * Handles both regular form submissions and AJAX requests
     */
    public function toggle($productId)
    {
        $user = Auth::user();
        $product = Product::findOrFail($productId);
    
        // Toggle the favorite status
        if ($user->favorites()->where('product_id', $productId)->exists()) {
            $user->favorites()->detach($productId);
            $status = 'removed';
        } else {
            $user->favorites()->attach($productId);
            $status = 'added';
        }
    
        return response()->json(['status' => $status]);
    }

      
    /**
     * Show the user's favorite products
     */
    public function index()
    {
        $user = Auth::user();
        $favorites = $user->favorites()->with('product')->get();
        
        return view('profile.favorites', compact('favorites'));
    }
}