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
        $cartItems = CartItem::where('user_id', Auth::id())
            ->with('product')
            ->get();
            
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
        
        return view('cart', compact('cartItems', 'total'));
    {
     return view('cart.show');
    }
        
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'sometimes|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;

        // Check if the product is already in the cart
        $existingItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingItem) {
            // Update the quantity if it's already in the cart
            $existingItem->quantity += $quantity;
            $existingItem->save();
        } else {
            // Add a new cart item
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        return back()->with('success', $product->name . ' added to cart!');
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

        // Here you would typically:
        // 1. Create an order
        // 2. Create order items
        // 3. Clear the cart
        // 4. Process payment
        
        // For now, let's just clear the cart
        CartItem::where('user_id', Auth::id())->delete();

        return redirect()->route('home')->with('success', 'Thank you for your order!');
    }
}