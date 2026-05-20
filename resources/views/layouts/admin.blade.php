<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin | Satya Interiors')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <script src="https://unpkg.com/lucide@latest" defer></script>
</head>
<body class="admin-body">
    <aside class="admin-sidebar">
        <h1>Admin Portal</h1>
        <a class="@if(request()->routeIs('admin.dashboard')) active @endif" href="{{ route('admin.dashboard') }}"><i data-lucide="layout-dashboard"></i> Dashboard</a>
        <a class="@if(request()->routeIs('admin.products.*')) active @endif" href="{{ route('admin.products.index') }}"><i data-lucide="package"></i> Product Management</a>
        <a class="@if(request()->routeIs('admin.orders')) active @endif" href="{{ route('admin.orders') }}"><i data-lucide="receipt-text"></i> Orders</a>
        <a class="@if(request()->routeIs('customorders.*')) active @endif" href="{{ route('customorders.index') }}"><i data-lucide="calendar-check"></i> Custom Orders</a>
        <a href="{{ route('home') }}"><i data-lucide="store"></i> Storefront</a>
    </aside>

    <main class="admin-main">
        @yield('content')
    </main>

    <script>window.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
</body>
</html>
