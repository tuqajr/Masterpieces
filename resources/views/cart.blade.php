@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

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
                <span id="cart-count">
                    @auth
                        {{ \App\Models\CartItem::where('user_id', Auth::id())->sum('quantity') }}
                    @else
                        0
                    @endauth
                </span>
            </a>
                
            @if(Auth::check())
                <div class="login-register-dropdown">
                    <a href="#" class="dropdown-toggle">
                        <span style="margin-right: 5px;">Welcome,</span>
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                    <div class="dropdown-content">
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        @else
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="login-register-dropdown">
                    <a href="#" class="dropdown-toggle">User</a>
                    <div class="dropdown-content">
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    </div>
                </div>
            @endif
        </div>
        
        <ul id="navMenu">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/shop') }}">Shop</a></li>
            <li><a href="{{ url('/learn') }}">Learn</a></li>
            <li><a href="{{ url('/about') }}">About</a></li>
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
        <div id="cart-content" class="{{ $checkoutMode ? 'hidden' : '' }}">
            <div class="cart-items">
                @foreach($cartItems as $item)
                    <div class="cart-item">
                        <div class="cart-item-image">
                            @if (Str::startsWith($item->product->image, 'http'))
                                <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}">
                            @else
                                @php
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
                <button id="checkout-btn" class="checkout-btn">Proceed to Checkout</button>
            </div>
        </div>

        <!-- Checkout Form Section -->
        <div id="checkout-form" class="{{ !$checkoutMode ? 'hidden' : '' }}">
            <div class="checkout-container">
                <h2>Shipping Information</h2>
                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="customer_name">Full Name</label>
                        <input type="text" id="customer_name" name="customer_name" required value="{{ Auth::user()->name ?? '' }}">
                    </div>
                             
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required value="{{ Auth::user()->email ?? '' }}">
                    </div>
                             
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                             
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" required>
                    </div>
                             
                    <div class="form-row">
                        <div class="form-group half">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" required>
                        </div>
                                         
                        <div class="form-group half">
                            <label for="postal_code">Postal Code</label>
                            <input type="text" id="postal_code" name="postal_code" required>
                        </div>
                    </div>
                             
                    <div class="form-group">
                        <label for="notes">Order Notes (Optional)</label>
                        <textarea id="notes" name="notes" rows="3"></textarea>
                    </div>
                             
                    <h2>Payment Method</h2>
                    <div class="payment-method">
                        <div class="payment-option">
                            <input type="radio" id="cash_on_delivery" name="payment_method" value="cash_on_delivery" checked>
                            <label for="cash_on_delivery">Cash on Delivery</label>
                        </div>
                    </div>
                             
                    <div class="order-summary">
                        <h3>Order Summary</h3>
                        @foreach($cartItems as $item)
                            <div class="summary-item">
                                <span class="item-name">{{ $item->product->name }} × {{ $item->quantity }}</span>
                                <span class="item-price">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                            </div>
                        @endforeach
                                         
                        <div class="summary-total">
                            <span>Total:</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                             
                    <div class="actions">
                        <button type="button" id="back-to-cart" class="secondary-btn">Back to Cart</button>
                        <button type="submit" class="primary-btn">Place Order</button>
                    </div>
                </form>
            </div>
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
    
    .hidden {
        display: none;
    }
    
    /* Cart Styles */
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
    
    /* Checkout Form Styles */
    .checkout-container {
        max-width: 600px; 
        margin: 0 auto;
        background-color: #fff;
        border-radius: 12px; 
        box-shadow: 0 4px 20px rgba(0,0,0,0.1); 
        padding: 30px;
        margin-top: 20px;
        margin-bottom: 20px;
    }
    
    .checkout-container h2 {
        color: rgb(145, 51, 51);
        margin-bottom: 25px;
        font-size: 1.8rem;
        border-bottom: 2px solid #eee;
        padding-bottom: 15px;
        text-align: center;
    }
    
    .form-group {
        margin-bottom: 20px;
    }

    .form-row {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .form-group.half {
        flex: 1;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #444;
        font-size: 14px;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-family: 'Reem Kufi', sans-serif;
        font-size: 16px;
        transition: border-color 0.3s ease;
        box-sizing: border-box;
    }
    
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="tel"]:focus,
    textarea:focus {
        outline: none;
        border-color: rgb(145, 51, 51);
        box-shadow: 0 0 0 3px rgba(145, 51, 51, 0.1);
    }

    .payment-method {
        margin: 25px 0;
    }

    .payment-option {
        display: flex;
        align-items: center;
        padding: 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 10px;
        background-color: #f9f9f9;
        transition: all 0.3s ease;
    }
    
    .payment-option:hover {
        border-color: rgb(145, 51, 51);
        background-color: rgba(145, 51, 51, 0.05);
    }

    .payment-option input[type="radio"] {
        margin-right: 12px;
        transform: scale(1.2);
    }

    .order-summary {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 25px;
        border-radius: 12px;
        margin: 30px 0;
        border: 1px solid #dee2e6;
    }

    .order-summary h3 {
        color: rgb(145, 51, 51);
        margin-bottom: 20px;
        font-size: 1.4rem;
        text-align: center;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        padding: 8px 0;
        border-bottom: 1px solid #ddd;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 3px solid rgb(145, 51, 51);
        font-weight: bold;
        font-size: 1.3rem;
        color: rgb(145, 51, 51);
    }

    .actions {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        margin-top: 30px;
    }

    .primary-btn, .secondary-btn {
        flex: 1;
        padding: 15px 25px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        letter-spacing: 0.5px;
        font-size: 16px;
        transition: all 0.3s ease;
        text-transform: uppercase;
    }
    
    .primary-btn {
        background: linear-gradient(135deg, rgb(145, 51, 51) 0%, #d9534f 100%);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(145, 51, 51, 0.3);
    }

    .primary-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(145, 51, 51, 0.4);
    }
    
    .secondary-btn {
        background-color: transparent;
        color: #6c757d;
        border: 2px solid #6c757d;
    }

    .secondary-btn:hover {
        background-color: #6c757d;
        color: white;
        transform: translateY(-2px);
    }
    
    /* Alert Messages */
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 8px;
        font-weight: 500;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
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
    
    /* Responsive Styles */
    @media (max-width: 768px) {
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
        
        .checkout-container {
            max-width: 95%;
            padding: 20px;
            margin: 10px auto;
        }
        
        .form-row {
            flex-direction: column;
            gap: 0;
        }
        
        .actions {
            flex-direction: column;
            gap: 10px;
        }
        
        .checkout-container h2 {
            font-size: 1.5rem;
        }
        
        .primary-btn, .secondary-btn {
            width: 100%;
        }
        
        .footer-container {
            flex-direction: column;
        }
        
        .footer-section {
            margin-bottom: 30px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.querySelector('.menu-toggle');
        const navMenu = document.querySelector('#navMenu');
        
        if (menuToggle && navMenu) {
            menuToggle.addEventListener('click', function() {
                navMenu.classList.toggle('show');
            });
            
            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.navbar') && navMenu.classList.contains('show')) {
                    navMenu.classList.remove('show');
                }
            });
        }
        
        // Add to cart functionality
        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', async (event) => {
                event.preventDefault();
                const form = button.closest('form');
                const formData = new FormData(form);

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                    });

                    if (response.ok) {
                        const data = await response.json();
                        const cartCountElement = document.getElementById('cart-count');
                        if (cartCountElement) {
                            cartCountElement.textContent = data.cart_count;
                        }
                        // You can replace this with your preferred notification method
                        alert(data.message);
                    }
                } catch (error) {
                    console.error('Error adding to cart:', error);
                }
            });
        });
        
        // Checkout process toggle
        const checkoutBtn = document.getElementById('checkout-btn');
        const backToCartBtn = document.getElementById('back-to-cart');
        const cartContent = document.getElementById('cart-content');
        const checkoutForm = document.getElementById('checkout-form');
        
        if (checkoutBtn && cartContent && checkoutForm) {
            checkoutBtn.addEventListener('click', function() {
                cartContent.classList.add('hidden');
                checkoutForm.classList.remove('hidden');
            });
        }
        
        if (backToCartBtn && cartContent && checkoutForm) {
            backToCartBtn.addEventListener('click', function() {
                checkoutForm.classList.add('hidden');
                cartContent.classList.remove('hidden');
            });
        }
    });
</script>

@endsection