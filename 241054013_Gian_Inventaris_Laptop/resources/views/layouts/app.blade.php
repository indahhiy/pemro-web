<!DOCTYPE html>
<html>
<head>
    <title>Inventaris Laptop</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        body { background-color: #f4f6f9; }
        .sidebar {
            background-color: #1e1e2e;
            min-height: 100vh;
            padding: 20px 0;
        }
        .sidebar-title {
            color: #a5b4fc;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 600;
            padding: 0 6px;
            margin-bottom: 10px;
        }
        .nav-btn {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 9px 12px;
            border-radius: 8px;
            color: #c7d2fe;
            font-size: 13px;
            text-decoration: none;
            transition: background 0.15s;
            margin-bottom: 4px;
        }
       .nav-btn:hover,
        .nav-btn.active {
            background-color: #4f46e5;
            color: white;
            font-weight: 600;
        }
        .sidebar-divider {
            border-color: rgba(255,255,255,0.1);
        }
        .topbar {
            background-color: #1e1e2e;
        }
    </style>
</head>
<body>

<nav class="navbar topbar">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1 text-white">
            <i class="ti ti-device-laptop me-2" style="color:#a5b4fc"></i>
            Sistem Inventaris Laptop
        </span>
    </div>
</nav>

<div class="container-fluid p-0">
    <div class="row g-0">

        <!-- SIDEBAR -->
<div class="col-md-2 sidebar">

    <p class="sidebar-title">
        Menu Admin
    </p>

    <a href="/"
        <a href="/"
   class="nav-btn {{ request()->is('/') ? 'active' : '' }}">
    <i class="ti ti-home"></i>
    Dashboard
</a>

    <a href="/laptops"
        class="nav-btn {{ request()->is('laptops') ? 'active' : '' }}">
        <i class="ti ti-device-laptop"></i>
        Data Laptop
    </a>

    <hr class="sidebar-divider my-2">

    <a href="/laptops/create"
        class="nav-btn {{ request()->is('laptops/create') ? 'active' : '' }}">
        <i class="ti ti-plus"></i>
        Tambah Laptop
    </a>

</div>

<!-- CONTENT -->
<div class="col-md-10">

    <div class="p-4">

        @yield('content')

    </div>
</div>
    <div>
<div>
</body>
</html>