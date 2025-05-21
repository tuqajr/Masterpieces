@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
                        <li class="breadcrumb-item active">Order #{{ $order->order_number }}</li>
                    </ol>
                </nav>
                <h1 class="page-title">Order Details</h1>
            </div>
            <div class="col-auto">
                <span class="badge badge-lg bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'primary') }}">
                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                </span>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Order Information -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Order Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">Order Number:</dt>
                                <dd class="col-sm-8">#{{ $order->order_number }}</dd>
                                
                                <dt class="col-sm-4">Order Date:</dt>
                                <dd class="col-sm-8">{{ $order->created_at->format('M d, Y at h:i A') }}</dd>
                                
                                <dt class="col-sm-4">Status:</dt>
                                <dd class="col-sm-8">
                                    <select class="form-select form-select-sm status-select" data-order-id="{{ $order->id }}" style="max-width: 200px;">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Preparing</option>
                                        <option value="out_for_delivery" {{ $order->status === 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">Payment Method:</dt>
                                <dd class="col-sm-8">{{ ucfirst($order->payment_method) }}</dd>
                                
                                <dt class="col-sm-4">Payment Status:</dt>
                                <dd class="col-sm-8">
                                    <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'failed' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </dd>
                                
                                <dt class="col-sm-4">Total Amount:</dt>
                                <dd class="col-sm-8"><strong>${{ number_format($order->total_amount, 2) }}</strong></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Order Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <div>
                                            <strong>{{ $item->menu_item_name }}</strong>
                                            @if($item->special_instructions)
                                                <br><small class="text-muted">{{ $item->special_instructions }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td><strong>${{ number_format($item->price * $item->quantity, 2) }}</strong></td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3">Subtotal:</th>
                                    <th>${{ number_format($order->orderItems->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</th>
                                </tr>
                                @if($order->delivery_fee > 0)
                                <tr>
                                    <th colspan="3">Delivery Fee:</th>
                                    <th>${{ number_format($order->delivery_fee, 2) }}</th>
                                </tr>
                                @endif
                                @if($order->tax_amount > 0)
                                <tr>
                                    <th colspan="3">Tax:</th>
                                    <th>${{ number_format($order->tax_amount, 2) }}</th>
                                </tr>
                                @endif
                                <tr class="table-active">
                                    <th colspan="3">Total:</th>
                                    <th>${{ number_format($order->total_amount, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer & Delivery Info -->
        <div class="col-lg-4">
            <!-- Customer Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Customer Information</h5>
                </div>
                <div class="card-body">
                    <dl>
                        <dt>Name:</dt>
                        <dd>{{ $order->customer_name }}</dd>
                        
                        <dt>Email:</dt>
                        <dd><a href="mailto:{{ $order->customer_email }}">{{ $order->customer_email }}</a></dd>
                        
                        <dt>Phone:</dt>
                        <dd><a href="tel:{{ $order->customer_phone }}">{{ $order->customer_phone }}</a></dd>
                        
                        @if($order->user)
                        <dt>User Account:</dt>
                        <dd>
                            <a href="#" class="text-decoration-none">
                                {{ $order->user->name }} 
                                <small class="text-muted">(ID: {{ $order->user->id }})</small>
                            </a>
                        </dd>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Delivery Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Delivery Information</h5>
                </div>
                <div class="card-body">
                    <dl>
                        <dt>Delivery Address:</dt>
                        <dd>{{ $order->delivery_address }}</dd>
                        
                        @if($order->delivery_instructions)
                        <dt>Special Instructions:</dt>
                        <dd>{{ $order->delivery_instructions }}</dd>
                        @endif
                        
                        <dt>Delivery Status:</dt>
                        <dd>
                            @if($order->status === 'delivered' && $order->delivered_at)
                                <span class="text-success">
                                    <i class="fas fa-check-circle"></i>
                                    Delivered on {{ $order->delivered_at->format('M d, Y at h:i A') }}
                                </span>
                            @else
                                <span class="text-muted">
                                    <i class="fas fa-clock"></i>
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($order->status === 'pending')
                            <button class="btn btn-success" onclick="updateOrderStatus('{{ $order->id }}', 'confirmed')">
                                <i class="fas fa-check"></i> Confirm Order
                            </button>
                        @endif
                        
                        @if($order->status === 'confirmed')
                            <button class="btn btn-primary" onclick="updateOrderStatus('{{ $order->id }}', 'preparing')">
                                <i class="fas fa-utensils"></i> Start Preparing
                            </button>
                        @endif
                        
                        @if($order->status === 'preparing')
                            <button class="btn btn-warning" onclick="updateOrderStatus('{{ $order->id }}', 'out_for_delivery')">
                                <i class="fas fa-truck"></i> Out for Delivery
                            </button>
                        @endif
                        
                        @if($order->status === 'out_for_delivery')
                            <button class="btn btn-success" onclick="updateOrderStatus('{{ $order->id }}', 'delivered')">
                                <i class="fas fa-check-circle"></i> Mark as Delivered
                            </button>
                        @endif
                        
                        <button class="btn btn-outline-secondary" onclick="window.print()">
                            <i class="fas fa-print"></i> Print Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.page-header {
    margin-bottom: 2rem;
}

.page-title {
    font-size: 1.75rem;
    font-weight: 600;
    color: #333;
}

.badge-lg {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

.card-title {
    font-weight: 600;
}

dt {
    font-weight: 600;
    color: #495057;
}

dd {
    margin-bottom: 0.5rem;
}

.table th {
    font-weight: 600;
    color: #495057;
    border-top: none;
}

.status-select {
    min-width: 140px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle status updates from dropdown
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            const orderId = this.dataset.orderId;
            const newStatus = this.value;
            updateOrderStatus(orderId, newStatus, this);
        });
        
        // Store original value
        select.dataset.originalValue = select.value;
    });
});

function updateOrderStatus(orderId, newStatus, selectElement = null) {
    fetch(`/admin/orders/${orderId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            status: newStatus
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('Order status updated successfully', 'success');
            // Reload page to refresh all status displays
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            if (selectElement) {
                selectElement.value = selectElement.dataset.originalValue;
            }
            showAlert('Failed to update order status', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (selectElement) {
            selectElement.value = selectElement.dataset.originalValue;
        }
        showAlert('An error occurred while updating order status', 'error');
    });
}

function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.page-header'));
    
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}
</script>
@endsection