@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container">
    <h1>{{ $product->name }}</h1>
    
    @if (Str::startsWith($product->image, 'http'))
        <img src="{{ $product->image }}" alt="{{ $product->name }}" style="max-width:300px;display:block;margin-bottom:20px;">
    @else
        @php
            // Always use products directory for the image path
            $imagePath = $product->image ? 'storage/products/' . basename($product->image) : 'images/no-image.jpg';
        @endphp
        <img src="{{ asset($imagePath) }}" alt="{{ $product->name }}" style="max-width:300px;display:block;margin-bottom:20px;">
    @endif
    
    <p>{{ $product->description }}</p>
    <p>Price: ${{ number_format($product->price, 2) }}</p>
    
    @if(Auth::check())
        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="cart-add-form">
            @csrf
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="add-to-cart-btn">
                <i class="fas fa-shopping-cart"></i> Add to Cart
            </button>
        </form>
    @else
        <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="add-to-cart-btn">
            <i class="fas fa-shopping-cart"></i> Login to Buy
        </a>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector('.cart-add-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            submitBtn.disabled = true;
            
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: new URLSearchParams(new FormData(form))
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                Swal.fire({
                    title: "Added to Cart!",
                    text: data.message || "Product added to cart successfully",
                    icon: "success",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#913333"
                });
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
            })
            .catch(error => {
                Swal.fire({
                    title: "Error",
                    text: "There was a problem adding this item to your cart. Please try again or log in if you haven't already.",
                    icon: "error",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#913333"
                });
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
            });
        });
    }
});
</script>
@endsection