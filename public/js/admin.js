// admin.js

// Show the table after loading
window.onload = function () {
    setTimeout(() => {
        document.getElementById('spinner').style.display = 'none';
        document.getElementById('userTable').style.display = 'block';
    }, 500);
};

// Close alert after 5 seconds
setTimeout(() => {
    const alert = document.querySelector('.alert');
    if (alert) {
        alert.style.display = 'none';
    }
}, 5000);
