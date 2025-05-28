@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb & Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
                        <li class="breadcrumb-item active">Order #{{ $order->order_number }}</li>
                    </ol>
                </nav>
                <h1 class="page-title mb-0">Order Details</h1>
                <p class="text-muted">Full order details and actions</p>
            </div>
            <div class="col-auto">
                <span class="badge badge-lg bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'primary') }}">
                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                </span>
            </div>
        </div>
    </div>

    <div class="row gy-4">
        <!-- Main info -->
        <div class="col-lg-8">
            <!-- Order Information Card -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Order Information</h5>
                </div>
                <div class="card-body">
                    <div class="row gy-3">
                        <div class="col-md-6">
                            <dl>
                                <dt>Order Number:</dt>
                                <dd>#{{ $order->order_number ?? $order->id }}</dd>
                                <dt>Order Date:</dt>
                                <dd>{{ $order->created_at->format('M d, Y h:i A') }}</dd>
                            
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl>
                                <dt>Payment Method:</dt>
                                <dd>{{ ucfirst($order->payment_method) }}</dd>
                                <dt>Payment Status:</dt>
                                <dd>
                                    <select class="form-select form-select-sm payment-status-select" data-order-id="{{ $order->id }}" style="max-width: 150px;">
                                        <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                                    </select>
                                </dd>
                                <dt>Total Amount:</dt>
                                <dd>
                                    <strong>
                                        ${{ number_format($order->total ?? $order->orderItems->sum(fn($item) => $item->subtotal ?? $item->product_price * $item->quantity), 2) }}
                                    </strong>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items Card -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Order Items</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Item Name</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $idx => $item)
                                <tr>
                                    <td>{{ $idx + 1 }}</td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>${{ number_format($item->product_price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->subtotal ?? $item->product_price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end">Subtotal:</td>
                                    <td>
                                        ${{ number_format($order->orderItems->sum(fn($item) => $item->subtotal ?? $item->product_price * $item->quantity), 2) }}
                                    </td>
                                </tr>
                                @if($order->delivery_fee ?? 0 > 0)
                                <tr>
                                    <td colspan="5" class="text-end">Delivery Fee:</td>
                                    <td>${{ number_format($order->delivery_fee, 2) }}</td>
                                </tr>
                                @endif
                                @if($order->tax_amount ?? 0 > 0)
                                <tr>
                                    <td colspan="5" class="text-end">Tax:</td>
                                    <td>${{ number_format($order->tax_amount, 2) }}</td>
                                </tr>
                                @endif
                                <tr class="table-active">
                                    <td colspan="5" class="text-end">Total:</td>
                                    <td>
                                        <strong>
                                            ${{ number_format(
                                                ($order->total ?? $order->orderItems->sum(fn($item) => $item->subtotal ?? $item->product_price * $item->quantity))
                                                + ($order->delivery_fee ?? 0)
                                                + ($order->tax_amount ?? 0),
                                            2) }}
                                        </strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Side info: Customer & Delivery -->
        <div class="col-lg-4">
            <!-- Customer Info -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Customer Information</h5>
                </div>
                <div class="card-body">
                    <dl>
                        <dt>Name:</dt>
                        <dd>{{ $order->user->name ?? $order->customer_name }}</dd>
                        <dt>Email:</dt>
                        <dd>{{ $order->user->email ?? $order->email }}</dd>
                        <dt>Phone:</dt>
                        <dd>{{ $order->user->phone ?? $order->phone ?? '-' }}</dd>
                        @if($order->user)
                        <dt>User Account:</dt>
                        <dd>
                            <a href="{{ route('admin.users.show', $order->user->id) }}" target="_blank">
                                {{ $order->user->name }} <small class="text-muted">(ID: {{ $order->user->id }})</small>
                            </a>
                        </dd>
                        @endif
                    </dl>
                </div>
            </div>
            <!-- Delivery Info -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Delivery Information</h5>
                </div>
                <div class="card-body">
                    <dl>
                        <dt>Delivery Address:</dt>
                        <dd>{{ $order->shipping_address ?? $order->address ?? '-' }}</dd>
                        @if($order->notes)
                        <dt>Notes:</dt>
                        <dd>{{ $order->notes }}</dd>
                        @endif
                        <dt>Delivery Status:</dt>
                        <dd>
                            @if($order->status === 'delivered' && $order->delivery_date)
                                <span class="text-success"><i class="fas fa-check-circle"></i>
                                    Delivered on {{ \Carbon\Carbon::parse($order->delivery_date)->format('M d, Y h:i A') }}
                                </span>
                            @else
                                <span class="text-muted"><i class="fas fa-clock"></i>
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header bg-light"><h5 class="card-title mb-0">Quick Actions</h5></div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-success" onclick="updateOrderStatus('{{ $order->id }}', 'confirmed')">
                            <i class="fas fa-check"></i> Confirm Order
                        </button>
                        <button class="btn btn-primary" onclick="updateOrderStatus('{{ $order->id }}', 'preparing')">
                            <i class="fas fa-utensils"></i> Start Preparing
                        </button>
                        <button class="btn btn-warning" onclick="updateOrderStatus('{{ $order->id }}', 'out_for_delivery')">
                            <i class="fas fa-truck"></i> Out for Delivery
                        </button>
                        <button class="btn btn-success" onclick="updateOrderStatus('{{ $order->id }}', 'delivered')">
                            <i class="fas fa-check-circle"></i> Mark as Delivered
                        </button>
                        <button class="btn btn-danger" onclick="updateOrderStatus('{{ $order->id }}', 'cancelled')">
                            <i class="fas fa-times"></i> Cancel Order
                        </button>
                        <button class="btn btn-outline-info" onclick="sendInvoice('{{ $order->id }}')">
                            <i class="fas fa-envelope"></i> Send Invoice
                        </button>
                        <button class="btn btn-outline-secondary" onclick="window.print()">
                            <i class="fas fa-print"></i> Print Order
                        </button>
                        <button class="btn btn-outline-danger" onclick="deleteOrder('{{ $order->id }}')">
                            <i class="fas fa-trash"></i> Delete Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.page-header { margin-bottom: 2rem; }
.page-title { font-size: 1.75rem; font-weight: 600; color: #333; }
.badge-lg { padding: 0.5rem 1rem; font-size: 0.875rem; }
.card-title { font-weight: 600; }
.table th { font-weight: 600; color: #495057; border-top: none; }
.status-select, .payment-status-select { min-width: 140px; }
.table thead th, .table tfoot td { background: #f8f9fa; }
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
        select.dataset.originalValue = select.value;
    });
    // Handle payment status updates
    document.querySelectorAll('.payment-status-select').forEach(select => {
        select.addEventListener('change', function() {
            const orderId = this.dataset.orderId;
            const newStatus = this.value;
            updatePaymentStatus(orderId, newStatus, this);
        });
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
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('Order status updated successfully', 'success');
            setTimeout(() => { location.reload(); }, 1000);
        } else {
            if (selectElement) selectElement.value = selectElement.dataset.originalValue;
            showAlert('Failed to update order status', 'error');
        }
    })
    .catch(() => {
        if (selectElement) selectElement.value = selectElement.dataset.originalValue;
        showAlert('An error occurred while updating order status', 'error');
    });
}

function updatePaymentStatus(orderId, newStatus, selectElement = null) {
    fetch(`/admin/orders/${orderId}/payment-status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ payment_status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('Payment status updated successfully', 'success');
            setTimeout(() => { location.reload(); }, 1000);
        } else {
            if (selectElement) selectElement.value = selectElement.dataset.originalValue;
            showAlert('Failed to update payment status', 'error');
        }
    })
    .catch(() => {
        if (selectElement) selectElement.value = selectElement.dataset.originalValue;
        showAlert('An error occurred while updating payment status', 'error');
    });
}

function sendInvoice(orderId) {
    showAlert('Invoice sent (simulate)', 'success');
}
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
                setTimeout(()=>window.location.href = '{{ route("admin.orders.index") }}', 1000);
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
    alertDiv.className = `alert alert-${type === 'success' ? 'success' : (type === 'info' ? 'info' : 'danger')} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.page-header'));
    setTimeout(() => { alertDiv.remove(); }, 5000);
}
</script>
@endsection