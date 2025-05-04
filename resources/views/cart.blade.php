@extends('layouts.app')

@section('content')


<link rel="stylesheet" href="css/navbar-footer.css">

<link href="https://fonts.googleapis.com/css2?family=Orpheus+Pro&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Alkalami&family=Badeen+Display&family=Handjet:wght@100..900&family=Reem+Kufi+Fun:wght@400..700&family=Reem+Kufi:wght@400..700&family=Ruwudu:wght@400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
<header>
    <div class="navbar">
        <div class="icons">
            <a href="{{ route('cart.show') }}" class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <span id="cart-count">{{ $cartItems->count() }}</span>
            </a>
            
            <div class="login-register-dropdown">
                <a href="#" class="dropdown-toggle">
                    <span style="margin-right: 5px;">Welcome,</span>
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
        </div>
        
        <ul id="navMenu">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/shop') }}">Shop</a></li>
            <li><a href="{{ url('/about') }}">About</a></li>
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
    
    @if($cartItems->isEmpty())
        <div class="empty-cart">
            <p>Your cart is empty. <a href="{{ url('/shop') }}">Continue shopping</a></p>
        </div>
    @else
        <div class="cart-items">
            @foreach($cartItems as $item)
                <div class="cart-item">
                    <div class="cart-item-image">
                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
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
<footer class="footer">
    <div class="footer-container">
        <div class="footer-section">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/shop') }}">Shop</a></li>
                <li><a href="{{ url('/about') }}">About Us</a></li>
                <li><a href="{{ url('/contact') }}">Contact Us</a></li>
                <li><a href="{{ url('/privacy') }}">Privacy Policy</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Customer Service</h3>
            <ul>
                <li><a href="{{ url('/faq') }}">FAQ</a></li>
                <li><a href="{{ url('/shipping') }}">Shipping Information</a></li>
                <li><a href="{{ url('/returns') }}">Returns & Exchanges</a></li>
                <li><a href="{{ url('/terms') }}">Terms & Conditions</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Connect With Us</h3>
            <div class="social-icons">
                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-pinterest"></i></a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Tatreez. All Rights Reserved.</p>
        <div class="payment-methods">
            <img src="{{ asset('images/payment/visa.png') }}" alt="Visa">
            <img src="{{ asset('images/payment/mastercard.png') }}" alt="Mastercard">
            <img src="{{ asset('images/payment/paypal.png') }}" alt="PayPal">
        </div>
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
    
    /* Navbar Styles */
    
    
   
    /* Container Styles - Cart specific styles */
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
    .footer {
        background-color: #333;
        color: #fff;
        padding: 50px 0 20px;
        margin-top: 50px;
    }
    
    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        padding: 0 20px;
    }
    
    .footer-section {
        flex: 1;
        min-width: 200px;
        margin-bottom: 30px;
    }
    
    .footer-section h3 {
        color: #fff;
        font-size: 1.2rem;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
    }
    
    .footer-section h3::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 2px;
        background-color: rgb(145, 51, 51);
    }
    
    .footer-section ul {
        list-style: none;
    }
    
    .footer-section ul li {
        margin-bottom: 10px;
    }
    
    .footer-section ul li a {
        color: #ccc;
        text-decoration: none;
        transition: color 0.3s;
    }
    
    .footer-section ul li a:hover {
        color: rgb(145, 51, 51);
    }
    
    .social-icons {
        display: flex;
        gap: 15px;
    }
    
    .social-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        color: #fff;
        transition: background-color 0.3s;
    }
    
    .social-icon:hover {
        background-color: rgb(145, 51, 51);
    }
    
    .footer-bottom {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .footer-bottom p {
        color: #ccc;
    }
    
    .payment-methods {
        display: flex;
        gap: 10px;
    }
    
    .payment-methods img {
        height: 30px;
        width: auto;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .navbar {
            flex-wrap: wrap;
        }
        
        .logo-container {
            order: 1;
            margin-bottom: 10px;
        }
        
        #navMenu {
            order: 3;
            width: 100%;
            display: none;
            flex-direction: column;
            margin-top: 15px;
        }

        #navMenu.active {
            display: flex;
        }

         #navMenu li {
            margin: 10px 0;
        }
        
        .icons {
            order: 2;
        }
        
        
        .menu-toggle {
            display: block;
            order: 3;
        }
    }
    
    @media (max-width: 768px) {
        .footer-section {
            flex: 0 0 100%;
        }
        
        .footer-bottom {
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }
        
        .cart-item {
            flex-direction: column;
        }
        
        .cart-item-image {
            width: 100%;
            margin-right: 0;
            margin-bottom: 15px;
        }
        
        .cart-item-total {
            text-align: left;
            margin-top: 15px;
        }
    }
</style>

<script>
// Cart functionality
        let cart = JSON.parse(localStorage.getItem("cart")) || [];

        function updateCartCount() {
            const cartCountElement = document.getElementById("cart-count");
            if (cartCountElement) {
                cartCountElement.textContent = cart.length;
            }
        }

        document.addEventListener("DOMContentLoaded", updateCartCount);

        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.getElementById('navMenu');
    
    menuToggle.addEventListener('click', function() {
        navMenu.classList.toggle('show');
    });
    
    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        const isClickInsideMenu = navMenu.contains(event.target);
        const isClickOnToggle = menuToggle.contains(event.target);
        
        if (!isClickInsideMenu && !isClickOnToggle && navMenu.classList.contains('show')) {
            navMenu.classList.remove('show');
        }
    });
});


    </script>
    <script src="js/navbar-footer.js"></script>
@endsection