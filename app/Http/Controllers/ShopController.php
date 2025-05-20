<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    /**
     * Display the shop page with products and filters.
     */
    public function index(Request $request)
    {
        // Start with a base query for active products
        $query = Product::where('active', true);
        
        // Apply filters using query scopes
        $this->applyFilters($query, $request);
        
        // Fetch products with pagination
        $products = $query->paginate(12);
        
        // Get categories for filter dropdown
        $categories = $this->getCategories();
        
        // Get cart items for the current user
        $cartItems = $this->getUserCartItems();
        
        return view('shop.index', compact('products', 'categories', 'cartItems'));
    }
    
    /**
     * Show a single product.
     */
    public function show(Product $product)
    {
        // Get cart items for the current user
        $cartItems = $this->getUserCartItems();
        
        return view('shop.show', compact('product', 'cartItems'));
    }
    
    /**
     * Add a product to cart.
     */
    public function addToCart(Request $request, Product $product)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to add items to cart.');
        }
        
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        
        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();
        
        if ($cartItem) {
            $cartItem->quantity += $validated['quantity'];
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
            ]);
        }
        
        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }
    
    /**
     * Apply filters to the product query.
     */
    private function applyFilters($query, Request $request)
    {
        // Apply category filter - Now using category_id instead of category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Apply price filter
        if ($request->filled('price') && is_numeric($request->price)) {
            $query->where('price', '<=', (float) $request->price);
        }
        
        // Apply search filter with proper input sanitization
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }
        
        // Apply favorites filter (if logged in)
        if (Auth::check() && $request->boolean('favorites_only')) {
            $userId = Auth::id();
            $query->whereHas('favoritedBy', function($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        }
        
        // Apply sorting
        $sortField = in_array($request->sort, ['price', 'created_at', 'name']) 
            ? $request->sort 
            : 'created_at';
            
        $sortDirection = $request->direction === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sortField, $sortDirection);
        
        return $query;
    }
    
    /**
     * Get categories for filter dropdown.
     */
    private function getCategories()
    {
        // Option 1: Hardcoded categories (if you don't have a Category model)
        return [
            'mug' => 'Mugs',
            'bag' => 'Bags',
            'hoodie' => 'Hoodies',
            'art' => 'Wall Art',
            'learn' => 'Workshop'
        ];
        
        // Option 2: Fetch from database (uncomment to use)
        // return Category::pluck('name', 'slug');
    }
    
    /**
     * Get cart items for the current user.
     */
    private function getUserCartItems()
    {
        return Auth::check()
            ? CartItem::where('user_id', Auth::id())->with('product')->get()
            : collect([]);
    }
}