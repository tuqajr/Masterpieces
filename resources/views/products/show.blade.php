@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="css/styles.css">
<link href="https://fonts.googleapis.com/css2?family=Orpheus+Pro&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Alkalami&family=Badeen+Display&family=Handjet:wght@100..900&family=Reem+Kufi+Fun:wght@400..700&family=Reem+Kufi:wght@400..700&family=Ruwudu:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<!-- Main Content -->
<main class="main-content">
    <div class="container">
        <!-- Breadcrumb -->
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
                        <i class="fas fa-user-circle mobile-user-icon"></i>
                        <span class="desktop-user-text" style="margin-right: 5px;">Welcome,</span>
                        <span class="desktop-user-text">{{ Auth::user()->name }}</span>
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
                    <a href="#" class="dropdown-toggle">
                        <i class="fas fa-user mobile-user-icon"></i>
                        <span class="desktop-user-text">User</span>
                    </a>
                    <div class="dropdown-content">
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    </div>
                </div>
            @endif
        </div>
        
        <ul id="navMenu" class="nav-menu">
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
        
        <div class="menu-toggle" id="menu-toggle">
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</header>

        <div class="product-detail-grid">
            <!-- Product Images -->
            <div class="product-images-section">
                <!-- Main Image -->
                <div class="main-image-container">
                    @if($product->featured)
                        <span class="featured-badge">
                            Featured
                        </span>
                    @endif
                    
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
                </div>

                <!-- Thumbnail Images -->
                @if($product->images->count() > 0)
                    <div class="thumbnail-grid">
                        <!-- Main image thumbnail -->
                        <div class="thumbnail-item active">
                            @if (Str::startsWith($product->image, 'http'))
                                <img src="{{ $product->image }}" 
                                     alt="{{ $product->name }}" 
                                     class="thumbnail-image"
                                     onclick="changeMainImage(this.src)">
                            @else
                                <img src="{{ asset($imagePath) }}" 
                                     alt="{{ $product->name }}" 
                                     class="thumbnail-image"
                                     onclick="changeMainImage(this.src)">
                            @endif
                        </div>
                        <!-- Additional images -->
                        @foreach($product->images as $img)
                            <div class="thumbnail-item">
                                <img src="{{ asset('storage/products/' . basename($img->path)) }}" 
                                     alt="{{ $product->name }}" 
                                     class="thumbnail-image"
                                     onclick="changeMainImage(this.src)">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Information -->
            <div class="product-info-section">
                <!-- Product Title -->
                <div class="product-header">
                    <h1 class="product-title">{{ $product->name }}</h1>
                </div>

                <!-- Price -->
                <div class="price-section">
                    <div class="current-price">${{ number_format($product->price, 2) }}</div>
                    <div class="original-price">${{ number_format($product->price * 1.2, 2) }}</div>
                    <div class="discount-badge">20% OFF</div>
                </div>

                <!-- Description -->
                <div class="description-section">
                    <h3 class="section-title">Product Description</h3>
                    <p class="description-text">{{ $product->description }}</p>
                </div>

                <!-- Features -->
                <div class="features-section">
                    <div class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span>Premium Quality Materials</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span>Free Shipping Available</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span>30-Day Return Policy</span>
                    </div>
                </div>

                <!-- Add to Cart Section -->
                @if(Auth::check())
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="add-to-cart-form">
                        @csrf
                        <div class="quantity-selector">
                            <label for="quantity">Quantity:</label>
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
                                Add to Cart
                            </button>
                            <button type="button" 
                                    class="favorite-btn secondary-btn"
                                    onclick="toggleFavorite(this, '{{ $product->id }}')">
                                <i class="far fa-heart"></i>
                                Favorite
                            </button>
                        </div>
                    </form>
                @else
                    <div class="login-prompt">
                        <a href="{{ route('login') }}" class="login-btn primary-btn">
                            <i class="fas fa-sign-in-alt"></i>
                            Login to Purchase
                        </a>
                        <p class="login-text">Create an account to enjoy exclusive benefits and faster checkout!</p>
                    </div>
                @endif

                <!-- Product Specifications -->
                <div class="specifications-section">
                    <h3 class="section-title">Product Specifications</h3>
                    <div class="specs-grid">
                        <div class="spec-item">
                            <span class="spec-label">Category:</span>
                            <span class="spec-value">{{ $product->category ?? 'General' }}</span>
                        </div>
                        @if($product->material)
                            <div class="spec-item">
                                <span class="spec-label">Material:</span>
                                <span class="spec-value">{{ $product->material }}</span>
                            </div>
                        @endif
                        @if($product->size)
                            <div class="spec-item">
                                <span class="spec-label">Size:</span>
                                <span class="spec-value">{{ $product->size }}</span>
                            </div>
                        @endif
                        <div class="spec-item">
                            <span class="spec-label">Availability:</span>
                            <span class="spec-value in-stock">In Stock</span>
                        </div>
                    </div>
                </div>

                <!-- Share Section -->
                <div class="share-section">
                    <h3 class="section-title">Share this product:</h3>
                    <div class="social-icons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                           target="_blank"
                           class="social-icon facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($product->name) }}" 
                           target="_blank"
                           class="social-icon twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(request()->url()) }}&description={{ urlencode($product->name) }}" 
                           target="_blank"
                           class="social-icon pinterest">
                            <i class="fab fa-pinterest-p"></i>
                        </a>
                        <button onclick="copyToClipboard()" 
                                class="social-icon copy">
                            <i class="fas fa-link"></i>
                        </button>
                    </div>
                </div>
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
    --bg-white: #fff;
    --border-color: #e0e0e0;
    --shadow-light: 0 2px 10px rgba(0,0,0,0.08);
    --shadow-hover: 0 8px 25px rgba(0,0,0,0.15);
    --border-radius: 16px;
    --transition: all 0.3s ease;
    --font-primary: 'Reem Kufi', 'Tajawal', 'Alkalami', sans-serif;
}

