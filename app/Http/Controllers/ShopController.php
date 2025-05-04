<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    /**
     * Display the shop page with filtered or all products.
     */
    public function index(Request $request)
    {
        $query = Product::query()->where('active', true);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('price')) {
            $query->where('price', '<=', $request->price);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $products = $query->paginate(12);

        // Get cart items for the current user if logged in, otherwise empty collection
        $cartItems = Auth::check()
            ? CartItem::where('user_id', Auth::id())->with('product')->get()
            : collect([]);

        return view('shop.index', compact('products', 'cartItems'));
    }

    /**
     * Show a single product.
     */
    public function show(Product $product)
    {
        $cartItems = Auth::check()
            ? CartItem::where('user_id', Auth::id())->with('product')->get()
            : collect([]);

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
}
