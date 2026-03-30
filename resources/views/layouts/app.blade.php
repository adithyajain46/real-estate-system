<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate CRM - @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #1a3a6b, #2c5282);
            width: 250px;
            position: fixed;
            top: 0; left: 0;
            padding-top: 20px;
            z-index: 100;
        }
        .sidebar .brand {
            color: #fff;
            font-size: 1.3rem;
            font-weight: 700;
            padding: 15px 20px 25px;
            border-bottom: 1px solid rgba(255,255,255,0.15);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.75);
            padding: 12px 20px;
            border-radius: 0;
            transition: all 0.2s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,0.15);
            border-left: 4px solid #63b3ed;
        }
        .sidebar .nav-link i { margin-right: 10px; width: 18px; }
        .main-content {
            margin-left: 250px;
            padding: 0;
            min-height: 100vh;
        }
        .topbar {
            background: #fff;
            padding: 15px 25px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 99;
        }
        .content-area { padding: 25px; }
        .stat-card {
            border: none;
            border-radius: 12px;
            padding: 20px;
            color: #fff;
            transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-3px); }
        .stat-card .icon { font-size: 2.5rem; opacity: 0.8; }
        .stat-card .number { font-size: 2rem; font-weight: 700; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
        .badge-available  { background: #48bb78; color: #fff; }
        .badge-sold       { background: #fc8181; color: #fff; }
        .badge-rented     { background: #4299e1; color: #fff; }
        .table th { background: #f7fafc; font-weight: 600; color: #4a5568; border-bottom: 2px solid #e2e8f0; }
        .btn-primary { background: #2c5282; border-color: #2c5282; }
        .btn-primary:hover { background: #1a3a6b; border-color: #1a3a6b; }
        @media (max-width: 768px) {
            .sidebar { width: 100%; min-height: auto; position: relative; }
            .main-content { margin-left: 0; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="brand">
                <i class="bi bi-building me-2"></i>RealEstate CRM
            </div>
            <ul class="nav flex-column mt-2">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('properties.*') ? 'active' : '' }}" href="{{ route('properties.index') }}">
                        <i class="bi bi-house-door"></i> Properties
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}" href="{{ route('clients.index') }}">
                        <i class="bi bi-people"></i> Clients
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                        <i class="bi bi-bar-chart"></i> Reports
                    </a>
                </li>
            </ul>
            <div class="position-absolute bottom-0 w-100 p-3" style="border-top:1px solid rgba(255,255,255,0.15)">
                <a class="nav-link text-white-50" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <div class="topbar">
                <h5 class="mb-0 fw-semibold text-dark">@yield('title', 'Dashboard')</h5>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted small"><i class="bi bi-bell me-1"></i>Notifications</span>
                    <span class="fw-semibold text-dark small">
                        <i class="bi bi-person-circle me-1"></i>
                        {{ Auth::user()->name ?? 'Admin' }}
                    </span>
                </div>
            </div>

            <div class="content-area">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-x-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