/* Navbar */
.navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-hover) 80%);
    color: #fff;
    padding: 0 30px;
    height: 70px;
    border-radius: 0 0 18px 18px;
    box-shadow: var(--shadow-light);
    position: relative;
    z-index: 100;
}
.logo-container {
    display: flex;
    align-items: center;
    gap: 10px;
}
.logo-text {
    font-family: var(--font-primary);
    color: var(--secondary-color);
    font-size: 2.1rem;
    font-weight: 700;
    letter-spacing: 2px;
}
.logo-container img {
    width: 38px;
    height: 38px;
}
.nav-menu {
    display: flex;
    gap: 30px;
    list-style: none;
    margin: 0;
    padding: 0;
}
.nav-menu li a {
    color: #fff;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.1rem;
    letter-spacing: 0.5px;
    transition: color .2s;
    padding: 8px 12px;
    border-radius: 8px;
}
.nav-menu li a:hover,
.nav-menu li a.active {
    color: var(--secondary-color);
    background: rgba(212,175,55,0.09);
}
.icons {
    display: flex;
    align-items: center;
    gap: 15px;
}
.cart-icon {
    position: relative;
    color: #fff;
    font-size: 1.4rem;
    transition: color .2s;
}
.cart-icon:hover {
    color: var(--secondary-color);
}
#cart-count {
    position: absolute;
    top: -9px;
    right: -13px;
    background: var(--secondary-color);
    color: var(--primary-color);
    font-size: 0.85rem;
    font-weight: bold;
    padding: 2px 7px;
    border-radius: 50%;
    border: 2px solid #fff;
}
.login-register-dropdown {
    position: relative;
}
.dropdown-toggle {
    color: #fff;
    font-weight: 500;
    font-size: 1.1rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 6px 10px;
    border-radius: 8px;
    transition: background .2s;
}
.dropdown-toggle:hover {
    background: rgba(145,51,51,0.15);
}
.dropdown-content {
    display: none;
    position: absolute;
    top: 46px;
    left: 0;
    background: #fff;
    min-width: 160px;
    border-radius: 12px;
    box-shadow: var(--shadow-light);
    overflow: hidden;
    z-index: 10;
}
.login-register-dropdown:hover .dropdown-content {
    display: block;
}
.dropdown-content a,
.dropdown-content button {
    color: var(--primary-color);
    text-decoration: none;
    display: block;
    padding: 13px 20px;
    font-weight: 600;
    background: none;
    border: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
    transition: background .2s;
}
.dropdown-content a:hover,
.dropdown-content button:hover {
    background: var(--bg-light);
    color: var(--primary-hover);
}

.menu-toggle {
    display: none;
    cursor: pointer;
}
.hamburger {
    width: 26px;
    height: 22px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.hamburger span {
    display: block;
    width: 100%;
    height: 4px;
    background: #fff;
    border-radius: 3px;
    transition: .3s;
}

@media (max-width: 992px) {
    .nav-menu {
        display: none;
        flex-direction: column;
        position: absolute;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-hover) 80%);
        top: 70px;
        left: 0;
        width: 100%;
        box-shadow: var(--shadow-light);
        z-index: 20;
        border-radius: 0 0 16px 16px;
        padding: 20px 0;
    }
    .nav-menu.show {
        display: flex;
    }
    .menu-toggle {
        display: block;
    }
}

