"use strict"


//timeout for alert
setTimeout(function () {
    let alertElement = document.querySelector('.alertDelete');
    if (alertElement) {
        alertElement.classList.remove('show'); // Hide it
        alertElement.classList.add('fade'); // Add fade effect
        setTimeout(() => {
            alertElement.remove(); // Remove it from the DOM completely
        }, 500); // Allow some time for fade-out animation before removal (300ms)
    }
}, 3000); // Trigger the hiding process after 3 seconds

  
//edit form for users 
document.addEventListener('click', function (e) {
    // Check if the clicked element has the class "edit-user-link"
    if (e.target.classList.contains('edit-user-link')) {
        e.preventDefault();

        // Get the user ID from the data-id attribute
        var userId = e.target.getAttribute('data-id');

        // Make an AJAX request to fetch the modal content
        fetch('/admin/users/' + userId + '/edit', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(function (response) {
            if (!response.ok) {
                throw new Error('Failed to fetch modal content.');
            }
            return response.json();
        })
        .then(function (data) {
            // Inject the modal content into the container
            var modalContainer = document.getElementById('ajaxEditModalContainer');
            modalContainer.innerHTML = data.html;

            // Show the modal using Bootstrap's modal API
            var editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
            editModal.show();
        })
        .catch(function (error) {
            console.error('Error fetching modal content:', error);
        });
    }
});

//edit form for coupons
document.addEventListener('click', function (e) {
    // Check if the clicked element has the class "edit-coupon-link"
    if (e.target.classList.contains('edit-coupon-link')) {
        e.preventDefault();

        // Get the coupon ID from the data-id attribute
        var couponId = e.target.getAttribute('data-id');

        // Make an AJAX request to fetch the modal content
        fetch('/admin/coupons/' + couponId + '/edit', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(function (response) {
            if (!response.ok) {
                throw new Error('Failed to fetch modal content.');
            }
            return response.json();
        })
        .then(function (data) {
            // Inject the modal content into the container
            var modalContainer = document.getElementById('ajaxEditModalCoupon');
            modalContainer.innerHTML = data.html;

            // Show the modal using Bootstrap's modal API
            var editModal = new bootstrap.Modal(document.getElementById('editCouponModal'));
            editModal.show();
        })
        .catch(function (error) {
            console.error('Error fetching modal content:', error);
        });
    }
});

//edit form for hotels
document.addEventListener('click', function (e) {
    // Check if the clicked element has the class "edit-hotel-link"
    if (e.target.classList.contains('edit-hotel-link')) {
        e.preventDefault();

        // Get the hotel ID from the data-id attribute
        var hotelId = e.target.getAttribute('data-id');

        // Make an AJAX request to fetch the modal content
        fetch('/admin/hotels/' + hotelId + '/edit', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(function (response) {
            if (!response.ok) {
                throw new Error('Failed to fetch modal content.');
            }
            return response.json();
        })
        .then(function (data) {
            // Inject the modal content into the container
            var modalContainer = document.getElementById('ajaxEditModalHotel');
            modalContainer.innerHTML = data.html;

            // Show the modal using Bootstrap's modal API
            var editModal = new bootstrap.Modal(document.getElementById('editHotelModal'));
            editModal.show();
        })
        .catch(function (error) {
            console.error('Error fetching modal content:', error);
        });
    }
});

//edit form for rooms
document.addEventListener('click', function (e) {
    // Check if the clicked element has the class "edit-room-link"
    if (e.target.classList.contains('edit-room-link')) {
        e.preventDefault();

        // Get the room ID from the data-id attribute
        var roomId = e.target.getAttribute('data-id');

        // Make an AJAX request to fetch the modal content
        fetch('/admin/rooms/' + roomId + '/edit', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(function (response) {
            if (!response.ok) {
                throw new Error('Failed to fetch modal content.');
            }
            return response.json();
        })
        .then(function (data) {
            // Inject the modal content into the container
            var modalContainer = document.getElementById('ajaxEditModalRoom');
            modalContainer.innerHTML = data.html;

            // Show the modal using Bootstrap's modal API
            var editModal = new bootstrap.Modal(document.getElementById('editRoomModal'));
            editModal.show();
        })
        .catch(function (error) {
            console.error('Error fetching modal content:', error);
        });
    }
});

//edit form for bookings
document.addEventListener('click', function (e) {
    // Check if the clicked element has the class "edit-room-link"
    if (e.target.classList.contains('edit-booking-link')) {
        e.preventDefault();

        // Get the room ID from the data-id attribute
        var bookingId = e.target.getAttribute('data-id');

        // Make an AJAX request to fetch the modal content
        fetch('/admin/bookings/' + bookingId + '/edit', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(function (response) {
            if (!response.ok) {
                throw new Error('Failed to fetch modal content.');
            }
            return response.json();
        })
        .then(function (data) {
            // Inject the modal content into the container
            var modalContainer = document.getElementById('ajaxEditModalBooking');
            modalContainer.innerHTML = data.html;

            // Show the modal using Bootstrap's modal API
            var editModal = new bootstrap.Modal(document.getElementById('editBookingModal'));
            editModal.show();
        })
        .catch(function (error) {
            console.error('Error fetching modal content:', error);
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const spinner = document.getElementById('spinner');
    const userTable = document.getElementById('userTable');

    // Simulate initial loading (set timeout if needed for slower data loading)
    setTimeout(function () {
        spinner.style.display = 'none'; // Hide spinner
        userTable.style.display = 'block'; // Show table
    }, 1500); // Adjust the timeout duration as needed
    
});


document.addEventListener('click', function (e) {
    // Handle Pagination Links
    const isPaginationLink = e.target.tagName === 'A' && e.target.closest('#paginationLinks');

    if (isPaginationLink) {
        e.preventDefault(); // Prevent default page reload

        const url = e.target.href; // Extract the URL

        const spinner = document.getElementById('spinner');
        const userTable = document.getElementById('userTable');

        // Show spinner and hide table while fetching data
        spinner.style.display = 'block';
        userTable.style.display = 'none';

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => {
                if (!response.ok) throw new Error('Failed to fetch data');
                return response.text();
            })
            .then(html => {
                userTable.innerHTML = html; // Replace table content

                setTimeout(function () {
                    spinner.style.display = 'none'; // Hide spinner
                    userTable.style.display = 'block'; // Show table
                }, 1500);
            })
            .catch(error => {
                spinner.style.display = 'none'; // Hide spinner if error occurs
                userTable.style.display = 'block'; // Ensure table is displayed
                console.error(error); // Log error for debugging
            });
    }
});

document.addEventListener('click', function (e) {
    // Check if the clicked element is a delete button
    if (e.target.classList.contains('delete-action')) {
        e.preventDefault();

        // Get the `data-id` and `data-type` attributes from the clicked button
        const entityId = e.target.getAttribute('data-id');
        const entityType = e.target.getAttribute('data-type'); // Example: "bookings", "users"
        console.log(entityId, entityType);
        
        // Build the form's action URL dynamically
        const deleteForm = document.getElementById('deleteForm'); // The ID for the shared delete form
        deleteForm.setAttribute('action', `/admin/${entityType}/${entityId}`);

        // Show the modal
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }
});

document.addEventListener('click', function (e) {
    const button = e.target.closest('.approve-action, .reject-action'); // Detect if "Approve" or "Reject" button is clicked
    if (button) {
        e.preventDefault();

        // Get the necessary data attributes
        const actionType = button.dataset.info; // 'approve' or 'reject'
        const reviewId = button.dataset.id;

        // Update the modal message and submit button
        const modalMessage = document.getElementById('modalMessage');
        const modalSubmitButton = document.getElementById('modalSubmitButton');
        const buttonText = document.getElementById('buttonText'); // Optional: if you want to change the button text
        if (actionType === 'approve') {
            modalMessage.textContent = "Are you sure you want to approve this review?";
            buttonText.textContent = "Approve";
            modalSubmitButton.classList.remove('btn-danger');
            modalSubmitButton.classList.add('btn-primary');
        } else if (actionType === 'reject') {
            modalMessage.textContent = "Are you sure you want to reject this review?";
            buttonText.textContent = "Reject";
            modalSubmitButton.classList.remove('btn-primary');
            modalSubmitButton.classList.add('btn-danger');
        }

        // Update the form's action dynamically
        const form = document.getElementById('actionForm');
        form.setAttribute('action', `/admin/reviews/${reviewId}/${actionType}`);
        document.getElementById('modalActionType').value = actionType; // Set hidden input value
    }
});
// <!-- Sidebar Toggle Script -->

document.addEventListener('DOMContentLoaded', function() {
    const sidebarCollapse = document.getElementById('sidebarCollapse');
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    
    sidebarCollapse.addEventListener('click', function() {
        sidebar.classList.toggle('active');
        if (sidebar.classList.contains('active')) {
            content.style.marginLeft = '280px';
            content.style.width = 'calc(100% - 280px)';
        } else {
            content.style.marginLeft = '0';
            content.style.width = '100%';
        }
    });
    
    // Check window size on load and resize
    function checkSize() {
        if (window.innerWidth <= 768) {
            sidebar.classList.remove('active');
            content.style.marginLeft = '0';
            content.style.width = '100%';
        } else {
            sidebar.classList.add('active');
            content.style.marginLeft = '280px';
            content.style.width = 'calc(100% - 280px)';
        }
    }
    
    // Initial check
    checkSize();
    
    // Listen for window resize
    window.addEventListener('resize', checkSize);
    
    // Make sure all tables are wrapped in table-responsive
    document.querySelectorAll('table').forEach(function(table) {
        if (!table.parentElement.classList.contains('table-responsive')) {
            const wrapper = document.createElement('div');
            wrapper.classList.add('table-responsive');
            table.parentNode.insertBefore(wrapper, table);
            wrapper.appendChild(table);
        }
    });
});