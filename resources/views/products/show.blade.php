@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/navbar-footer.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="container product-detail-container">
    <div class="product-detail-wrapper">
        <div class="product-detail-image">
            @if (Str::startsWith($product->image, 'http'))
                <img src="{{ $product->image }}" alt="{{ $product->name }}">
            @else
                @php
                    // Always use products directory for the image path
                    $imagePath = $product->image ? 'storage/products/' . basename($product->image) : 'images/no-image.jpg';
                @endphp
                <img src="{{ asset($imagePath) }}" alt="{{ $product->name }}">
            @endif
        </div>
        
        <div class="product-detail-info">
            <h1>{{ $product->name }}</h1>
            
            <div class="product-price">${{ number_format($product->price, 2) }}</div>
            
            <div class="product-description">
                <p>{{ $product->description }}</p>
            </div>
            
            @if(Auth::check())
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="cart-add-form">
                    @csrf
                    <div class="quantity-selector">
                        <label for="quantity">Quantity:</label>
                        <div class="quantity-controls">
                            <button type="button" class="quantity-btn minus">-</button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="10">
                            <button type="button" class="quantity-btn plus">+</button>
                        </div>
                    </div>
                    
                    <button type="submit" class="add-to-cart-btn">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="add-to-cart-btn login-to-buy">
                    <i class="fas fa-shopping-cart"></i> Login to Buy
                </a>
            @endif
            
            <div class="product-meta">
                <p><strong>Category:</strong> {{ $product->category ?? 'Uncategorized' }}</p>
                @if($product->material)
                    <p><strong>Material:</strong> {{ $product->material }}</p>
                @endif
                @if($product->size)
                    <p><strong>Size:</strong> {{ $product->size }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Quantity selector functionality
    const minusBtn = document.querySelector('.quantity-btn.minus');
    const plusBtn = document.querySelector('.quantity-btn.plus');
    const quantityInput = document.querySelector('#quantity');
    
    if (minusBtn && plusBtn && quantityInput) {
        minusBtn.addEventListener('click', function() {
            const currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });
        
        plusBtn.addEventListener('click', function() {
            const currentValue = parseInt(quantityInput.value);
            if (currentValue < 10) {
                quantityInput.value = currentValue + 1;
            }
        });
    }
    
    // Add to cart functionality
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
                
                // Update cart count in navbar if it exists
                const cartCountElement = document.getElementById("cart-count");
                if (cartCountElement) {
                    fetch('/cart/count')
                        .then(response => response.json())
                        .then(data => {
                            cartCountElement.textContent = data.count;
                        });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: "Error",
                    text: "There was a problem adding this item to your cart. Please try again.",
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

<style>
.product-detail-container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
    font-family: 'Reem Kufi', sans-serif;
}

.product-detail-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 40px;
    align-items: flex-start;
}

.product-detail-image {
    flex: 1;
    min-width: 300px;
    max-width: 500px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.product-detail-image img {
    width: 100%;
    height: auto;
    display: block;
}

.product-detail-info {
    flex: 1;
    min-width: 300px;
}

.product-detail-info h1 {
    color: #913333;
    font-size: 2.2rem;
    margin-bottom: 15px;
    font-weight: bold;
}

.product-price {
    font-size: 1.8rem;
    font-weight: bold;
    color: #913333;
    margin-bottom: 20px;
}

.product-description {
    margin-bottom: 30px;
    line-height: 1.7;
    color: #333;
    font-size: 1.1rem;
}

.quantity-selector {
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.quantity-selector label {
    font-weight: bold;
    color: #555;
}

.quantity-controls {
    display: flex;
    align-items: center;
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: hidden;
}

.quantity-btn {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f5f5f5;
    border: none;
    font-size: 1.2rem;
    cursor: pointer;
    transition: background-color 0.2s;
}

.quantity-btn:hover {
    background: #e0e0e0;
}

#quantity {
    width: 60px;
    height: 40px;
    text-align: center;
    border: none;
    border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
    font-size: 1rem;
}

.add-to-cart-btn, .login-to-buy {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background-color: #913333;
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 5px;
    font-size: 1.1rem;
    cursor: pointer;
    transition: background-color 0.3s;
    text-decoration: none;
    margin-bottom: 30px;
}

.add-to-cart-btn:hover, .login-to-buy:hover {
    background-color: #7c2828;
}

.product-meta {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.product-meta p {
    margin-bottom: 10px;
    color: #555;
}

@media (max-width: 768px) {
    .product-detail-wrapper {
        flex-direction: column;
    }
    
    .product-detail-image {
        max-width: 100%;
    }
}
</style>
@endsection