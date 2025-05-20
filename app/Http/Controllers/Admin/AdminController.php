<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
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


    public function storeProduct(Request $request)
{
    // Validate request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        // other validations
    ]);
    
    // Handle image upload
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        
        // Store in the products directory
        $path = $image->storeAs('products', $imageName, 'public');
        
        // Set the database path - important! Store the relative path, not full path
        $validatedData['image'] = $path;
    }
    
    // Create or update product
    $product = Product::create($validatedData);
    
    return redirect()->route('admin.products')->with('success', 'Product created successfully');
}
}