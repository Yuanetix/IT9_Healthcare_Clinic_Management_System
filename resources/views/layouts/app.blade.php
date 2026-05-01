<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Healthcare Clinic System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Sidebar Styles */
        .sidebar {
            background: #1e1e2f;
            width: 260px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }
        
        .sidebar .nav-link {
            color: #a0a0b0;
            padding: 12px 20px;
            margin: 4px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        
        .sidebar .nav-link:hover {
            background: #2d2d3f;
            color: white;
        }
        
        .sidebar .nav-link.active {
            background: #e94560;
            color: white;
        }
        
        .sidebar .nav-link i {
            width: 24px;
            margin-right: 12px;
            font-size: 16px;
        }
        
        .sidebar .logo {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #2d2d3f;
            margin-bottom: 20px;
        }
        
        .sidebar .logo h4 {
            color: white;
            margin: 0;
            font-size: 20px;
        }
        
        .sidebar .logo small {
            color: #a0a0b0;
            font-size: 11px;
        }
        
        /* Main Content Styles */
        .main-content {
            margin-left: 260px;
            background: #f5f7fa;
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        /* Navbar Styles */
        .top-navbar {
            background: white;
            padding: 12px 24px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        .top-navbar .navbar-brand {
            font-weight: 600;
            color: #1e1e2f;
            font-size: 18px;
        }
        
        .menu-toggle {
            display: none;
            background: transparent;
            border: none;
            font-size: 24px;
            color: #1e1e2f;
            cursor: pointer;
        }
        
        .user-dropdown .dropdown-toggle {
            background: transparent;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 6px 16px;
            font-size: 14px;
        }
        
        .user-dropdown .dropdown-toggle:hover {
            background: #f5f5f5;
        }
        
        /* Content Container */
        .content-container {
            padding: 20px 24px;
            min-height: calc(100vh - 60px);
        }
        
        /* Card Styles */
        .card {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            background: white;
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid #e0e0e0;
            padding: 15px 20px;
            font-weight: 600;
        }
        
        .card-body {
            padding: 20px;
        }
        
        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table thead th {
            background: #f8f9fa;
            color: #1e1e2f;
            border-bottom: 2px solid #e0e0e0;
            padding: 12px;
            font-weight: 600;
            font-size: 14px;
        }
        
        .table tbody td {
            padding: 10px 12px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 14px;
        }
        
        .table tbody tr:hover {
            background: #f8f9fa;
        }
        
        /* Button Styles */
        .btn-primary {
            background: #e94560;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            font-size: 14px;
        }
        
        .btn-primary:hover {
            background: #c62a47;
        }
        
        .btn-sm {
            padding: 4px 10px;
            font-size: 12px;
        }
        
        /* Alert Styles */
        .alert {
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            border: none;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }
        
        /* Badge Styles */
        .badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
        }
        
        .bg-success {
            background: #28a745 !important;
        }
        
        .bg-warning {
            background: #ffc107 !important;
        }
        
        .bg-danger {
            background: #dc3545 !important;
        }
        
        .bg-info {
            background: #17a2b8 !important;
        }
        
        /* Overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        
        /* ============================================ */
        /* MEDIA QUERIES */
        /* ============================================ */
        
        /* DESKTOP (1200px and above) */
        @media (min-width: 1200px) {
            .sidebar {
                width: 280px;
            }
            .sidebar .nav-link {
                padding: 14px 24px;
                font-size: 15px;
            }
            .content-container {
                padding: 24px 32px;
            }
            .top-navbar .navbar-brand {
                font-size: 20px;
            }
        }
        
        /* LAPTOP (992px to 1199px) */
        @media (min-width: 992px) and (max-width: 1199px) {
            .sidebar {
                width: 250px;
            }
            .sidebar .nav-link {
                padding: 10px 16px;
                font-size: 14px;
            }
            .content-container {
                padding: 20px 24px;
            }
            .table thead th,
            .table tbody td {
                padding: 8px 10px;
                font-size: 13px;
            }
        }
        
        /* TABLET (768px to 991px) */
        @media (min-width: 768px) and (max-width: 991px) {
            .sidebar {
                transform: translateX(-260px);
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .menu-toggle {
                display: block;
            }
            .top-navbar .navbar-brand {
                font-size: 16px;
            }
            .content-container {
                padding: 16px 20px;
            }
            .card-header {
                padding: 12px 16px;
                font-size: 14px;
            }
            .card-body {
                padding: 16px;
            }
            .table {
                display: block;
                overflow-x: auto;
            }
        }
        
        /* MOBILE PHONE (up to 767px) */
        @media (max-width: 767px) {
            .sidebar {
                width: 240px;
                transform: translateX(-240px);
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .menu-toggle {
                display: block;
            }
            .top-navbar {
                padding: 10px 16px;
            }
            .top-navbar .navbar-brand {
                font-size: 14px;
            }
            .user-dropdown .dropdown-toggle {
                padding: 4px 12px;
                font-size: 12px;
            }
            .content-container {
                padding: 12px 16px;
            }
            .card-header {
                padding: 10px 12px;
                font-size: 13px;
            }
            .card-body {
                padding: 12px;
            }
            .table thead th,
            .table tbody td {
                padding: 8px;
                font-size: 12px;
            }
            .btn {
                padding: 6px 12px;
                font-size: 12px;
            }
            .btn-sm {
                padding: 3px 8px;
                font-size: 11px;
            }
            h2 {
                font-size: 20px;
            }
            h3 {
                font-size: 18px;
            }
            h4 {
                font-size: 16px;
            }
            h5 {
                font-size: 14px;
            }
            .row > [class*="col-"] {
                margin-bottom: 15px;
            }
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            .form-control, .form-select {
                font-size: 14px;
            }
            .sidebar .logo h4 {
                font-size: 18px;
            }
            .sidebar .logo small {
                font-size: 10px;
            }
        }
        
        /* SMALL MOBILE (up to 480px) */
        @media (max-width: 480px) {
            .sidebar {
                width: 220px;
            }
            .top-navbar .navbar-brand {
                font-size: 12px;
            }
            .user-dropdown .dropdown-toggle {
                padding: 3px 8px;
                font-size: 11px;
            }
            .content-container {
                padding: 10px 12px;
            }
            .btn {
                padding: 5px 10px;
                font-size: 11px;
            }
            h2 {
                font-size: 18px;
            }
            .card-header {
                padding: 8px 10px;
                font-size: 12px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <h4>Clinic System</h4>
            <small>Healthcare Management</small>
        </div>
        <nav class="nav flex-column">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ route('patients.index') }}" class="nav-link {{ request()->routeIs('patients.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Patients
            </a>
            <a href="{{ route('doctors.index') }}" class="nav-link {{ request()->routeIs('doctors.*') ? 'active' : '' }}">
                <i class="fas fa-user-md"></i> Doctors
            </a>
            <a href="{{ route('appointments.index') }}" class="nav-link {{ request()->routeIs('appointments.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i> Appointments
            </a>
            <a href="{{ route('transactions.index') }}" class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                <i class="fas fa-money-bill"></i> Billing
            </a>
            <a href="{{ route('reports.revenue') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Reports
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <nav class="top-navbar">
            <div>
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="navbar-brand ms-2">Healthcare Clinic System</span>
            </div>
            <div class="dropdown user-dropdown">
                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="content-container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" style="background: none; border: none; font-size: 20px;">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" style="background: none; border: none; font-size: 20px;">&times;</button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
    
    <script>
        // Mobile sidebar toggle
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('open');
                if (overlay) {
                    overlay.style.display = sidebar.classList.contains('open') ? 'block' : 'none';
                }
            });
        }
        
        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('open');
                overlay.style.display = 'none';
            });
        }
        
        // Close sidebar when clicking on a link (mobile)
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 991) {
                    sidebar.classList.remove('open');
                    if (overlay) overlay.style.display = 'none';
                }
            });
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 991) {
                sidebar.classList.remove('open');
                if (overlay) overlay.style.display = 'none';
            }
        });
    </script>
    @stack('scripts')
</body>
</html>