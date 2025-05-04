<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Show the admin dashboard with statistics.
     */
    public function index()
    {
        // Get count of users
        $userCount = User::count();

        // Get count of products
        $productCount = Product::count();

        // Get count of orders
        $orderCount = Order::count();

        // Get total revenue
        $revenue = Order::where('status', 'delivered')->sum('total_amount');

        // Get recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Get monthly sales data
        $monthlySales = Order::where('status', 'delivered')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_amount) as total'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Format data for chart
        $salesData = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = date('F', mktime(0, 0, 0, $i, 1));
            $amount = 0;

            foreach ($monthlySales as $sale) {
                if ($sale->month == $i) {
                    $amount = $sale->total;
                    break;
                }
            }

            $salesData[$month] = $amount;
        }

        return view('admin.dashboard', compact(
            'userCount',
            'productCount',
            'orderCount',
            'revenue',
            'recentOrders',
            'salesData'
        ));
    }
}