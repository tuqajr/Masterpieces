<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Add product to cart
     */
    public function add(Request $request, Product $product)
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1|max:10'
            ]);

            $userId = Auth::id();
            $quantity = $request->input('quantity', 1);

            // Check if item already exists in cart
            $existingCartItem = CartItem::where('user_id', $userId)
                                      ->where('product_id', $product->id)
                                      ->first();

            // Check available stock
            $cartQuantity = $existingCartItem ? $existingCartItem->quantity : 0;
            if ($product->stock < ($quantity + $cartQuantity)) {
                $message = 'Not enough stock available';
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $message
                    ], 400);
                }
                return redirect()->back()->with('error', $message);
            }

            if ($existingCartItem) {
                // Update quantity
                $existingCartItem->quantity += $quantity;
                $existingCartItem->save();
                $message = 'Product quantity updated in cart!';
            } else {
                // Create new cart item
                CartItem::create([
                    'user_id' => $userId,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price
                ]);
                $message = 'Product added to cart successfully!';
            }

            // Return JSON response for AJAX requests
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'cart_count' => CartItem::where('user_id', $userId)->sum('quantity')
                ]);
            }

            return redirect()->back()->with('cart_success', $message);

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add product to cart'
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to add product to cart');
        }
    }

    /**
     * Show cart items
     */
    public function show()
    {
        $cartItems = CartItem::with('product')
                            ->where('user_id', Auth::id())
                            ->get();

        // Always use the current product price for total calculation
        $total = $cartItems->sum(function($item) {
            return optional($item->product)->price * $item->quantity;
        });

        $checkoutMode = false; 

        return view('cart', compact('cartItems', 'total', 'checkoutMode'));
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        // Ensure user owns this cart item
        if ($cartItem->user_id !== Auth::id()) {
            abort(403);
        }

        // Check available stock before updating
        if ($cartItem->product && $cartItem->product->stock < $request->quantity) {
            $message = 'Not enough stock available';
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $message
                ], 400);
            }
            return redirect()->back()->with('error', $message);
        }

        $cartItem->update([
            'quantity' => $request->quantity
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully'
            ]);
        }

        return redirect()->back()->with('success', 'Cart updated successfully');
    }

    /**
     * Remove item from cart
     */
    public function remove(CartItem $cartItem)
    {
        // Ensure user owns this cart item
        if ($cartItem->user_id !== Auth::id()) {
            abort(403);
        }

        $cartItem->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart'
            ]);
        }

        return redirect()->back()->with('success', 'Item removed from cart');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        CartItem::where('user_id', Auth::id())->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully'
            ]);
        }

        return redirect()->back()->with('success', 'Cart cleared successfully');
    }

    /**
     * Get cart count (for AJAX)
     */
    public function count()
    {
        $count = 0;
        
        if (Auth::check()) {
            $count = CartItem::where('user_id', Auth::id())->sum('quantity');
        }

        return response()->json(['count' => $count]);
    }
}