/* Main Content */
.main-content {
    padding: 50px 0 30px 0;
    background: var(--bg-light);
    min-height: 60vh;
}
.container {
    max-width: 1300px;
    margin: 0 auto;
    padding: 0 15px;
}

/* Product Details Grid */
.product-detail-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 45px;
    margin-bottom: 30px;
}
@media (min-width: 992px) {
    .product-detail-grid {
        grid-template-columns: 1fr 1fr;
    }
}

/* Product Images */
.product-images-section {
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.main-image-container {
    position: relative;
    background: var(--bg-white);
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow-light);
    aspect-ratio: 1/1;
}
.main-product-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: var(--transition);
    background: #f5f5f5;
}
.featured-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: var(--primary-color);
    color: white;
    padding: 6px 20px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    z-index: 10;
}
.thumbnail-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
}
.thumbnail-item {
    cursor: pointer;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    overflow: hidden;
    aspect-ratio: 1/1;
    transition: var(--transition);
}
.thumbnail-item.active,
.thumbnail-item:hover {
    border-color: var(--primary-color);
}
.thumbnail-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

@media (max-width: 576px) {
    .thumbnail-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* Product Info */
.product-info-section {
    display: flex;
    flex-direction: column;
    gap: 28px;
}
.product-header {
    margin-bottom: 8px;
}
.product-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0;
    line-height: 1.2;
}
@media (max-width: 768px) {
    .product-title { font-size: 1.5rem; }
}

