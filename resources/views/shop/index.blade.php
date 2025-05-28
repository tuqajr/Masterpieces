@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="css/navbar-footer.css">
<link href="https://fonts.googleapis.com/css2?family=Orpheus+Pro&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Alkalami&family=Badeen+Display&family=Handjet:wght@100..900&family=Reem+Kufi+Fun:wght@400..700&family=Reem+Kufi:wght@400..700&family=Ruwudu:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

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

<!-- Main Content -->
<main class="main-content">
    <div class="container">
        <div class="page-header">
            <h1 class="animate__animated animate__fadeInDown">Our Products</h1>
            <p class="page-subtitle animate__animated animate__fadeInUp animate__delay-1s">Discover authentic Palestinian embroidery</p>
        </div>

        <!-- Enhanced Filter Section -->
        <div class="product-filters-wrapper">
            <div class="filter-header">
                <h3><i class="fas fa-filter"></i> Filter Products</h3>
                <button class="filter-toggle-btn" id="filter-toggle">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
            
            <div class="product-filters" id="filter-content">
                <form method="GET" action="{{ url('/shop') }}" id="filter-form">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label for="category">
                                <i class="fas fa-tags"></i>
                                Category
                            </label>
                            <select name="category" id="category" class="filter-select">
                                <option value="">All Categories</option>
                                @foreach($categories as $categoryValue => $categoryName)
                                    <option value="{{ $categoryValue }}" {{ request('category') == $categoryValue ? 'selected' : '' }}>
                                        {{ $categoryName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="price">
                                <i class="fas fa-dollar-sign"></i>
                                Max Price
                            </label>
                            <input type="number" name="price" id="price" class="filter-input" 
                                   placeholder="e.g. 50" value="{{ request('price') }}" min="0">
                        </div>

                        <div class="filter-group">
                            <label for="search">
                                <i class="fas fa-search"></i>
                                Search
                            </label>
                            <input type="text" name="search" id="search" class="filter-input" 
                                   placeholder="Search products..." value="{{ request('search') }}">
                        </div>
                    </div>

                    @if(Auth::check())
                    <div class="filter-row">
                        <div class="filter-group checkbox-group">
                            <label class="checkbox-label" for="favorites-only">
                                <input type="checkbox" name="favorites_only" id="favorites-only" value="1" 
                                       {{ request('favorites_only') ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                <i class="fas fa-heart"></i>
                                Show my favorites only
                            </label>
                        </div>
                    </div>
                    @endif

                    <div class="filter-actions">
                        <button type="submit" class="filter-btn primary-btn">
                            <i class="fas fa-filter"></i>
                            Apply Filters
                        </button>
                        <a href="{{ url('/shop') }}" class="reset-btn secondary-btn">
                            <i class="fas fa-undo"></i>
                            Reset All
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="products-section">
            @if(!$products->isEmpty())
                <div class="products-count">
                    <span>{{ $products->count() }} products found</span>
                </div>
            @endif

            <div class="product-grid">
                @foreach ($products as $product)
                <div class="product-card animate__animated animate__fadeInUp" 
                 style="--delay: {{ $loop->index * 0.1 }}; animation-delay: calc(var(--delay) * 1s);">                   <!-- HEART FAVORITE ICON -->
                    @if(Auth::check())
                        <div class="favorite-heart" data-product-id="{{ $product->id }}">
                            <i class="{{ auth()->user() && $product->isFavoritedBy(auth()->user()) ? 'fas fa-heart filled' : 'far fa-heart empty' }}"></i>
                        </div>
                    @endif

                    <div class="product-image">
                        @if (Str::startsWith($product->image, 'http'))
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" loading="lazy" />
                        @else
                            @php
                                $imagePath = 'storage/products/' . basename($product->image);
                            @endphp
                            <img src="{{ asset($imagePath) }}" alt="{{ $product->name }}" loading="lazy" />
                        @endif
                        <div class="product-overlay">
                            <a href="{{ route('product.show', $product->id) }}" class="quick-view-btn">
                                <i class="fas fa-eye"></i>
                                Quick View
                            </a>
                        </div>
                    </div>
                    
                    <div class="product-info">
                        <div class="product-header">
                            <h3>{{ $product->name }}</h3>
                            <div class="product-price">${{ number_format($product->price, 2) }}</div>
                        </div>
                        <p class="product-description">{{ Str::limit($product->description, 80) }}</p>
                        
                        <div class="product-actions">
                            @if(Auth::check())
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="cart-add-form">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="add-to-cart-btn primary-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        Add to Cart
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="add-to-cart-btn primary-btn">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Login to Buy
                                </a>
                            @endif
                            <a href="{{ route('product.show', $product->id) }}" class="view-details-btn secondary-btn">
                                <i class="fas fa-info-circle"></i>
                                Details
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @if(session('cart_success'))
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: "Added to Cart!",
                text: "{{ session('cart_success') }}",
                icon: "success",
                confirmButtonText: "OK",
                confirmButtonColor: "#913333"
            });
        });
        </script>
        @endif
            
        @if($products->isEmpty())
        <div class="no-products-found animate__animated animate__fadeIn">
            <div class="empty-state">
                <i class="fas fa-search fa-3x"></i>
                <h3>No products found</h3>
                <p>Try adjusting your filters or search terms</p>
                <a href="{{ url('/shop') }}" class="reset-btn primary-btn">
                    <i class="fas fa-undo"></i>
                    Reset Filters
                </a>
            </div>
        </div>
        @endif

        <!-- Pagination -->
        @if(method_exists($products, 'links'))
            <div class="pagination-wrapper">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
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
    /* CSS Variables for consistent theming */
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
        --border-radius: 12px;
        --transition: all 0.3s ease;
        --font-primary: 'Reem Kufi', sans-serif;
    }

    /* Base Styles */
    * {
        box-sizing: border-box;
    }

    body {
        font-family: var(--font-primary);
        line-height: 1.6;
        color: var(--text-dark);
        margin: 0;
        padding: 0;
        background-color: var(--bg-light);
    }

    .main-content {
        min-height: 70vh;
    }

    /* Container & Layout */
    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Page Header */
    .page-header {
        text-align: center;
        margin-bottom: 40px;
        padding: 20px 0;
    }

    .page-header h1 {
        color: var(--primary-color);
        font-size: 3rem;
        font-weight: 700;
        margin: 0 0 10px 0;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }

    .page-subtitle {
        color: var(--text-muted);
        font-size: 1.2rem;
        margin: 0;
        font-weight: 300;
    }

    /* Enhanced Filter Styles */
    .product-filters-wrapper {
        background: var(--bg-white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        margin-bottom: 40px;
        overflow: hidden;
        border: 1px solid var(--border-color);
    }

    .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
        color: white;
        cursor: pointer;
    }

    .filter-header h3 {
        margin: 0;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .filter-toggle-btn {
        background: none;
        border: none;
        color: white;
        font-size: 1.2rem;
        cursor: pointer;
        transition: var(--transition);
        padding: 5px;
        border-radius: 50%;
    }

    .filter-toggle-btn:hover {
        background: rgba(255,255,255,0.1);
    }

    .filter-toggle-btn.active {
        transform: rotate(180deg);
    }

    .product-filters {
        padding: 25px;
        transition: var(--transition);
        max-height: 500px;
        overflow: hidden;
    }

    .product-filters.collapsed {
        max-height: 0;
        padding: 0 25px;
    }

    .filter-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .filter-group label {
        font-weight: 600;
        color: var(--primary-color);
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
    }

    .filter-select, .filter-input {
        padding: 12px 16px;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        font-family: inherit;
        font-size: 1rem;
        transition: var(--transition);
        background: var(--bg-white);
    }

    .filter-select:focus, .filter-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(145, 51, 51, 0.1);
    }

    /* Enhanced Checkbox Styles */
    .checkbox-group {
        margin-top: 10px;
    }

    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        padding: 12px 16px;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        transition: var(--transition);
        background: var(--bg-white);
        font-weight: 500;
    }

    .checkbox-label:hover {
        border-color: var(--primary-color);
        background: rgba(145, 51, 51, 0.05);
    }

    .checkbox-label input[type="checkbox"] {
        display: none;
    }

    .checkmark {
        width: 20px;
        height: 20px;
        border: 2px solid var(--border-color);
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
    }

    .checkbox-label input[type="checkbox"]:checked + .checkmark {
        background: var(--primary-color);
        border-color: var(--primary-color);
    }

    .checkbox-label input[type="checkbox"]:checked + .checkmark::after {
        content: '✓';
        color: white;
        font-size: 14px;
        font-weight: bold;
    }

    /* Filter Actions */
    .filter-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid var(--border-color);
    }

    .primary-btn, .secondary-btn {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-family: inherit;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-align: center;
        justify-content: center;
        min-width: 140px;
    }

    .primary-btn {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
        color: white;
        box-shadow: var(--shadow-light);
    }

    .primary-btn:hover {
        background: linear-gradient(135deg, var(--primary-hover), #6a1f1f);
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
    }

    .secondary-btn {
        background: var(--bg-white);
        color: var(--text-dark);
        border: 2px solid var(--border-color);
    }

    .secondary-btn:hover {
        border-color: var(--primary-color);
        background: rgba(145, 51, 51, 0.05);
        transform: translateY(-2px);
    }

    /* Products Section */
    .products-section {
        margin-bottom: 40px;
    }

    .products-count {
        text-align: center;
        margin-bottom: 30px;
        padding: 15px;
        background: var(--bg-white);
        border-radius: 8px;
        box-shadow: var(--shadow-light);
    }

    .products-count span {
        color: var(--text-muted);
        font-weight: 500;
    }

    /* Enhanced Product Grid */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
        margin: 30px 0;
    }

    /* Enhanced Product Card */
    .product-card {
        background: var(--bg-white);
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow-light);
        transition: var(--transition);
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
        border: 1px solid var(--border-color);
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
    }

    /* Enhanced Favorite Heart */
    .favorite-heart {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 10;
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        backdrop-filter: blur(10px);
    }

    .favorite-heart:hover {
        transform: scale(1.1);
        background: white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .favorite-heart .filled {
        color: #e74c3c;
        animation: heartbeat 0.6s ease-in-out;
    }

    .favorite-heart .empty {
        color: #ccc;
    }

    .favorite-heart .empty:hover {
        color: #e74c3c;
    }

    @keyframes heartbeat {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }

    /* Enhanced Product Image */
    .product-image {
        width: 100%;
        height: 250px;
        overflow: hidden;
        position: relative;
        background: var(--bg-light);
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .product-card:hover .product-image img {
        transform: scale(1.05);
    }

    .product-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: var(--transition);
    }

    .product-card:hover .product-overlay {
        opacity: 1;
    }

    .quick-view-btn {
        color: white;
        text-decoration: none;
        padding: 12px 20px;
        border: 2px solid white;
        border-radius: 25px;
        font-weight: 600;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .quick-view-btn:hover {
        background: white;
        color: var(--text-dark);
        transform: scale(1.05);
    }

    /* Enhanced Product Info */
    .product-info {
        padding: 25px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .product-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
        gap: 15px;
    }

    .product-card h3 {
        color: var(--primary-color);
        font-size: 1.3rem;
        margin: 0;
        font-weight: 700;
        line-height: 1.3;
        flex: 1;
    }

    .product-price {
        color: var(--primary-color);
        font-size: 1.4rem;
        font-weight: 700;
        white-space: nowrap;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .product-description {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
        margin: 10px 0 20px 0;
        flex-grow: 1;
    }

    /* Enhanced Product Actions */
    .product-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: auto;
    }

    .add-to-cart-btn, .view-details-btn {
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-align: center;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-decoration: none;
        font-family: inherit;
        border: none;
    }

    .product-actions .primary-btn {
        min-width: auto;
    }

    .product-actions .secondary-btn {
        min-width: auto;
    }

    /* No Products Found */
    .no-products-found {
        text-align: center;
        padding: 60px 20px;
        background: var(--bg-white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        margin: 40px 0;
    }

    .empty-state i {
        color: var(--text-muted);
        margin-bottom: 20px;
        opacity: 0.6;
    }

    .empty-state h3 {
        color: var(--text-dark);
        margin: 20px 0 10px 0;
        font-size: 1.5rem;
    }

    .empty-state p {
        color: var(--text-muted);
        margin-bottom: 30px;
        font-size: 1.1rem;
    }

    /* Enhanced Footer */
    footer {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
        color: white;
        margin-top: 60px;
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

    /* Pagination Styles */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin: 50px 0;
    }

    /* Loading States */
    .loading {
        opacity: 0.7;
        pointer-events: none;
    }

    .spinner {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Enhanced Mobile Navigation */
    .mobile-user-icon {
        display: none;
    }

    .desktop-user-text {
        display: inline;
    }

    /* Enhanced Hamburger Menu */
    .hamburger {
        width: 25px;
        height: 20px;
        position: relative;
        cursor: pointer;
    }

    .hamburger span {
        display: block;
        height: 3px;
        width: 100%;
        background: var(--bg-light);
        border-radius: 2px;
        position: absolute;
        transition: var(--transition);
    }

    .hamburger span:nth-child(1) {
        top: 0;
    }

    .hamburger span:nth-child(2) {
        top: 50%;
        transform: translateY(-50%);
    }

    .hamburger span:nth-child(3) {
        bottom: 0;
    }

    .menu-toggle.active .hamburger span:nth-child(1) {
        transform: rotate(45deg);
        top: 50%;
    }

    .menu-toggle.active .hamburger span:nth-child(2) {
        opacity: 0;
    }

    .menu-toggle.active .hamburger span:nth-child(3) {
        transform: rotate(-45deg);
        bottom: 50%;
    }

    /* RESPONSIVE DESIGN */
    
    /* Large Desktop */
    @media (min-width: 1400px) {
        .product-grid {
            grid-template-columns: repeat(4, 1fr);
        }
        
        .container {
            padding: 40px;
        }
    }

    /* Desktop */
    @media (max-width: 1199px) {
        .product-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }
        
        .page-header h1 {
            font-size: 2.5rem;
        }
    }

    /* Tablet */
    @media (max-width: 992px) {
        .container {
            padding: 20px 15px;
        }

        .page-header h1 {
            font-size: 2.2rem;
        }

        .product-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .filter-row {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .filter-actions {
            flex-direction: column;
            gap: 10px;
        }

        .primary-btn, .secondary-btn {
            width: 100%;
        }

        /* Mobile Navigation Adjustments */
        .mobile-user-icon {
            display: inline;
            font-size: 1.2rem;
        }

        .desktop-user-text {
            display: none;
        }
    }

    /* Mobile Large */
    @media (max-width: 768px) {
        .page-header {
            margin-bottom: 30px;
            padding: 15px 0;
        }

        .page-header h1 {
            font-size: 2rem;
        }

        .page-subtitle {
            font-size: 1rem;
        }

        .product-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .product-card {
            max-width: 400px;
            margin: 0 auto;
        }

        .filter-header {
            padding: 15px 20px;
        }

        .product-filters {
            padding: 20px;
        }

        .filter-row {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .product-actions {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .product-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .product-price {
            font-size: 1.2rem;
        }

        /* Auto-collapse filters on mobile */
        .product-filters {
            max-height: 0;
            padding: 0 20px;
        }

        .product-filters.show {
            max-height: 600px;
            padding: 20px;
        }

        .filter-toggle-btn {
            display: block;
        }

        /* Footer responsive */
        .footer-container {
            grid-template-columns: 1fr;
            gap: 30px;
            padding: 40px 20px;
        }

        .footer-social {
            justify-content: center;
        }
    }

    /* Mobile Small */
    @media (max-width: 480px) {
        .container {
            padding: 15px 10px;
        }

        .page-header h1 {
            font-size: 1.8rem;
        }

        .product-filters-wrapper {
            margin: 0 -10px 30px -10px;
            border-radius: 0;
        }

        .filter-header {
            padding: 12px 15px;
        }

        .filter-header h3 {
            font-size: 1rem;
        }

        .product-filters {
            padding: 15px;
        }

        .filter-select, .filter-input {
            padding: 10px 12px;
            font-size: 0.9rem;
        }

        .checkbox-label {
            padding: 10px 12px;
            font-size: 0.9rem;
        }

        .primary-btn, .secondary-btn {
            padding: 10px 16px;
            font-size: 0.9rem;
            min-width: 120px;
        }

        .product-card {
            border-radius: 8px;
        }

        .product-image {
            height: 220px;
        }

        .product-info {
            padding: 20px;
        }

        .product-card h3 {
            font-size: 1.2rem;
        }

        .add-to-cart-btn, .view-details-btn {
            padding: 10px 12px;
            font-size: 0.85rem;
        }

        .favorite-heart {
            width: 40px;
            height: 40px;
            top: 12px;
            right: 12px;
        }

        .no-products-found {
            padding: 40px 15px;
            margin: 30px -10px;
            border-radius: 0;
        }

        .empty-state h3 {
            font-size: 1.3rem;
        }

        .empty-state p {
            font-size: 1rem;
        }
    }

    /* Extra Small Mobile */
    @media (max-width: 360px) {
        .page-header h1 {
            font-size: 1.6rem;
        }

        .product-info {
            padding: 15px;
        }

        .filter-actions {
            gap: 8px;
        }

        .primary-btn, .secondary-btn {
            padding: 8px 12px;
            font-size: 0.85rem;
            min-width: 100px;
        }
    }

    /* Landscape Mobile */
    @media (max-width: 768px) and (orientation: landscape) {
        .page-header {
            margin-bottom: 20px;
            padding: 10px 0;
        }

        .page-header h1 {
            font-size: 1.8rem;
        }

        .product-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .product-image {
            height: 180px;
        }
    }

    /* High DPI Displays */
    @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
        .product-image img {
            image-rendering: -webkit-optimize-contrast;
        }
    }

    /* Dark Mode Support */
    @media (prefers-color-scheme: dark) {
        :root {
            --bg-light: #1a1a1a;
            --bg-white: #2d2d2d;
            --text-dark: #ffffff;
            --text-muted: #cccccc;
            --border-color: #404040;
        }
    }

    /* Reduced Motion */
    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }

    /* Print Styles */
    @media print {
        .product-filters-wrapper,
        .filter-actions,
        .favorite-heart,
        .product-actions,
        footer {
            display: none;
        }

        .product-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .product-card {
            break-inside: avoid;
            box-shadow: none;
            border: 1px solid #ccc;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced Mobile Menu Toggle
    const menuToggle = document.getElementById('menu-toggle');
    const navMenu = document.querySelector('#navMenu');
    
    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            navMenu.classList.toggle('show');
            document.body.classList.toggle('menu-open');
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.navbar') && navMenu.classList.contains('show')) {
                menuToggle.classList.remove('active');
                navMenu.classList.remove('show');
                document.body.classList.remove('menu-open');
            }
        });

        // Close menu on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                menuToggle.classList.remove('active');
                navMenu.classList.remove('show');
                document.body.classList.remove('menu-open');
            }
        });
    }

    // Enhanced Filter Toggle
    const filterToggle = document.getElementById('filter-toggle');
    const filterContent = document.getElementById('filter-content');
    
    if (filterToggle && filterContent) {
        // Auto-collapse on mobile
        if (window.innerWidth <= 768) {
            filterContent.classList.add('collapsed');
            filterToggle.classList.remove('active');
        }

        filterToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            filterContent.classList.toggle('collapsed');
            filterContent.classList.toggle('show');
        });

        // Auto-collapse/expand on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth <= 768) {
                if (!filterContent.classList.contains('collapsed')) {
                    filterContent.classList.add('collapsed');
                    filterToggle.classList.remove('active');
                }
            } else {
                filterContent.classList.remove('collapsed');
                filterContent.classList.add('show');
                filterToggle.classList.add('active');
            }
        });
    }

    // Cart Count Management
    const cartCountElement = document.getElementById("cart-count");

    function fetchCartCount() {
        fetch('/cart/count')
            .then(response => response.json())
            .then(data => {
                if (cartCountElement) {
                    cartCountElement.textContent = data.count;
                    // Add animation for count update
                    cartCountElement.style.transform = 'scale(1.2)';
                    setTimeout(() => {
                        cartCountElement.style.transform = 'scale(1)';
                    }, 200);
                }
            })
            .catch(error => {
                console.warn('Cart count fetch failed:', error);
                if (cartCountElement && !document.querySelector('meta[name="user-authenticated"]')) {
                    cartCountElement.textContent = '0';
                }
            });
    }

    fetchCartCount();

    // Enhanced AJAX Add to Cart
    const addToCartForms = document.querySelectorAll('.cart-add-form');
    addToCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            
            // Enhanced loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            submitBtn.disabled = true;
            submitBtn.classList.add('loading');
            
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                fetchCartCount();
                
                // Enhanced success animation
                submitBtn.innerHTML = '<i class="fas fa-check"></i> Added!';
                submitBtn.style.background = '#28a745';
                
                setTimeout(() => {
                    submitBtn.innerHTML = originalBtnText;
                    submitBtn.style.background = '';
                }, 1500);
                
                // Enhanced success message
                Swal.fire({
                    title: "Added to Cart!",
                    text: data.message || "Product added to cart successfully",
                    icon: "success",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#913333",
                    timer: 3000,
                    timerProgressBar: true,
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
            })
            .catch(error => {
                console.error('Add to cart error:', error);
                Swal.fire({
                    title: "Error",
                    text: "There was a problem adding this item to your cart. Please try again.",
                    icon: "error",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#913333"
                });
            })
            .finally(() => {
                setTimeout(() => {
                    submitBtn.innerHTML = originalBtnText;
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('loading');
                    submitBtn.style.background = '';
                }, 1500);
            });
        });
    });

    // Enhanced Favorites Functionality
    document.querySelectorAll('.favorite-heart').forEach(heart => {
        heart.addEventListener('click', async function(e) {
            e.preventDefault();
            e.stopPropagation();

            const productId = this.dataset.productId;
            const heartIcon = this.querySelector('i');

            if (!productId || !heartIcon) return;

            // Add click animation
            this.style.transform = 'scale(0.8)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);

            try {
                heartIcon.className = 'fas fa-spinner fa-spin';

                const response = await fetch('/favorites/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ product_id: productId })
                });

                const data = await response.json();

                if (data.success) {
                    if (data.is_favorite) {
                        heartIcon.className = 'fas fa-heart filled';
                        this.setAttribute('title', 'Remove from favorites');
                    } else {
                        heartIcon.className = 'far fa-heart empty';
                        this.setAttribute('title', 'Add to favorites');
                    }

                    // Enhanced toast notification
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        showClass: {
                            popup: 'animate__animated animate__slideInRight'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__slideOutRight'
                        }
                    });

                } else {
                    throw new Error(data.message || 'Failed to toggle favorite');
                }

            } catch (error) {
                console.error('Favorite Toggle Error:', error);
                heartIcon.className = 'far fa-heart empty';
                
                Swal.fire({
                    title: 'Error',
                    text: error.message || 'Failed to update favorite',
                    icon: 'error',
                    confirmButtonColor: '#913333'
                });
            }
        });
    });

    // Enhanced Search Input
    const searchInput = document.getElementById('search');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            
            // Visual feedback for search
            if (this.value.length > 0) {
                this.style.borderColor = '#913333';
            } else {
                this.style.borderColor = '#e0e0e0';
            }
            
            searchTimeout = setTimeout(() => {
                if (this.value.length >= 2 || this.value.length === 0) {
                    document.getElementById('filter-form').submit();
                }
            }, 500);
        });
    }

    // Price Input Validation
    const priceInput = document.getElementById('price');
    if (priceInput) {
        priceInput.addEventListener('input', function() {
            if (this.value < 0) {
                this.value = 0;
            }
            
            // Visual feedback
            if (this.value > 0) {
                this.style.borderColor = '#913333';
            } else {
                this.style.borderColor = '#e0e0e0';
            }
        });
    }

    // Enhanced Filter Form
    const filterForm = document.getElementById('filter-form');
    if (filterForm) {
        filterForm.addEventListener('submit', function() {
            const filterBtn = this.querySelector('.filter-btn');
            if (filterBtn) {
                filterBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Filtering...';
                filterBtn.disabled = true;
            }
        });
    }

    // Initialize favorite tooltips
    document.querySelectorAll('.favorite-heart').forEach(heart => {
        const heartIcon = heart.querySelector('i');
        if (heartIcon && heartIcon.classList.contains('filled')) {
            heart.setAttribute('title', 'Remove from favorites');
        } else {
            heart.setAttribute('title', 'Add to favorites');
        }
    });

    // Lazy loading for images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Performance optimization: Debounce resize events
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            // Trigger any resize-dependent functions here
            console.log('Window resized');
        }, 250);
    });
});

// Utility Functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Error handling for network issues
window.addEventListener('online', function() {
    console.log('Back online');
});

window.addEventListener('offline', function() {
    console.log('Gone offline');
    Swal.fire({
        title: 'No Internet Connection',
        text: 'Please check your internet connection',
        icon: 'warning',
        confirmButtonColor: '#913333'
    });
});
</script>

@endsection