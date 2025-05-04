<div class="container my-5">
    <div class="row g-5">
        <!-- Total Products -->
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-basket fs-1 text-primary"></i>
                    <h5 class="card-title mt-3">Total Products</h5>
                    <p class="card-text fs-4 fw-bold">{{ $totalProducts }}</p>
                    <small class="text-muted d-block">
                        <i class="bi bi-check-circle text-success"></i> Available: {{ $availableProducts }}
                    </small>
                    <small class="text-muted d-block">
                        <i class="bi bi-star text-warning"></i> Most Reviews: {{ $productWithMostReviews->name ?? 'N/A' }}
                    </small>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-people fs-1 text-secondary"></i>
                    <h5 class="card-title mt-3">Total Users</h5>
                    <p class="card-text fs-4 fw-bold">{{ $totalUsers }}</p>
                    <small class="text-muted d-block">
                        <i class="bi bi-person-badge text-info"></i> Admins: {{ $adminUsers }}
                    </small>
                    <small class="text-muted d-block">
                        <i class="bi bi-calendar-plus text-primary"></i> New This Month: {{ $newUsersThisMonth }}
                    </small>
                </div>
            </div>
        </div>


        <!-- Total Reviews -->
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-chat-square-dots fs-1 text-info"></i>
                    <h5 class="card-title mt-3">Total Reviews</h5>
                    <p class="card-text fs-4 fw-bold">{{ $totalReviews }}</p>
                    <small class="text-muted d-block">
                        <i class="bi bi-hourglass-bottom text-danger"></i> Pending Approval: {{ $pendingReviews }}
                    </small>
                </div>
            </div>
        </div>
        
    </div>
</div>
