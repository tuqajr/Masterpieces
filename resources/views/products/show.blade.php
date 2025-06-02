@extends('layouts.app')

@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="A platform to shop and learn traditional Palestinian Tatreez embroidery.">
<link rel="stylesheet" href="{{ asset('css/navbar-footer.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Reem+Kufi:wght@400;700&family=Orpheus+Pro:wght@400;700&display=swap" rel="stylesheet">

@endsection

@section('content')
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
                    <a href="#" class="dropdown-toggle" style="display: flex; align-items: center; white-space: nowrap;">
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
                            <button type="submit" style="border: none; background: none; padding: 8px 16px; font-size: 14px; color: rgb(155, 55, 55); width: 100%; text-align: left; cursor: pointer;">
                                Logout
                            </button>
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
            @if(optional(Auth::user())->is_admin)
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            @endif
            <li><a href="{{ url('/shop') }}">Shop</a></li>
            <li><a href="{{ url('/learn') }}">Learn</a></li>
            <li><a href="{{ url('/about') }}">About</a></li>
            <li><a href="{{ url('/contact') }}">Contact</a></li>
        </ul>
        
        <div class="logo-container">
            <span class="logo-text">غرزه</span>
            <div class="logo-circle">
                <img src="{{ asset('images/embroidery_1230695.png') }}" alt="Tatreez Logo">
            </div>
        </div>
        
        <div class="menu-toggle" id="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>
    </div>
</header>

<!-- Font import in your head section -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Reem+Kufi+Fun:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
/* Base navbar styles */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 25px;
    background-color: rgb(145, 51, 51);
    color: white;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Set Reem Kufi Fun font for all navbar elements */
.navbar, 
.navbar a, 
.navbar button,
.navbar #navMenu li a,
.navbar .dropdown-toggle,
.navbar .dropdown-content a,
.navbar .dropdown-content button,
.navbar .logo-text {
    font-family: 'Reem Kufi Fun', sans-serif;
}

/* Logo styles */
.logo-container {
    display: flex;
    align-items: center;
    gap: 10px;
}

.logo-circle {
    width: 40px;
    height: 40px;
    background-color: transparent;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.logo-circle img {
    max-width: 100%;
    max-height: 100%;
}

.logo-text {
    font-size: 24px;
    font-weight: 700;
}

/* Navigation menu */
#navMenu {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 20px;
    transition: all 0.3s ease;
}

#navMenu li {
    margin: 0;
    padding: 0;
}

#navMenu li a {
    color: white;
    text-decoration: none;
    font-weight: 500;
    padding: 8px 15px;
    border-radius: 20px;
    transition: all 0.3s ease;
    position: relative;
}

#navMenu li a:hover {
    background-color: rgba(255, 255, 255, 0.15);
    transform: translateY(-2px);
}

#navMenu li a.active {
    background-color: rgba(255, 255, 255, 0.3);
    font-weight: 600;
}

/* Icons section */
.icons {
    display: flex;
    align-items: center;
    gap: 20px;
}

/* Cart icon styles */
.cart-icon {
    position: relative;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
}

.cart-icon i {
    font-size: 20px;
    display: inline-block;
}

.cart-icon:hover {
    transform: scale(1.1);
}

#cart-count {
    position: absolute;
    top: -8px;
    right: -10px;
    background-color: #e4c4b0;
    color: #9b3737;
    font-size: 12px;
    height: 18px;
    width: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

/* Dropdown styles */
.login-register-dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-toggle {
    color: white;
    text-decoration: none;
    cursor: pointer;
    padding: 8px 15px;
    border-radius: 20px;
    transition: all 0.3s ease;
}

.dropdown-toggle:hover {
    background-color: rgba(255, 255, 255, 0.15);
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    top: 120%;
    min-width: 180px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    z-index: 10;
    overflow: hidden;
}

.login-register-dropdown:hover .dropdown-content {
    display: block;
}

