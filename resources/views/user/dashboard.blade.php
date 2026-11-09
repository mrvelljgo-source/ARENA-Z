
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User - ARENA Z</title>

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #070b16;
            color: white;
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            min-height: 75px;
            padding: 0 7%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #101a2d;
            border-bottom: 1px solid #263653;
        }

        .logo {
            font-family: 'Orbitron', sans-serif;
            font-size: 25px;
            font-weight: 800;
            color: #3685ff;
        }

        .logout button {
            background: #e34b5b;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-family: inherit;
            font-weight: 600;
        }

        .container {
            max-width: 1150px;
            margin: 50px auto;
            padding: 0 25px;
        }

        .welcome {
            margin-bottom: 35px;
        }

        .welcome h1 {
            font-size: 30px;
            margin-bottom: 8px;
        }

        .welcome h1 span {
            color: #3685ff;
        }

        .welcome p {
            color: #91a0b8;
            font-size: 14px;
        }

        .profile {
            background: linear-gradient(120deg, #142c50, #17213d);
            border: 1px solid #294b79;
            padding: 28px;
            border-radius: 15px;
            margin-bottom: 35px;
        }

        .profile h3 {
            font-size: 18px;
            margin-bottom: 12px;
        }

        .profile p {
            color: #b8c7dc;
            font-size: 14px;
            margin: 5px 0;
        }

        .section-title {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .registration {
            background: #101a2d;
            border: 1px solid #263653;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 35px;
        }

        .team-card {
            background: #0b1425;
            border: 1px solid #263653;
            border-radius: 12px;
            padding: 20px;
            margin-top: 15px;
        }

        .team-card h3 {
            color: #60a5fa;
            margin-bottom: 15px;
        }

        .team-info p {
            color: #b8c7dc;
            font-size: 13px;
            margin: 8px 0;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            margin-top: 12px;
        }

        .pending {
            background: #493915;
            color: #facc15;
        }

        .approved {
            background: #123d2b;
            color: #4ade80;
        }

        .rejected {
            background: #4b2028;
            color: #fb7185;
        }

        .empty {
            color: #91a0b8;
            font-size: 13px;
            line-height: 1.8;
        }

        .register-link {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 17px;
            background: #3685ff;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
        }

        .menu {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .menu-card {
            background: #101a2d;
            border: 1px solid #263653;
            border-radius: 13px;
            padding: 25px;
            transition: 0.3s;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            border-color: #3685ff;
        }

        .menu-card .icon {
            font-size: 30px;
            margin-bottom: 15px;
        }

        .menu-card h3 {
            margin-bottom: 8px;
            font-size: 17px;
        }

        .menu-card p {
            color: #91a0b8;
            font-size: 12px;
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .menu-card a {
            display: inline-block;
            color: #3685ff;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }

        .success {
            background: #123d2b;
            color: #4ade80;
            padding: 15px 20px;
            border: 1px solid #22c55e;
            border-radius: 10px;
            margin: 20px auto;
            max-width: 1100px;
        }

        body {
            background:
                radial-gradient(ellipse at 85% 4%, rgba(54, 133, 255, .08), transparent 28%),
                #070b16;
        }

        .navbar {
            position: sticky;
            top: 0;
            z-index: 5;
            min-height: 76px;
            gap: 20px;
            background: rgba(12, 19, 33, .92);
            border-bottom-color: rgba(148, 163, 184, .14);
            backdrop-filter: blur(16px);
        }

        .logo {
            color: #fff;
            letter-spacing: 2px;
            text-shadow: 0 0 24px rgba(54, 133, 255, .26);
        }

        .home-link {
            margin-left: auto;
            color: #9aa8bd;
            font-size: 12px;
            text-decoration: none;
            transition: color .2s;
        }

        .home-link:hover {
            color: #fff;
        }

        .logout button {
            padding: 10px 16px;
            border: 1px solid rgba(251, 113, 133, .2);
            border-radius: 10px;
            background: rgba(227, 75, 91, .12);
            color: #fda4af;
            transition: background .2s, transform .2s;
        }

        .logout button:hover {
            background: rgba(227, 75, 91, .22);
            transform: translateY(-1px);
        }

        .container {
            max-width: 1190px;
            margin: 42px auto;
        }

        .welcome {
            position: relative;
            overflow: hidden;
            padding: 34px;
            margin-bottom: 22px;
            border: 1px solid rgba(96, 165, 250, .22);
            border-radius: 20px;
            background:
                radial-gradient(ellipse at 88% 15%, rgba(139, 92, 246, .23), transparent 34%),
                linear-gradient(115deg, #14294b, #111b35 72%, #1b1740);
            box-shadow: 0 22px 55px rgba(0, 0, 0, .2);
        }

        .welcome::before {
            content: 'PLAYER DASHBOARD  /  ARENA Z';
            display: block;
            margin-bottom: 15px;
            color: #a78bfa;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 2.2px;
        }

        .welcome h1 {
            font-size: clamp(25px, 4vw, 34px);
            letter-spacing: -.8px;
        }

        .welcome h1 span {
            color: #93c5fd;
        }

        .welcome p {
            font-size: 13px;
        }

        .profile {
            padding: 25px 28px;
            margin-bottom: 32px;
            border-color: rgba(96, 165, 250, .18);
            border-radius: 17px;
            background:
                radial-gradient(ellipse at 100% 0, rgba(54, 133, 255, .12), transparent 40%),
                linear-gradient(120deg, #121f36, #111a2e);
            box-shadow: 0 14px 35px rgba(0, 0, 0, .15);
        }

        .profile h3 {
            margin-bottom: 14px;
            font-size: 17px;
        }

        .profile p {
            font-size: 13px;
        }

        .section-title {
            margin-bottom: 16px;
            font-size: 18px;
            letter-spacing: -.3px;
        }

        .registration {
            padding: 20px;
            margin-bottom: 32px;
            border-color: rgba(148, 163, 184, .13);
            border-radius: 17px;
            background: linear-gradient(145deg, rgba(16, 26, 45, .96), rgba(12, 19, 33, .96));
            box-shadow: 0 14px 35px rgba(0, 0, 0, .12);
        }

        .team-card {
            margin-top: 0;
            padding: 23px;
            border-color: rgba(148, 163, 184, .13);
            border-radius: 14px;
            background: rgba(8, 17, 31, .62);
        }

        .team-card + .team-card {
            margin-top: 14px;
        }

        .team-card h3 {
            font-size: 17px;
        }

        .team-info {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 2px 20px;
        }

        .team-info p {
            overflow-wrap: anywhere;
            font-size: 12px;
        }

        .status {
            padding: 7px 12px;
            font-size: 10px;
            letter-spacing: .3px;
        }

        .empty {
            padding: 7px 3px 4px;
        }

        .register-link {
            padding: 11px 17px;
            border-radius: 10px;
            background: linear-gradient(100deg, #2563eb, #3685ff);
            box-shadow: 0 8px 20px rgba(54, 133, 255, .19);
            transition: transform .2s, filter .2s;
        }

        .register-link:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
        }

        .menu {
            gap: 16px;
        }

        .menu-card {
            position: relative;
            overflow: hidden;
            padding: 24px;
            border-color: rgba(148, 163, 184, .13);
            border-radius: 16px;
            background: linear-gradient(145deg, rgba(17, 27, 46, .96), rgba(12, 19, 33, .96));
            box-shadow: 0 12px 28px rgba(0, 0, 0, .12);
        }

        .menu-card:hover {
            transform: translateY(-4px);
            border-color: rgba(96, 165, 250, .4);
            box-shadow: 0 18px 34px rgba(0, 0, 0, .2);
        }

        .menu-card .icon {
            width: 54px;
            height: 54px;
            display: grid;
            place-items: center;
            border: 1px solid rgba(96, 165, 250, .16);
            border-radius: 16px;
            background: rgba(54, 133, 255, .1);
            font-size: 25px;
        }

        .menu-card h3 {
            font-size: 16px;
        }

        .menu-card p {
            min-height: 42px;
            font-size: 12px;
        }

        .menu-card a {
            transition: color .2s;
        }

        .menu-card a:hover {
            color: #93c5fd;
        }

        .success {
            border-radius: 12px;
        }

        a:focus-visible,
        button:focus-visible {
            outline: 2px solid #93c5fd;
            outline-offset: 3px;
        }

        @media (max-width: 700px) {
            .menu {
                grid-template-columns: 1fr;
            }

            .welcome h1 {
                font-size: 23px;
            }

            .navbar {
                padding: 0 20px;
            }

            .container {
                margin: 28px auto;
                padding: 0 18px;
            }

            .welcome {
                padding: 27px 22px;
            }

            .profile {
                padding: 22px;
            }

            .team-info {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }

        @media (max-width: 430px) {
            .navbar {
                min-height: 68px;
                padding: 0 15px;
            }

            .logo {
                font-size: 21px;
            }

            .home-link {
                display: none;
            }

            .logout button {
                padding: 9px 12px;
                font-size: 11px;
            }

            .registration {
                padding: 14px;
            }

            .team-card {
                padding: 18px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>

    @if (session('success'))
        <div class="success">
            ✓ {{ session('success') }}
        </div>
    @endif

    <nav class="navbar">
        <div class="logo">ARENA Z</div>
        <a href="{{ url('/') }}" class="home-link">Kembali ke Website</a>

        <form class="logout" action="{{ url('/logout') }}" method="POST">
            @csrf
            <button type="submit">LOGOUT</button>
        </form>
    </nav>

    <main class="container">

        <div class="welcome">
            <h1>Selamat Datang, <span>{{ auth()->user()->name }}</span>!</h1>
            <p>Pantau pendaftaran tim dan ikuti perjalanan turnamenmu di ARENA Z.</p>
        </div>

        <div class="profile">
            <h3>Informasi Akun</h3>
            <p>Nama: {{ auth()->user()->name }}</p>
            <p>Email: {{ auth()->user()->email }}</p>
            <p>Status Akun: Peserta</p>
        </div>

        <h2 class="section-title">Status Pendaftaran Tim</h2>

        <div class="registration">

            @forelse ($teams as $team)

                <div class="team-card">

                    <h3>{{ $team->team_name }}</h3>

                    <div class="team-info">
                        <p>Sekolah: {{ $team->school_name }}</p>
                        <p>Ketua Tim: {{ $team->leader_name }}</p>
                        <p>Email Ketua: {{ $team->leader_email }}</p>
                        <p>No. WhatsApp: {{ $team->leader_phone }}</p>
                        <p>Turnamen: {{ $team->tournament->name ?? '-' }}</p>
                    </div>

                    @if ($team->status == 'pending')
                        <span class="status pending">MENUNGGU PERSETUJUAN</span>
                    @elseif ($team->status == 'approved')
                        <span class="status approved">PENDAFTARAN DISETUJUI</span>
                    @elseif ($team->status == 'rejected')
                        <span class="status rejected">PENDAFTARAN DITOLAK</span>
                    @endif

                </div>

            @empty

                <p class="empty">
                    Kamu belum mendaftarkan tim ke turnamen ARENA Z.
                    Silakan daftarkan tim terlebih dahulu.
                </p>

                <a href="{{ url('/user/team-register') }}" class="register-link">
                    + Daftar Tim Sekarang
                </a>

            @endforelse

        </div>

        <h2 class="section-title">Menu Peserta</h2>

        <div class="menu">

            <div class="menu-card">
                <div class="icon">🏆</div>
                <h3>Turnamen</h3>
                <p>Lihat informasi turnamen Mobile Legends yang tersedia.</p>
                <a href="{{ url('/turnamen') }}">Lihat Turnamen →</a>
            </div>

            <div class="menu-card">
                <div class="icon">📅</div>
                <h3>Jadwal Pertandingan</h3>
                <p>Lihat jadwal pertandingan turnamen ARENA Z.</p>
                <a href="{{ url('/jadwal') }}">Lihat Jadwal →</a>
            </div>

            <div class="menu-card">
                <div class="icon">⚔️</div>
                <h3>Bracket Turnamen</h3>
                <p>Lihat bagan pertandingan dan perkembangan turnamen.</p>
                <a href="{{ url('/bracket') }}">Lihat Bracket →</a>
            </div>

        </div>

    </main>

</body>
</html>
