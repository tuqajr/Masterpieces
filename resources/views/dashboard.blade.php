<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Profile | Ghorzah</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="css/navbar-footer.css">

    <link href="https://fonts.googleapis.com/css2?family=Orpheus+Pro&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alkalami&family=Badeen+Display&family=Handjet:wght@100..900&family=Reem+Kufi+Fun:wght@400..700&family=Reem+Kufi:wght@400..700&family=Ruwudu:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        /* Base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Orpheus Pro', serif;
            color: #333;
            line-height: 1.6;
            background-color: #fcf9f3;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("{{ asset('images/back.png') }}") no-repeat center center;
            background-size: cover;
            background-attachment: fixed;
            opacity: 0.08;
            z-index: -1;
        }

        
        /* Profile Content */
        .profile-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 40px;
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .user-avatar {
            color: #9b3737;
            font-size: 80px;
            margin-right: 10px;
        }

        .user-welcome h1 {
            color: #9b3737;
            font-family: 'Reem Kufi', sans-serif;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .user-welcome p {
            color: #555;
            font-size: 18px;
        }

        .profile-sections {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(500px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .profile-section {
            background-color: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .profile-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .section-title {
            background-color: #9b3737;
            color: white;
            padding: 15px 20px;
            font-family: 'Reem Kufi', sans-serif;
            font-size: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-content {
            padding: 20px;
        }

        .info-card {
            padding: 10px;
        }

        .info-card p {
            margin-bottom: 15px;
            font-size: 17px;
            color: #555;
        }

        .info-card strong {
            color: #9b3737;
        }

        .edit-button {
            display: inline-block;
            background-color: #9b3737;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-family: 'Reem Kufi', sans-serif;
            font-size: 16px;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .edit-button:hover {
            background-color: #7c2828;
        }

        .order-item {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .status-completed {
            color: #2e8b57;
        }

        .status-processing {
            color: #ff8c00;
        }

        .status-cancelled {
            color: #dc3545;
        }

        .view-button {
            display: inline-block;
            background-color: #f0d0a0;
            color: #9b3737;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-family: 'Reem Kufi', sans-serif;
            font-size: 14px;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .view-button:hover {
            background-color: #e6c08e;
        }

        .empty-state {
            color: #777;
            font-style: italic;
            margin-bottom: 15px;
        }

        .shop-button, .workshop-button {
            display: inline-block;
            background-color: #9b3737;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-family: 'Reem Kufi', sans-serif;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .shop-button:hover, .workshop-button:hover {
            background-color: #7c2828;
        }

        .saved-items-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
        margin-top: 15px;
    }
    
    .saved-item {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .saved-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    
    .saved-item img {
        width: 100%;
        height: 160px;
        object-fit: cover;
    }
    
    .saved-item h4 {
        color: #913333;
        font-size: 1.1rem;
        margin: 10px 15px 5px;
    }
    
    .saved-item p {
        color: #555;
        font-weight: bold;
        margin: 0 15px 10px;
    }
    
    .saved-item-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        padding: 10px 15px 15px;
    }
    
    .view-button, .add-to-cart-button, .remove-button {
        padding: 6px 12px;
        border-radius: 5px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        text-decoration: none;
    }
    
    .view-button {
        background-color: #f8f9fa;
        color: #333;
        border: 1px solid #ddd;
        flex: 1;
    }
    
    .view-button:hover {
        background-color: #e9ecef;
    }
    
    .add-to-cart-button {
        background-color: #913333;
        color: white;
        border: none;
        flex: 1;
    }
    
    .add-to-cart-button:hover {
        background-color: #7c2828;
    }
    
    .remove-button {
        background-color: #f8f9fa;
        color: #dc3545;
        border: 1px solid #dc3545;
        flex-basis: 100%;
        margin-top: 5px;
    }
    
    .remove-button:hover {
        background-color: #dc3545;
        color: white;
    }
    
    .empty-state {
        text-align: center;
        color: #6c757d;
        margin: 20px 0;
        font-size: 1rem;
    }
    
    .shop-button {
        display: block;
        width: max-content;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: #913333;
        color: #fff;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }
    
    .shop-button:hover {
        background-color: #7c2828;
    }
    
    @media (max-width: 768px) {
        .saved-items-grid {
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        }
        
        .saved-item-actions {
            flex-direction: column;
        }
        
        .view-button, .add-to-cart-button, .remove-button {
            flex-basis: 100%;
        }
    }
    
    @media (max-width: 480px) {
        .saved-items-grid {
            grid-template-columns: 1fr;
        }
    }

        .add-to-cart-button {
            background-color: #9b3737;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Reem Kufi', sans-serif;
            font-size: 14px;
            transition: background-color 0.3s ease;
            flex: 1;
        }

        .add-to-cart-button:hover {
            background-color: #7c2828;
        }

        .workshop-item {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }

        .workshop-item:last-child {
            border-bottom: none;
        }

        .workshop-item h4 {
            color: #9b3737;
            margin-bottom: 10px;
            font-family: 'Reem Kufi', sans-serif;
        }

        .profile-actions {
            text-align: center;
            margin-top: 20px;
        }

        .logout-button {
            display: inline-block;
            background-color: #9b3737;
            color: white;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-family: 'Reem Kufi', sans-serif;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .logout-button:hover {
            background-color: #7c2828;
        }

        /* Progress Tracker */
        .progress-section {
            background-color: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            grid-column: 1 / -1;
        }

        .progress-tracker {
            padding: 20px;
        }

        .progress-title {
            color: #9b3737;
            font-family: 'Reem Kufi', sans-serif;
            font-size: 20px;
            margin-bottom: 15px;
        }

        .progress-bar-container {
            height: 20px;
            background-color: #f0f0f0;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .progress-bar {
            height: 100%;
            background-color: #9b3737;
            border-radius: 10px;
            width: 65%;
        }

        .progress-stats {
            display: flex;
            justify-content: space-between;
            color: #777;
            font-size: 14px;
        }

        .skill-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .skill-badge {
            background-color: #f0d0a0;
            color: #9b3737;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-family: 'Reem Kufi', sans-serif;
        }

        /* Recent Projects */
        .projects-section {
            background-color: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            grid-column: 1 / -1;
        }

        .projects-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            padding: 20px;
        }

        .project-item {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            height: 150px;
        }

        .project-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .project-item:hover img {
            transform: scale(1.05);
        }

        .project-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(155, 55, 55, 0.8), transparent);
            padding: 10px;
            color: white;
            font-family: 'Reem Kufi', sans-serif;
            font-size: 14px;
        }

        /* Back to top button */
        #topBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 99;
            border: none;
            outline: none;
            background-color: #9b3737;
            color: white;
            cursor: pointer;
            padding: 12px;
            border-radius: 50%;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        #topBtn:hover {
            background-color: #7c2828;
        }

        
    </style>
</head>
<body>
<header>
    <div class="navbar">
        <button class="menu-toggle" id="menuToggle">☰</button>
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
                        <button type="submit" style="border: none; background: none; padding: 8px 16px; font-size: 14px; color: #9b3737; width: 100%; text-align: left; cursor: pointer;">
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
            <li><a href="{{ url('/shop') }}">Shop</a></li>
            <li><a href="{{ url('/learn') }}">Learn</a></li>
            <li><a href="{{ url('/about') }}">About</a></li>
            <li><a href="{{ url('/contact') }}">Contact</a></li>
        </ul>
        <div class="logo-container">
            <span class="logo-text">غرزه</span>
            <img src="{{ asset('images/embroidery_1230695.png') }}" alt="Logo">
        </div>
    </div>  
</header>
    <!-- Main Content -->
    <div class="content">
        <div class="profile-container">
            <div class="profile-header">
                <div class="user-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="user-welcome">
                    <h1>Welcome, {{ Auth::user()->name }}!</h1>
                    <p>Here you can manage your account, view orders, and update your preferences.</p>
                </div>
            </div>

            <div class="profile-sections">
                <!-- Account Details -->
                <div class="profile-section">
                    <div class="section-title">
                        <i class="fas fa-id-card"></i>
                        Account Details
                    </div>
                    <div class="section-content">
                        <div class="info-card">
                            <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                            <p><strong>Joined:</strong> {{ Auth::user()->created_at->format('d M, Y') }}</p>
                            <a href="{{ route('profile.edit') }}" class="edit-button">
                                <i class="fas fa-pencil-alt"></i> Edit Profile
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="profile-section">
                    <div class="section-title">
                        <i class="fas fa-shopping-bag"></i>
                        Recent Orders
                    </div>
                    <div class="section-content">
                        <div class="info-card">
                            @if(count($orders ?? []) > 0)
                                @foreach($orders as $order)
                                <div class="order-item">
                                    <p><strong>Order #:</strong> {{ $order->id }}</p>
                                    <p><strong>Date:</strong> {{ $order->created_at->format('d M, Y') }}</p>
                                    <p><strong>Status:</strong> <span class="status-{{ strtolower($order->status) }}">{{ $order->status }}</span></p>
                                    <a href="{{ route('orders.show', $order->id) }}" class="view-button">View Details</a>
                                </div>
                                @endforeach
                            @else
                                <p class="empty-state">You have no recent orders at the moment.</p>
                                <a href="{{ url('/shop') }}" class="shop-button">
                                    <i class="fas fa-store"></i> Shop Now
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                    <!-- Saved Items -->
        <div class="profile-section">
            <div class="section-title">
                <i class="fas fa-heart"></i>
                Saved Items
            </div>
            <div class="section-content">
                <div class="info-card">
                    @if(count($favorites ?? []) > 0)
                        <div class="saved-items-grid">
                            @foreach($favorites as $favorite)
                            <div class="saved-item">
                                <img src="{{ asset($favorite->product->image) }}" alt="{{ $favorite->product->name }}">
                                <h4>{{ $favorite->product->name }}</h4>
                                <p>${{ number_format($favorite->product->price, 2) }}</p>
                                <div class="saved-item-actions">
                                    <a href="{{ route('product.show', $favorite->product->id) }}" class="view-button">View</a>
                                    <form action="{{ route('cart.add', $favorite->product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="add-to-cart-button">Add to Cart</button>
                                    </form>
                                    <form action="{{ route('favorites.toggle', $favorite->product->id) }}" method="POST" class="remove-favorite-form">
                                        @csrf
                                        <button type="submit" class="remove-button">
                                            <i class="fas fa-trash-alt"></i> Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="empty-state">You have no saved items.</p>
                        <a href="{{ url('/shop') }}" class="shop-button">
                            <i class="fas fa-store"></i> Browse Products
                        </a>
                    @endif
                </div>
            </div>
        </div>


                <!-- Workshops -->
                <div class="profile-section">
                    <div class="section-title">
                        <i class="fas fa-chalkboard-teacher"></i>
                        My Workshops
                    </div>
                    <div class="section-content">
                        <div class="info-card">
                            @if(count($workshops ?? []) > 0)
                                @foreach($workshops as $workshop)
                                <div class="workshop-item">
                                    <h4>{{ $workshop->title }}</h4>
                                    <p><strong>Date:</strong> {{ $workshop->date->format('d M, Y') }}</p>
                                    <p><strong>Time:</strong> {{ $workshop->start_time }} - {{ $workshop->end_time }}</p>
                                    <a href="{{ route('workshops.show', $workshop->id) }}" class="view-button">View Details</a>
                                </div>
                                @endforeach
                            @else
                                <p class="empty-state">You are not enrolled in any workshops.</p>
                                <a href="{{ url('/learn') }}" class="workshop-button">
                                    <i class="fas fa-book"></i> Explore Workshops
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="profile-actions">
                <a href="{{ route('logout') }}" class="logout-button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-links">
                <div class="links-column">
                    <h4>Shop</h4>
                    <ul>
                        <li><a href="{{ url('/shop/category/kits') }}">Embroidery Kits</a></li>
                        <li><a href="{{ url('/shop/category/supplies') }}">Supplies</a></li>
                        <li><a href="{{ url('/shop/category/finished') }}">Finished Pieces</a></li>
                        <li><a href="{{ url('/shop/category/digital') }}">Digital Patterns</a></li>
                    </ul>
                </div>
                <div class="links-column">
                    <h4>Learn</h4>
                    <ul>
                        <li><a href="{{ url('/learn/workshops') }}">Workshops</a></li>
                        <li><a href="{{ url('/learn/tutorials') }}">Tutorials</a></li>
                        <li><a href="{{ url('/learn/history') }}">History</a></li>
                    </ul>
                </div>
                <div class="links-column">
                    <h4>Customer Service</h4>
                    <ul>
                        <li><a href="{{ url('/contact') }}">Contact Us</a></li>
                        <li><a href="{{ url('/faq') }}">FAQ</a></li>
                        <li><a href="{{ url('/shipping') }}">Shipping & Returns</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-social">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-pinterest"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
            <p class="footer-copy">&copy; 2025 Ghorzah - Embroidery. All rights reserved.</p>
        </div>
    </footer>

    <button id="topBtn" title="Go to top"><i class="fas fa-arrow-up"></i></button>

    <script>
        // Back to top button
        const topButton = document.getElementById("topBtn");
        
        window.onscroll = function() {scrollFunction()};
        
        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                topButton.style.display = "block";
            } else {
                topButton.style.display = "none";
            }
        }
        
        topButton.addEventListener("click", function() {
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        });

         document.addEventListener("DOMContentLoaded", function() {
    const cartCountElement = document.getElementById("cart-count");

    // Function to fetch cart count from server
    function fetchCartCount() {
        fetch('/cart/count')
            .then(response => response.json())
            .then(data => {
                if (cartCountElement) {
                    cartCountElement.textContent = data.count;
                }
            })
            .catch(() => {
                // Fallback: for guests, use localStorage
                if (cartCountElement) {
                    let guestCart = JSON.parse(localStorage.getItem("cart")) || [];
                    cartCountElement.textContent = guestCart.length;
                }
            });
    }

    fetchCartCount();

    // Optionally, re-call fetchCartCount after AJAX add-to-cart or remove, if you use AJAX for those
    // For example, after a successful add-to-cart:
    // fetchCartCount();
});
       document.addEventListener("DOMContentLoaded", function() {
       
        const menuToggle = document.querySelector('.menu-toggle');
        const navMenu = document.getElementById('navMenu');
        
        if (menuToggle && navMenu) {
            menuToggle.addEventListener('click', function() {
                navMenu.classList.toggle('show');
            });
            
            document.addEventListener('click', function(event) {
                const isClickInsideMenu = navMenu.contains(event.target);
                const isClickOnToggle = menuToggle.contains(event.target);
                
                if (!isClickInsideMenu && !isClickOnToggle && navMenu.classList.contains('show')) {
                    navMenu.classList.remove('show');
                }
            });
        }
        
        const quantityInputs = document.querySelectorAll('.quantity-form input[name="quantity"]');
        if (quantityInputs) {
            quantityInputs.forEach(input => {
                input.addEventListener('change', function() {
                   
                });
            });
        }
    
        });
    </script>
        <script src="js/navbar-footer.js"></script>

</body>
</html>