.dropdown-content a,
.dropdown-content button {
    display: block;
    padding: 12px 15px;
    text-decoration: none;
    color: rgb(145, 51, 51);
    transition: all 0.2s ease;
    text-align: left;
    width: 100%;
    font-size: 14px;
    border: none;
    background: none;
    cursor: pointer;
}

.dropdown-content a:hover,
.dropdown-content button:hover {
    background-color: rgba(145, 51, 51, 0.1);
}

/* Hamburger menu toggle */
.menu-toggle {
    display: none;
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0;
}

.menu-toggle:hover {
    transform: scale(1.1);
}

/* Mobile responsive styles */
@media (max-width: 992px) {
    .navbar {
        padding: 10px 15px;
    }
    
    .menu-toggle {
        display: block;
    }
    
    #navMenu {
        position: absolute;
        top: 70px;
        left: 0;
        right: 0;
        flex-direction: column;
        background-color: rgb(145, 51, 51);
        padding: 20px;
        display: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        z-index: 99;
    }
    
    #navMenu.show {
        display: flex;
    }
    
    #navMenu li a {
        display: block;
        width: 100%;
        text-align: center;
        padding: 12px 15px;
    }
}

@media (max-width: 576px) {
    .navbar {
        padding: 10px;
    }
    
    .icons {
        gap: 10px;
    }
    
    .logo-text {
        font-size: 20px;
    }
    
    .logo-circle {
        width: 35px;
        height: 35px;
    }
    
    .dropdown-toggle span:first-of-type {
        display: none; /* Hide "Welcome," text on very small screens */
    }
}

/* Add margin to content to prevent overlap with fixed navbar */
body {
    padding-top: 70px;
}

@media (max-width: 768px) {
    body {
        padding-top: 60px;
    }
}

/* Fix for Font Awesome icons if they don't appear */
.fa-shopping-cart:before {
    content: "\f07a";
}

.fa-bars:before {
    content: "\f0c9";
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle functionality
    const menuToggle = document.getElementById('menu-toggle');
    const navMenu = document.getElementById('navMenu');
    
    menuToggle.addEventListener('click', function(e) {
        e.preventDefault();
        navMenu.classList.toggle('show');
    });
    
    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('#menu-toggle') && 
            !event.target.closest('#navMenu') && 
            navMenu.classList.contains('show')) {
            navMenu.classList.remove('show');
        }
    });
    // Update cart count
    const cartCountElement = document.getElementById('cart-count');
    
    function fetchCartCount() {
        fetch('/cart/count')
            .then(response => response.json())
            .then(data => {
                if (cartCountElement) {
                    cartCountElement.textContent = data.count;
                }
            })
            .catch(() => {
                // Fallback for guests
                if (cartCountElement) {
                    let guestCart = JSON.parse(localStorage.getItem("cart")) || [];
                    cartCountElement.textContent = guestCart.length;
                }
            });
    }
    
    fetchCartCount();
});
</script>

