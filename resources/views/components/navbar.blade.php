<header class="site-header">
    <div class="container">
        <nav class="navbar">
            <a href="{{ route('home') }}" class="brand-logo">
                ARENA<span class="accent">Z</span>
                <span class="brand-badge">STUDENT</span>
            </a>

            <button class="mobile-nav-toggle" aria-label="Toggle navigation">
                ☰
            </button>

            <ul class="nav-menu">
                <li>
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                </li>
                <li>
                    <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">Tentang</a>
                </li>
                <li>
                    <a href="{{ route('tournaments.index') }}" class="nav-link {{ request()->routeIs('tournaments.*') ? 'active' : '' }}">Turnamen</a>
                </li>
                <li>
                    <a href="{{ route('schedule') }}" class="nav-link {{ request()->routeIs('schedule') ? 'active' : '' }}">Jadwal</a>
                </li>
                <li>
                    <a href="{{ route('bracket') }}" class="nav-link {{ request()->routeIs('bracket') ? 'active' : '' }}">Bracket</a>
                </li>

                {{-- Tombol aksi khusus mobile (hanya tampil saat menu mobile terbuka) --}}
                <li class="nav-mobile-actions">
                    @auth
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm" style="width:100%;justify-content:center;">Panel Admin</a>
                        @else
                            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary btn-sm" style="width:100%;justify-content:center;">Dashboard Saya</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline btn-sm" style="width:100%;">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline btn-sm" style="width:100%;justify-content:center;">Login</a>
                        <a href="{{ route('user.register') }}" class="btn btn-primary btn-sm" style="width:100%;justify-content:center;">Gabung Sekarang</a>
                    @endauth
                </li>
            </ul>

            {{-- Tombol aksi khusus desktop (selalu tampil di kanan navbar) --}}
            <div class="nav-actions">
                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">Panel Admin</a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary btn-sm">Dashboard Saya</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline btn-sm">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Login</a>
                    <a href="{{ route('user.register') }}" class="btn btn-primary btn-sm">Gabung Sekarang</a>
                @endauth
            </div>
        </nav>
    </div>
</header>
