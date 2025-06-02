<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
public function toggle(Request $request)
{
    $request->validate(['product_id' => 'required|exists:products,id']);
    $userId    = Auth::id();
    $productId = $request->product_id;

    $favorite = Favorite::where('user_id', $userId)
                        ->where('product_id', $productId)
                        ->first();

    if ($favorite) {
        $favorite->delete();
        $isFavorite = false;
    } else {
        Favorite::create(['user_id' => $userId, 'product_id' => $productId]);
        $isFavorite = true;
    }

    return response()->json([
        'success'     => true,
        'is_favorite' => $isFavorite,
    ]);
}
    public function index(Request $request)
{
    $query = Product::query();

    if ($request->has('favorites_only') && Auth::check()) {
        $user = Auth::user();
        $query->whereHas('favoritedByUsers', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        });
    }

    $products = $query->get();

    return view('shop.index', compact('products'));
}

}
