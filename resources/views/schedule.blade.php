
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match Center - ARENA Z</title>

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --blue: #3685ff;
            --purple: #8b5cf6;
            --muted: #9ba8c7;
            --panel: #111a2c;
            --border: #253552;
        }

        body {
            background: #070b16;
            color: white;
            font-family: 'Poppins', sans-serif;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        header {
            padding: 18px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(13,20,37,.96);
            border-bottom: 1px solid #1d2a43;
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(12px);
        }

        .logo {
            font-family: 'Orbitron', sans-serif;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .logo span {
            color: var(--blue);
        }

        nav {
            display: flex;
            gap: 28px;
        }

        nav a {
            color: #aab6ce;
            font-size: 12px;
            transition: .3s;
        }

        nav a:hover,
        nav a.active {
            color: var(--blue);
        }

        .back-button {
            padding: 10px 17px;
            border: 1px solid #3685ff;
            border-radius: 7px;
            color: #75adff;
            font-size: 11px;
            font-weight: 600;
            transition: .3s;
        }

        .back-button:hover {
            background: var(--blue);
            color: white;
        }

        .hero {
            position: relative;
            padding: 75px 7% 65px;
            background:
                radial-gradient(ellipse at 50% 0%, rgba(54,133,255,.22), transparent 65%),
                linear-gradient(180deg, #0c1428, #070b16);
            text-align: center;
            overflow: hidden;
        }

        .hero::before {
            content: "MATCH";
            position: absolute;
            font-family: 'Orbitron', sans-serif;
            font-size: 150px;
            font-weight: 800;
            color: rgba(255,255,255,.018);
            left: 50%;
            top: 20px;
            transform: translateX(-50%);
            white-space: nowrap;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .eyebrow {
            color: #6daaff;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 4px;
        }

        .hero h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: clamp(30px, 5vw, 46px);
            margin: 17px 0;
        }

        .hero h1 span {
            color: var(--blue);
        }

        .hero p {
            color: var(--muted);
            font-size: 12px;
        }

        .container {
            max-width: 1250px;
            margin: auto;
            padding: 45px 25px 90px;
        }

        .overview {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 45px;
        }

        .overview-card {
            background: linear-gradient(135deg, #142344, #101729);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px 23px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .overview-icon {
            width: 45px;
            height: 45px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            background: rgba(54,133,255,.15);
            color: #7db2ff;
            font-size: 20px;
        }

        .overview-card small {
            color: var(--muted);
            font-size: 10px;
        }

        .overview-card h3 {
            font-family: 'Orbitron', sans-serif;
            font-size: 14px;
            margin-top: 4px;
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 15px;
            margin-bottom: 23px;
        }

        .section-heading h2 {
            font-family: 'Orbitron', sans-serif;
            font-size: 21px;
            margin-top: 9px;
        }

        .section-heading p {
            color: var(--muted);
            font-size: 11px;
            margin-top: 7px;
        }

        .match-card {
            position: relative;
            background: linear-gradient(145deg, #131f36, #0c1424);
            border: 1px solid #253552;
            border-radius: 14px;
            padding: 25px;
            margin-bottom: 17px;
            overflow: hidden;
            transition: .3s;
        }

        .match-card:hover {
            border-color: var(--blue);
            transform: translateY(-3px);
            box-shadow: 0 10px 35px rgba(0,0,0,.2);
        }

        .match-card.live-card {
            border-color: rgba(46,204,113,.45);
            background: linear-gradient(145deg, #132b2a, #0c1724);
        }

        .match-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
        }

        .match-info small {
            display: block;
            color: var(--muted);
            font-size: 10px;
            margin-bottom: 5px;
        }

        .match-info strong {
            font-size: 12px;
        }

        .match-status {
            padding: 7px 13px;
            border-radius: 30px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1px;
            background: rgba(54,133,255,.15);
            color: #83b5ff;
            white-space: nowrap;
        }

        .match-status.live {
            background: rgba(46,204,113,.13);
            color: #5ee4a0;
        }

        .match-status.finished {
            background: rgba(255,255,255,.08);
            color: #aab5cb;
        }

        .match-content {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 15px;
            text-align: center;
        }

        .team-logo {
            width: 62px;
            height: 62px;
            margin: 0 auto 12px;
            display: grid;
            place-items: center;
            border-radius: 15px;
            background: linear-gradient(135deg, #1b4b91, #192344);
            border: 1px solid rgba(91,153,255,.3);
            color: #a6cbff;
            font-family: 'Orbitron', sans-serif;
            font-size: 17px;
            font-weight: 800;
        }

        .team h3 {
            font-size: 15px;
            margin-bottom: 5px;
        }

        .team p {
            color: var(--muted);
            font-size: 10px;
        }

        .vs {
            font-family: 'Orbitron', sans-serif;
            font-size: 21px;
            font-weight: 800;
            color: var(--blue);
            text-shadow: 0 0 18px rgba(54,133,255,.5);
        }

        .match-time {
            margin-top: 27px;
            padding-top: 18px;
            border-top: 1px solid rgba(255,255,255,.08);
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .match-time p {
            color: var(--muted);
            font-size: 10px;
        }

        .match-time strong {
            color: white;
            margin-left: 5px;
        }

        .result {
            margin-top: 15px;
            padding: 12px 15px;
            background: rgba(54,133,255,.08);
            border: 1px solid rgba(54,133,255,.2);
            border-radius: 8px;
            font-size: 11px;
        }

        .result span {
            color: #82b6ff;
            font-weight: 700;
            margin-right: 8px;
        }

        .empty {
            text-align: center;
            padding: 65px 20px;
            background: linear-gradient(145deg, #111a2c, #0c1323);
            border: 1px dashed #304361;
            border-radius: 14px;
        }

        .empty-icon {
            width: 65px;
            height: 65px;
            display: grid;
            place-items: center;
            margin: 0 auto 18px;
            border-radius: 18px;
            background: rgba(54,133,255,.12);
            font-size: 27px;
        }

        .empty h3 {
            font-family: 'Orbitron', sans-serif;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .empty p {
            color: var(--muted);
            font-size: 11px;
            line-height: 1.8;
        }

        .notice {
            margin-top: 35px;
            padding: 23px;
            background: #0e1729;
            border: 1px solid var(--border);
            border-radius: 12px;
        }

        .notice h3 {
            font-family: 'Orbitron', sans-serif;
            font-size: 13px;
            margin-bottom: 9px;
        }

        .notice p {
            color: var(--muted);
            font-size: 11px;
            line-height: 1.8;
        }

        footer {
            padding: 25px;
            text-align: center;
            background: #0d1425;
            border-top: 1px solid #1d2a43;
            color: #7e8ba8;
            font-size: 10px;
        }

        @media(max-width: 700px) {
            header {
                padding: 17px 5%;
                flex-wrap: wrap;
                gap: 15px;
            }

            .logo {
                font-size: 20px;
            }

            nav {
                order: 3;
                width: 100%;
                justify-content: center;
                gap: 20px;
            }

            .back-button {
                font-size: 10px;
                padding: 8px 11px;
            }

            .container {
                padding: 35px 5% 65px;
            }

            .overview {
                grid-template-columns: 1fr;
            }

            .match-card {
                padding: 19px;
            }

            .team-logo {
                width: 48px;
                height: 48px;
                font-size: 13px;
            }

            .team h3 {
                font-size: 12px;
                overflow-wrap: anywhere;
            }

            .vs {
                font-size: 15px;
            }

            .hero {
                padding: 60px 5%;
            }

            .hero::before {
                font-size: 90px;
            }
        }

        @media(max-width: 400px) {
            .match-top {
                align-items: flex-start;
            }

            .match-time {
                flex-direction: column;
            }

            .team p {
                font-size: 9px;
            }
        }
    </style>
</head>

<body>

<header>
    <a href="{{ url('/') }}" class="logo">ARENA<span>Z.</span></a>

    <nav>
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ url('/turnamen') }}">Turnamen</a>
        <a href="{{ url('/jadwal') }}" class="active">Jadwal</a>
    </nav>

    <a href="{{ url('/') }}" class="back-button">← Kembali</a>
</header>

<section class="hero">
    <div class="hero-content">
        <div class="eyebrow">ARENA Z • STUDENT ESPORTS</div>
        <h1>MATCH <span>CENTER.</span></h1>
        <p>Pantau jadwal pertandingan dan hasil kompetisi Mobile Legends.</p>
    </div>
</section>

<main class="container">

    <div class="overview">
        <div class="overview-card">
            <div class="overview-icon">⚔</div>
            <div>
                <small>COMPETITION</small>
                <h3>MOBILE LEGENDS</h3>
            </div>
        </div>

        <div class="overview-card">
            <div class="overview-icon">🏆</div>
            <div>
                <small>TOURNAMENT FORMAT</small>
                <h3>TEAM 5 VS 5</h3>
            </div>
        </div>
    </div>

    <div class="section-heading">
        <div>
            <div class="eyebrow">MATCH INFORMATION</div>
            <h2>JADWAL PERTANDINGAN</h2>
            <p>Daftar pertandingan resmi ARENA Z.</p>
        </div>
    </div>

    @forelse ($schedules as $schedule)

        <div class="match-card {{ $schedule->status === 'live' ? 'live-card' : '' }}">

            <div class="match-top">
                <div class="match-info">
                    <small>
                        {{ $schedule->tournament->name ?? 'ARENA Z TOURNAMENT' }}
                    </small>
                    <strong>{{ $schedule->round ?? 'MATCH' }}</strong>
                </div>

                <span class="match-status {{ $schedule->status }}">
                    @if ($schedule->status === 'live')
                        ● LIVE
                    @elseif ($schedule->status === 'finished')
                        FINISHED
                    @else
                        UPCOMING
                    @endif
                </span>
            </div>

            <div class="match-content">

                <div class="team">
                    <div class="team-logo">
                        {{ strtoupper(substr($schedule->teamA->team_name ?? 'A', 0, 2)) }}
                    </div>
                    <h3>{{ $schedule->teamA->team_name ?? 'Tim A' }}</h3>
                    <p>TEAM A</p>
                </div>

                <div class="vs">VS</div>

                <div class="team">
                    <div class="team-logo">
                        {{ strtoupper(substr($schedule->teamB->team_name ?? 'B', 0, 2)) }}
                    </div>
                    <h3>{{ $schedule->teamB->team_name ?? 'Tim B' }}</h3>
                    <p>TEAM B</p>
                </div>

            </div>

            <div class="match-time">
                <p>
                    📅 Tanggal:
                    <strong>
                        {{ $schedule->match_date
                            ? \Carbon\Carbon::parse($schedule->match_date)->format('d M Y')
                            : 'Menunggu Jadwal' }}
                    </strong>
                </p>

                <p>
                    🕒 Waktu:
                    <strong>
                        {{ $schedule->match_time
                            ? substr($schedule->match_time, 0, 5) . ' WIB'
                            : 'Belum Ditentukan' }}
                    </strong>
                </p>
            </div>

            @if ($schedule->result)
                <div class="result">
                    <span>HASIL PERTANDINGAN</span>
                    {{ $schedule->result }}
                </div>
            @endif

        </div>

    @empty

        <div class="empty">
            <div class="empty-icon">⚔</div>
            <h3>NO MATCH SCHEDULE</h3>
            <p>
                Belum ada jadwal pertandingan yang tersedia.<br>
                Jadwal akan ditampilkan setelah admin menambahkannya.
            </p>
        </div>

    @endforelse

    <div class="notice">
        <h3>INFORMASI PERTANDINGAN</h3>
        <p>
            Seluruh jadwal dan hasil pertandingan dikelola oleh administrator
            ARENA Z. Peserta diharapkan memperhatikan informasi pertandingan
            yang telah tersedia.
        </p>
    </div>

</main>

<footer>
    © {{ date('Y') }} ARENA Z — STUDENT ESPORTS PLATFORM.
</footer>

</body>
</html>
     