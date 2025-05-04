<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile Settings | Tatreez Traditions</title>
    <link rel="stylesheet" href="{{ asset('css/navbar-footer.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Orpheus+Pro&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi+Fun:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
       :root {
    --primary: #9b3737;          
    --primary-dark: #7e2c2c;      
    --primary-light: #c25454;     
    --secondary: #e4c4b0;        
    --accent: #d4af37;           
    
    --text-dark: #333333;         
    --text-light: #ffffff;       
    
    --background: #f9f5f2;        
    --card-bg: #ffffff;
    
    --danger: #d9534f;
    --danger-dark: #c82333;
    --success: #5cb85c;
    
    --border-radius: 8px;
    --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    --transition: all 0.3s ease;
}


        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Reem Kufi Fun", sans-serif;
            background-color: var(--background);
            color: var(--text-dark);
            line-height: 1.6;
        }

        /* Navbar Styles */
        .navbar {
            background-color: var(--primary);
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-container img {
            height: 40px;
            filter: drop-shadow(0 0 2px rgba(0, 0, 0, 0.2));
        }

        .logo-container .logo-text {
            font-family: "Reem Kufi Fun", sans-serif;
            font-weight: 500;
            font-size: 32px;
            color: white;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }

        .menu-toggle {
            display: none;
            font-size: 1.5rem;
            color: white;
            cursor: pointer;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 16px;
            margin: 0;
            padding: 0;
        }

        .navbar ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 8px 12px;
            transition: var(--transition);
        }

        .navbar ul li a:hover {
            color: var(--secondary);
        }

        .navbar .icons {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .cart-icon {
            position: relative;
            color: white;
            font-size: 20px;
            transition: var(--transition);
        }

        .cart-icon:hover {
            color: var(--card-bg);
        }

        #cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--secondary);
            color: var(--primary);
            font-size: 12px;
            font-weight: bold;
            height: 18px;
            width: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-register-dropdown {
            position: relative;
        }

        .login-register-dropdown .dropdown-toggle {
            color: white;
            text-decoration: none;
            font-size: 14px;
            padding: 8px 16px;
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            transition: var(--transition);
        }

        .login-register-dropdown .dropdown-toggle:hover {
            background-color: var(--primary-dark);
        }

        .login-register-dropdown .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 5px);
            background-color: var(--card-bg);
            box-shadow: var(--box-shadow);
            border-radius: var(--border-radius);
            overflow: hidden;
            min-width: 180px;
            z-index: 100;
        }

        .login-register-dropdown:hover .dropdown-content {
            display: block;
        }

        .login-register-dropdown .dropdown-content a {
            color: var(--primary);
            text-decoration: none;
            padding: 12px 16px;
            display: block;
            font-size: 14px;
            transition: var(--transition);
        }

        .login-register-dropdown .dropdown-content a:hover {
            background-color: rgba(145, 51, 51, 0.1);
        }

        .login-register-dropdown .dropdown-content button {
            border: none;
            background: none;
            padding: 12px 16px;
            font-size: 14px;
            color: var(--primary);
            width: 100%;
            text-align: left;
            cursor: pointer;
            transition: var(--transition);
            font-family: "Reem Kufi Fun", sans-serif;
        }

        .login-register-dropdown .dropdown-content button:hover {
            background-color: rgba(145, 51, 51, 0.1);
        }

        /* Main Container Styles */
        .main-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .page-title {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 24px;
            color: var(--primary);
            text-align: center;
        }

        .settings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .card {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            background-color: var(--primary);
            color: white;
            padding: 16px 20px;
            font-size: 18px;
            font-weight: 600;
        }

        .card-body {
            padding: 24px;
        }

        .card p {
            color: var(--text-light);
            margin-bottom: 16px;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-dark);
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-family: inherit;
            font-size: 16px;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(145, 51, 51, 0.2);
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-family: inherit;
            font-size: 16px;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            text-align: center;
        }

        .btn:hover {
            background-color: var(--primary-dark);
        }

        .btn-danger {
            background-color: var(--danger);
        }

        .btn-danger:hover {
            background-color: var(--danger-dark);
        }

        .alert {
            padding: 12px 16px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: rgba(92, 184, 92, 0.2);
            border: 1px solid rgba(92, 184, 92, 0.5);
            color: #3d8b3d;
        }

        .alert-danger {
            background-color: rgba(217, 83, 79, 0.2);
            border: 1px solid rgba(217, 83, 79, 0.5);
            color: #a94442;
        }

        /* Footer Styles */
        footer {
            background-color: var(--primary);
            color: white;
            padding: 40px 0 20px;
            margin-top: 60px;
        }

        .footer-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 20px;
            text-align: center;
        }

        .footer-logo {
            font-family: "Reem Kufi Fun", sans-serif;
            font-size: 28px;
            margin-bottom: 16px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 24px;
            margin-bottom: 24px;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: var(--accent);
        }

        .footer-social {
            margin-bottom: 24px;
        }

        .footer-social a {
            color: white;
            margin: 0 12px;
            font-size: 22px;
            transition: var(--transition);
            display: inline-block;
        }

        .footer-social a:hover {
            color: var(--accent);
            transform: translateY(-3px);
        }

        .footer-copy {
            font-size: 14px;
            opacity: 0.8;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                padding: 10px;
            }

            .menu-toggle {
                display: block;
                position: absolute;
                left: 20px;
                top: 20px;
            }

            .navbar ul {
                flex-direction: column;
                width: 100%;
                margin-top: 20px;
                display: none;
            }

            .navbar ul.show {
                display: flex;
            }

            .navbar ul li {
                width: 100%;
                text-align: center;
            }

            .navbar ul li a {
                display: block;
                padding: 12px;
            }

            .settings-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <header>
    <div class="navbar">
        <button class="menu-toggle" id="menuToggle">☰</button>
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
    <div class="main-container">
        <h1 class="page-title">Profile Settings</h1>
        
        @if(session('status') === 'profile-updated')
            <div class="alert alert-success">
                Profile information updated successfully.
            </div>
        @endif

        @if(session('status') === 'password-updated')
            <div class="alert alert-success">
                Password updated successfully.
            </div>
        @endif

        <div class="settings-grid">
            <!-- Profile Information Card -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user"></i> Profile Information
                </div>
                <div class="card-body">
                    <p>Update your account's profile information and email address.</p>
                    
                    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')
                        
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="email">
                            @error('email')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn">Save</button>
                    </form>
                </div>
            </div>
            
            <!-- Update Password Card -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-lock"></i> Update Password
                </div>
                <div class="card-body">
                    <p>Ensure your account is using a strong password for security.</p>
                    
                    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('put')
                        
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password">
                            @error('current_password')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input id="password" name="password" type="password" class="form-control" autocomplete="new-password">
                            @error('password')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
                            @error('password_confirmation')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn">Update Password</button>
                    </form>
                </div>
            </div>
            
            <!-- Delete Account Card -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-trash-alt"></i> Delete Account
                </div>
                <div class="card-body">
                    <p>Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</p>
                    
                    <form method="post" action="{{ route('profile.destroy') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('delete')
                        
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input id="password" name="password" type="password" class="form-control" placeholder="Password" required>
                            @error('password')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-danger">Delete Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            
            <div class="footer-links">
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ url('/shop') }}">Shop</a>
                <a href="{{ url('/learn') }}">Learn</a>
                <a href="{{ url('/about') }}">About</a>
                <a href="{{ url('/contact') }}">Contact</a>
                <a href="{{ url('/privacy') }}">Privacy Policy</a>
                <a href="{{ url('/terms') }}">Terms of Service</a>
            </div>
            
            <div class="footer-social">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-pinterest"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
            
            <p class="footer-copy">&copy; 2025 Tatreez Traditions. All rights reserved.</p>
        </div>
    </footer>

  
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
</body>
</html>