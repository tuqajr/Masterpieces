@extends('layouts.admin')

@section('title', 'Product Details')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Product Details</h1>
    
    <div class="card">
        <div class="card-body">
            <h5><strong>Name:</strong> {{ $product->name }}</h5>
            <p><strong>Description:</strong> {{ $product->description }}</p>
            <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
            <p><strong>Created At:</strong> {{ $product->created_at ? $product->created_at->format('M d, Y') : 'N/A' }}</p>
            <p><strong>Updated At:</strong> {{ $product->updated_at ? $product->updated_at->format('M d, Y') : 'N/A' }}</p>
            
            @if($product->image)
                <div>
                    <strong>Image:</strong><br>
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" width="200">
                </div>
            @else
                <p><strong>Image:</strong> No image available</p>
            @endif
        </div>
    </div>
    
    <div class="mt-4">
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back to Products</a>
    </div>
</div>
@endsection