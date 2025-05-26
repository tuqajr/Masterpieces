@extends('layouts.app')

@section('content')
@include('partials.navbar')
<div class="container order-details-container">
    <div class="page-header">
        <div class="header-left">
                <a href="{{ route('orders.index') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
            <h1>Order Details</h1>
            <p class="order-number">Order #{{ $order->order_number }}</p>
        </div>
        <div class="header-right">
            <span class="status-badge status-{{ strtolower($order->status) }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>
    </div>

    <!-- Order Progress Bar -->
    @php
        $progressWidth = match($order->status) {
            'pending' => '25%',
            'confirmed' => '50%',
            'preparing' => '75%',
            'delivered' => '100%',
            default => '25%'
        };
    @endphp
    
    <div class="progress-container">
        <div class="progress-bar">
         <div class="progress-fill" data-progress="{{ $progressWidth }}"></div>
        </div>
        <div class="progress-steps">
            <span class="{{ in_array($order->status, ['pending', 'confirmed', 'preparing', 'delivered']) ? 'active' : '' }}">Pending</span>
            <span class="{{ in_array($order->status, ['confirmed', 'preparing', 'delivered']) ? 'active' : '' }}">Confirmed</span>
            <span class="{{ in_array($order->status, ['preparing', 'delivered']) ? 'active' : '' }}">Preparing</span>
            <span class="{{ $order->status == 'delivered' ? 'active' : '' }}">Delivered</span>
        </div>
    </div>

    <div class="order-details-grid">
        <!-- Order Information -->
        <div class="details-card">
            <h3>Order Information</h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="label">Order Date:</span>
                    <span class="value">{{ $order->created_at->format('M d, Y at h:i A') }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Order Status:</span>
                    <span class="value status-{{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Payment Status:</span>
                    <span class="value status-{{ strtolower($order->payment_status) }}">{{ ucfirst($order->payment_status) }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Payment Method:</span>
                    <span class="value">{{ ucfirst($order->payment_method) }}</span>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="details-card">
            <h3>Customer Information</h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="label">Name:</span>
                    <span class="value">{{ $order->customer_name }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Email:</span>
                    <span class="value">{{ $order->customer_email }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Phone:</span>
                    <span class="value">{{ $order->customer_phone }}</span>
                </div>
            </div>
        </div>

        <!-- Delivery Information -->
        <div class="details-card">
            <h3>Delivery Information</h3>
            <div class="info-grid">
                <div class="info-item full-width">
                    <span class="label">Delivery Address:</span>
                    <span class="value">{{ $order->delivery_address }}</span>
                </div>
                @if($order->delivery_instructions)
                <div class="info-item full-width">
                    <span class="label">Special Instructions:</span>
                    <span class="value">{{ $order->delivery_instructions }}</span>
                </div>
                @endif
                <div class="info-item">
                    <span class="label">Delivery Time:</span>
                    <span class="value">
                        @if($order->status === 'delivered' && $order->delivered_at)
                            {{ $order->delivered_at->format('M d, Y at h:i A') }}
                        @else
                            Estimated: 30-45 minutes
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="details-card order-items-card">
        <h3>Order Items</h3>
        <div class="items-list">
            @foreach($order->orderItems as $item)
            <div class="item-row">
                <div class="item-info">
                    <div class="item-details">
                        <h4 class="item-name">{{ $item->menu_item_name }}</h4>
                        @if($item->special_instructions)
                            <p class="item-instructions">{{ $item->special_instructions }}</p>
                        @endif
                    </div>
                    <div class="item-meta">
                        <span class="item-price">${{ number_format($item->price, 2) }} each</span>
                        <span class="item-quantity">Qty: {{ $item->quantity }}</span>
                    </div>
                </div>
                <div class="item-total">
                    ${{ number_format($item->price * $item->quantity, 2) }}
                </div>
            </div>
            @endforeach
        </div>

        <!-- Order Summary -->
        <div class="order-summary">
            <div class="summary-row">
                <span>Subtotal:</span>
                <span>${{ number_format($order->orderItems->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</span>
            </div>
            @if($order->delivery_fee > 0)
            <div class="summary-row">
                <span>Delivery Fee:</span>
                <span>${{ number_format($order->delivery_fee, 2) }}</span>
            </div>
            @endif
            @if($order->tax_amount > 0)
            <div class="summary-row">
                <span>Tax:</span>
                <span>${{ number_format($order->tax_amount, 2) }}</span>
            </div>
            @endif
            <div class="summary-row total-row">
                <span>Total:</span>
                <span>${{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Order Actions -->
    <div class="order-actions">
        @if($order->status === 'pending' || $order->status === 'confirmed')
            <button class="btn btn-secondary" onclick="trackOrder('{{ $order->order_number }}')">
                <i class="fas fa-truck"></i> Track Order
            </button>
        @endif
        
        @if($order->status === 'delivered')
            <a href="{{ route('orders.reorder', $order->id) }}" class="btn btn-primary">
                <i class="fas fa-redo"></i> Reorder
            </a>
        @endif
        
        <button class="btn btn-outline" onclick="printOrder()">
            <i class="fas fa-print"></i> Print Receipt
        </button>

        @if($order->status === 'pending')
            <button class="btn btn-danger" onclick="cancelOrder('{{ $order->id }}')">
                <i class="fas fa-times"></i> Cancel Order
            </button>
        @endif
    </div>
</div>

<style>

    
.order-details-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 30px;
}

.back-btn {
    color: #007bff;
    text-decoration: none;
    margin-bottom: 10px;
    display: inline-block;
    font-weight: 600;
}

.back-btn:hover {
    text-decoration: underline;
}

.page-header h1 {
    color: #333;
    margin-bottom: 5px;
}

.order-number {
    color: #666;
    font-size: 1.1rem;
}

.status-badge {
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-confirmed {
    background: #d1ecf1;
    color: #0c5460;
}

.status-preparing {
    background: #e2e3e5;
    color: #383d41;
}

.status-delivered {
    background: #d4edda;
    color: #155724;
}

.status-cancelled {
    background: #f8d7da;
    color: #721c24;
}

.status-paid {
    color: #28a745;
    font-weight: 600;
}

.progress-container {
    margin-bottom: 30px;
}

.progress-bar {
    width: 100%;
    height: 8px;
    background-color: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 15px;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #007bff, #0056b3);
    transition: width 0.3s ease;
}

.progress-steps {
    display: flex;
    justify-content: space-between;
    font-size: 0.9rem;
}

.progress-steps span {
    color: #6c757d;
    font-weight: 500;
}

.progress-steps span.active {
    color: #007bff;
    font-weight: 600;
}

.order-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.details-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 24px;
}

.details-card h3 {
    color: #333;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f8f9fa;
}

.info-grid {
    display: grid;
    gap: 15px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.info-item.full-width {
    flex-direction: column;
    gap: 5px;
}

.label {
    font-weight: 600;
    color: #333;
}

.value {
    color: #666;
    text-align: right;
}

.info-item.full-width .value {
    text-align: left;
}

.order-items-card {
    grid-column: 1 / -1;
}

.items-list {
    margin-bottom: 30px;
}

.item-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 20px 0;
    border-bottom: 1px solid #e9ecef;
}

.item-row:last-child {
    border-bottom: none;
}

.item-info {
    flex: 1;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-right: 20px;
}

.item-details h4 {
    color: #333;
    margin-bottom: 5px;
}

.item-instructions {
    color: #666;
    font-style: italic;
    margin: 0;
    font-size: 0.9rem;
}

.item-meta {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 5px;
}

.item-price, .item-quantity {
    color: #666;
    font-size: 0.9rem;
}

.item-total {
    font-weight: bold;
    color: #333;
    font-size: 1.1rem;
}

.order-summary {
    border-top: 2px solid #e9ecef;
    padding-top: 20px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
}

.total-row {
    font-weight: bold;
    font-size: 1.2rem;
    color: #333;
    border-top: 1px solid #e9ecef;
    margin-top: 10px;
    padding-top: 15px;
}

.order-actions {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    justify-content: center;
    margin-top: 30px;
}

.btn {
    padding: 12px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-primary {
    background: #007bff;
    color: white;
}

.btn-primary:hover {
    background: #0056b3;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #545b62;
}

.btn-outline {
    background: transparent;
    color: #007bff;
    border: 1px solid #007bff;
}

.btn-outline:hover {
    background: #007bff;
    color: white;
}

.btn-danger {
    background: #dc3545;
    color: white;
}

.btn-danger:hover {
    background: #c82333;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        gap: 15px;
    }
    
    .order-details-grid {
        grid-template-columns: 1fr;
    }
    
    .item-info {
        flex-direction: column;
        gap: 10px;
    }
    
    .item-meta {
        align-items: flex-start;
    }
    
    .order-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
    
    .progress-steps {
        font-size: 0.8rem;
    }
}
</style>

<script>
function trackOrder(orderNumber) {
    alert('Order tracking for #' + orderNumber + ' - Feature coming soon!');
}

function printOrder() {
    window.print();
}

function cancelOrder(orderId) {
    if (confirm('Are you sure you want to cancel this order?')) {
        fetch(`/orders/${orderId}/cancel`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Order cancelled successfully');
                location.reload();
            } else {
                alert('Failed to cancel order: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while cancelling the order');
        });
    }
}
</script>
@endsection