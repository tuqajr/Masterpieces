@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="{{ asset('css/navbar-footer.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Orpheus+Pro&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Alkalami&family=Badeen+Display&family=Handjet:wght@100..900&family=Reem+Kufi+Fun:wght@400..700&family=Reem+Kufi:wght@400..700&family=Ruwudu:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<header>
    <div class="navbar">
        <div class="icons">
            @if(Auth::check())
            <a href="{{ route('cart.show') }}" class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <span id="cart-count">
                    {{ $cartItems->sum('quantity') }}
                </span>
            </a>
            @endif
            @if(Auth::check())
            <div class="login-register-dropdown">
                <a href="#" class="dropdown-toggle">
                    <span style="margin-right: 5px;">Hello,</span>
                    <span>{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-content">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </div>
            </div>
            @else
            <div class="login-register">
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            </div>
            @endif
        </div>
        
        <ul id="navMenu">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/shop') }}">Shop</a></li>
            <li><a href="{{ url('/about') }}">About Us</a></li>
            <li><a href="{{ url('/learn') }}">Learn</a></li>
            <li><a href="{{ url('/contact') }}">Contact</a></li>
        </ul>
        
        <div class="logo-container">
            <span class="logo-text">غرزه</span>
            <img src="{{ asset('images/embroidery_1230695.png') }}" alt="Logo">
        </div>
        
        <div class="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>
    </div>
</header>

<!-- Main Content -->
<div class="container">
    <h1>Your Shopping Cart</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($cartItems->isEmpty())
        <div class="empty-cart">
            <p>Your cart is empty. <a href="{{ url('/shop') }}">Continue Shopping</a></p>
        </div>
    @else
        <div class="cart-items">
            @foreach($cartItems as $item)
                <div class="cart-item">
                   <div class="cart-item-image">
    @if (Str::startsWith($item->product->image, 'http'))
        <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}">
    @else
        @php
            // Always use products directory for the image path
            $imagePath = $item->product->image ? 'storage/products/' . basename($item->product->image) : 'images/placeholder.png';
        @endphp
        <img src="{{ asset($imagePath) }}" alt="{{ $item->product->name }}">
    @endif
