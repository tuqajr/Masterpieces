@extends('layouts.app')

@section('content')
@include('partials.navbar')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- تحقق أن المتغير $order معرف --}}
@if(isset($order))
<div class="container thank-you-container">
    <div class="thank-you-card">
        <div class="thank-you-header">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Thank You for Your Order!</h1>
            <p class="order-message">
                Your order has been received!<br>
                <b>It will be shipped within 3 days and we will contact you soon.</b>
            </p>
            <p class="order-number">Order #{{ $order->id }}</p>
        </div>
        

        <div class="order-summary">
            <h3>Order Summary</h3>
            <div class="summary-details">
                <div class="detail-row">
                    <span>Order Date:</span>
                    <span>{{ $order->created_at->format('M d, Y h:i A') }}</span>
                </div>
                <div class="detail-row">
                    <span>Total Amount:</span>
                    <span class="amount">${{ number_format($order->total, 2) }}</span>
                </div>
                <div class="detail-row">
                    <span>Payment Status:</span>
                    <span class="status success">
                        {{ isset($order->payment_status) ? ucfirst($order->payment_status) : 'Pending' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="order-items">
            <h3>Items Ordered</h3>
            @if(isset($order->orderItems) && count($order->orderItems))
                @foreach($order->orderItems as $item)
                <div class="item-row">
                    <div class="item-info">
                        <span class="item-name">{{ $item->product_name }}</span>
                        <span class="item-quantity">x{{ $item->quantity }}</span>
                    </div>
                    <span class="item-price">${{ number_format($item->product_price * $item->quantity, 2) }}</span>
                </div>
                @endforeach
            @else
                <div class="item-row">
                    <span>No items found for this order.</span>
                </div>
            @endif
        </div>

        <div class="delivery-info">
            <h3>Delivery Information</h3>
            <div class="delivery-details">
                <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
                <p><strong>Estimated Delivery:</strong> {{ $order->delivery_date ? $order->delivery_date->format('M d, Y') : 'N/A' }}</p>
                <p><strong>Contact:</strong> {{ $order->phone }}</p>
            </div>
        </div>

        <div class="thank-you-actions">
            <a href="{{ url('/shop') }}" class="btn btn-primary">Continue Shopping</a>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">View My Orders</a>
        </div>
    </div>
</div>
@else
    <div class="alert alert-danger">No order found.</div>
@endif

<style>
.thank-you-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}
.thank-you-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 40px;
    text-align: center;
}
.thank-you-header {
    margin-bottom: 30px;
}
.success-icon {
    font-size: 4rem;
    color: #28a745;
    margin-bottom: 20px;
}
.thank-you-header h1 {
    color: #333;
    margin-bottom: 10px;
}
.order-message {
    font-size: 1.1rem;
    color: #444;
    margin-bottom: 10px;
}
.order-number {
    font-size: 1.2rem;
    color: #666;
    font-weight: 600;
}
.order-summary, .order-items, .delivery-info {
    margin: 30px 0;
    text-align: left;
}
.summary-details, .delivery-details {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
}
.detail-row, .item-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #e9ecef;
}
.detail-row:last-child, .item-row:last-child {
    border-bottom: none;
}
.amount {
    font-weight: bold;
    color: #28a745;
    font-size: 1.1rem;
}
.status.success {
    color: #28a745;
    font-weight: 600;
}
.item-info {
    display: flex;
    flex-direction: column;
    gap: 5px;
}
.item-name {
    font-weight: 600;
}
.item-quantity {
    color: #666;
    font-size: 0.9rem;
}
.item-price {
    font-weight: 600;
    color: #333;
}
.thank-you-actions {
    margin-top: 40px;
    display: flex;
    gap: 15px;
    justify-content: center;
}
.btn {
    padding: 12px 24px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-primary {
    background: #007bff;
    color: white;
}
.btn-primary:hover {
    background: #0056b3;
    color: white;
}
.btn-secondary {
    background: #6c757d;
    color: white;
}
.btn-secondary:hover {
    background: #545b62;
    color: white;
}
@media (max-width: 768px) {
    .thank-you-card {
        padding: 20px;
    }
    .thank-you-actions {
        flex-direction: column;
    }
    .btn {
        width: 100%;
    }
}
</style>
@endsection