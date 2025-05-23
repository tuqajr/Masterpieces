<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Tatreez Traditions</title>

    <link rel="stylesheet" href="css/navbar-footer.css">

    <link href="https://fonts.googleapis.com/css2?family=Orpheus+Pro&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alkalami&family=Badeen+Display&family=Handjet:wght@100..900&family=Reem+Kufi+Fun:wght@400..700&family=Reem+Kufi:wght@400..700&family=Ruwudu:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
 

    .hero-section {
        position: relative;
        background: url("{{ asset('images/tatreez-banner.jpg') }}") no-repeat center center;
        background-size: cover;
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
    }

    .hero-section::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.7);
    }

    .hero-content {
        position: relative;
        z-index: 1;
        max-width: 800px;
        padding: 0 20px;
    }

    .hero-content h1 {
        font-size: 36px;
        margin-bottom: 15px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        color: rgb(145, 51, 51);

    }

    .hero-content p {
        font-size: 18px;
        margin-bottom: 20px;
        color: rgb(145, 51, 51);
    }

    .welcome-message {
        text-align: center;
        color: rgb(145, 51, 51);
        padding: 50px 30px;
        max-width: 800px;
        margin: 0 auto;
        border-bottom: 1px solid rgba(145, 51, 51, 0.2);
    }

    .welcome-message h2 {
        font-size: 28px;
        margin-bottom: 15px;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
    }

    .welcome-message p {
        font-size: 18px;
        line-height: 1.8;
    }

    .about-us {
        padding: 60px 20px;
        text-align: center;
        background-color: rgba(255, 255, 255, 0.7);
    }

    .about-us h2 {
        font-size: 35px;
        margin-bottom: 40px;
        color: rgb(145, 51, 51);
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        position: relative;
    }

    .about-us h2::after {
        content: "";
        display: block;
        width: 80px;
        height: 3px;
        background-color: rgb(145, 51, 51);
        margin: 15px auto 0;
    }

    .about-us-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
        margin-bottom: 50px;
    }

    .about-us-item {
        flex: 1 1 280px;
        max-width: 300px;
        padding: 25px 15px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border-radius: 8px;
        background-color: white;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .about-us-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .about-us-icon {
        width: 60px;
        height: 60px;
        margin-bottom: 15px;
        object-fit: contain;
    }

    .about-us-item h3 {
        font-size: 22px;
        color: rgb(145, 51, 51);
        margin-bottom: 15px;
    }

    .about-us-item p {
        font-size: 16px;
        color: #333;
        line-height: 1.6;
    }

    .founder-section {
        background-color: #f1f1f1;
        padding: 60px 20px;
    }

    .founder-container {
        display: flex;
        flex-wrap: wrap;
        max-width: 1000px;
        margin: 0 auto;
        align-items: center;
        gap: 40px;
    }

    .founder-image {
        flex: 1 1 300px;
        text-align: center;
    }

    .founder-image img {
        width: 100%;
        max-width: 300px;
        border-radius: 50%;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .founder-text {
        flex: 1 1 500px;
        padding: 20px;
    }

    .founder-text h2 {
        color: rgb(145, 51, 51);
        font-size: 32px;
        margin-bottom: 20px;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
    }

    .founder-text p {
        font-size: 17px;
        line-height: 1.8;
        margin-bottom: 15px;
        color: #333;
    }

    .timeline-section {
        padding: 60px 20px;
        background-color: white;
    }

    .timeline-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .timeline-header h2 {
        font-size: 32px;
        color: rgb(145, 51, 51);
        text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        position: relative;
    }

    .timeline-header h2::after {
        content: "";
        display: block;
        width: 80px;
        height: 3px;
        background-color: rgb(145, 51, 51);
        margin: 15px auto 0;
    }

    .timeline {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
    }

    .timeline::before {
        content: '';
        position: absolute;
        height: 100%;
        width: 3px;
        background-color: rgb(145, 51, 51);
        left: 50%;
        transform: translateX(-50%);
    }

    .milestone {
        padding: 20px;
        width: calc(50% - 40px);
        position: relative;
        margin-bottom: 30px;
    }

    .milestone:nth-child(odd) {
        left: 0;
    }

    .milestone:nth-child(even) {
        left: 50%;
    }

    .milestone::before {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: rgb(145, 51, 51);
        top: 20px;
    }

    .milestone:nth-child(odd)::before {
        right: -50px;
    }

    .milestone:nth-child(even)::before {
        left: -50px;
    }

    .milestone-content {
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    .milestone-year {
        font-weight: bold;
        color: rgb(145, 51, 51);
        font-size: 22px;
        margin-bottom: 10px;
    }

  

    .inspiration-section {
        background-color: rgb(145, 51, 51);
        padding: 50px 20px;
        color: #fff;
        text-align: center;
    }

    .inspiration-content {
        max-width: 800px;
        margin: 0 auto;
    }

    .inspiration-heading {
        font-size: 26px;
        margin-bottom: 20px;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    }

    .inspiration-text,
    .inspiration-question {
        font-size: 17px;
        line-height: 1.7;
        margin-bottom: 20px;
    }

    .contact-button {
        background-color: #fff;
        color: rgb(145, 51, 51);
        padding: 12px 25px;
        font-weight: bold;
        border-radius: 5px;
        display: inline-block;
        transition: 0.3s;
        text-decoration: none;
        margin-top: 15px;
        font-size: 16px;
    }

    .contact-button:hover {
        background-color: #d9534f;
        color: white;
        transform: translateY(-3px);
    }

    footer {
        background-color: rgb(145, 51, 51);
        color: white;
        text-align: center;
        padding: 20px;
        font-size: 14px;
    }

    .social-links {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .social-links a {
        color: white;
        font-size: 20px;
        transition: transform 0.3s ease;
    }

    .social-links a:hover {
        transform: translateY(-3px);
    }

    .login-register-dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-toggle {
        color: white;
        text-decoration: none;
        cursor: pointer;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        right: 0;
        border-radius: 5px;
        overflow: hidden;
    }

    .dropdown-content a {
        color: rgb(145, 51, 51);
        padding: 8px 16px;
        text-decoration: none;
        display: block;
        font-size: 14px;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    .login-register-dropdown:hover .dropdown-content {
        display: block;
    }

    .cart-icon {
        color: white;
        position: relative;
        display: inline-block;
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

    .menu-toggle {
        display: none;
        background-color: transparent;
        color: white;
        border: none;
        font-size: 26px;
        cursor: pointer;
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
    }
    @media (max-width: 768px) {

        .hero-content h1 {
            font-size: 28px;
        }

        .timeline::before {
            left: 20px;
        }

        .milestone {
            width: calc(100% - 50px);
            left: 40px !important;
        }

        .milestone::before {
            left: -30px !important;
        }

        .founder-container {
            flex-direction: column;
        }

        .founder-image {
            margin-bottom: 20px;
        }

        .founder-text {
            text-align: center;
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
    
    <section class="hero-section">
        <div class="hero-content">
            <h1>Our Story</h1>
        </div>
    </section>

    <section class="welcome-message">
        <h2>Welcome to Tatreez Traditions</h2>
        <p>Established in 2025, we are dedicated to preserving and promoting the rich cultural heritage of Palestinian embroidery. Through education, community engagement, and high-quality products, we aim to ensure this beautiful art form continues to flourish for generations to come.</p>
    </section>

    <section class="about-us">
        <h2>Our Philosophy</h2>
        <div class="about-us-row">
            <div class="about-us-item">
                <img src="{{ asset('images/icon.png') }}" alt="Mission Icon" class="about-us-icon">
                <h3>Our Mission</h3>
                <p>To preserve and promote Palestinian embroidery by empowering individuals through education and authentic resources, reconnecting them with their cultural roots and heritage.</p>
            </div>
            <div class="about-us-item">
                <img src="{{ asset('images/icon.png') }}" alt="Vision Icon" class="about-us-icon">
                <h3>Our Vision</h3>
                <p>A world where Palestinian cultural heritage is celebrated globally, where Tatreez is recognized as a significant art form, and where traditions are preserved while evolving with modern times.</p>
            </div>
            <div class="about-us-item">
                <img src="{{ asset('images/icon.png') }}" alt="Values Icon" class="about-us-icon">
                <h3>Our Values</h3>
                <p>We are guided by authenticity, creativity, cultural respect, community empowerment, and sustainability in all our efforts to preserve and share Palestinian embroidery traditions.</p>
            </div>
        </div>
    </section>

    <section class="founder-section">
        <div class="founder-container">
            <div class="founder-image">
                <img src="{{ asset('images/girl.jpeg') }}" alt="Founder of Tatreez Traditions">
            </div>
            <div class="founder-text">
                <h2>Our Founder's Story</h2>
                <p>Born from a deep passion for Palestinian heritage, Tatreez Traditions was founded by Tuqa Jaradat, whose grandmother first taught her the art of embroidery at the age of seven.</p>
                <p>After years of studying traditional techniques and patterns from various Palestinian regions, Tuqa established this platform to share her knowledge and create a community dedicated to preserving this cultural treasure.</p>
                <p>"I believe that every stitch tells a story of resilience, identity, and artistic excellence. My goal is to ensure these stories continue to be told through generations, connecting the past with the future."</p>
            </div>
        </div>
    </section>

    <section class="timeline-section">
        <div class="timeline-header">
            <h2>Our Journey</h2>
        </div>
        <div class="timeline">
            <div class="milestone">
                <div class="milestone-content">
                    <div class="milestone-year">2025</div>
                    <p>Tatreez Traditions was founded with a vision to preserve Palestinian embroidery culture.</p>
                </div>
            </div>
            <div class="milestone">
                <div class="milestone-content">
                    <div class="milestone-year">2025</div>
                    <p>Launched our first collection of authentic Tatreez products,educational materials and custom orders.</p>
                </div>
            </div>
            <div class="milestone">
                <div class="milestone-content">
                    <div class="milestone-year">2025</div>
                    <p>Established partnerships with artisans across Palestinian communities.</p>
                </div>
            </div>
            <div class="milestone">
                <div class="milestone-content">
                    <div class="milestone-year">Futuer</div>
                    <p>Create our comprehensive online learning platform for embroidery enthusiasts worldwide.</p>
                </div>
            </div>
        </div>
    </section>


    <section class="inspiration-section">
        <div class="inspiration-content">
            <h2 class="inspiration-heading">INSPIRED BY YOU</h2>
            <p class="inspiration-text">
                You, our vibrant community of makers, learners, and culture keepers, inspire everything we do. Together, we're ensuring that the art of Tatreez continues to flourish.
            </p>
            <div class="inspiration-cta">
                <p class="inspiration-question">
                    Is there a learning guide you'd like to see? Do you have a story to share about your Tatreez journey?
                </p>
                <a href="{{ url('/contact') }}" class="contact-button">Connect With Us</a>
            </div>
        </div>
    </section>

    <footer>
        <div class="social-links">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
            <a href="#"><i class="fab fa-pinterest"></i></a>
        </div>
        <p>&copy; 2025 Tatreez Traditions. All rights reserved.</p>
    </footer>

    <script>

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
    </script>
        <script src="js/navbar-footer.js"></script>

</body>
</html>