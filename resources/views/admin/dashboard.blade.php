@extends('layouts.admin')

@section('content')
<div class="admin-dashboard">
    <div class="dashboard-header">
        <h1>Dashboard</h1>
        <p>Welcome, {{ Auth::user()->name }}</p>
    </div>

    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-content">
                <h3>Total Products</h3>
                <p class="stat-number">{{ $productsCount }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3>Active Products</h3>
                <p class="stat-number">{{ $activeProductsCount }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-content">
                <h3>Total Orders</h3>
                <p class="stat-number">{{ $ordersCount }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3>Total Customers</h3>
                <p class="stat-number">{{ $customersCount }}</p>
            </div>
        </div>
    </div>
    
    <div class="recent-orders-section" style="margin-top:40px;">
        <h2 style="margin-bottom: 25px; color: rgb(145, 51, 51);">Recent Orders</h2>
        <table class="recent-orders-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                @php
                    // Map statuses to CSS classes and readable names
                    $status = strtolower($order->status);
                    $statusMap = [
                        'pending'           => ['class' => 'status-pending',           'label' => 'Pending'],
                        'confirmed'         => ['class' => 'status-confirmed',         'label' => 'Confirmed'],
                        'preparing'         => ['class' => 'status-preparing',         'label' => 'Preparing'],
                        'processing'        => ['class' => 'status-processing',        'label' => 'Processing'],
                        'out_for_delivery'  => ['class' => 'status-out-for-delivery',  'label' => 'Out for Delivery'],
                        'delivered'         => ['class' => 'status-delivered',         'label' => 'Delivered'],
                        'completed'         => ['class' => 'status-completed',         'label' => 'Completed'],
                        'cancelled'         => ['class' => 'status-cancelled',         'label' => 'Cancelled'],
                    ];
                    $badge = $statusMap[$status] ?? ['class'=>'status-unknown','label'=>ucfirst($order->status)];
                @endphp
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer->name ?? 'N/A' }}</td>
                    <td>{{ number_format($order->total, 2) }} {{ $currency ?? '$' }}</td>
                    <td>
                        <span class="status-badge {{ $badge['class'] }}">
                            {{ $badge['label'] }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Chart.js CDN (or use local if preferred) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@php
    $chartLabels = isset($ordersChartLabels) ? $ordersChartLabels : [];
    $chartData = isset($ordersChartData) ? $ordersChartData : [];
@endphp
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById("ordersChart")?.getContext("2d");
        if (ctx) {
            new Chart(ctx, {
                type: "line",
                data: {
                    labels: chartLabels,
                    datasets: [
                        {
                            label: "Orders",
                            data: chartData,
                            borderColor: "rgb(145, 51, 51)",
                            backgroundColor: "rgba(145, 51, 51, 0.15)",
                            tension: 0.3,
                            pointRadius: 5,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: { grid: { display: false } },
                        y: { beginAtZero: true }
                    }
                }
            });
        }
    });
</script>


<style>
    /* Dashboard Styles */
    .admin-dashboard {
        padding: 20px;
        font-family: 'Reem Kufi', sans-serif;
    }

    .dashboard-header {
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e0e0e0;
    }

    .dashboard-header h1 {
        color: rgb(145, 51, 51);
        font-size: 2.2rem;
        margin-bottom: 10px;
        font-weight: bold;
    }

    .dashboard-header p {
        color: #555;
        font-size: 1rem;
    }

    .stats-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        flex: 1;
        min-width: 200px;
        display: flex;
        align-items: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
        background-color: rgba(145, 51, 51, 0.1);
        color: rgb(145, 51, 51);
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
    }

    .stat-icon i {
        font-size: 24px;
    }

    .stat-content h3 {
        color: #555;
        font-size: 1rem;
        margin-bottom: 5px;
    }

    .stat-number {
        color: rgb(145, 51, 51);
        font-size: 1.8rem;
        font-weight: bold;
    }

    .charts-section {
        background: #fff;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        margin-bottom: 40px;
    }

    .recent-orders-section {
        background: #fff;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .recent-orders-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 1rem;
    }

    .recent-orders-table th, .recent-orders-table td {
        border-bottom: 1px solid #f0f0f0;
        padding: 10px 12px;
        text-align: left;
    }

    .recent-orders-table th {
        background: #FAF3ED;
        color: rgb(145, 51, 51);
        font-weight: bold;
    }

    .recent-orders-table tr:last-child td {
        border-bottom: none;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 12px;
        color: #fff;
        font-size: 0.92em;
        font-weight: 600;
    }
    .status-pending { background: #e0a800; color: #fff; }
    .status-confirmed { background: #17a2b8; color: #fff; }
    .status-preparing { background: #007bff; color: #fff; }
    .status-processing { background: #6c757d; color: #fff; }
    .status-out-for-delivery { background: #6f42c1; color: #fff; }
    .status-delivered { background: #28a745; color: #fff; }
    .status-completed { background: #20c997; color: #fff; }
    .status-cancelled { background: #dc3545; color: #fff; }
    .status-unknown { background: #adb5bd; color: #fff; }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .stats-container {
            flex-direction: column;
        }
        .stat-card {
            width: 100%;
        }
        .charts-section, .recent-orders-section {
            padding: 10px;
        }
    }
</style>
@endsection