<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index(Request $request)
    {
        // No default status filter - show all orders of all statuses
        $orders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        return view('admin.orders.create');
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,confirmed,preparing,out_for_delivery,delivered,cancelled',
            'total' => 'required|numeric|min:0',
            // Add other fields as needed
        ]);
        
        $order = Order::create($validated);
        
        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,out_for_delivery,delivered,cancelled',
            'total' => 'nullable|numeric|min:0',
            // Add other fields as needed
        ]);
        
        $order->update($validated);
        
        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        
        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    /**
     * Update the status of an order via AJAX.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,out_for_delivery,delivered,cancelled',
        ]);

        $order->status = $data['status'];
        if ($data['status'] === 'delivered') {
            $order->delivered_at = now();
        } else {
            $order->delivered_at = null;
        }
        $order->save();

        return response()->json([
            'success' => true,
            'status'  => $order->status,
        ]);
    }
}