<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'ARENA Z — Student Esports Tournament Platform')</title>

    <!-- Google Fonts: Orbitron (Headings) & Poppins (Body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Global Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>
<body>

    <!-- Header & Navbar -->
    <x-navbar />

    <!-- Global Alerts -->
    @if (session('success'))
        <div class="container" style="margin-top: 20px;" data-flash>
            <div class="flash-message" style="background: rgba(34, 197, 94, 0.12); border: 1px solid var(--success); color: #86efac; padding: 14px 20px; border-radius: var(--radius-md); font-weight: 500;">
                ✓ {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="container" style="margin-top: 20px;" data-flash>
            <div class="flash-message" style="background: rgba(239, 68, 68, 0.12); border: 1px solid var(--danger); color: #fca5a5; padding: 14px 20px; border-radius: var(--radius-md); font-weight: 500;">
                ✕ {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="site-main">
        @yield('content')
    </main>

    <!-- Footer -->
    <x-footer />

    <!-- Scripts -->
    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>

