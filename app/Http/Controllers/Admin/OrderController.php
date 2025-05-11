<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        $orders = Order::latest()->paginate(10); // Fetch orders with pagination
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::findOrFail($id); // Find the order by ID or throw a 404
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the status of the specified order.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,completed,canceled',
        ]);

        $order = Order::findOrFail($id); // Find the order by ID or throw a 404
        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Order status updated successfully.');
    }
}