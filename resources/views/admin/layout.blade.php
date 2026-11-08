<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Barbershop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/CSS/admin.css') }}">
</head>
<body>
<div class="admin-layout">

    <aside class="sidebar">
        <div class="sidebar-brand">Barbershop</div>

        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('admin.service-categories') }}" class="sidebar-link {{ request()->routeIs('admin.service-categories') ? 'active' : '' }}">Service Categories</a>
            <a href="{{ route('admin.services') }}" class="sidebar-link {{ request()->routeIs('admin.services') ? 'active' : '' }}">Services</a>
            <a href="{{ route('admin.clients') }}" class="sidebar-link {{ request()->routeIs('admin.clients') ? 'active' : '' }}">Clients</a>
            <a href="{{ route('admin.barbers') }}" class="sidebar-link {{ request()->routeIs('admin.barbers') ? 'active' : '' }}">Barbers</a>
            <a href="{{ route('admin.schedule') }}" class="sidebar-link {{ request()->routeIs('admin.schedule') ? 'active' : '' }}">Schedule</a>
        </nav>

        <div class="sidebar-footer">
            <a href="{{ route('landing') }}" class="sidebar-link">Back to Site</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link sidebar-btn">Logout</button>
            </form>
        </div>
    </aside>

    <main class="admin-main">
        <header class="main-header">
            <h1>@yield('title', 'Dashboard')</h1>
        </header>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

</div>
</body>
</html>
