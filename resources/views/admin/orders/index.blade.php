@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Orders</h1>

    <div class="card">
        <div class="card-body">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>No orders found.</p>
            @endif
        </div>
    </div>
</div>
@endsection