<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us - Tatreez Traditions</title>
    
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

        /* Contact Content */
        .contact-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(500px, 1fr));
            gap: 30px;
        }

        .contact-info, .contact-form {
            background-color: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .contact-info:hover, .contact-form:hover {
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

        /* Contact Info */
        .info-content {
            padding: 20px;
        }

        .info-item {
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .info-item i {
            color: #9b3737;
            font-size: 24px;
            min-width: 30px;
            text-align: center;
        }

        .info-item-details h4 {
            margin: 0;
            font-size: 18px;
            color: #333;
            font-family: 'Reem Kufi', sans-serif;
        }

        .info-item-details p {
            margin: 5px 0 0;
            font-size: 16px;
            color: #666;
        }

        /* Contact Form */
        form {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            color: #333;
            font-family: 'Reem Kufi', sans-serif;
        }

        input,
        textarea {
            display: block;
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: #9b3737;
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        button {
            display: block;
            width: 100%;
            padding: 14px;
            background-color: #9b3737;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-family: 'Reem Kufi', sans-serif;
        }

        button:hover {
            background-color: #b14545;
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
        }

        #loading {
            display: none;
            text-align: center;
            margin-top: 20px;
            color: #9b3737;
            font-weight: 500;
        }

        #feedback {
            display: none;
            color: #28a745;
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background-color: rgba(40, 167, 69, 0.1);
            border-radius: 4px;
            font-weight: 500;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .contact-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .section-title {
                font-size: 18px;
            }
            
            .info-item i {
                font-size: 20px;
            }
            
            .info-item-details h4 {
                font-size: 16px;
            }
            
            .info-item-details p {
                font-size: 14px;
            }
        }
        
        /* Footer Styles */
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
        }

        .footer-section p {
            color: white;
            margin-bottom: 12px;
            font-size: 16px;
        }

        .footer-section ul {
            list-style: none;
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
            border-top: 1px solid #ddd;
            margin-top: 20px;
        }

        .footer-bottom p {
            color: #fff;
        }

        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
            }
            
            .footer-section {
                margin-bottom: 30px;
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
                <div class="login-register-dropdown">
                @if(Auth::check())
                    <a href="#" class="dropdown-toggle">
                        <span style="margin-right: 5px;">Welcome,</span>
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                    <div class="dropdown-content">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </div>
                @else
                <a href="#" class="dropdown-toggle">User</a>
                <div class="dropdown-content">
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                </div>
                @endif
            </div>
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

    <div class="contact-container">
        <!-- Contact Info Section -->
        <div class="contact-info">
            <div class="section-title">
                <i class="fas fa-map-marked-alt"></i>
                Contact Information
            </div>
            <div class="info-content">
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="info-item-details">
                        <h4>Our Location</h4>
                        <p>123 Embroidery Street, Artisan District, Amman, Jordan</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-phone-alt"></i>
                    <div class="info-item-details">
                        <h4>Phone</h4>
                        <p>+123 456 789</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <div class="info-item-details">
                        <h4>Email</h4>
                        <p>info@tatreez.com</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-clock"></i>
                    <div class="info-item-details">
                        <h4>Business Hours</h4>
                        <p>Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday: 10:00 AM - 4:00 PM</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Contact Form Section -->
        <div class="contact-form">
            <div class="section-title">
                <i class="fas fa-paper-plane"></i>
                Send Us a Message
            </div>
            <form id="contactForm">
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" placeholder="Enter subject" required>
                </div>
                
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" placeholder="Type your message here..." required></textarea>
                </div>
                
                <button type="submit">
                    <i class="fas fa-paper-plane"></i> Send Message
                </button>
                <div id="loading">Sending your message...</div>
                <div id="feedback">Your message has been sent successfully! We'll get back to you soon.</div>
            </form>
        </div>
    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    
        
    
            // Email sending functionality
            emailjs.init('ocAT76gWIBqPj_Mx2');  
            
            $("#contactForm").submit(function (event) {
                event.preventDefault();
                $("#loading").show();  

                let name = $("#name").val().trim();
                let email = $("#email").val().trim();
                let subject = $("#subject").val().trim();
                let message = $("#message").val().trim();

                if (!name || !email || !subject || !message) {
                    alert("All fields are required!");
                    $("#loading").hide();
                    return;
                }

                let params = {
                    name: name,
                    email: email,
                    subject: subject,
                    message: message
                };

                emailjs.send('service_e8cg9vn', 'template_8ghikqm', params)
                    .then(() => {
                        $("#feedback").show();
                        $("#loading").hide();
                        $("#contactForm")[0].reset();
                        
                        // Hide the feedback message after 5 seconds
                        setTimeout(function() {
                            $("#feedback").fadeOut();
                        }, 5000);
                    })
                    .catch((error) => {
                        alert("Failed to send email. Please try again later.");
                        console.error("FAILED...", error);
                        $("#loading").hide();
                    });
            });
        });
    </script>
    <script src="js/navbar-footer.js"></script>
  </body>
</html>