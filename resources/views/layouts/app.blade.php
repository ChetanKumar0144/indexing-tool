<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XTI Indexing Tool</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            overflow-x: hidden;
        }
        .sidebar {
            width: 220px;
            position: fixed;
            top: 56px;
            bottom: 0;
            left: 0;
            background-color: #f8f9fa;
            padding-top: 1rem;
            border-right: 1px solid #ddd;
        }
        .sidebar a {
            padding: 10px 20px;
            display: block;
            color: #333;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        .sidebar a:hover {
            background-color: #e9ecef;
        }
        .sidebar a.active {
            font-weight: bold;
            background-color: #e2e6ea;
        }
        .main-content {
            margin-left: 220px;
            padding: 20px;
            margin-top: 56px;
        }
    </style>
</head>
<body>

    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">📡 XTI Tool</a>
            <div class="d-flex ms-auto">
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-danger btn-sm">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    @auth
    <!-- Sidebar (only for logged-in users) -->
    <div class="sidebar">
        <a href="{{ route('dashboard') }}"
           class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
           🏠 Dashboard
        </a>

        <a href="{{ route('websites.index') }}"
           class="{{ request()->routeIs('websites.index') ? 'active' : '' }}">
           🌐 My Websites
        </a>

        <a href="{{ route('websites.create') }}"
           class="{{ request()->routeIs('websites.create') ? 'active' : '' }}">
           ➕ Add Website
        </a>

        @if(session('active_website_id'))
            <a href="{{ route('urls.index', session('active_website_id')) }}"
               class="{{ request()->routeIs('urls.index') ? 'active' : '' }}">
               🔗 View URLs
            </a>
            <a href="{{ route('urls.csv.form', session('active_website_id')) }}"
               class="{{ request()->routeIs('urls.csv.form') ? 'active' : '' }}">
               📁 Upload CSV
            </a>
        @endif

        @if(auth()->user()->is_admin ?? false)
            <hr>
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
               ⚙️ Admin Panel
            </a>
            <a href="{{ route('admin.clients.create') }}"
                class="{{ request()->routeIs('admin.clients.create') ? 'active' : '' }}">
                👤 Create Client
            </a>

        @endif
    </div>
    @endauth

    <!-- Main Content -->
    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('scripts')
</body>
</html>
