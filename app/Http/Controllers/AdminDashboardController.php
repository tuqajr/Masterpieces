<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get counts for dashboard summary
        $productCount = Product::count();
        $orderCount = Order::count();
        $userCount = User::count();
        $pendingOrderCount = Order::where('status', 'pending')->count();
        
        // Get recent orders
        $recentOrders = Order::with('user')
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();
        
        // Get top selling products
        $topProducts = Product::withCount('orderItems')
                            ->orderBy('order_items_count', 'desc')
                            ->take(5)
                            ->get();
        
        return view('admin.dashboard', compact(
            'productCount', 
            'orderCount', 
            'userCount', 
            'pendingOrderCount',
            'recentOrders',
            'topProducts'
        ));
    }
}