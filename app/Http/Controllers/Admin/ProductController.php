<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::all(); 
        View::share('cartItems', collect([]));

        return view('admin.products.index', compact('products'));

    }
    

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|url',
        'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle main image
    if ($request->has('image') && filter_var($request->image, FILTER_VALIDATE_URL)) {
        $validated['image'] = $request->image;
    } elseif ($request->hasFile('image_file')) {
        $validated['image'] = $request->file('image_file')->store('products', 'public');
    }

    // Handle gallery images
    $galleryPaths = [];
    if ($request->hasFile('gallery')) {
        foreach ($request->file('gallery') as $file) {
            $galleryPaths[] = $file->store('products/gallery', 'public');
        }
    }

    $validated['gallery'] = json_encode($galleryPaths); // Optional: store as JSON string in DB

    Product::create($validated);

    return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
}

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->has('image') && filter_var($request->image, FILTER_VALIDATE_URL)) {
            $product->image = $request->image;
        } elseif ($request->hasFile('image_file')) {
            // Delete old image if local
            if ($product->image && !filter_var($product->image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image_file')->store('products', 'public');
        }

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'image' => $product->image,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        if ($product->image && !filter_var($product->image, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}
