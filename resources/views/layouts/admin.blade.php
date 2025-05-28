<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - {{ config('app.name') }}</title>
    
    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Orpheus+Pro&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alkalami&family=Badeen+Display&family=Handjet:wght@100..900&family=Reem+Kufi+Fun:wght@400..700&family=Reem+Kufi:wght@400..700&family=Ruwudu:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --sidebar-bg: #121212;
            --navbar-bg: #121212;
            --text-light: #fff;
            --text-muted: #ccc;
            --hover-bg: rgba(255, 255, 255, 0.1);
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("{{ asset('images/back.png') }}") repeat center center;
            background-size: cover;
            background-attachment: fixed;
            opacity: 0.08;
            z-index: -1;
        }

        body {
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 20px 0 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            background-color: var(--sidebar-bg);
            color: var(--text-light);
            width: 240px;
            transition: all 0.3s;
        }
        
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 70px);
            padding-top: 0.5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }
        
        .sidebar .nav-link {
            font-weight: 500;
            color: var(--text-muted);
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .sidebar .nav-link:hover {
            color: var(--text-light);
            background-color: var(--hover-bg);
        }
        
        .sidebar .nav-link.active {
            color: var(--text-light);
            background-color: var(--hover-bg);
        }
        
        .sidebar .nav-link i.menu-icon {
            margin-right: 10px;
        }
        
        .main-content {
            margin-left: 240px;
            padding-top: 20px;
            transition: all 0.3s;
        }
        
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 15px;
        }
        
        .sidebar-logo img {
            height: 40px;
        }
        
        .logo-text {
            font-family: 'Reem Kufi Fun', sans-serif !important;
            font-size: 26px;
            color: white !important;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        }
        
        .submenu {
            list-style: none;
            padding-left: 25px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        
        .submenu.show {
            max-height: 500px;
        }
        
        .submenu .nav-link {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
        
        .dropdown-toggle::after {
            display: inline-block;
            margin-left: 0.255em;
            vertical-align: 0.255em;
            content: "";
            border-top: 0.3em solid;
            border-right: 0.3em solid transparent;
            border-bottom: 0;
            border-left: 0.3em solid transparent;
        }
        
        @media (max-width: 767.98px) {
            .sidebar {
                transform: translateX(-240px);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .main-content.sidebar-open {
                margin-left: 240px;
            }
            
            .sidebar-toggle {
                display: block;
                position: fixed;
                top: 10px;
                left: 10px;
                z-index: 999;
                background-color: var(--navbar-bg);
                color: var(--text-light);
                border: none;
                border-radius: 4px;
                padding: 8px 12px;
                cursor: pointer;
            }
        }
        
        .sidebar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 15px 15px;
        }
        
        .user-info {
            margin-top: 15px;
            padding: 10px 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .user-info-dropdown {
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: var(--text-light);
        }
        
        .user-menu {
            list-style: none;
            padding-left: 0;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        
        .user-menu.show {
            max-height: 200px;
        }
    </style>
</head>
<body>
    <!-- Mobile sidebar toggle button -->
    <button class="sidebar-toggle d-md-none">
        <i class="fas fa-bars"></i>
    </button>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebarMenu" class="sidebar">
                <div class="sidebar-header">
                    <div class="sidebar-logo">
                        <span class="logo-text">غرزه</span>
                        <img src="{{ asset('images/embroidery_1230695.png') }}" alt="Logo">
                    </div>
                </div>
                
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt menu-icon"></i> Dashboard
                            </a>
                        </li>
                        
                        <!-- Products dropdown -->
                        <li class="nav-item">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-box menu-icon"></i> Products
                                <i class="fas fa-chevron-right"></i>
                            </a>
                            <ul class="submenu">
                                <li><a class="nav-link" href="{{ route('admin.products.index') }}">All Products</a></li>
                                <li><a class="nav-link" href="{{ route('admin.products.create') }}">Add New Product</a></li>
                                <li><a class="nav-link" href="{{ route('admin.categories.index') }}">Categories</a></li>
                            </ul>
                        </li>
                        
                        <!-- Orders dropdown -->
                        <li class="nav-item">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-shopping-cart menu-icon"></i> Orders
                                <i class="fas fa-chevron-right"></i>
                            </a>
                            <ul class="submenu">
                                <li><a class="nav-link" href="{{ route('admin.orders.index') }}">All Orders</a></li>
                            </ul>
                        </li>
                        
                        <!-- Users dropdown -->
                        <li class="nav-item">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-users menu-icon"></i> Users
                                <i class="fas fa-chevron-right"></i>
                            </a>
                            <ul class="submenu">
                                <li><a class="nav-link" href="{{ route('admin.all_user_dashboard') }}">All Users</a></li>
                                <li><a class="nav-link" href="{{ route('admin.users.create') }}">Add New User</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.testimonials.pending') ? 'active' : '' }}" href="{{ route('admin.testimonials.pending') }}">
                            <i class="fas fa-comments menu-icon"></i> Pending Testimonials
                        </a>
                    </li>
                            <li class="nav-item mt-4">
                            <a class="nav-link" href="{{ route('home') }}">
                                <i class="fas fa-home menu-icon"></i> Back to Site
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- User info section -->
                <div class="user-info">
                    <div class="user-info-dropdown">
                        <span>{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <ul class="user-menu">
                        <li><a class="nav-link" href="{{ route('home') }}">Back to Site</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 main-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle dropdown toggles
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const submenu = this.nextElementSibling;
                    submenu.classList.toggle('show');
                    
                    // Toggle chevron icon direction
                    const chevron = this.querySelector('.fa-chevron-right');
                    if (chevron) {
                        if (submenu.classList.contains('show')) {
                            chevron.classList.replace('fa-chevron-right', 'fa-chevron-down');
                        } else {
                            chevron.classList.replace('fa-chevron-down', 'fa-chevron-right');
                        }
                    }
                });
            });
            
            // Handle mobile sidebar toggle
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    mainContent.classList.toggle('sidebar-open');
                });
            }
            
            // User menu toggle
            const userInfoDropdown = document.querySelector('.user-info-dropdown');
            const userMenu = document.querySelector('.user-menu');
            
            if (userInfoDropdown && userMenu) {
                userInfoDropdown.addEventListener('click', function() {
                    userMenu.classList.toggle('show');
                    const chevron = this.querySelector('.fa-chevron-down');
                    if (chevron) {
                        if (userMenu.classList.contains('show')) {
                            chevron.classList.replace('fa-chevron-down', 'fa-chevron-up');
                        } else {
                            chevron.classList.replace('fa-chevron-up', 'fa-chevron-down');
                        }
                    }
                });
            }
            
            // Mark active parent items
            const currentPath = window.location.pathname;
            document.querySelectorAll('.submenu .nav-link').forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    const parentDropdown = link.closest('.nav-item').querySelector('.dropdown-toggle');
                    if (parentDropdown) {
                        parentDropdown.classList.add('active');
                        link.closest('.submenu').classList.add('show');
                    }
                }
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>