<!-- Main Content -->
<main class="main-content" style="margin-top:40px;">    
    <div class="container">
        <!-- Breadcrumb -->
        

        <div class="product-detail-grid animate__animated animate__fadeInUp">
            <!-- Product Images -->
            <div class="product-images-section">
                <!-- Main Image -->
                <div class="main-image-container">
                    @if($product->featured)
                        <span class="featured-badge animate__animated animate__pulse animate__infinite">
                            <i class="fas fa-star"></i> Featured
                        </span>
                    @endif
                    
                    <div class="image-zoom-container">
                        @if (Str::startsWith($product->image, 'http'))
                            <img src="{{ $product->image }}" 
                                 alt="{{ $product->name }}" 
                                 class="main-product-image"
                                 id="mainImage">
                        @else
                            @php
                                $imagePath = $product->image ? 'storage/products/' . basename($product->image) : 'images/no-image.jpg';
                            @endphp
                            <img src="{{ asset($imagePath) }}" 
                                 alt="{{ $product->name }}" 
                                 class="main-product-image"
                                 id="mainImage">
                        @endif
                        <div class="zoom-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                </div>

                <!-- Thumbnail Images -->
                @if($product->images->count() > 0)
                    <div class="thumbnail-grid">
                        <!-- Main image thumbnail -->
                        <div class="thumbnail-item active animate__animated animate__fadeInLeft" style="--delay: 0.1s;">
                            @if (Str::startsWith($product->image, 'http'))
                                <img src="{{ $product->image }}" 
                                     alt="{{ $product->name }}" 
                                     class="thumbnail-image"
                                     onclick="changeMainImage(this.src, this)">
                            @else
                                <img src="{{ asset($imagePath) }}" 
                                     alt="{{ $product->name }}" 
                                     class="thumbnail-image"
                                     onclick="changeMainImage(this.src, this)">
                            @endif
                            <div class="thumbnail-overlay">
                                <i class="fas fa-eye"></i>
                            </div>
                        </div>
                        <!-- Additional images -->
                        @foreach($product->images as $index => $img)
                            @php
                                // Fix the extra image path to use the correct storage path
                                $extraPath = Str::startsWith($img->image, 'http')
                                    ? $img->image
                                    : (Str::startsWith($img->image, 'products/') ? asset('storage/' . $img->image) : asset('storage/products/' . basename($img->image)));
                            @endphp
                            <div class="thumbnail-item animate__animated animate__fadeInLeft" style="--delay: {{ ($index + 2) * 0.1 }}s;">
                                <img src="{{ $extraPath }}" 
                                     alt="{{ $product->name }}" 
                                     class="thumbnail-image"
                                     onclick="changeMainImage(this.src, this)">
                                <div class="thumbnail-overlay">
                                    <i class="fas fa-eye"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Information -->
            <div class="product-info-section animate__animated animate__fadeInRight">
                <!-- Product Title -->
                <div class="product-header">
                    <h1 class="product-title">{{ $product->name }}</h1>
                    <div class="product-rating">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="rating-text">(4.5) 24 reviews</span>
                    </div>
                </div>

                <!-- Price -->
                <div class="price-section">
                    <div class="current-price">${{ number_format($product->price, 2) }}</div>
                    <div class="original-price">${{ number_format($product->price * 1.2, 2) }}</div>
                    <div class="discount-badge">
                        <i class="fas fa-tag"></i>
                        20% OFF
                    </div>
                </div>

                <!-- Description -->
                <div class="description-section">
                    <h3 class="section-title">
                        <i class="fas fa-info-circle"></i>
                        Product Description
                    </h3>
                    <p class="description-text">{{ $product->description }}</p>
                </div>

                <!-- Features -->
                <div class="features-section">
                    <div class="feature-item animate__animated animate__fadeInUp" style="--delay: 0.1s;">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span>Premium Quality Materials</span>
                    </div>
                    <div class="feature-item animate__animated animate__fadeInUp" style="--delay: 0.2s;">
                        <i class="fas fa-shipping-fast feature-icon"></i>
                        <span>Free Shipping Available</span>
                    </div>
                    <div class="feature-item animate__animated animate__fadeInUp" style="--delay: 0.3s;">
                        <i class="fas fa-undo-alt feature-icon"></i>
                        <span>30-Day Return Policy</span>
                    </div>
                </div>

                <!-- Add to Cart Section -->
                @if(Auth::check())
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="add-to-cart-form">
                        @csrf
                        <div class="quantity-selector">
                            <label for="quantity">
                                <i class="fas fa-shopping-basket"></i>
                                Quantity:
                            </label>
                            <div class="quantity-control">
                                <button type="button" class="quantity-btn" onclick="decrementQuantity()">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" 
                                       name="quantity" 
                                       id="quantity" 
                                       value="1" 
                                       min="1" 
                                       class="quantity-input">
                                <button type="button" class="quantity-btn" onclick="incrementQuantity()">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="action-buttons">
                            <button type="submit" class="add-to-cart-btn primary-btn">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Add to Cart</span>
                                <div class="btn-ripple"></div>
                            </button>
                            <button type="button" 
                                    class="favorite-btn secondary-btn"
                                    onclick="toggleFavorite(this, '{{ $product->id }}')">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                    </form>
                @else
                    <div class="login-prompt">
                        <a href="{{ route('login') }}" class="login-btn primary-btn">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Login to Purchase</span>
                            <div class="btn-ripple"></div>
                        </a>
                        <p class="login-text">Create an account to enjoy exclusive benefits and faster checkout!</p>
                    </div>
                @endif

                <!-- Product Specifications -->
                <div class="specifications-section">
                    <h3 class="section-title">
                        <i class="fas fa-clipboard-list"></i>
                        Product Specifications
                    </h3>
                    <div class="specs-grid">
                        <div class="spec-item">
                            <span class="spec-label">
                                <i class="fas fa-tags"></i>
                                Category:
                            </span>
                            <span class="spec-value">{{ $product->category ?? 'General' }}</span>
                        </div>
                        @if($product->material)
                            <div class="spec-item">
                                <span class="spec-label">
                                    <i class="fas fa-layer-group"></i>
                                    Material:
                                </span>
                                <span class="spec-value">{{ $product->material }}</span>
                            </div>
                        @endif
                        @if($product->size)
                            <div class="spec-item">
                                <span class="spec-label">
                                    <i class="fas fa-ruler"></i>
                                    Size:
                                </span>
                                <span class="spec-value">{{ $product->size }}</span>
                            </div>
                        @endif
                        <div class="spec-item">
                            <span class="spec-label">
                                <i class="fas fa-box"></i>
                                Availability:
                            </span>
                            <span class="spec-value in-stock">
                                <i class="fas fa-check-circle"></i>
                                In Stock
                            </span>
                        </div>
                    </div>
                </div>
            </main>

