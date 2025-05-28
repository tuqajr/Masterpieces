@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-title">Orders Management</h1>
                <p class="text-muted">Manage customer orders and track delivery status</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="preparing" {{ request('status') === 'preparing' ? 'selected' : '' }}>Preparing</option>
                        <option value="out_for_delivery" {{ request('status') === 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                        <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Search by order number or customer..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card">
        <div class="card-body">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Order #</th>
                                <th>Customer Name</th>
                                <th>Customer Phone</th>
                                <th>Items</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Payment Method</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>
                                    <strong>
                                        #{{ $order->order_number ?? $order->id }}
                                    </strong>
                                </td>
                                <td>
                                    <strong>
                                        {{ $order->user->name ?? $order->customer_name ?? '-' }}
                                    </strong>
                                </td>
                                <td>
                                    {{ $order->user->phone ?? $order->phone ?? '-' }}
                                </td>
                                <td>
                                    {{ $order->orderItems->sum('quantity') }}
                                </td>
                                <td>
                                    <strong>
                                        ${{ number_format($order->total ?? $order->orderItems->sum(fn($item) => ($item->subtotal ?? $item->product_price * $item->quantity)), 2) }}
                                    </strong>
                                </td>
                                <td>
                                    <span class="badge status-badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'primary') }}">
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ ucfirst($order->payment_method ?? 'Cash on Delivery') }}</strong>
                                </td>
                                <td>
                                    <div>
                                        {{ $order->created_at->format('M d, Y') }}<br>
                                        <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm mb-2">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Delete" onclick="deleteOrder('{{ $order->id }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                     <select class="form-select form-select-sm status-select d-inline-block mt-2" style="width:auto;" data-order-id="{{ $order->id }}">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Preparing</option>
                                        <option value="out_for_delivery" {{ $order->status === 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h4>No Orders Found</h4>
                    <p class="text-muted">No orders match your current filters.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.page-header { margin-bottom: 2rem; }
.page-title { font-size: 1.75rem; font-weight: 600; color: #333; }
.status-select { min-width: 120px; }
.table th { font-weight: 600; color: #495057; border-top: none; }
.btn-group-sm .btn { padding: 0.25rem 0.5rem; }
.badge { font-size: 0.75rem; }
.status-badge { transition: background 0.3s, color 0.3s; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle status updates
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            const orderId = this.dataset.orderId;
            const newStatus = this.value;
            const row = this.closest('tr');
            const badge = row.querySelector('.status-badge');
            fetch(`/admin/orders/${orderId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the badge text and color instantly
                    badge.textContent = capitalizeStatus(data.status);
                    badge.className = 'badge status-badge ' + getBadgeClass(data.status);
                    showAlert('Order status updated successfully', 'success');
                } else {
                    this.value = this.dataset.originalValue;
                    showAlert('Failed to update order status', 'error');
                }
            })
            .catch(() => {
                this.value = this.dataset.originalValue;
                showAlert('An error occurred while updating order status', 'error');
            });
        });
        select.dataset.originalValue = select.value;
    });
});

// Helper functions for badge status
function capitalizeStatus(status) {
    return status.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
}
function getBadgeClass(status) {
    switch(status) {
        case 'delivered':
            return 'bg-success';
        case 'cancelled':
            return 'bg-danger';
        default:
            return 'bg-primary';
    }
}

// Delete order function
function deleteOrder(orderId) {
    if(confirm('Are you sure you want to delete this order?')) {
        fetch(`/admin/orders/${orderId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success){
                showAlert('Order deleted successfully', 'success');
                setTimeout(()=>location.reload(), 1000);
            } else {
                showAlert('Failed to delete order', 'error');
            }
        })
        .catch(() => {
            showAlert('An error occurred while deleting order', 'error');
        });
    }
}

function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.page-header'));
    setTimeout(() => { alertDiv.remove(); }, 5000);
}
</script>
@endsection