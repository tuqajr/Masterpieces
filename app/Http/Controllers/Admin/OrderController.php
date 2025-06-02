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
    // Define the sequence of statuses
    $steps = ['pending', 'confirmed', 'preparing', 'delivered'];
    $currentStep = array_search($order->status, $steps);
    $progressWidth = $currentStep !== false ? (($currentStep) / (count($steps) - 1)) * 100 : 0;

    return view('orders.show', compact('order', 'progressWidth', 'steps'));
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

        return response()->json([
            'success' => true,
            'status'  => $order->status,
            'message' => 'Order status updated successfully',
        ]);
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed'
        ]);

        $order->payment_status = $request->payment_status;
        $order->save();

        return response()->json([
            'success' => true,
            'payment_status' => $order->payment_status,
            'message' => 'Payment status updated successfully',
        ]);
    }
}