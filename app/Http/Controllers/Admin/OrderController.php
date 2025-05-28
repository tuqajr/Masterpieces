<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['user', 'orderItems'])
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->payment_status, function ($query) use ($request) {
                $query->where('payment_status', $request->payment_status);
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('order_number', 'like', "%{$request->search}%")
                      ->orWhereHas('user', function($qq) use ($request) {
                          $qq->where('name', 'like', "%{$request->search}%")
                             ->orWhere('phone', 'like', "%{$request->search}%");
                      });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderItems']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
{
    $request->validate([
        'status' => 'required|in:pending,confirmed,preparing,out_for_delivery,delivered,cancelled'
    ]);

    $order->status = $request->status;
    if ($request->status === 'delivered') {
        $order->delivered_at = now();
    } else {
        $order->delivered_at = null;
    }
    $order->save();

    // AJAX
    if ($request->ajax() || $request->wantsJson()) {
        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'status'  => $order->status
        ]);
    }

    return back()->with('success', 'Order status updated!');
}
}