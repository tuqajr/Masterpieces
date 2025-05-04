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
            @if(Auth::check())
            <a href="{{ route('cart.show') }}" class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <span id="cart-count">
                    {{ \App\Models\CartItem::where('user_id', Auth::id())->sum('quantity') }}
                </span>
            </a>
            @endif
            
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
    <h1>Our Products</h1>
    <div class="product-filters">
    <form method="GET" action="{{ url('/shop') }}">
        <div class="filter-group">
            <label for="category">Category:</label>
            <select name="category" id="category">
                <option value="">All</option>
                <option value="mug" {{ request('category') == 'mug' ? 'selected' : '' }}>Mugs</option>
                <option value="bag" {{ request('category') == 'bag' ? 'selected' : '' }}>Bags</option>
                <option value="hoodie" {{ request('category') == 'hoodie' ? 'selected' : '' }}>Hoodies</option>
                <option value="art" {{ request('category') == 'art' ? 'selected' : '' }}>Wall Art</option>
                <option value="learn" {{ request('category') == 'learn' ? 'selected' : '' }}>Workshop</option>
            </select>
        </div>

        <div class="filter-group">
            <label for="price">Max Price:</label>
            <input type="number" name="price" id="price" placeholder="e.g. 50" value="{{ request('price') }}">
        </div>

        <div class="filter-group">
            <label for="search">Search:</label>
            <input type="text" name="search" id="search" placeholder="Search..." value="{{ request('search') }}">
        </div>

        <div class="filter-actions">
            <button type="submit" class="filter-btn">Filter</button>
            <a href="{{ url('/shop') }}" class="reset-btn">Reset</a>
        </div>
        
        @if(Auth::check())
        <div class="filter-group favorites-filter">
            <label for="favorites-only">
                <input type="checkbox" name="favorites_only" id="favorites-only" value="1" {{ request('favorites_only') ? 'checked' : '' }}>
                Show my favorites only
            </label>
        </div>
        @endif
    </form>
</div>


    <div class="product-grid">
        @foreach ($products as $product)
        <div class="product-card">
            <div class="product-image">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" />
            </div>
            <div class="product-info">
                <h3>{{ $product->name }}</h3>
                <p class="product-description">{{ $product->description }}</p>
                <p class="product-price">${{ number_format($product->price, 2) }}</p>
                
                <div class="product-actions">
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="add-to-cart-btn">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </form>
                    <a href="{{ route('product.show', $product->id) }}" class="view-details-btn">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    @if($products->isEmpty())
    <div class="no-products-found">
        <p>No products found matching your criteria.</p>
        <a href="{{ url('/shop') }}" class="reset-btn">Reset Filters</a>
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
    /* Shop Page Specific Styles */
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
    }

    /* Filter Styles */
    .product-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 30px;
        padding: 15px;
        background-color: #f9f9f9;
        border-radius: 10px;
        font-family: 'Reem Kufi', sans-serif;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .product-filters form {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: flex-end;
        width: 100%;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        margin-right: 20px;
    }

    .filter-group label {
        margin-bottom: 5px;
        font-weight: bold;
        color: #913333;
    }

    .filter-group select,
    .filter-group input {
        padding: 8px 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

   
    .filter-actions {
        display: flex;
        align-items: flex-end;
        gap: 15px;
    }

    .filter-btn, .reset-btn {
        background-color: #913333;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.95rem;
        transition: background-color 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .reset-btn {
        background-color: #6c757d;
    }

    .filter-btn:hover {
        background-color: #7c2828;
    }

    .reset-btn:hover {
        background-color: #5a6268;
    }
    
    /* No Products Found */
    .no-products-found {
        text-align: center;
        padding: 40px 0;
        background-color: #f9f9f9;
        border-radius: 10px;
        margin: 30px 0;
    }
    
    .no-products-found p {
        font-size: 1.2rem;
        color: #555;
        margin-bottom: 20px;
    }

    /* Product Grid & Card Styles */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
        justify-content: center;
        margin: 30px 0;
    }
    
    .product-card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    
    

    
    .product-image {
        width: 100%;
        height: 220px;
        overflow: hidden;
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .product-card:hover .product-image img {
        transform: scale(1.1);
    }
    
    .product-info {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        position: relative;
    }
    
    .product-card h3 {
        color: rgb(145, 51, 51);
        font-size: 1.3rem;
        margin-bottom: 10px;
        font-weight: bold;
    }
    
    .product-description {
        color: #555;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 15px;
        flex-grow: 1;
    }
    
    .product-price {
        color: #913333;
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 15px;
    }
    
    .product-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: space-between;
        margin-top: auto;
    }
    
    .add-to-cart-btn, .view-details-btn {
        padding: 8px 15px;
        border-radius: 5px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        text-decoration: none;
        flex-basis: calc(50% - 5px);
    }
    
    .add-to-cart-btn {
        background-color: rgb(145, 51, 51);
        color: white;
        border: none;
    }
    
    .add-to-cart-btn:hover {
        background-color: #7c2828;
    }
    
    .view-details-btn {
        background-color: #f8f9fa;
        color: #333;
        border: 1px solid #ddd;
    }
    
    .view-details-btn:hover {
        background-color: #e9ecef;
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
    
    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }
        
    }
    
    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        }
        
        .product-actions {
            flex-direction: column;
        }
        
        .add-to-cart-btn, .view-details-btn {
            flex-basis: 100%;
        }
        
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
    
    @media (max-width: 480px) {
        .product-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
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