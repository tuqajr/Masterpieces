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
    </div>
</div>

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

    .sidebar-logo {
        text-align: center;
        padding: 20px 0;
        margin-bottom: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar-logo .logo-text {
        font-family: 'Reem Kufi', sans-serif;
        color: #d4af37;
        font-size: 2rem;
        display: block;
        margin-bottom: 10px;
    }

    .sidebar-logo img {
        width: 60px;
        height: auto;
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .stats-container {
            flex-direction: column;
        }
        
        .stat-card {
            width: 100%;
        }
    }
</style>
@endsection