<!-- Footer Section -->
<footer>
    <div class="footer-container">
        <div class="footer-section">
            <h4>Tatreez Traditions</h4>
            <p>Preserving Palestinian embroidery heritage through authentic products and educational resources.</p>
            <div class="footer-social">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" aria-label="Pinterest"><i class="fab fa-pinterest-p"></i></a>
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
:root {
    --primary-color: #913333;
    --primary-hover: #7c2828;
    --secondary-color: #d4af37;
    --text-dark: #333;
    --text-muted: #666;
    --bg-light: #f8f9fa;
    --bg-white: #ffffff;
    --border-color: #e0e0e0;
    --shadow-light: 0 2px 10px rgba(0,0,0,0.08);
    --shadow-hover: 0 8px 25px rgba(0,0,0,0.15);
    --shadow-strong: 0 15px 35px rgba(0,0,0,0.12);
    --border-radius: 12px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --font-primary: 'Reem Kufi', sans-serif;
}

body {
    font-family: var(--font-primary);
    color: var(--text-dark);
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    margin: 0;
    padding: 0;
}

.main-content {
    padding: 40px 0;
    min-height: 100vh;
}

.container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
}

.product-detail-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 40px;
    background: var(--bg-white);
    border-radius: 20px;
    box-shadow: var(--shadow-strong);
    padding: 40px;
    position: relative;
    overflow: hidden;
    animation-delay: 0.2s;
}

.product-detail-grid::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), var(--primary-color));
    animation: shimmer 3s ease-in-out infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

