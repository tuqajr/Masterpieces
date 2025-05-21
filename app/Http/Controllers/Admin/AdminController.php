<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Http\Controllers\Controller;

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

    public function dashboard()
    {
        // Count products
        $productsCount = Product::count();
        $activeProductsCount = Product::where('is_active', 1)->count();
        
        // Count orders
        $ordersCount = Order::count();
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        
        // Get recent orders
        $recentOrders = Order::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'productsCount', 
            'activeProductsCount', 
            'ordersCount', 
            'pendingOrdersCount',
            'recentOrders'
        ));
    }
}