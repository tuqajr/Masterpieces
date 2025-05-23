<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            // Get cart items from session
            $cart = session('cart', []);
            
            if (empty($cart)) {
                return redirect()->back()->with('error', 'Your cart is empty');
            }
            
            // Calculate total
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'status' => 'pending',
                'delivery_date' => now()->addDays(7), // Delivery in 7 days
                'shipping_address' => $request->shipping_address ?? Auth::user()->address,
                'phone' => $request->phone ?? Auth::user()->phone,
            ]);
            
            // Create order items
            foreach ($cart as $productId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'product_name' => $item['name'],
                    'product_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity']
                ]);
                
                // Update product stock
                $product = Product::find($productId);
                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                }
            }
            
            // Clear cart
            session()->forget('cart');
            
            DB::commit();
            
            return redirect()->route('orders.show', $order->id)
                           ->with('success', 'Order placed successfully!');
                           
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to place order. Please try again.');
        }
    }
    
    public function show($id)
    {
        $order = Order::with('orderItems')->findOrFail($id);
        
        // Check if user owns this order or is admin
        if (Auth::id() !== $order->user_id && !Auth::user()->is_admin) {
            abort(403);
        }
        
        return view('orders.show', compact('order'));
    }
    
    public function index()
    {
        $orders = Order::with('orderItems')
                      ->where('user_id', Auth::id())
                      ->orderBy('created_at', 'desc')
                      ->get();
                      
        return view('orders.index', compact('orders'));
    }
    
    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        
        if (Auth::id() !== $order->user_id) {
            abort(403);
        }
        
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Cannot cancel this order');
        }
        
        // Restore product stock
        foreach ($order->orderItems as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->increment('stock', $item->quantity);
            }
        }
        
        $order->update(['status' => 'cancelled']);
        
        return redirect()->back()->with('success', 'Order cancelled successfully');
    }
}