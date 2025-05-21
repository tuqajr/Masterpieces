@extends('layouts.app')

@section('content')
<div class="container orders-container">
    <div class="page-header">
        <h1>My Orders</h1>
        <p class="subtitle">View and track all your orders</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($orders->isEmpty())
        <div class="empty-orders">
            <div class="empty-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <h3>No Orders Yet</h3>
            <p>You haven't placed any orders yet. Start shopping to see your orders here!</p>
            <a href="{{ route('menu.index') }}" class="btn btn-primary">Browse Menu</a>
        </div>
    @else
        <div class="orders-list">
            @foreach($orders as $order)
            <div class="order-card">
                <div class="order-header">
                    <div class="order-info">
                        <h3>Order #{{ $order->order_number }}</h3>
                        <p class="order-date">{{ $order->created_at->format('M d, Y at h:i A') }}</p>
                    </div>
                    <div class="order-status">
                        <span class="status-badge status-{{ strtolower($order->status) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>

                <div class="order-summary">
                    <div class="summary-row">
                        <span>{{ $order->orderItems->count() }} item(s)</span>
                        <span class="total-amount">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Payment Status:</span>
                        <span class="payment-status status-{{ strtolower($order->payment_status) }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>

                <div class="order-items-preview">
                    @foreach($order->orderItems->take(3) as $item)
                        <div class="item-preview">
                            <span class="item-name">{{ $item->menu_item_name }}</span>
                            <span class="item-quantity">x{{ $item->quantity }}</span>
                        </div>
                    @endforeach
                    @if($order->orderItems->count() > 3)
                        <div class="more-items">
                            +{{ $order->orderItems->count() - 3 }} more items
                        </div>
                    @endif
                </div>

                <div class="order-actions">
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline">View Details</a>
                    @if($order->status === 'pending' || $order->status === 'confirmed')
                        <button class="btn btn-secondary" onclick="trackOrder('{{ $order->order_number }}')">
                            Track Order
                        </button>
                    @endif
                    @if($order->status === 'delivered')
                        <a href="{{ route('orders.reorder', $order->id) }}" class="btn btn-primary">Reorder</a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $orders->links() }}
        </div>
    @endif
</div>

<style>
.orders-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
}

.page-header {
    text-align: center;
    margin-bottom: 40px;
}

.page-header h1 {
    color: #333;
    margin-bottom: 10px;
}

.subtitle {
    color: #666;
    font-size: 1.1rem;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    padding: 12px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    border: 1px solid #c3e6cb;
}

.empty-orders {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.empty-icon {
    font-size: 4rem;
    color: #ddd;
    margin-bottom: 20px;
}

.empty-orders h3 {
    color: #333;
    margin-bottom: 10px;
}

.empty-orders p {
    color: #666;
    margin-bottom: 30px;
}

.orders-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.order-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 24px;
    transition: transform 0.2s ease;
}

.order-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
}

.order-info h3 {
    color: #333;
    margin-bottom: 5px;
}

.order-date {
    color: #666;
    font-size: 0.9rem;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
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

.order-summary {
    margin-bottom: 20px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
}

.total-amount {
    font-weight: bold;
    color: #28a745;
    font-size: 1.1rem;
}

.payment-status.status-paid {
    color: #28a745;
    font-weight: 600;
}

.payment-status.status-pending {
    color: #ffc107;
    font-weight: 600;
}

.order-items-preview {
    margin-bottom: 20px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
}

.item-preview {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 5px 0;
}

.item-name {
    color: #333;
}

.item-quantity {
    color: #666;
    font-size: 0.9rem;
}

.more-items {
    color: #666;
    font-style: italic;
    margin-top: 5px;
}

.order-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.btn {
    padding: 8px 16px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
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
    text-decoration: none;
}

.pagination-wrapper {
    margin-top: 40px;
    display: flex;
    justify-content: center;
}

@media (max-width: 768px) {
    .order-header {
        flex-direction: column;
        gap: 15px;
    }
    
    .order-actions {
        justify-content: center;
    }
    
    .btn {
        flex: 1;
        text-align: center;
    }
}
</style>

<script>
function trackOrder(orderNumber) {
    // This would integrate with your order tracking system
    alert('Order tracking for #' + orderNumber + ' - Feature coming soon!');
}
</script>
@endsection