@media (min-width: 992px) {
    .product-detail-grid {
        grid-template-columns: 1fr 1fr;
    }
}
@media (max-width: 992px) {
    .product-detail-grid {
        grid-template-columns: 1fr;
        padding: 20px;
        gap: 30px;
    }
    .product-images-section, .product-info-section {
        padding: 0;
    }
    .main-image-container {
        aspect-ratio: unset;
        min-height: 220px;
    }
    .thumbnail-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
    }
}
@media (max-width: 600px) {
    .product-detail-grid {
        padding: 8px;
        gap: 18px;
    }
    .main-image-container {
        min-height: 140px;
        border-radius: 8px;
    }
    .product-title {
        font-size: 1.2rem;
    }
    .current-price {
        font-size: 1.2rem;
    }
    .original-price {
        font-size: 1rem;
    }
    .product-info-section {
        gap: 14px;
    }
    .action-buttons {
        flex-direction: column;
        gap: 10px;
    }
    .primary-btn, .secondary-btn {
        width: 100%;
        min-width: unset;
        padding: 12px 0;
        font-size: 1rem;
    }
    .secondary-btn {
        height: auto;
        padding: 12px 0;
    }
    .specs-grid {
        grid-template-columns: 1fr;
        gap: 8px;
    }
    .features-section, .description-section, .specifications-section, .share-section {
        padding: 10px;
    }
}

/* Enhanced Image Section */
.product-images-section {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.main-image-container {
    position: relative;
    background: linear-gradient(135deg, #fafafa, #ffffff);
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow-light);
    aspect-ratio: 1/1;
}

.image-zoom-container {
    position: relative;
    width: 100%;
    height: 100%;
    overflow: hidden;
    cursor: zoom-in;
}

.main-product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.image-zoom-container:hover .main-product-image {
    transform: scale(1.1);
}

.zoom-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 15px;
    border-radius: 50%;
    opacity: 0;
    transition: var(--transition);
    pointer-events: none;
}

.image-zoom-container:hover .zoom-overlay {
    opacity: 1;
}

.featured-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
    color: white;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 0.8rem;
    font-weight: 600;
    z-index: 10;
    box-shadow: var(--shadow-light);
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Enhanced Thumbnails */
.thumbnail-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
}

.thumbnail-item {
    position: relative;
    cursor: pointer;
    border: 3px solid transparent;
    border-radius: 12px;
    overflow: hidden;
    aspect-ratio: 1/1;
    transition: var(--transition);
    background: linear-gradient(135deg, #f8f8f8, #ffffff);
    animation-delay: calc(var(--delay));
}

.thumbnail-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
    transition: left 0.5s ease;
    z-index: 1;
}

.thumbnail-item:hover::before {
    left: 100%;
}

.thumbnail-item:hover {
    transform: translateY(-8px) scale(1.08);
    box-shadow: 0 15px 30px rgba(145, 51, 51, 0.3);
    border-color: var(--primary-color);
}

.thumbnail-item.active {
    border-color: var(--primary-color);
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(145, 51, 51, 0.4);
}

.thumbnail-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.thumbnail-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 8px;
    border-radius: 50%;
    opacity: 0;
    transition: var(--transition);
}

.thumbnail-item:hover .thumbnail-overlay {
    opacity: 1;
}

/* Enhanced Product Info */
.product-info-section {
    display: flex;
    flex-direction: column;
    gap: 30px;
    animation-delay: 0.4s;
}

.product-header {
    border-bottom: 2px solid var(--border-color);
    padding-bottom: 20px;
}

.product-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0 0 15px 0;
    line-height: 1.2;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.product-rating {
    display: flex;
    align-items: center;
    gap: 10px;
}

.stars {
    color: #ffc107;
    font-size: 1.1rem;
}

.rating-text {
    color: var(--text-muted);
    font-size: 0.9rem;
}