</div>
                    <div class="cart-item-details">
                        <h4>{{ $item->product->name }}</h4>
                        <p>{{ Str::limit($item->product->description, 100) }}</p>
                        <p class="price">${{ number_format($item->product->price, 2) }}</p>
                        <form action="{{ route('cart.update') }}" method="POST" class="quantity-form">
                            @csrf
                            <input type="hidden" name="cart_item_id" value="{{ $item->id }}">
                            <div class="quantity-control">
                                <label for="quantity">Quantity:</label>
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="99">
                                <button type="submit" class="update-btn">Update</button>
                            </div>
                        </form>
                        <form action="{{ route('cart.remove') }}" method="POST" class="remove-form">
                            @csrf
                            <input type="hidden" name="cart_item_id" value="{{ $item->id }}">
                            <button type="submit" class="remove-btn">Remove</button>
                        </form>
                    </div>
                    <div class="cart-item-total">
                        <p>Total: ${{ number_format($item->product->price * $item->quantity, 2) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="cart-summary">
            <h3>Order Summary</h3>
            <div class="summary-row">
                <span>Subtotal:</span>
                <span>${{ number_format($total, 2) }}</span>
            </div>
            <div class="summary-row">
                <span>Shipping:</span>
                <span>Free</span>
            </div>
            <div class="summary-row total">
                <span>Total:</span>
                <span>${{ number_format($total, 2) }}</span>
            </div>
            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <button type="submit" class="checkout-btn">Proceed to Checkout</button>
            </form>
        </div>
    @endif
</div>

<!-- Footer Section -->
<footer>
    <div class="footer-container">
        <div class="footer-section">
            <h4>Tatreez Traditions</h4>
            <p>Preserving Palestinian embroidery heritage through authentic products and educational resources.</p>
            <div class="footer-social">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-pinterest-p"></i></a>
            </div>
        </div>
        
        <div class="footer-section">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/shop') }}">Shop</a></li>
                <li><a href="{{ url('/learn') }}">Learn</a></li>
                <li><a href="{{ url('/about') }}">About</a></li>
                <li><a href="{{ url('/contact') }}">Contact</a></li>
            </ul>
        </div>
        
        <div class="footer-section">
            <h4>Contact</h4>
            <ul>
                <li><a href="mailto:info@tatreez.com">info@tatreez.com</a></li>
                <li><a href="tel:+123456789">+123 456 789</a></li>
                <li>123 Embroidery Street<br>Artisan District<br>Amman, Jordan</li>
            </ul>
        </div>
    </div>
    
    <div class="footer-bottom">
        <p>&copy; 2025 Tatreez Traditions. All rights reserved.</p>
    </div>
</footer>


<style>
   
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Reem Kufi', sans-serif;
        background-color: #f9f9f9;
        color: #333;
    }
    
    /* Container Styles */
    .container {
        max-width: 1200px;
        margin: 30px auto;
        padding: 20px;
        font-family: 'Reem Kufi', sans-serif;
    }
    
    h1 {
        color: rgb(145, 51, 51);
        margin-bottom: 30px;
        text-align: center;
        font-size: 2.5rem;
        font-weight: bold;
        font-family: 'Reem Kufi', sans-serif;
    }
    
    .empty-cart {
        text-align: center;
        padding: 40px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .empty-cart a {
        color: rgb(145, 51, 51);
        text-decoration: none;
        font-weight: bold;
    }
    
    .cart-items {
        margin-bottom: 30px;
    }
    
    .cart-item {
        display: flex;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-bottom: 15px;
        padding: 15px;
    }
    
    .cart-item-image {
        width: 120px;
        margin-right: 20px;
    }
    
    .cart-item-image img {
        width: 100%;
        border-radius: 4px;
        object-fit: cover;
    }
    
    .cart-item-details {
        flex: 1;
    }
    
    .cart-item-details h4 {
        color: rgb(145, 51, 51);
        margin-top: 0;
        margin-bottom: 10px;
        font-size: 1.2rem;
    }
    
    .price {
        color: #d9534f;
        font-weight: bold;
        font-size: 1.1rem;
        margin: 8px 0;
    }
    
    .quantity-form, .remove-form {
        display: inline-block;
        margin-right: 10px;
    }
    
    .quantity-control {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }
    
    .quantity-control label {
        margin-right: 10px;
    }
    
    .quantity-control input {
        width: 60px;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-right: 10px;
    }
    
    .update-btn, .remove-btn, .checkout-btn {
        background-color: rgb(145, 51, 51);
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s;
    }
    
    .update-btn:hover, .checkout-btn:hover {
        background-color: #d9534f;
    }
    
    .remove-btn {
        background-color: #6c757d;
    }
    
    .remove-btn:hover {
        background-color: #5a6268;
    }
    
    .cart-item-total {
        text-align: right;
        min-width: 120px;
        font-weight: bold;
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }
    
    .cart-summary {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        padding: 20px;
    }
    
    .cart-summary h3 {
        color: rgb(145, 51, 51);
        margin-bottom: 15px;
        font-size: 1.5rem;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        padding: 5px 0;
    }
    
    .summary-row.total {
        border-top: 1px solid #ddd;
        padding-top: 15px;
        margin-top: 15px;
        font-weight: bold;
        font-size: 1.2rem;
    }
    
    .checkout-btn {
        width: 100%;
        padding: 15px;
        margin-top: 20px;
        font-size: 16px;
        font-weight: bold;
        letter-spacing: 0.5px;
    }
     /* Footer Styles */
    footer {
        background-color: #913333;
        color: white;
        padding: 20px 0;
        margin-top: 50px;
    }
    
    .footer-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .footer-section {
        flex: 1;
        min-width: 250px;
        margin-bottom: 20px;
    }

    .footer-section h4 {
        color: #d4af37;
        font-family: 'Reem Kufi', sans-serif;
        margin-bottom: 15px;
        font-size: 20px;
        font-weight: bolder;
    }

    .footer-section p {
        color: white;
        margin-bottom: 12px;
        font-size: 16px;
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
    }

    .footer-section ul li {
        margin-bottom: 10px;
    }

    .footer-section ul li a {
        color: #fff;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-section ul li a:hover {
        color: #d4af37;
    }

    .footer-social {
        display: flex;
        gap: 15px;
    }

    .footer-social a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background-color: #9b3737;
        color: white;
        border-radius: 50%;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .footer-social a:hover {
        background-color: #7c2828;
        transform: translateY(-3px);
    }

    .footer-bottom {
        text-align: center;
        padding: 20px 0;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin-top: 20px;
    }

    .footer-bottom p {
        color: #fff;
        margin: 0;
    }
     @media (max-width: 768px) {
        
        .footer-container {
            flex-direction: column;
        }
        
        .footer-section {
            margin-bottom: 30px;
        }
        
        .filter-group {
            flex-basis: 100%;
            margin-right: 0;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', async (event) => {
            event.preventDefault();
            const form = button.closest('form');
            const formData = new FormData(form);

            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
            });

            if (response.ok) {
                const data = await response.json();
                document.getElementById('cart-count').textContent = data.cart_count;
                Swal.fire('Success', data.message, 'success');
            }
        });
    });
});
</script>
@endsection