document.addEventListener('DOMContentLoaded', function() {
    // Set current year
    const currentYearElement = document.getElementById('current-year');
    if (currentYearElement) {
        currentYearElement.textContent = new Date().getFullYear();
    }
    
    // Check login status
    checkLoginStatus();
    
    // Update cart count
    updateCartCount();
    
    // Setup mobile menu
    setupMobileMenu();
    
    // Scroll to top button
    setupScrollToTop();
    
    // Header scroll effect
    setupHeaderScroll();
});

function checkLoginStatus() {
    const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
    const userName = localStorage.getItem('userName');
    const isAdmin = localStorage.getItem('isAdmin') === 'true';
    
    const welcomeMessage = document.getElementById('welcome-message');
    const loggedInItems = document.querySelectorAll('.logged-in-item');
    const loggedOutItems = document.querySelectorAll('.logged-out-item');
    
    if (isLoggedIn && userName) {
        if (welcomeMessage) {
            welcomeMessage.textContent = 'Welcome, ' + userName;
        }
        
        loggedInItems.forEach(item => {
            item.style.display = 'block';
        });
        
        loggedOutItems.forEach(item => {
            item.style.display = 'none';
        });
        
        if (isAdmin) {
            const dashboardLink = document.querySelector('.logged-in-item[href="dashboard.html"]');
            if (dashboardLink) {
                dashboardLink.href = 'admin/dashboard.html';
                dashboardLink.textContent = 'Admin Dashboard';
            }
        }
    } else {
        if (welcomeMessage) {
            welcomeMessage.textContent = 'User';
        }
        
        loggedOutItems.forEach(item => {
            item.style.display = 'block';
        });
        
        loggedInItems.forEach(item => {
            item.style.display = 'none';
        });
    }
    
    const logoutBtn = document.getElementById('logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function() {
            localStorage.removeItem('isLoggedIn');
            localStorage.removeItem('userName');
            localStorage.removeItem('isAdmin');
            window.location.reload();
        });
    }
}

function updateCartCount() {
    const cartCountElement = document.getElementById('cart-count');
    if (cartCountElement) {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        cartCountElement.textContent = cart.length;
    }
}

function setupMobileMenu() {
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.getElementById('navMenu');
    
    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            navMenu.classList.toggle('show');
            menuToggle.classList.toggle('active');
        });
        
        // Close menu when clicking on a link
        navMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('show');
                menuToggle.classList.remove('active');
            });
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!navMenu.contains(e.target)) {
                navMenu.classList.remove('show');
                menuToggle.classList.remove('active');
            }
        });
    }
}

function setupScrollToTop() {
    const topBtn = document.getElementById('topBtn');
    if (topBtn) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                topBtn.classList.add('show');
            } else {
                topBtn.classList.remove('show');
            }
        });
        
        topBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
}

function setupHeaderScroll() {
    const header = document.querySelector('header');
    if (header) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    }
}