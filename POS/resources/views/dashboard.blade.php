<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <link href="{{ asset('css/navi.css') }}" rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>
<body>

    @include('layouts.navigation')

    <div class="content">
        <!-- Welcome Section -->
        <div class="dashboard-welcome" style="margin-bottom: 30px;">
            <h1>Welcome Back, <span style="color:#7a0f5c;">Admin!</span></h1>
            <p style="font-size:1rem; color:#555;">Here’s a quick overview of your system today.</p>
        </div>

        <!-- Quick Stats Cards -->
        <div class="dashboard-cards" style="display:flex; gap:20px; flex-wrap:wrap; margin-bottom:30px;">

            <div class="card" style="flex:1 1 200px; background:#fff; padding:20px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                <h3>Categories</h3>
                <p style="font-size:1.5rem; font-weight:bold;">{{ $categoryCount }}</p>
            </div>

            <div class="card" style="flex:1 1 200px; background:#fff; padding:20px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                <h3>Sub Categories</h3>
                <p style="font-size:1.5rem; font-weight:bold;">{{ $subcategoryCount }}</p>
            </div>

            <div class="card" style="flex:1 1 200px; background:#fff; padding:20px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                <h3>Total Items</h3>
                <p style="font-size:1.5rem; font-weight:bold;">{{ $totalItems }}</p>
            </div>

            <div class="card" style="flex:1 1 200px; background:#fff; padding:20px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                <h3>Active Items</h3>
                <p style="font-size:1.5rem; font-weight:bold;">{{ $activeItems }}</p>
            </div>

        </div>

        <!-- Quick Actions -->
        <div class="dashboard-actions" style="display:flex; gap:20px; flex-wrap:wrap;">
            <a href="{{ route('item.add') }}" class="action-btn" style="flex:1 1 200px; background:#7a0f5c; color:#fff; padding:20px; border-radius:12px; text-align:center; text-decoration:none; transition:0.3s;"> 
                <i class="fas fa-plus-circle" style="margin-right:8px;"></i> Add New Item
            </a>
            <a href="{{ route('category.manage') }}" class="action-btn" style="flex:1 1 200px; background:#4b0f3a; color:#fff; padding:20px; border-radius:12px; text-align:center; text-decoration:none; transition:0.3s;"> 
                <i class="fas fa-tasks" style="margin-right:8px;"></i> Manage Categories
            </a>
            <a href="{{ route('item.view') }}" class="action-btn" style="flex:1 1 200px; background:#ff4dc4; color:#fff; padding:20px; border-radius:12px; text-align:center; text-decoration:none; transition:0.3s;"> 
                <i class="fas fa-chart-line" style="margin-right:8px;"></i> View Items
            </a>
            <!-- <a href="#" class="action-btn" style="flex:1 1 200px; background:#1f1f2e; color:#fff; padding:20px; border-radius:12px; text-align:center; text-decoration:none; transition:0.3s;"> 
                <i class="fas fa-users" style="margin-right:8px;"></i> User Management
            </a> -->
        </div>
    </div>

</body>
</html>