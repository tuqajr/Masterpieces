<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function show()
    {
        $cartItems = CartItem::where('user_id', Auth::id())
            ->with(['product'])
            ->latest()
            ->get();
        
        $total = 0;
        foreach ($cartItems as $item) {
            if ($item->product) {
                $total += $item->product->price * $item->quantity;
            }
        }
        
        // Default setting - not in checkout mode
        $checkoutMode = false;
        
        return view('cart', compact('cartItems', 'total', 'checkoutMode'));
    }
    
    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())
            ->with(['product'])
            ->get();
            
        return view('cart.index', compact('cartItems'));
    }
    
    public function addProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        
        $product = Product::findOrFail($request->product_id);
        
        // Check if product already in cart
        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();
        
        if ($cartItem) {
            // Update quantity
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Add new cart item
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }
        
        // Count cart items for the cart icon badge
        $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cart_count' => $cartCount
            ]);
        }
        
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
    
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
        
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Cart updated successfully!']);
        }
        
        return redirect()->route('cart.show')->with('success', 'Cart updated successfully!');
    }
    
    public function remove(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
        ]);
        
        $cartItem = CartItem::where('id', $request->cart_item_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        $cartItem->delete();
        
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Item removed from cart!']);
        }
        
        return redirect()->route('cart.show')->with('success', 'Item removed from cart!');
    }
    
    public function clear()
    {
        CartItem::where('user_id', Auth::id())->delete();
        
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Cart cleared']);
        }
        
        return redirect()->route('cart.show')->with('success', 'Cart cleared successfully!');
    }
    
    public function checkout()
    {
        $cartItems = CartItem::where('user_id', Auth::id())
            ->with(['product'])
            ->latest()
            ->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.show')
                ->with('error', 'Your cart is empty. Cannot proceed to checkout.');
        }
        
        $total = 0;
        foreach ($cartItems as $item) {
            if ($item->product) {
                $total += $item->product->price * $item->quantity;
            }
        }
        
        // Set checkout mode to true
        $checkoutMode = true;
        
        return view('cart', compact('cartItems', 'total', 'checkoutMode'));
    }
}