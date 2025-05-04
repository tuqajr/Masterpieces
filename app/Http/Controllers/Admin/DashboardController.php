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
        $productsCount = \App\Models\Product::count();
        $activeProductsCount = \App\Models\Product::where('status', 'active')->count();

        return view('admin.dashboard', compact('productsCount', 'activeProductsCount'));
    }
    
}