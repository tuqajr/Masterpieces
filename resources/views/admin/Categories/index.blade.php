@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="admin-header">
        <h1>Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn-add">Add New Category</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="category-list">
        <table class="products-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th>Products Count</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>{{ $category->description }}</td>
                        <td>{{ $category->created_at ? $category->created_at->format('Y-m-d') : '-' }}</td>
                        <td>{{ $category->products_count ?? $category->products()->count() }}</td>
                        <td class="actions">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Delete category?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="no-products">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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
</style>
@endsection