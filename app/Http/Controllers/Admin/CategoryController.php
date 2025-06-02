<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
       $categories = Category::withCount('products')->get();
    $products = \App\Models\Product::with('category')->get(); 
    return view('admin.categories.index', compact('categories', 'products'));
    }

public function create()
{
    return view('admin.Categories.create');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:categories,name',
    ]);

    \App\Models\Category::create($validated);

    return redirect()->route('admin.categories.index')->with('success', 'Category created!');
}

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
            'description' => 'nullable|string',
        ]);

        $category->name = $validated['name'];
        $category->slug = Str::slug($validated['name']);
        $category->description = $validated['description'] ?? null;
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully');
    }
}