.price-section {
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
    padding: 20px;
    background: linear-gradient(135deg, #f8f9fa, #ffffff);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-light);
}

.current-price {
    font-size: 2.2rem;
    font-weight: 800;
    color: var(--primary-color);
    text-shadow: 0 2px 4px rgba(145, 51, 51, 0.1);
}

.original-price {
    font-size: 1.4rem;
    color: var(--text-muted);
    text-decoration: line-through;
}

.discount-badge {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 5px;
    animation: pulse 2s infinite;
}

.section-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-title i {
    color: var(--primary-color);
}

.description-section {
    padding: 20px;
    background: linear-gradient(135deg, #f8f9fa, #ffffff);
    border-radius: var(--border-radius);
    border-left: 4px solid var(--primary-color);
}

.description-text {
    line-height: 1.8;
    color: var(--text-dark);
    font-size: 1.05rem;
}

.features-section {
    display: flex;
    flex-direction: column;
    gap: 15px;
    padding: 20px;
    background: linear-gradient(135deg, #f8f9fa, #ffffff);
    border-radius: var(--border-radius);
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 10px;
    border-radius: 8px;
    transition: var(--transition);
    animation-delay: calc(var(--delay));
}

.feature-item:hover {
    background: rgba(145, 51, 51, 0.05);
    transform: translateX(10px);
}

.feature-icon {
    color: #28a745;
    font-size: 1.2rem;
    width: 20px;
}

/* Enhanced Form Elements */
.add-to-cart-form {
    display: flex;
    flex-direction: column;
    gap: 25px;
    padding: 25px;
    background: linear-gradient(135deg, #f8f9fa, #ffffff);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-light);
}

.quantity-selector {
    display: flex;
    align-items: center;
    gap: 20px;
}

.quantity-selector label {
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--text-dark);
}

.quantity-control {
    display: flex;
    align-items: center;
    border: 2px solid var(--border-color);
    border-radius: 12px;
    overflow: hidden;
    background: white;
    transition: var(--transition);
}

.quantity-control:hover {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(145, 51, 51, 0.1);
}

.quantity-btn {
    background: none;
    border: none;
    padding: 12px 18px;
    cursor: pointer;
    font-size: 1.1rem;
    color: var(--text-dark);
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
}

.quantity-btn:hover {
    background: var(--primary-color);
    color: white;
}

.quantity-input {
    width: 60px;
    text-align: center;
    border: none;
    border-left: 1px solid var(--border-color);
    border-right: 1px solid var(--border-color);
    padding: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    background: white;
}

.action-buttons {
    display: flex;
    gap: 15px;
}

.primary-btn, .secondary-btn {
    padding: 15px 30px;
    border: none;
    border-radius: 12px;
    font-family: var(--font-primary);
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    position: relative;
    overflow: hidden;
}

.primary-btn {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
    color: white;
    flex: 1;
    box-shadow: var(--shadow-light);
}

.primary-btn:hover {
    background: linear-gradient(135deg, var(--primary-hover), #6a1f1f);
    transform: translateY(-3px);
    box-shadow: var(--shadow-hover);
}

.secondary-btn {
    background: var(--bg-white);
    color: var(--text-dark);
    border: 2px solid var(--border-color);
    width: 60px;
    height: 60px;
}

.secondary-btn:hover {
    border-color: var(--primary-color);
    background: rgba(145, 51, 51, 0.1);
    color: var(--primary-color);
    transform: translateY(-3px);
}

.btn-ripple {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 5px;
    height: 5px;
    background: rgba(255, 255, 255, 0.5);
    border-radius: 50%;
    opacity: 0;
    pointer-events: none;
}

.primary-btn:hover .btn-ripple {
    animation: ripple 1s ease-out;
}

@keyframes ripple {
    0% {
        width: 5px;
        height: 5px;
        opacity: 1;
    }
    100% {
        width: 300px;
        height: 300px;
        opacity: 0;
    }
}

.login-prompt {
    padding: 25px;
    background: linear-gradient(135deg, #f8f9fa, #ffffff);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-light);
    text-align: center;
}

.login-btn {
    margin-bottom: 15px;
}

.login-text {
    color: var(--text-muted);
    font-size: 0.95rem;
    line-height: 1.6;
}

/* Enhanced Specifications */
.specifications-section {
    padding: 20px;
    background: linear-gradient(135deg, #f8f9fa, #ffffff);
    border-radius: var(--border-radius);
    border-left: 4px solid var(--secondary-color);
}

.specs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 15px;
}

.spec-item {
    display: flex;
    flex-direction: column;
    gap: 5px;
    padding: 12px;
    background: white;
    border-radius: 8px;
    box-shadow: var(--shadow-light);
    transition: var(--transition);
}

.spec-item:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-hover);
}

.spec-label {
    font-weight: 600;
    color: var(--primary-color);
    display: flex;
    align-items: center;
    gap: 8px;
}

.spec-value {
    color: var(--text-dark);
    font-size: 0.95rem;
}

.in-stock {
    color: #28a745;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Enhanced Share Section */
.share-section {
    padding: 20px;
    background: linear-gradient(135deg, #f8f9fa, #ffffff);
    border-radius: var(--border-radius);
    border-left: 4px solid var(--primary-color);
}

.social-icons {
    display: flex;
    gap: 15px;
}

.social-icon {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.social-icon::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.1);
    transform: scale(0);
    border-radius: 50%;
    transition: var(--transition);
}

.social-icon:hover::after {
    transform: scale(1);
}

.facebook {
    background: #3b5998;
}

.twitter {
    background: #1da1f2;
}

.pinterest {
    background: #e60023;
}

.copy {
    background: var(--text-muted);
}

.social-icon:hover {
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Footer Enhancements */
footer {
    background: linear-gradient(135deg, #913333 0%, #7c2828 100%);
    color: white;
    padding: 60px 0 0;
    margin-top: 60px;
}

.footer-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 40px;
}

.footer-section {
    padding: 20px;
}

.footer-section h4 {
    font-size: 1.4rem;
    margin-bottom: 25px;
    position: relative;
    padding-bottom: 10px;
    color: var(--secondary-color);
}

.footer-section h4::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 3px;
    background: var(--secondary-color);
}

.footer-section p {
    line-height: 1.8;
    margin-bottom: 20px;
    opacity: 0.9;
}

.footer-section ul {
    list-style: none;
    padding: 0;
}

.footer-section ul li {
    margin-bottom: 12px;
}

.footer-section ul li a {
    color: white;
    text-decoration: none;
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 10px;
    opacity: 0.9;
}

.footer-section ul li a:hover {
    opacity: 1;
    color: var(--secondary-color);
    transform: translateX(5px);
}

.footer-section ul li a i {
    font-size: 0.8rem;
}

.footer-social {
    display: flex;
    gap: 15px;
    margin-top: 20px;
}

.footer-social a {
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.1);
    transition: var(--transition);
}

.footer-social a:hover {
    background: var(--secondary-color);
    color: #2c3e50;
    transform: translateY(-5px);
}

.footer-bottom {
    text-align: center;
    padding: 20px;
    margin-top: 40px;
    border-top: 1px solid rgba(255,255,255,0.1);
    font-size: 0.9rem;
    opacity: 0.8;
    background: linear-gradient(135deg, #913333 0%, #7c2828 100%);
    color: #fff;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .product-detail-grid {
        padding: 20px;
    }
    
    .product-title {
        font-size: 1.8rem;
    }
    
    .current-price {
        font-size: 1.8rem;
    }
    
    .original-price {
        font-size: 1.2rem;
    }
    
    .thumbnail-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .primary-btn, .secondary-btn {
        width: 100%;
    }
    
    .secondary-btn {
        height: auto;
        padding: 15px;
    }
}

/* Animation Classes */
.animate__animated {
    animation-duration: 0.8s;
}

/* JavaScript Interactive Elements */
.image-zoom-container.zoomed {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: rgba(0,0,0,0.9);
    cursor: zoom-out;
    display: flex;
    align-items: center;
    justify-content: center;
}

.image-zoom-container.zoomed .main-product-image {
    width: auto;
    height: auto;
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
    transform: none;
}

.image-zoom-container.zoomed .zoom-overlay {
    display: none;
}

/* Favorite Button Active State */
.favorite-btn.active {
    color: #dc3545;
    border-color: #dc3545;
}

.favorite-btn.active i {
    font-weight: 900;
}
</style>

<script>
// Change main image when clicking on thumbnails
function changeMainImage(src, element) {
    document.getElementById('mainImage').src = src;
    
    // Update active thumbnail
    const thumbnails = document.querySelectorAll('.thumbnail-item');
    thumbnails.forEach(thumb => thumb.classList.remove('active'));
    element.closest('.thumbnail-item').classList.add('active');
}

// Quantity controls
function incrementQuantity() {
    const quantityInput = document.getElementById('quantity');
    quantityInput.value = parseInt(quantityInput.value) + 1;
}

function decrementQuantity() {
    const quantityInput = document.getElementById('quantity');
    if (parseInt(quantityInput.value) > 1) {
        quantityInput.value = parseInt(quantityInput.value) - 1;
    }
}

// Image zoom functionality
document.querySelector('.image-zoom-container').addEventListener('click', function() {
    this.classList.toggle('zoomed');
});

// Toggle favorite button
function toggleFavorite(button, productId) {
    button.classList.toggle('active');
    const icon = button.querySelector('i');
    
    if (button.classList.contains('active')) {
        icon.classList.remove('far');
        icon.classList.add('fas');
        // Here you would typically make an AJAX call to save the favorite
    } else {
        icon.classList.remove('fas');
        icon.classList.add('far');
        // Here you would typically make an AJAX call to remove the favorite
    }
}

// Copy to clipboard function
function copyToClipboard() {
    const tempInput = document.createElement('input');
    tempInput.value = window.location.href;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);
    
    // Show feedback
    const copyButton = document.querySelector('.social-icon.copy');
    const originalIcon = copyButton.innerHTML;
    copyButton.innerHTML = '<i class="fas fa-check"></i>';
    copyButton.style.backgroundColor = '#28a745';
    
    setTimeout(() => {
        copyButton.innerHTML = originalIcon;
        copyButton.style.backgroundColor = '';
    }, 2000);
}

// Mobile menu toggle
document.getElementById('menu-toggle').addEventListener('click', function() {
    document.getElementById('navMenu').classList.toggle('active');
    this.classList.toggle('active');
});

// Add to cart form submission
document.querySelector('.add-to-cart-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Here you would typically make an AJAX call to add to cart
    // For now, we'll just show a success message
    
    const addButton = this.querySelector('.add-to-cart-btn');
    const originalText = addButton.innerHTML;
    
    addButton.innerHTML = '<i class="fas fa-check"></i> Added to Cart';
    addButton.style.backgroundColor = '#28a745';
    
    // Update cart count
    const cartCount = document.getElementById('cart-count');
    if (cartCount) {
        cartCount.textContent = parseInt(cartCount.textContent) + parseInt(document.getElementById('quantity').value);
    }
    
    setTimeout(() => {
        addButton.innerHTML = originalText;
        addButton.style.backgroundColor = '';
    }, 2000);
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Lazy loading for images
document.addEventListener('DOMContentLoaded', function() {
    const lazyImages = [].slice.call(document.querySelectorAll('img.lazy'));
    
    if ('IntersectionObserver' in window) {
        let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    let lazyImage = entry.target;
                    lazyImage.src = lazyImage.dataset.src;
                    lazyImage.classList.remove('lazy');
                    lazyImageObserver.unobserve(lazyImage);
                }
            });
        });

        lazyImages.forEach(function(lazyImage) {
            lazyImageObserver.observe(lazyImage);
        });
    }
});

// Add animation when elements come into view
const animateOnScroll = function() {
    const elements = document.querySelectorAll('.animate-on-scroll');
    
    elements.forEach(element => {
        const elementPosition = element.getBoundingClientRect().top;
        const screenPosition = window.innerHeight / 1.2;
        
        if (elementPosition < screenPosition) {
            element.classList.add('animate__animated', 'animate__fadeInUp');
        }
    });
};

window.addEventListener('scroll', animateOnScroll);
animateOnScroll(); // Run once on page load
</script>
@endsection