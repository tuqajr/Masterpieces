<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    /**
     * Display a listing of orders.
     */
    public function orders()
    {
        // Fetch all orders from the database
        $orders = Order::all();

        // Return a view to display the orders
        return view('admin.orders.index', compact('orders'));
    }
}