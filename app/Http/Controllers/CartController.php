<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the cart page.
     */
    public function show()
    {
        $user = Auth::user();

        $cartItems = CartItem::where('user_id', $user->id)
            ->with('product') 
            ->get()
            ->filter(fn($item) => $item->product !== null); 

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart', compact('cartItems', 'total'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request)
    {
        // Validate product existence
        $product = Product::findOrFail($request->product_id);

        $cartItem = CartItem::firstOrNew([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        if ($request->has('replace') && $request->replace) {
            $cartItem->quantity = $request->quantity;
        } else {
            $cartItem->quantity += $request->input('quantity', 1);
        }

        $cartItem->save();

        return redirect()->route('cart')->with('success', 'Item added to cart!');
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
        ]);

        $cartItem = CartItem::where('id', $request->cart_item_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cartItem->delete();

        return back()->with('success', 'Item removed from cart!');
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::where('id', $request->cart_item_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return back()->with('success', 'Cart updated!');
    }

    /**
     * Process checkout.
     */
    public function checkout()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty!');
        }

        // TODO:
        // 1. Create Order
        // 2. Add OrderItems
        // 3. Handle payment
        // 4. Clear cart

        CartItem::where('user_id', Auth::id())->delete();

        return redirect()->route('home')->with('success', 'Thank you for your order!');
    }
}
