<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — ARENA Z</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/user-dashboard.css') }}">
    @stack('styles')
</head>
<body>

    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- SIDEBAR -->
    <aside class="ud-sidebar" id="udSidebar">
        <div class="ud-sidebar-header">
            <a href="{{ route('home') }}" class="ud-logo">
                ARENA<span>Z</span>
            </a>
            <button class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Tutup menu">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- User info -->
        <div class="ud-user-card">
            <div class="ud-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="ud-user-info">
                <div class="ud-user-name">{{ auth()->user()->name }}</div>
                <div class="ud-user-role">Peserta ARENA Z</div>
            </div>
        </div>

        <!-- Nav menu -->
        <nav class="ud-nav">
            <div class="ud-nav-label">MENU UTAMA</div>

            <a href="{{ route('user.dashboard') }}" class="ud-nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('tournaments.index') }}" class="ud-nav-item {{ request()->routeIs('tournaments.*') ? 'active' : '' }}">
                <i class="fas fa-trophy"></i>
                <span>Turnamen</span>
            </a>

            <a href="{{ route('user.team.create') }}" class="ud-nav-item {{ request()->routeIs('user.team.create') ? 'active' : '' }}">
                <i class="fas fa-plus-circle"></i>
                <span>Daftar Tim</span>
            </a>

            <a href="{{ route('user.my-teams') }}" class="ud-nav-item {{ request()->routeIs('user.my-teams*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Tim Saya</span>
            </a>

            <a href="{{ route('user.my-schedule') }}" class="ud-nav-item {{ request()->routeIs('user.my-schedule') ? 'active' : '' }}">
                <i class="fas fa-calendar-days"></i>
                <span>Jadwal Saya</span>
            </a>

            <a href="{{ route('user.my-bracket') }}" class="ud-nav-item {{ request()->routeIs('user.my-bracket') ? 'active' : '' }}">
                <i class="fas fa-diagram-project"></i>
                <span>Bracket Saya</span>
            </a>

            <a href="{{ route('user.profile') }}" class="ud-nav-item {{ request()->routeIs('user.profile*') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i>
                <span>Profil</span>
            </a>
        </nav>

        <!-- Bottom actions -->
        <div class="ud-sidebar-bottom">
            <a href="{{ route('home') }}" class="ud-nav-item">
                <i class="fas fa-globe"></i>
                <span>Lihat Website</span>
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="ud-nav-item ud-logout-btn">
                    <i class="fas fa-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <div class="ud-wrapper">

        <!-- Top Bar -->
        <header class="ud-topbar">
            <button class="sidebar-toggle-btn" id="sidebarToggleBtn" aria-label="Buka menu">
                <i class="fas fa-bars"></i>
            </button>

            <div class="ud-topbar-title">
                @yield('page-title', 'Dashboard')
            </div>

            <div class="ud-topbar-actions">
                <a href="{{ route('user.team.create') }}" class="ud-topbar-btn">
                    <i class="fas fa-plus"></i>
                    <span>Daftar Tim</span>
                </a>
            </div>
        </header>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="ud-alert ud-alert-success" data-flash>
                <i class="fas fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="ud-alert ud-alert-danger" data-flash>
                <i class="fas fa-circle-xmark"></i>
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="ud-alert ud-alert-danger" data-flash>
                <i class="fas fa-triangle-exclamation"></i>
                <div>
                    <strong>Terjadi kesalahan validasi:</strong>
                    <ul style="margin: 6px 0 0 16px; font-size: 13px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Page Content -->
        <main class="ud-content">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="ud-footer">
            &copy; {{ date('Y') }} ARENA Z — Student Esports Tournament Platform
        </footer>
    </div>

    <script src="{{ asset('js/user-dashboard.js') }}"></script>
    @stack('scripts')
</body>
</html>
