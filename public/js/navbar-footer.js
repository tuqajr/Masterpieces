document.addEventListener('DOMContentLoaded', function() {
    const currentYearElement = document.getElementById('current-year');
    if (currentYearElement) {
        currentYearElement.textContent = new Date().getFullYear();
    }
    
    checkLoginStatus();
    
    updateCartCount();
    
    setupMobileMenu();
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
}