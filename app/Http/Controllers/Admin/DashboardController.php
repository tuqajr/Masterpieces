<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  
        $this->middleware('admin'); 
    }

    public function index()
    {
        $productsCount = Product::count();
        $activeProductsCount = Product::where('status', 'active')->count();
        $ordersCount = Order::count();
        $customersCount = User::where('role', 'customer')->count();

        $recentOrders = Order::with('customer')->orderBy('created_at', 'desc')->take(10)->get();

        $ordersChartLabels = [];
        $ordersChartData = [];
        foreach (
            Order::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
                ->groupBy('month')
                ->orderBy('month', 'asc')
                ->take(6)
                ->get() as $stat
        ) {
            $ordersChartLabels[] = $stat->month;
            $ordersChartData[] = $stat->total;
        }

        $currency = '$';

        return view('admin.dashboard', compact(
            'productsCount',
            'activeProductsCount',
            'ordersCount',
            'customersCount',
            'recentOrders',
            'ordersChartLabels',
            'ordersChartData',
            'currency'
        ));
    }
}