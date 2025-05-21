<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CartItem;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'payment_method' => 'required|in:cash_on_delivery',
        ]);

        $cartItems = CartItem::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.show')->with('error', 'Your cart is empty.');
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->product->price * $item->quantity;
        }

        DB::beginTransaction();
        
        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
                'status' => 'pending',
                'total' => $total,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            CartItem::where('user_id', Auth::id())->delete();
            DB::commit();

            return redirect()->route('orders.thankyou', $order->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function thankyou($id)
    {
        $order = Order::with('items')->findOrFail($id);
        
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('orders.thankyou', compact('order'));
    }

    public function userOrders()
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    $orders = $user->orders()
        ->with('orderItems')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('orders.user-orders', compact('orders'));
}
    public function show(Order $order)
    {
        $user = Auth::user();

        if ($order->user_id !== Auth::id() && Auth::user()->role !== 'admin')
         {
            abort(403, 'Unauthorized');
        }

        $order->load('orderItems');
        return view('orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        if ($order->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Order cannot be cancelled'
            ]);
        }
        
        $order->update(['status' => 'cancelled']);

        return response()->json([
            'success' => true,
            'message' => 'Order cancelled successfully'
        ]);
    }
}
