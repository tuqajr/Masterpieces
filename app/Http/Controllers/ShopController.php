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
        $query = Product::where('active', true);

        // Apply filters using query scopes
        $this->applyFilters($query, $request);

        // Paginate products
        $products = $query->paginate(12);

        // Get categories for filter dropdown from the database (array of names)
        $categories = $this->getCategories();

        // Get cart items for current user
        $cartItems = $this->getUserCartItems();

        return view('shop.index', compact('products', 'categories', 'cartItems'));
    }

    /**
     * Display a single product.
     */
    public function show(Product $product)
    {
        $cartItems = $this->getUserCartItems();

        return view('shop.show', compact('product', 'cartItems'));
    }

    /**
     * Add a product to the cart.
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
        // Filter by category name
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // Filter by max price
        if ($request->filled('price') && is_numeric($request->price)) {
            $query->where('price', '<=', (float) $request->price);
        }

        // Search filter
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Favorites only (if logged in)
        if (Auth::check() && $request->boolean('favorites_only')) {
            $userId = Auth::id();
            $query->whereHas('favoritedByUsers', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        }

        // Sorting
        $sortField = in_array($request->sort, ['price', 'created_at', 'name']) 
            ? $request->sort 
            : 'created_at';

        $sortDirection = $request->direction === 'asc' ? 'asc' : 'desc';

        $query->orderBy($sortField, $sortDirection);

        return $query;
    }

    /**
     * Get categories for the filter dropdown from the database.
     * Returns an array of category names (strings).
     */
    private function getCategories()
    {
        // Fetch all unique category names from the database (ordered by name)
        return \App\Models\Category::orderBy('name')->pluck('name')->toArray();
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