.price-section {
    display: flex;
    align-items: center;
    gap: 18px;
    flex-wrap: wrap;
}
.current-price {
    font-size: 1.7rem;
    font-weight: 700;
    color: var(--primary-color);
}
.original-price {
    font-size: 1.1rem;
    color: var(--text-muted);
    text-decoration: line-through;
}
.discount-badge {
    background: #f8d7da;
    color: #721c24;
    padding: 4px 13px;
    border-radius: 5px;
    font-size: 0.93rem;
    font-weight: 600;
}
.section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 10px;
}
.description-section {
    padding-top: 15px;
    border-top: 1px solid var(--border-color);
}
.features-section {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.feature-item {
    display: flex;
    align-items: center;
    gap: 9px;
    color: var(--primary-color);
    font-size: 1rem;
    font-weight: 500;
}
.feature-icon {
    color: #28a745;
    font-size: 1.1rem;
}
.add-to-cart-form {
    display: flex;
    flex-direction: column;
    gap: 24px;
}
.quantity-selector {
    display: flex;
    align-items: center;
    gap: 15px;
}
.quantity-control {
    display: flex;
    align-items: center;
    border: 1px solid var(--border-color);
    border-radius: 7px;
    overflow: hidden;
}
.quantity-btn {
    background: none;
    border: none;
    padding: 8px 14px;
    cursor: pointer;
    font-size: 1rem;
    color: var(--text-dark);
    transition: var(--transition);
}
.quantity-btn:hover {
    background-color: var(--bg-light);
}
.quantity-input {
    width: 50px;
    text-align: center;
    border: none;
    border-left: 1px solid var(--border-color);
    border-right: 1px solid var(--border-color);
    padding: 8px;
    font-size: 1rem;
    appearance: textfield;
}
.quantity-input::-webkit-outer-spin-button,
.quantity-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
.action-buttons {
    display: flex;
    gap: 15px;
}
.primary-btn, .secondary-btn {
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-family: var(--font-primary);
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.primary-btn {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
    color: white;
    flex: 1;
}
.primary-btn:hover {
    background: linear-gradient(135deg, var(--primary-hover), #6a1f1f);
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
}
.secondary-btn {
    background: var(--bg-white);
    color: var(--text-dark);
    border: 1px solid var(--border-color);
    width: 50px;
    justify-content: center;
}
.secondary-btn:hover {
    border-color: var(--primary-color);
    background: rgba(145, 51, 51, 0.05);
}
.login-prompt {
    background-color: var(--bg-white);
    padding: 20px;
    border-radius: var(--border-radius);
    text-align: center;
    box-shadow: var(--shadow-light);
}
.login-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 24px;
    border-radius: 8px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
    color: white;
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition);
}
.login-btn:hover {
    background: linear-gradient(135deg, var(--primary-hover), #6a1f1f);
    transform: translateY(-2px);
}
.login-text {
    margin-top: 10px;
    color: var(--text-muted);
    font-size: 0.9rem;
}
.specifications-section {
    padding-top: 15px;
    border-top: 1px solid var(--border-color);
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
}
.spec-label {
    font-weight: 600;
    color: var(--text-dark);
    font-size: 0.9rem;
}
.spec-value {
    color: var(--text-muted);
    font-size: 0.9rem;
}
.in-stock {
    color: #28a745;
    font-weight: 600;
}
.share-section {
    padding-top: 15px;
    border-top: 1px solid var(--border-color);
}
.social-icons {
    display: flex;
    gap: 10px;
}
.social-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    transition: var(--transition);
}
.social-icon.facebook { background-color: #3b5998; }
.social-icon.twitter { background-color: #1da1f2; }
.social-icon.pinterest { background-color: #e60023; }
.social-icon.copy { background-color: var(--text-muted); }
.social-icon:hover {
    transform: translateY(-3px);
}

/* Footer */
footer {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
    color: white;
    margin-top: 60px;
    border-radius: 22px 22px 0 0;
}
.footer-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 40px;
    max-width: 1400px;
    margin: 0 auto;
    padding: 50px 20px;
}
.footer-section h4 {
    color: var(--secondary-color);
    font-family: var(--font-primary);
    margin-bottom: 20px;
    font-size: 1.3rem;
    font-weight: 700;
}
.footer-section p, .footer-section ul li {
    margin-bottom: 12px;
    line-height: 1.6;
}
.footer-section ul {
    list-style: none;
    padding: 0;
}
.footer-section ul li a {
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    transition: var(--transition);
}
.footer-section ul li a:hover {
    color: var(--secondary-color);
    padding-left: 5px;
}
.footer-social {
    display: flex;
    gap: 15px;
    margin-top: 20px;
}
.footer-social a {
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: var(--transition);
    border: 2px solid transparent;
}
.footer-social a:hover {
    background: var(--secondary-color);
    transform: translateY(-3px);
    border-color: rgba(255, 255, 255, 0.3);
}
.footer-bottom {
    text-align: center;
    padding: 25px 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(0, 0, 0, 0.1);
}
.footer-bottom p {
    margin: 0;
    color: rgba(255, 255, 255, 0.8);
}

/* Responsive */
@media (max-width: 992px) {
    .container { max-width: 98vw; }
    .footer-container { padding: 40px 18px; }
}
@media (max-width: 768px) {
    .main-content { padding: 30px 0 10px 0; }
    .container { padding: 0 6px;}
    .product-detail-grid { grid-template-columns: 1fr; gap: 28px;}
    .footer-container { grid-template-columns: 1fr; gap: 30px; padding: 35px 7px;}
    .nav-menu { flex-direction: column; gap: 16px;}
}
@media (max-width: 576px) {
    .main-content { padding: 16px 0 5px 0; }
    .product-title { font-size: 1.1rem; }
    .thumbnail-grid { grid-template-columns: repeat(2, 1fr); }
    .specs-grid { grid-template-columns: 1fr; }
    .footer-container { padding: 16px 5px; }
}
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const favoriteBtn = document.querySelector('.favorite-btn');
    var isFavorited = "{{ (Auth::check() && $product->isFavoritedBy(Auth::user())) ? 'true' : 'false' }}";
    if (favoriteBtn && isFavorited === 'true') {
        favoriteBtn.querySelector('i').className = 'fas fa-heart';
    }
});

function changeMainImage(imageSrc) {
    document.getElementById('mainImage').src = imageSrc;
    document.querySelectorAll('.thumbnail-item').forEach(item => {
        item.classList.remove('active');
    });
    event.target.closest('.thumbnail-item').classList.add('active');
}

function incrementQuantity() {
    const input = document.getElementById('quantity');
    input.value = parseInt(input.value) + 1;
}

function decrementQuantity() {
    const input = document.getElementById('quantity');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

function toggleFavorite(button, productId) {
    const heartIcon = button.querySelector('i');
    const isFavorite = heartIcon.classList.contains('fa-heart');
    fetch(`/favorite/toggle/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.is_favorite) {
                heartIcon.className = 'fas fa-heart';
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Added to favorites',
                    showConfirmButton: false,
                    timer: 2000
                });
            } else {
                heartIcon.className = 'far fa-heart';
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Removed from favorites',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error',
            text: 'Failed to update favorites',
            icon: 'error',
            confirmButtonColor: '#913333'
        });
    });
}

function copyToClipboard() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Link copied to clipboard',
            showConfirmButton: false,
            timer: 2000
        });
    });
}
</script>
@endsection