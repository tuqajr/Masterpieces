
@section('content')
<div class="container">
    <div class="order-confirmation">
        <div class="confirmation-header">
            <i class="fas fa-check-circle"></i>
            <h1>Order Confirmed!</h1>
            <p>Thank you for your order. Your order has been placed and is being processed.</p>
            <p>Order #: <strong>{{ $order->id }}</strong></p>
        </div>
        
        <div class="order-details">
            <h2>Order Details</h2>
            
            <div class="details-section">
                <h3>Shipping Information</h3>
                <div class="info-grid">
                    <div>
                        <strong>Name:</strong>
                        <p>{{ $order->customer_name }}</p>
                    </div>
                    <div>
                        <strong>Email:</strong>
                        <p>{{ $order->email }}</p>
                    </div>
                    <div>
                        <strong>Phone:</strong>
                        <p>{{ $order->phone }}</p>
                    </div>
                    <div>
                        <strong>Address:</strong>
                        <p>{{ $order->address }}, {{ $order->city }}, {{ $order->postal_code }}</p>
                    </div>
                </div>
            </div>
            
            <div class="details-section">
                <h3>Order Summary</h3>
                <div class="order-items">
                    @foreach($order->items as $item)
                    <div class="order-item">
                        <div class="item-name">{{ $item->product_name }} × {{ $item->quantity }}</div>
                        <div class="item-price">${{ number_format($item->price * $item->quantity, 2) }}</div>
                    </div>
                    @endforeach
                    
                    <div class="order-total">
                        <div>Total</div>
                        <div>${{ number_format($order->total, 2) }}</div>
                    </div>
                </div>
            </div>
            
            <div class="details-section">
                <h3>Payment Method</h3>
                <p>Cash on Delivery</p>
            </div>
        </div>
        
        <div class="confirmation-footer">
            <p>We'll send you an email when your order ships. If you have any questions, please contact our customer service.</p>
            <a href="{{ url('/shop') }}" class="btn-continue">Continue Shopping</a>
        </div>
    </div>
</div>

<style>
    .order-confirmation {
        max-width: 800px;
        margin: 40px auto;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .confirmation-header {
        text-align: center;
        background-color: #f5f8fa;
        padding: 40px 20px;
        border-bottom: 1px solid #eee;
    }
    
    .confirmation-header i {
        font-size: 60px;
        color: #28a745;
        margin-bottom: 20px;
    }
    
    .confirmation-header h1 {
        color: rgb(145, 51, 51);
        margin-bottom: 15px;
    }
    
    .confirmation-header p {
        color: #555;
        margin-bottom: 10px;
    }
    
    .order-details {
        padding: 30px;
    }
    
    .order-details h2 {
        color: rgb(145, 51, 51);
        margin-bottom: 25px;
        text-align: center;
    }
    
    .details-section {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    
    .details-section:last-child {
        border-bottom: none;
    }
    
    .details-section h3 {
        color: #333;
        margin-bottom: 15px;
        font-size: 18px;
        font-weight: 600;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }
    
    .info-grid div {
        line-height: 1.5;
    }
    
    .info-grid strong {
        color: #555;
        display: block;
        margin-bottom: 5px;
    }
    
    .order-items {
        border: 1px solid #eee;
        border-radius: 4px;
    }
    
    .order-item {
        display: flex;
        justify-content: space-between;
        padding: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .order-total {
        display: flex;
        justify-content: space-between;
        padding: 15px;
        font-weight: bold;
        background-color: #f9f9f9;
    }
    
    .confirmation-footer {
        text-align: center;
        padding: 30px;
        background-color: #f5f8fa;
        border-top: 1px solid #eee;
    }
    
    .confirmation-footer p {
        margin-bottom: 20px;
        color: #555;
    }
    
    .btn-continue {
        display: inline-block;
        background-color: rgb(145, 51, 51);
        color: white;
        padding: 12px 25px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.3s;
    }
    
    .btn-continue:hover {
        background-color: #d9534f;
        color: white;
    }
    
    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection