@extends('layouts.app')

@section('content')
<div class="container">
    <div class="product-detail">
        <div class="product-gallery">
            <div class="main-image">
                <img id="mainImage" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            </div>
            
            <!-- Additional images gallery -->
            @if(isset($product->gallery) && count($product->gallery) > 0)
            <div class="thumbnail-container">
                <div class="thumbnail active" data-image="{{ asset('storage/' . $product->image) }}">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                </div>
                @foreach($product->gallery as $image)
                <div class="thumbnail" data-image="{{ asset('storage/' . $image) }}">
                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}">
                </div>
                @endforeach
            </div>
            @endif
        </div>
        
        <div class="product-info">
            <h1>{{ $product->name }}</h1>
            <p class="price">${{ number_format($product->price, 2) }}</p>
            
            <div class="product-description">
                <h3>Description</h3>
                <p>{{ $product->description }}</p>
            </div>
            
            <div class="product-actions">
            @if ((int) $product->stock > 0)
            <form method="POST" action="{{ route('cart.add') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="quantity-selector">
                            <label for="quantity">Quantity:</label>
                            <div class="quantity-controls">
                                <button type="button" class="quantity-btn decrease" onclick="decreaseQuantity()">-</button>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}">
                                <button type="button" class="quantity-btn increase" onclick="increaseQuantity()">+</button>
                            </div>
                        </div>
                        <div class="stock-info">
                            <span>{{ $product->stock }} items in stock</span>
                        </div>
                        <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                    </form>
                @else
                    <p class="out-of-stock">This product is currently out of stock.</p>
                @endif
                
                <a href="{{ route('shop') }}" class="back-to-shop-btn">
                    <i class="fas fa-arrow-left"></i> Back to Shop
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    /* Product Detail Page Styles */
    .container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
        font-family: 'Reem Kufi', sans-serif;
    }
    
    .product-detail {
        display: flex;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    /* Gallery Styles */
    .product-gallery {
        flex: 1;
        padding: 30px;
        background-color: #f9f9f9;
        display: flex;
        flex-direction: column;
    }
    
    .main-image {
        width: 100%;
        height: 400px;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 20px;
    }
    
    .main-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .main-image:hover img {
        transform: scale(1.05);
    }
    
    .thumbnail-container {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding: 10px 0;
    }
    
    .thumbnail {
        width: 80px;
        height: 80px;
        border-radius: 6px;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        transition: border-color 0.3s ease;
    }
    
    .thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .thumbnail.active {
        border-color: rgb(145, 51, 51);
    }
    
    /* Product Info Styles */
    .product-info {
        flex: 1;
        padding: 30px;
        display: flex;
        flex-direction: column;
    }
    
    .product-info h1 {
        color: rgb(145, 51, 51);
        font-size: 2rem;
        margin-bottom: 15px;
    }
    
    .price {
        color: #d9534f;
        font-size: 1.6rem;
        font-weight: bold;
        margin-bottom: 20px;
    }
    
    .product-description {
        margin-bottom: 30px;
    }
    
    .product-description h3 {
        color: rgb(145, 51, 51);
        font-size: 1.3rem;
        margin-bottom: 10px;
    }
    
    .product-description p {
        color: #555;
        line-height: 1.7;
        font-size: 1rem;
    }
    
    /* Quantity Selector Styles */
    .quantity-selector {
        margin-bottom: 15px;
    }
    
    .quantity-selector label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
    }
    
    .quantity-controls {
        display: flex;
        align-items: center;
        max-width: 150px;
    }
    
    .quantity-btn {
        width: 35px;
        height: 35px;
        background-color: #f1f1f1;
        border: 1px solid #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }
    
    .quantity-btn.decrease {
        border-radius: 4px 0 0 4px;
    }
    
    .quantity-btn.increase {
        border-radius: 0 4px 4px 0;
    }
    
    .quantity-btn:hover {
        background-color: #e4e4e4;
    }
    
    input[type="number"] {
        width: 60px;
        height: 35px;
        border: 1px solid #ddd;
        text-align: center;
        font-size: 1rem;
        border-left: none;
        border-right: none;
        -moz-appearance: textfield;
        /* Add standard appearance property */
        appearance: textfield;
    }
    
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    
    .stock-info {
        margin-bottom: 20px;
        font-size: 0.9rem;
        color: #666;
    }
    
    /* Button Styles */
    .product-actions {
        margin-top: auto;
    }
    
    .add-to-cart-btn {
        display: block;
        width: 100%;
        padding: 12px;
        background-color: rgb(145, 51, 51);
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 1.1rem;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-bottom: 15px;
        text-align: center;
    }
    
    .add-to-cart-btn:hover {
        background-color: #7c2828;
    }
    
    .back-to-shop-btn {
        display: inline-block;
        padding: 10px 15px;
        color: #555;
        text-decoration: none;
        font-size: 0.95rem;
        transition: color 0.3s ease;
    }
    
    .back-to-shop-btn:hover {
        color: rgb(145, 51, 51);
    }
    
    .out-of-stock {
        padding: 12px;
        background-color: #f8d7da;
        color: #721c24;
        border-radius: 6px;
        text-align: center;
        font-weight: 500;
        margin-bottom: 15px;
    }
    
    /* Responsive Styles */
    @media (max-width: 992px) {
        .product-detail {
            flex-direction: column;
        }
        
        .product-gallery, .product-info {
            width: 100%;
        }
        
        .main-image {
            height: 350px;
        }
    }
    
    @media (max-width: 576px) {
        .main-image {
            height: 300px;
        }
        
        .thumbnail {
            width: 60px;
            height: 60px;
        }
        
        .product-info h1 {
            font-size: 1.7rem;
        }
    }
</style>

<script>
    // Add event listeners to all thumbnails
    document.addEventListener('DOMContentLoaded', function() {
        const thumbnails = document.querySelectorAll('.thumbnail');
        thumbnails.forEach(function(thumbnail) {
            thumbnail.addEventListener('click', function() {
                const imageSrc = this.getAttribute('data-image');
                document.getElementById('mainImage').src = imageSrc;
                
                // Update active thumbnail
                thumbnails.forEach(function(thumb) {
                    thumb.classList.remove('active');
                });
                this.classList.add('active');
            });
        });
    });
    
    function decreaseQuantity() {
        const input = document.getElementById('quantity');
        if (input.value > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
    
    function increaseQuantity(maxStock) {
        const input = document.getElementById('quantity');
        const max = parseInt(maxStock);
        if (parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
        }
    }
</script>
@endsection