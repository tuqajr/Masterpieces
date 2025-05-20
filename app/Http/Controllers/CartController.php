<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;

class CartController extends Controller
{
   public function showCart(Request $request)
{
    $userId = $request->user()->id;
    $cartItems = CartItem::with('product')->where('user_id', $userId)->get();
    $total = $cartItems->sum(function($item) {
        return $item->product->price * $item->quantity;
    });
    return view('cart', compact('cartItems', 'total'));
}

    public function addToCart(Request $request, $productId)
{
    // ... your validation and logic ...
    $userId = $request->user()->id;
    $product = Product::findOrFail($productId);

    $cartItem = CartItem::firstOrCreate(
        ['user_id' => $userId, 'product_id' => $product->id],
        ['quantity' => 0]
    );
    $cartItem->quantity += $request->input('quantity', 1);
    $cartItem->save();

    $cartCount = CartItem::where('user_id', $userId)->sum('quantity');

    if ($request->ajax() || $request->expectsJson()) {
        return response()->json([
            'cart_count' => $cartCount,
            'message' => "{$product->name} added to cart!",
        ]);
    }
    return redirect()->back()->with('cart_success', "{$product->name} added to cart!");
}

    public function remove(Request $request)
    {
        $request->validate(['cart_item_id' => 'required|exists:cart_items,id']);
        $userId = $request->user()->id;
        CartItem::where('id', $request->cart_item_id)->where('user_id', $userId)->delete();
        return redirect()->route('cart.show')->with('success', 'Item removed from cart.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1|max:99',
        ]);
        $userId = $request->user()->id;
        $cartItem = CartItem::where('id', $request->cart_item_id)->where('user_id', $userId)->firstOrFail();
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        return redirect()->route('cart.show')->with('success', 'Quantity updated.');
    }

    public function checkout(Request $request)
    {
        $userId = $request->user()->id;
        CartItem::where('user_id', $userId)->delete();
        return redirect()->route('cart.show')->with('success', 'Order placed! Thank you.');
    }
}