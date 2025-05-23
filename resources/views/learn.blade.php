<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Learn Tatreez - Traditional Palestinian Embroidery</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="css/navbar-footer.css">

    <link href="https://fonts.googleapis.com/css2?family=Orpheus+Pro&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alkalami&family=Badeen+Display&family=Handjet:wght@100..900&family=Reem+Kufi+Fun:wght@400..700&family=Reem+Kufi:wght@400..700&family=Ruwudu:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        
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

        /* Navigation */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
            background-color: #9b3737;
            color: white;
            position: relative;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.2);
        }

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 30px;
            margin: 0;
            padding: 0;
        }

        .navbar ul li a {
            color: white;
            text-decoration: none;
            font-family: 'Reem Kufi', sans-serif;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .navbar ul li a:hover {
            color: #f0d0a0;

        }
        
        .navbar ul.show {
            display: flex;
            flex-direction: column;
            background-color: #9b3737;
            padding: 15px;
            position: absolute;
            top: 70px;
            right: 10px;
            border-radius: 10px;
            z-index: 1000;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }       

        .menu-toggle {
            display: none;
            font-size: 1.5rem;
            color: white;
            cursor: pointer;
        }

        .navbar .icons {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .cart-icon {
            position: relative;
            color: white;
            font-size: 1.2rem;
            text-decoration: none;
        }
        
        .cart-icon i {
            font-size: 22px;
        }
        
        #cart-count {
            position: absolute;
            top: -8px;
            right: -10px;
            background-color: #f0d0a0;
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

        /* User dropdown */
        .login-register-dropdown {
            position: relative;
            display: inline-block;
        }

        .login-register-dropdown .dropdown-toggle {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 8px 15px;
            background-color: rgba(155, 55, 55, 0.7);
            border-radius: 5px;
            font-family: 'Reem Kufi', sans-serif;
            display: flex;
            align-items: center;
            transition: background-color 0.3s ease;
        }
        
        .login-register-dropdown .dropdown-toggle:hover {
            background-color: rgba(155, 55, 55, 1);
        }

        .login-register-dropdown .dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 8px;
            top: 100%;
            right: 0;
            padding: 8px 0;
            min-width: 160px;
            margin-top: 5px;
        }

        .login-register-dropdown:hover .dropdown-content {
            display: block;
        }

        .login-register-dropdown .dropdown-content a {
            color: #9b3737;
            text-decoration: none;
            padding: 10px 16px;
            display: block;
            font-size: 15px;
            font-family: 'Reem Kufi', sans-serif;
            transition: background-color 0.3s ease;
        }

        .login-register-dropdown .dropdown-content a:hover {
            background-color: #f7e9e9;
        }
        
        .login-register-dropdown .dropdown-content button {
            border: none;
            background: none;
            padding: 10px 16px;
            font-size: 15px;
            color: #9b3737;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-family: 'Reem Kufi', sans-serif;
            transition: background-color 0.3s ease;
        }
        
        .login-register-dropdown .dropdown-content button:hover {
            background-color: #f7e9e9;
        }

        /* Logo */
        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-container img {
            height: 45px;
        }

        .logo-text {
            font-family: 'Reem Kufi Fun', sans-serif;
            font-size: 26px;
            color: white;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        }

        /* Learn Section */
        #learn {
            padding: 60px 40px;
            font-family: 'Orpheus Pro', serif;
            color: #333;
            text-align: center;
            max-width: 1200px;
            margin: 0 auto;
            margin-top: 40px; 
            padding-top: 30px; 
        }

        #learn h2 {
            color: #913333;
            margin-bottom: 40px;
            font-size: 38px;
            font-weight: 600;
            font-family: 'Reem Kufi', sans-serif;
            text-align: center;
            position: relative;
            padding-bottom: 15px;
        }
        
        #learn h2::after {
            content: "";
            position: absolute;
            width: 120px;
            height: 3px;
            background-color: #913333;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        #learn p {
            margin-bottom: 40px;
            line-height: 1.8;
            font-size: 19px;
            color: #555;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Fixed navbar positioning to prevent overlap */
        header {
            position: relative;
            z-index: 100;
        }

        /* Main content positioning */
        main {
            position: relative;
            z-index: 1;
        }

        .material {
            display: flex;
            flex-direction: row;
            gap: 40px;
            align-items: center;
            margin-bottom: 40px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            padding: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .material:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .material:nth-child(even) {
            flex-direction: row-reverse;
        }

        .material img {
            width: 280px;
            height: 280px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.12);
            object-fit: cover;
            margin: 0;
            transition: transform 0.3s ease;
        }
        
        .material:hover img {
            transform: scale(1.03);
        }

        .material-content {
            flex: 1;
            padding: 10px;
            text-align: left;
        }

        .material-content h3 {
            margin: 0 0 15px;
            color: #9b3737;
            font-size: 26px;
            font-family: 'Reem Kufi', sans-serif;
            position: relative;
            padding-bottom: 10px;
        }
        
        .material-content h3::after {
            content: "";
            position: absolute;
            width: 60px;
            height: 2px;
            background-color: #9b3737;
            bottom: 0;
            left: 0;
        }

        .material-content p {
            margin-bottom: 15px;
            color: #555;
            line-height: 1.8;
            font-size: 17px;
            text-align: left;
        }

        .material-content ul {
            list-style: none;
            padding-left: 5px;
            margin: 0;
            font-size: 17px;
        }

        .material-content ul li {
            margin-bottom: 10px;
            position: relative;
            padding-left: 25px;
            color: #555;
        }
        
        .material-content ul li::before {
            content: "•";
            color: #9b3737;
            font-size: 20px;
            position: absolute;
            left: 0;
            top: -2px;
        }

        .material-content ul li strong {
            color: #9b3737;
            font-weight: 600;
        }

        /* Footer */
        footer {
            background-color: #913333;
            color: #fff;
            padding: 40px 0 20px;
            font-family: 'Reem Kufi', sans-serif;
        }
        
        .footer-container {
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .footer-links {
            display: flex;
            gap: 60px;
        }
        
        .links-column h4 {
            color: #f0d0a0;
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .links-column ul {
            list-style: none;
            padding: 0;
        }
        
        .links-column ul li {
            margin-bottom: 10px;
        }
        
        .links-column ul li a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .links-column ul li a:hover {
            color: #f0d0a0;
        }
        
        .footer-social {
            display: flex;
            gap: 15px;
        }
        
        .footer-social a {
            color: white;
            font-size: 20px;
            transition: color 0.3s ease;
        }
        
        .footer-social a:hover {
            color: #f0d0a0;
        }
        
        .footer-copy {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
        }

        /* Responsive styles */
        @media (max-width: 992px) {
            #learn {
                padding: 40px 20px;
                margin-top: 30px;
            }
            
            .material {
                padding: 25px;
            }
            
            .material img {
                width: 220px;
                height: 220px;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 15px 20px;
            }
            
            .menu-toggle {
                display: block;
            }

            .navbar ul {
                display: none;
                gap: 15px;
            }

            .navbar ul.show {
                display: flex;
            }

            .navbar .icons {
                gap: 15px;
            }
            
            .logo-text {
                font-size: 22px;
            }
            
            .logo-container img {
                height: 38px;
            }
            
            #learn {
                margin-top: 20px;
            }

            .material {
                flex-direction: column !important;
                gap: 25px;
                text-align: center;
                padding: 20px;
            }

            .material-content {
                text-align: center;
            }
            
            .material-content h3::after {
                left: 50%;
                transform: translateX(-50%);
            }
            
            .material-content p {
                text-align: center;
            }
            
            .material-content ul {
                display: inline-block;
                text-align: left;
            }

            .material img {
                width: 100%;
                max-width: 300px;
                height: auto;
                margin: auto;
            }

            footer .footer-container {
                flex-direction: column;
                gap: 30px;
                align-items: center;
                text-align: center;
            }
            
            .footer-links {
                flex-direction: column;
                gap: 20px;
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            #learn h2 {
                font-size: 28px;
            }
            
            .material {
                padding: 15px;
                margin-bottom: 30px;
            }
            
            .material-content h3 {
                font-size: 22px;
            }
            
            .material img {
                width: 100%;
            }
        }
    </style>
  </head>
  <body>
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
    <main>
        <section id="learn">
            <h2>Essential Materials for Tatreez Embroidery</h2>
            <p>Begin your journey into the beautiful art of Palestinian Tatreez with these quality materials and tools. Each item has been carefully selected to help you create authentic and stunning embroidery pieces.</p>
            
            <div class="material">
                <img src="{{ asset('images/aida.png') }}" alt="Cross-Stitch Fabric">
                <div class="material-content">
                    <h3>1. Cross-Stitch Fabric</h3>
                    <p>
                        The foundation of your Tatreez art begins with the right fabric. A good quality cross-stitch fabric provides the perfect grid for precise and beautiful stitching patterns.
                    </p>
                    <ul>
                        <li><strong>Waste Canvas:</strong> Ideal for embellishing clothing items. This temporary grid can be removed after your embroidery is complete.</li>
                        <li><strong>Aida Cloth:</strong> Perfect for wall hangings, decorative pieces, and sampler projects. Available in various counts to match your design complexity.</li>
                    </ul>
                </div>
            </div>
            
            <div class="material">
                <div class="material-content">
                    <h3>2. Embroidery Thread</h3>
                    <p>The vibrant colors and quality of your thread will bring your Tatreez designs to life. Choose from these popular options:</p>
                    <ul>
                        <li><strong>Pearl Cotton (Size 8):</strong> A smooth, lustrous thread with excellent durability. Ideal for creating detailed patterns with consistent texture and shine.</li>
                        <li><strong>Embroidery Floss (Size 25):</strong> Versatile and divisible into multiple strands, allowing you to adjust the thickness for different design elements and techniques.</li>
                    </ul>
                </div>
                <img src="{{ asset('images/theard.png') }}" alt="Embroidery Threads">
            </div>
            
            <div class="material">
                <img src="{{ asset('images/needle.png') }}" alt="Embroidery Needles">
                <div class="material-content">
                    <h3>3. Specialized Needles</h3>
                    <p>
                        The right needle makes all the difference in creating smooth, even stitches and protecting your fabric and thread from damage.
                    </p>
                    <ul>
                        <li><strong>Embroidery Needles:</strong> Feature sharp tips perfect for penetrating tightly woven fabrics. Available in sizes 1-5, with larger numbers for finer work and smaller numbers for heavier fabrics.</li>
                        <li><strong>Tapestry Needles:</strong> Have blunt tips that slide between the weave of evenweave fabrics like Aida cloth without splitting threads. Ideal for traditional sampler projects.</li>
                    </ul>
                </div>
            </div>
            
            <div class="material">
                <div class="material-content">
                    <h3>4. Essential Tools & Accessories</h3>
                    <p>These helpful tools will make your embroidery process smoother and more enjoyable:</p>
                    <ul>
                        <li><strong>Embroidery Scissors:</strong> Small, sharp scissors with fine points for precise cutting of threads.</li>
                        <li><strong>Tweezers:</strong> Helpful for manipulating small threads or fixing minor mistakes.</li>
                        <li><strong>Pins:</strong> Used to secure fabric in place while working.</li>
                        <li><strong>Sewing Thread:</strong> For attaching waste canvas to your base fabric.</li>
                        <li><strong>Embroidery Hoops:</strong> While optional for beginners, these help maintain even tension across your fabric.</li>
                    </ul>
                </div>
                <img src="{{ asset('images/DMC.png') }}" alt="Embroidery Tools">
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-links">
                <div class="links-column">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/shop') }}">Shop</a></li>
                        <li><a href="{{ url('/about') }}">About</a></li>
                        <li><a href="{{ url('/learn') }}">Learn</a></li>
                    </ul>
                </div>
                
                <div class="links-column">
                    <h4>Contact Us</h4>
                    <ul>
                        <li><a href="mailto:info@tatreez.com">info@tatreez.com</a></li>
                        <li><a href="tel:+123456789">+123 456 789</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-social">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-pinterest"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
        
        <p class="footer-copy">&copy; 2025 Tatreez Traditions. All rights reserved.</p>
    </footer>

    <script>
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

    
    // Mobile menu toggle functionality
   document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.querySelector('#navMenu');
    
    menuToggle.addEventListener('click', function() {
        navMenu.classList.toggle('show');
    });
    
    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.navbar') && navMenu.classList.contains('show')) {
            navMenu.classList.remove('show');
        }
    });
});
    
    // Quantity input handling for cart items
    const quantityInputs = document.querySelectorAll('.quantity-form input[name="quantity"]');
    if (quantityInputs) {
        quantityInputs.forEach(input => {
            input.addEventListener('change', function() {
                // Optional: Auto-submit the form when quantity changes
                // this.closest('form').submit();
            });
        });
    }
});
    </script>
    <script src="{{ asset('js/cart-count.js') }}"></script>
    <script src="js/navbar-footer.js"></script>

  </body>
</html>