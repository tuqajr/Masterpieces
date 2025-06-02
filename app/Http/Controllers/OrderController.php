<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class OrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();
            $cartItems = CartItem::with('product')->where('user_id', $user->id)->get();

            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Your cart is empty');
            }

            $total = $cartItems->sum(function($item) {
                return $item->product->price * $item->quantity;
            });

            $order = Order::create([
                'user_id'          => $user->id,
                'customer_name'    => $request->customer_name ?? $user->name,
                'email'            => $request->email ?? $user->email,
                'phone'            => $request->phone ?? $user->phone,
                'address'          => $request->address,
                'city'             => $request->city,
                'postal_code'      => $request->postal_code,
                'payment_method'   => $request->payment_method ?? 'cash_on_delivery',
                'notes'            => $request->notes,
                'total'            => $total,
                'status'           => 'pending',
                'delivery_date'    => now()->addDays(3),
                'shipping_address' => $request->address,
            ]);

            foreach ($cartItems as $item) {
                // Check if the product exists and has enough stock
                if (!$item->product) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'The product "' . $item->product_id . '" is not available!');
                }
                if ($item->product->stock >= $item->quantity) {
                    // Decrement stock and create order item only if enough stock is available
                    $item->product->decrement('stock', $item->quantity);

                    OrderItem::create([
                        'order_id'       => $order->id,
                        'product_id'     => $item->product_id,
                        'product_name'   => $item->product->name,
                        'product_price'  => $item->product->price,
                        'quantity'       => $item->quantity,
                        'subtotal'       => $item->product->price * $item->quantity,
                        'special_instructions' => null,
                    ]);
                } else {
                    // Rollback and inform the user if stock is insufficient
                    DB::rollBack();
                    return redirect()->back()->with('error', 'The requested quantity for "' . $item->product->name . '" is not available in stock!');
                }
            }

            DB::commit();
            // Empty the cart only after a successful order placement
            CartItem::where('user_id', $user->id)->delete();

            return redirect()->route('orders.thank-you', $order->id)
                ->with('success', 'Your order has been received! It will be shipped within 3 days and we will contact you soon.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function thankYou(Order $order)
    {
        return view('orders.thank-you', compact('order'));
    }

    public function userOrders()
{
    $user = Auth::user();
    $orders = \App\Models\Order::where('user_id', $user->id)
        ->with('orderItems')
        ->latest()
        ->paginate(10);
    return view('orders.user-orders', compact('orders'));
}

public function show(Order $order)
{
    $order->load('orderItems');

    if (Auth::id() !== $order->user_id) {
        abort(403, 'Unauthorized');
    }

    return view('orders.show', compact('order'));
}

public function cancel(Order $order)
{
    // Optional: Confirm user owns the order
    if (Auth::id() !== $order->user_id) {
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    }

    if ($order->status !== 'pending') {
        return response()->json(['success' => false, 'message' => 'Only pending orders can be cancelled.'], 400);
    }

    $order->status = 'cancelled';
    $order->save();

    return response()->json(['success' => true, 'message' => 'Order cancelled successfully!']);
}

public function updateStatus(Request $request, Order $order)
{
    $request->validate(['status' => 'required|string']);
    $order->status = $request->status;
    $order->save();
    return response()->json(['success' => true, 'status' => $order->status]);
}

public function update(Request $request, $id) {
    $order = Order::findOrFail($id);
    $order->update($request->all());
    return redirect()->back()->with('success', 'Order updated successfully.');
}

}