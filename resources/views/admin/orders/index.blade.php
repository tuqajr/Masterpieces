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
                @csrf
                @method('PATCH')
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending"           {{ request('status')==='pending'           ? 'selected':'' }}>Pending</option>
                        <option value="confirmed"         {{ request('status')==='confirmed'         ? 'selected':'' }}>Confirmed</option>
                        <option value="preparing"         {{ request('status')==='preparing'         ? 'selected':'' }}>Preparing</option>
                        <option value="out_for_delivery"  {{ request('status')==='out_for_delivery'  ? 'selected':'' }}>Out for Delivery</option>
                        <option value="delivered"         {{ request('status')==='delivered'         ? 'selected':'' }}>Delivered</option>
                        <option value="cancelled"         {{ request('status')==='cancelled'         ? 'selected':'' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control"
                           placeholder="Search by order number or customer..."
                           value="{{ request('search') }}">
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
            @if($orders->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td><strong>#{{ $order->order_number ?? $order->id }}</strong></td>
                            <td><strong>{{ $order->user->name ?? $order->customer_name ?? '-' }}</strong></td>
                            <td>{{ $order->user->phone ?? $order->phone ?? '-' }}</td>
                            <td>{{ $order->orderItems->sum('quantity') }}</td>
                            <td><strong>${{ number_format(
                                $order->total 
                                ?? $order->orderItems->sum(fn($i)=> $i->subtotal ?? $i->product_price*$i->quantity)
                            ,2) }}</strong></td>
                            <td>
                                @php
                                    $statusMap = [
                                        'pending'           => ['label' => 'Pending',           'class' => 'bg-warning text-dark'],
                                        'confirmed'         => ['label' => 'Confirmed',         'class' => 'bg-info text-dark'],
                                        'preparing'         => ['label' => 'Preparing',         'class' => 'bg-primary'],
                                        'out_for_delivery'  => ['label' => 'Out for Delivery',  'class' => 'bg-secondary'],
                                        'delivered'         => ['label' => 'Delivered',         'class' => 'bg-success'],
                                        'cancelled'         => ['label' => 'Cancelled',         'class' => 'bg-danger'],
                                    ];
                                    $status = strtolower($order->status);
                                    $statusBadge = $statusMap[$status] ?? ['label' => ucfirst(str_replace('_',' ',$status)), 'class' => 'bg-light text-dark'];
                                @endphp
                                <span class="badge status-badge {{ $statusBadge['class'] }}">
                                    {{ $statusBadge['label'] }}
                                </span>
                            </td>
                            <td><strong>{{ ucfirst($order->payment_method ?? 'Cash on Delivery') }}</strong></td>
                            <td>
                                {{ $order->created_at->format('M d, Y') }}<br>
                                <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm mb-2">
                                    <a href="{{ route('admin.orders.show',$order) }}"
                                       class="btn btn-outline-primary" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="btn btn-outline-danger"
                                            onclick="deleteOrder('{{ $order->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <select class="form-select form-select-sm status-select mt-2"
                                        style="width:auto;"
                                        data-order-id="{{ $order->id }}">
                                    <option value="pending"           {{ $order->status==='pending'           ? 'selected':'' }}>Pending</option>
                                    <option value="confirmed"         {{ $order->status==='confirmed'         ? 'selected':'' }}>Confirmed</option>
                                    <option value="preparing"         {{ $order->status==='preparing'         ? 'selected':'' }}>Preparing</option>
                                    <option value="out_for_delivery"  {{ $order->status==='out_for_delivery'  ? 'selected':'' }}>Out for Delivery</option>
                                    <option value="delivered"         {{ $order->status==='delivered'         ? 'selected':'' }}>Delivered</option>
                                    <option value="cancelled"         {{ $order->status==='cancelled'         ? 'selected':'' }}>Cancelled</option>
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
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.status-select').forEach(select => {
        select.dataset.originalValue = select.value;
        select.addEventListener('change', function() {
            const orderId = this.dataset.orderId;
            const newStatus = this.value;
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(
                "{{ route('admin.orders.status',['order'=>'__ID__']) }}".replace('__ID__', orderId),
                {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    },
                    body: JSON.stringify({ status: newStatus })
                }
            )
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    this.value = this.dataset.originalValue;
                }
            })
            .catch(() => {
                this.value = this.dataset.originalValue;
            });
        });
    });
});
</script>
@endsection