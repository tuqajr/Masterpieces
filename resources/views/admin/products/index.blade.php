@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="admin-header">
        <h1>Products</h1>
        <a href="{{ route('admin.products.create') }}" class="btn-add">Add New Product</a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="product-list">
        <table class="products-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            <img class="product-image" src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td class="actions">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="no-products">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Pagination Links -->
        <div class="pagination-container">
            {{ $products->links() }}
        </div>
    </div>
</div>

<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    
    .admin-header h1 {
        color: rgb(145, 51, 51);
        margin: 0;
    }
    
    .btn-add {
        background-color: rgb(145, 51, 51);
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }
    
    .btn-add:hover {
        background-color: #d9534f;
    }
    
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
    }
    
    .alert-success {
        background-color: #dff0d8;
        color: #3c763d;
        border: 1px solid #d6e9c6;
    }
    
    .products-table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        border-radius: 5px;
        overflow: hidden;
    }
    
    .products-table th,
    .products-table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .products-table th {
        background-color: #f8f9fa;
        font-weight: bold;
        color: #555;
    }
    
    .product-image {
        width: 80px;
        height: 80px;
        border-radius: 4px;
        border: 1px solid #eee;
        object-fit: cover;
    }
    
    .actions {
        display: flex;
        gap: 10px;
    }
    
    .btn-edit, .btn-delete {
        padding: 8px 15px;
        border-radius: 4px;
        text-decoration: none;
        text-align: center;
        font-size: 14px;
        cursor: pointer;
    }
    
    .btn-edit {
        background-color: #5bc0de;
        color: white;
        border: none;
    }
    
    .btn-edit:hover {
        background-color: #46b8da;
    }
    
    .btn-delete {
        background-color: #d9534f;
        color: white;
        border: none;
    }
    
    .btn-delete:hover {
        background-color: #c9302c;
    }
    
    .no-products {
        text-align: center;
        color: #777;
        padding: 30px 0;
        font-style: italic;
    }
    
    .pagination-container {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }
    
    /* Pagination Styling */
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 5px;
    }
    
    .pagination li {
        display: inline-block;
    }
    
    .pagination li a, 
    .pagination li span {
        display: block;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        color: #666;
        text-decoration: none;
    }
    
    .pagination li.active span {
        background-color: rgb(145, 51, 51);
        color: white;
        border-color: rgb(145, 51, 51);
    }
    
    .pagination li a:hover {
        background-color: #f5f5f5;
    }
</style>
@endsection