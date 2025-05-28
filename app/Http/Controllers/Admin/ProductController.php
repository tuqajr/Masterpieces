<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        $categories = Category::all();
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }


    public function updateCategory(Request $request, Product $product)
{
    $validated = $request->validate([
        'category_id' => 'nullable|exists:categories,id',
    ]);

    $product->category_id = $validated['category_id'];
    $product->save();

    return redirect()->route('admin.categories.index')->with('success', 'Category updated for product!');
}

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'extra_images' => 'nullable|array',
        'extra_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $product = new Product();
    $product->name = $validated['name'];
    $product->description = $validated['description'];
    $product->price = $validated['price'];

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
        $product->image = $imagePath;
    }
    $product->save();

    if ($request->hasFile('extra_images')) {
        foreach ($request->file('extra_images') as $image) {
            if ($image && $image->isValid()) {
                $path = $image->store('products/extra', 'public');
                $product->images()->create(['image' => $path]);
            }
        }
    }

    return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
}

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // No limit on the number of extra images
            'extra_images' => 'nullable|array',
            'extra_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $validated['name'];
        $product->description = $validated['description'];
        $product->price = $validated['price'];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        if ($request->hasFile('extra_images')) {
            foreach ($request->file('extra_images') as $image) {
                $path = $image->store('products/extra', 'public');
                $product->images()->create(['image' => $path]);
            }
        }
        if ($request->hasFile('extra_images')) {
    foreach ($request->file('extra_images') as $image) {
        if ($image && $image->isValid()) {
            $path = $image->store('products/extra', 'public');
            $product->images()->create(['image' => $path]);
        }
    }
}

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete main image if exists
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete extra images if exist
        foreach ($product->images as $image) {
            if ($image->image && Storage::disk('public')->exists($image->image)) {
                Storage::disk('public')->delete($image->image);
            }
            $image->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }
}