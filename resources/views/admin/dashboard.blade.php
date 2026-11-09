
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - ARENA Z</title>

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #070b16;
            color: #fff;
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #0c1222;
            border-right: 1px solid #1d2940;
            padding: 30px 20px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            z-index: 10;
        }

        .logo {
            font-family: 'Orbitron', sans-serif;
            font-size: 25px;
            font-weight: 800;
            color: #3685ff;
            margin-bottom: 45px;
            letter-spacing: 2px;
        }

        .logo span {
            color: #8b5cf6;
        }

        .menu-title {
            font-size: 10px;
            color: #64748b;
            letter-spacing: 2px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px 15px;
            margin-bottom: 8px;
            color: #9caac1;
            text-decoration: none;
            border-radius: 10px;
            font-size: 13px;
            transition: .3s;
        }

        .menu a i {
            width: 18px;
            text-align: center;
        }

        .menu a:hover,
        .menu a.active {
            background: linear-gradient(90deg, #1b3157, #14243f);
            color: #58a0ff;
        }

        .sidebar-bottom {
            margin-top: auto;
            border-top: 1px solid #253149;
            padding-top: 20px;
        }

        .sidebar-bottom a {
            display: block;
            color: #ff647c;
            text-decoration: none;
            font-size: 12px;
            padding: 10px 5px;
        }

        .sidebar-bottom a:last-child {
            color: #9caac1;
        }

        .main {
            flex: 1;
            margin-left: 250px;
            padding: 35px;
            min-width: 0;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
            gap: 20px;
        }

        .topbar h1 {
            font-size: 25px;
            font-weight: 700;
        }

        .topbar p {
            color: #8290a8;
            font-size: 12px;
            margin-top: 6px;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #111d33;
            border: 1px solid #253653;
            padding: 10px 15px;
            border-radius: 12px;
        }

        .admin-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #3685ff, #8b5cf6);
            border-radius: 10px;
            display: grid;
            place-items: center;
        }

        .admin-profile strong {
            font-size: 12px;
            display: block;
        }

        .admin-profile small {
            color: #8290a8;
            font-size: 10px;
        }

        .welcome {
            background: linear-gradient(115deg, #14294b, #182044, #281c4d);
            border: 1px solid #304875;
            padding: 28px;
            border-radius: 17px;
            margin-bottom: 25px;
            position: relative;
            overflow: hidden;
        }

        .welcome::after {
            content: '';
            position: absolute;
            width: 220px;
            height: 220px;
            background: #3685ff;
            opacity: .10;
            filter: blur(65px);
            border-radius: 50%;
            right: 30px;
            top: -100px;
        }

        .welcome h2 {
            font-size: 21px;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .welcome p {
            color: #aabbd6;
            font-size: 12px;
            position: relative;
            z-index: 1;
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 28px 0 17px;
        }

        .section-heading h2 {
            font-size: 16px;
        }

        .section-heading span {
            color: #8290a8;
            font-size: 11px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
        }

        .stat-card {
            display: block;
            background: #101a2d;
            border: 1px solid #1e2d48;
            padding: 20px;
            border-radius: 14px;
            transition: .3s;
            color: #fff;
            text-decoration: none;
            min-width: 0;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            border-color: #3685ff;
        }

        .stat-card.pending-card:hover {
            border-color: #fb923c;
            background: #191f2c;
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 5px;
        }

        .stat-top p {
            color: #8795ad;
            font-size: 10px;
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 11px;
            display: grid;
            place-items: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .blue { background: #17345e; color: #58a0ff; }
        .purple { background: #30214e; color: #b18aff; }
        .green { background: #153b34; color: #4ade80; }
        .orange { background: #46301d; color: #fb923c; }

        .stat-card h3 {
            font-size: 27px;
            margin-top: 17px;
            font-weight: 700;
        }

        .stat-card small {
            color: #64748b;
            font-size: 9px;
        }

        .pending-card small {
            color: #fb923c;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 20px;
            margin-top: 25px;
        }

        .panel {
            background: #101a2d;
            border: 1px solid #1e2d48;
            padding: 23px;
            border-radius: 15px;
            min-width: 0;
        }

        .panel h2 {
            font-size: 15px;
            margin-bottom: 20px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 420px;
        }

        th, td {
            text-align: left;
            padding: 13px 10px;
            border-bottom: 1px solid #253149;
            font-size: 11px;
        }

        th {
            color: #8290a8;
            font-weight: 500;
        }

        td {
            color: #d3dbea;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 9px;
            background: #3b3016;
            color: #fbbf24;
        }

        .status.finished,
        .status.approved {
            background: #153b34;
            color: #4ade80;
        }

        .status.live,
        .status.rejected {
            background: #451c2a;
            color: #fb7185;
        }

        .empty {
            text-align: center;
            color: #64748b;
            padding: 25px 10px;
            font-size: 11px;
        }

        .quick-menu {
            display: grid;
            gap: 12px;
        }

        .quick-menu a {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 14px;
            border: 1px solid #253653;
            background: #131f34;
            border-radius: 11px;
            text-decoration: none;
            color: white;
            transition: .3s;
        }

        .quick-menu a:hover {
            border-color: #3685ff;
            background: #182b49;
        }

        .quick-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #1b3157;
            color: #58a0ff;
            display: grid;
            place-items: center;
        }

        .quick-menu strong {
            display: block;
            font-size: 11px;
        }

        .quick-menu small {
            display: block;
            color: #8290a8;
            font-size: 9px;
            margin-top: 3px;
        }

        .footer {
            color: #53617a;
            font-size: 10px;
            text-align: center;
            margin-top: 30px;
        }

        @media(max-width: 1250px) {
            .stats {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media(max-width: 1100px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media(max-width: 700px) {
            body {
                display: block;
            }

            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
                padding: 20px;
            }

            .logo {
                margin-bottom: 20px;
            }

            .menu {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 5px;
            }

            .menu a {
                margin: 0;
            }

            .sidebar-bottom {
                margin-top: 15px;
            }

            .main {
                margin-left: 0;
                padding: 20px;
            }

            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .stats {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-card h3 {
                font-size: 23px;
            }

            .welcome {
                padding: 22px;
            }
        }

        body {
            background:
                radial-gradient(ellipse at 82% 0, rgba(54, 133, 255, .09), transparent 30%),
                #070b16;
        }

        .sidebar {
            width: 265px;
            padding: 28px 21px;
            background: linear-gradient(180deg, #0d1629, #0a101e 78%);
            border-right-color: rgba(148, 163, 184, .12);
        }

        .logo {
            font-size: 24px;
            letter-spacing: 2.5px;
            text-shadow: 0 0 24px rgba(54, 133, 255, .2);
        }

        .menu-title {
            letter-spacing: 2.2px;
        }

        .menu a {
            padding: 13px 14px;
            border: 1px solid transparent;
            transition: background .2s, border-color .2s, color .2s, transform .2s;
        }

        .menu a:hover {
            transform: translateX(3px);
            background: rgba(54, 133, 255, .08);
        }

        .menu a.active {
            border-color: rgba(96, 165, 250, .16);
            background: linear-gradient(100deg, rgba(54, 133, 255, .2), rgba(54, 133, 255, .06));
            color: #83b5ff;
        }

        .sidebar-bottom {
            border-top-color: rgba(148, 163, 184, .12);
        }

        .sidebar-bottom button,
        .sidebar-bottom a {
            transition: color .2s;
        }

        .sidebar-bottom button:hover,
        .sidebar-bottom a:hover {
            color: #fff !important;
        }

        .main {
            margin-left: 265px;
            padding: clamp(24px, 3.2vw, 44px);
        }

        .topbar {
            margin-bottom: 28px;
        }

        .topbar h1 {
            font-size: clamp(23px, 2.3vw, 29px);
            letter-spacing: -.7px;
        }

        .topbar p {
            font-size: 13px;
        }

        .admin-profile {
            border-color: rgba(148, 163, 184, .15);
            border-radius: 14px;
            background: linear-gradient(135deg, rgba(19, 31, 52, .94), rgba(14, 23, 40, .94));
            box-shadow: 0 12px 30px rgba(0, 0, 0, .14);
        }

        .admin-icon {
            border-radius: 12px;
            box-shadow: 0 7px 20px rgba(54, 133, 255, .22);
        }

        .welcome {
            padding: 30px;
            border-color: rgba(96, 165, 250, .24);
            border-radius: 20px;
            background:
                radial-gradient(ellipse at 88% 16%, rgba(139, 92, 246, .23), transparent 35%),
                linear-gradient(115deg, #14294b, #121d39 70%, #1a1740);
            box-shadow: 0 20px 55px rgba(0, 0, 0, .2);
        }

        .welcome::before {
            content: 'ADMIN CONTROL CENTER';
            position: relative;
            display: block;
            margin-bottom: 10px;
            color: #83b5ff;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 2.3px;
        }

        .welcome h2 {
            font-size: clamp(22px, 2.4vw, 28px);
            letter-spacing: -.6px;
        }

        .welcome p {
            font-size: 13px;
        }

        .section-heading {
            margin: 30px 0 17px;
        }

        .section-heading h2 {
            font-size: 17px;
        }

        .stats {
            gap: 14px;
        }

        .stat-card {
            position: relative;
            overflow: hidden;
            padding: 19px;
            border-color: rgba(148, 163, 184, .13);
            border-radius: 16px;
            background: linear-gradient(145deg, rgba(17, 27, 46, .96), rgba(12, 19, 33, .96));
            box-shadow: 0 12px 28px rgba(0, 0, 0, .12);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            border-color: rgba(96, 165, 250, .44);
            box-shadow: 0 18px 34px rgba(0, 0, 0, .2);
        }

        .stat-card.pending-card:hover {
            border-color: rgba(251, 146, 60, .6);
            background: linear-gradient(145deg, #201b22, #151924);
        }

        .stat-top p {
            font-size: 11px;
        }

        .stat-icon {
            border: 1px solid rgba(255, 255, 255, .05);
            border-radius: 12px;
        }

        .stat-card h3 {
            margin-top: 15px;
            font-size: 30px;
            letter-spacing: -.8px;
        }

        .stat-card small {
            font-size: 10px;
        }

        .content-grid {
            gap: 18px;
            margin-top: 22px;
        }

        .panel {
            padding: 22px;
            border-color: rgba(148, 163, 184, .13);
            border-radius: 17px;
            background: linear-gradient(145deg, rgba(16, 26, 45, .96), rgba(12, 19, 33, .96));
            box-shadow: 0 14px 35px rgba(0, 0, 0, .12);
        }

        .panel h2 {
            font-size: 15px;
        }

        .panel h2 i {
            margin-right: 7px;
            color: #60a5fa;
        }

        th, td {
            padding: 14px 10px;
            border-bottom-color: rgba(148, 163, 184, .12);
            font-size: 12px;
        }

        tbody tr:last-child td {
            border-bottom: 0;
        }

        .status {
            padding: 6px 10px;
            font-size: 10px;
            font-weight: 600;
        }

        .quick-menu a {
            padding: 13px;
            border-color: rgba(148, 163, 184, .12);
            background: rgba(19, 31, 52, .7);
            transition: transform .2s, border-color .2s, background .2s;
        }

        .quick-menu a:hover {
            transform: translateY(-2px);
            border-color: rgba(96, 165, 250, .38);
            background: rgba(24, 43, 73, .85);
        }

        .quick-icon {
            border-radius: 12px;
        }

        .footer {
            margin-bottom: 10px;
            font-size: 11px;
        }

        a:focus-visible,
        button:focus-visible {
            outline: 2px solid #93c5fd;
            outline-offset: 3px;
        }

        @media (max-width: 700px) {
            .sidebar {
                width: 100%;
                padding: 20px;
            }

            .main {
                margin-left: 0;
                padding: 22px 18px;
            }

            .topbar {
                gap: 14px;
            }

            .admin-profile {
                padding: 8px 11px;
            }

            .welcome {
                padding: 25px 22px;
            }

            .panel {
                padding: 18px;
            }
        }

        @media (max-width: 420px) {
            .stats {
                grid-template-columns: 1fr;
            }

            .stat-card h3 {
                font-size: 26px;
            }
        }
    </style>
</head>

<body>

    <aside class="sidebar">
        <div class="logo">ARENA <span>Z</span></div>

        <p class="menu-title">MENU UTAMA</p>

        <div class="menu">
            <a href="{{ url('/admin/dashboard') }}" class="active">
                <i class="fas fa-chart-pie"></i> Dashboard
            </a>

            <a href="{{ url('/turnamen') }}">
                <i class="fas fa-trophy"></i> Turnamen
            </a>

            <a href="{{ url('/jadwal') }}">
                <i class="fas fa-calendar-days"></i> Jadwal
            </a>

            <a href="{{ url('/bracket') }}">
                <i class="fas fa-diagram-project"></i> Bracket
            </a>

            <a href="{{ url('/admin/teams') }}">
                <i class="fas fa-users"></i> Kelola Tim
            </a>
        </div>

        <div class="sidebar-bottom">
            <form action="{{ url('/logout') }}" method="POST">
                @csrf
                <button type="submit" style="background:none;border:none;color:#ff647c;font-size:12px;padding:10px 5px;cursor:pointer;font-family:inherit;">
                    <i class="fas fa-right-from-bracket"></i> Logout Admin
                </button>
            </form>

            <a href="{{ url('/') }}">
                <i class="fas fa-arrow-left"></i> Kembali ke Website
            </a>
        </div>
    </aside>

    <main class="main">

        <div class="topbar">
            <div>
                <h1>Dashboard Admin</h1>
                <p>Kelola seluruh aktivitas turnamen ARENA Z dari sini.</p>
            </div>

            <div class="admin-profile">
                <div class="admin-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div>
                    <strong>{{ auth()->user()->name }}</strong>
                    <small>Administrator</small>
                </div>
            </div>
        </div>

        <section class="welcome">
            <h2>Selamat datang, {{ auth()->user()->name }}!</h2>
            <p>Siap mengelola kompetisi Mobile Legends pelajar hari ini?</p>
        </section>

        <div class="section-heading">
            <h2>Ringkasan Statistik</h2>
            <span>Data dari database ARENA Z</span>
        </div>

        <div class="stats">

            <div class="stat-card">
                <div class="stat-top">
                    <p>Total Turnamen</p>
                    <div class="stat-icon blue">
                        <i class="fas fa-trophy"></i>
                    </div>
                </div>
                <h3>{{ $totalTournaments }}</h3>
                <small>Turnamen terdaftar</small>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <p>Total Tim</p>
                    <div class="stat-icon purple">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <h3>{{ $totalTeams }}</h3>
                <small>Tim yang mendaftar</small>
            </div>

            <!-- KARTU PENDAFTARAN PENDING -->
            <a href="{{ url('/admin/teams') }}" class="stat-card pending-card">
                <div class="stat-top">
                    <p>Pendaftaran Pending</p>
                    <div class="stat-icon orange">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <h3>{{ $totalPendingTeams }}</h3>
                <small>Menunggu persetujuan admin →</small>
            </a>

            <div class="stat-card">
                <div class="stat-top">
                    <p>Total Pertandingan</p>
                    <div class="stat-icon green">
                        <i class="fas fa-gamepad"></i>
                    </div>
                </div>
                <h3>{{ $totalMatches }}</h3>
                <small>Jadwal pertandingan</small>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <p>Turnamen Aktif</p>
                    <div class="stat-icon blue">
                        <i class="fas fa-bolt"></i>
                    </div>
                </div>
                <h3>{{ $totalActiveTournaments }}</h3>
                <small>Status aktif</small>
            </div>

        </div>

        <div class="content-grid">

            <section class="panel">
                <h2><i class="fas fa-calendar-check"></i> Pertandingan Terbaru</h2>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Babak</th>
                                <th>Tim</th>
                                <th>Skor</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($recentMatches as $match)
                                <tr>
                                    <td>{{ $match->round }}</td>
                                    <td>
                                        {{ $match->teamA?->team_name ?? 'TBD' }}
                                        <br>
                                        <small style="color:#64748b;">vs</small>
                                        <br>
                                        {{ $match->teamB?->team_name ?? 'TBD' }}
                                    </td>
                                    <td>{{ $match->result ?? '-' }}</td>
                                    <td>
                                        <span class="status {{ $match->status }}">
                                            {{ ucfirst($match->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="empty">
                                        Belum ada pertandingan yang dibuat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="panel">
                <h2><i class="fas fa-bolt"></i> Akses Cepat</h2>

                <div class="quick-menu">
                    <a href="{{ url('/turnamen') }}">
                        <div class="quick-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div>
                            <strong>Kelola Turnamen</strong>
                            <small>Lihat informasi turnamen</small>
                        </div>
                    </a>

                    <a href="{{ url('/admin/teams') }}">
                        <div class="quick-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <strong>Kelola Tim</strong>
                            <small>Periksa dan setujui pendaftaran</small>
                        </div>
                    </a>

                    <a href="{{ url('/admin/schedules') }}">
                        <div class="quick-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div>
                            <strong>Kelola Jadwal</strong>
                            <small>Atur pertandingan</small>
                        </div>
                    </a>

                    <a href="{{ url('/bracket') }}">
                        <div class="quick-icon">
                            <i class="fas fa-diagram-project"></i>
                        </div>
                        <div>
                            <strong>Lihat Bracket</strong>
                            <small>Pantau perjalanan turnamen</small>
                        </div>
                    </a>
                </div>
            </section>

        </div>

        <section class="panel" style="margin-top:22px;">
            <h2><i class="fas fa-medal"></i> Daftar Turnamen</h2>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Turnamen</th>
                            <th>Game</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($tournaments as $tournament)
                            <tr>
                                <td>{{ $tournament->name }}</td>
                                <td>{{ $tournament->game }}</td>
                                <td>
                                    {{ $tournament->tournament_date
                                        ? \Carbon\Carbon::parse($tournament->tournament_date)->format('d M Y')
                                        : '-' }}
                                </td>
                                <td>
                                    <span class="status {{ $tournament->status }}">
                                        {{ ucfirst($tournament->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty">
                                    Belum ada turnamen terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <div class="footer">
            © 2026 ARENA Z — Student Esports Management System
        </div>

    </main>

</body>
</html>
