
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bracket Turnamen - ARENA Z</title>

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
        }

        body {
            background: #070b16;
            color: white;
            font-family: 'Poppins', sans-serif;
        }

        header {
            padding: 22px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #0d1425;
            border-bottom: 1px solid #1d2a43;
        }

        .logo {
            font-family: 'Orbitron', sans-serif;
            font-size: 25px;
            font-weight: 800;
        }

        .logo span {
            color: var(--blue);
        }

        nav {
            display: flex;
            gap: 25px;
        }

        nav a {
            color: #c5cde0;
            text-decoration: none;
            font-size: 13px;
        }

        nav a:hover,
        nav a.active {
            color: var(--blue);
        }

        .back-button {
            background: rgba(54,133,255,.12);
            color: var(--blue);
            padding: 11px 20px;
            border: 1px solid var(--blue);
            border-radius: 8px;
            text-decoration: none;
            font-size: 12px;
            transition: .3s;
        }

        .back-button:hover {
            background: var(--blue);
            color: white;
        }

        .hero {
            text-align: center;
            padding: 75px 8% 55px;
            background: radial-gradient(ellipse at center, rgba(54,133,255,.18), transparent 60%);
        }

        .hero small {
            color: var(--blue);
            letter-spacing: 4px;
            font-size: 11px;
        }

        .hero h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: clamp(30px, 5vw, 45px);
            margin: 18px 0;
        }

        .hero h1 span {
            color: var(--blue);
        }

        .hero p {
            color: var(--muted);
            font-size: 13px;
        }

        .container {
            padding: 30px 8% 100px;
        }

        .section-title {
            margin-bottom: 30px;
        }

        .section-title small {
            color: var(--blue);
            letter-spacing: 3px;
            font-size: 10px;
        }

        .section-title h2 {
            font-family: 'Orbitron', sans-serif;
            font-size: 23px;
            margin-top: 10px;
        }

        .tournament-info {
            background: linear-gradient(145deg, #121d34, #0c1323);
            border: 1px solid #253552;
            border-radius: 14px;
            padding: 22px;
            margin-bottom: 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .tournament-info h3 {
            font-family: 'Orbitron', sans-serif;
            font-size: 17px;
        }

        .tournament-info p {
            color: var(--muted);
            font-size: 12px;
            margin-top: 7px;
        }

        .status {
            background: rgba(54,133,255,.15);
            color: #83b5ff;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 10px;
        }

        .bracket-section {
            margin-top: 45px;
        }

        .bracket-heading {
            margin-bottom: 20px;
        }

        .bracket-heading h2 {
            font-family: 'Orbitron', sans-serif;
            font-size: 19px;
            color: var(--blue);
        }

        .bracket-heading p {
            color: var(--muted);
            font-size: 12px;
            margin-top: 7px;
        }

        .bracket-wrapper {
            display: contents;
        }

        .bracket {
            display: contents;
        }

        .bracket-board {
            position: relative;
            display: grid;
            grid-template-columns: 230px 46px 230px 46px 230px;
            grid-template-rows: 370px 370px;
            column-gap: 12px;
            width: 100%;
            min-width: 0;
            overflow-x: auto;
            padding: 14px;
            border: 1px solid rgba(148, 163, 184, .12);
            border-radius: 18px;
            background:
                radial-gradient(ellipse at 40% 15%, rgba(54, 133, 255, .08), transparent 50%),
                linear-gradient(145deg, rgba(13, 22, 39, .96), rgba(9, 15, 28, .96));
        }

        .bracket-section {
            display: contents;
        }

        .bracket-heading {
            display: none;
        }

        .round {
            position: relative;
            z-index: 2;
            min-width: 0;
            height: 370px;
        }

        .upper-semi {
            grid-area: 1 / 1;
        }

        .upper-connector {
            grid-area: 1 / 2;
        }

        .upper-final {
            grid-area: 1 / 3;
        }

        .lower-round {
            grid-area: 2 / 1;
        }

        .lower-connector {
            grid-area: 2 / 2;
        }

        .lower-final {
            grid-area: 2 / 3;
        }

        .upper-semi h3::before,
        .upper-final h3::before {
            content: "UPPER BRACKET";
            color: #83b5ff;
        }

        .lower-round h3::before,
        .lower-final h3::before {
            content: "LOWER BRACKET";
            color: #b69aff;
        }

        .grand-final h3::before {
            content: "UPPER + LOWER BRACKET";
            color: #b69aff;
        }

        .upper-semi h3::before,
        .upper-final h3::before,
        .lower-round h3::before,
        .lower-final h3::before,
        .grand-final h3::before {
            display: block;
            margin-bottom: 4px;
            font-family: 'Poppins', sans-serif;
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 1.5px;
        }

        .upper-connector {
            grid-area: 1 / 2;
        }

        .upper-final-connector {
            grid-area: 1 / 4;
        }

        .lower-connector {
            grid-area: 2 / 2;
        }

        .lower-final-connector {
            grid-area: 2 / 4;
        }

        .lower-finalist {
            display: none;
        }

        .grand-final {
            grid-area: 1 / 5 / 3 / 6;
            height: 740px;
        }

        .round h3 {
            height: 42px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
            text-align: center;
            font-family: 'Orbitron', sans-serif;
            font-size: 13px;
            color: var(--blue);
            line-height: 1.3;
            margin: 0;
        }

        .round-matches {
            display: grid;
            grid-template-rows: repeat(var(--match-count, 2), minmax(0, 1fr));
            height: 320px;
        }

        .round-matches.single-match-list {
            height: 320px;
            grid-template-rows: 1fr;
        }

        .round-matches .match {
            align-self: center;
        }

        .bracket-connector {
            position: relative;
            z-index: 1;
            height: 320px;
            margin-top: 42px;
            color: rgba(96, 165, 250, .55);
        }

        .bracket-connector span {
            position: absolute;
            display: block;
        }

        .connector-trunk {
            top: 25%;
            bottom: 25%;
            left: -12px;
            border-left: 2px solid currentColor;
        }

        .connector-top,
        .connector-bottom,
        .connector-exit {
            height: 0;
            border-top: 2px solid currentColor;
        }

        .connector-top {
            top: 25%;
            left: -12px;
            width: calc(50% + 12px);
        }

        .connector-bottom {
            bottom: 25%;
            left: -12px;
            width: calc(50% + 12px);
        }

        .connector-exit {
            top: 50%;
            left: -12px;
            width: calc(100% + 24px);
        }

        .connector-single .connector-trunk,
        .connector-single .connector-top,
        .connector-single .connector-bottom {
            display: none;
        }

        .lower-connector {
            color: rgba(167, 139, 250, .58);
        }

        .lower-round h3,
        .lower-final h3 {
            color: #b69aff;
        }

        .match {
            position: relative;
            z-index: 1;
            background: linear-gradient(145deg, #17243b, #0e1729);
            border: 1px solid rgba(96, 165, 250, .2);
            border-radius: 12px;
            padding: 14px;
            box-shadow: 0 10px 24px rgba(0, 0, 0, .2);
            transition: .3s;
        }

        .match:hover {
            border-color: var(--blue);
            transform: translateY(-3px);
        }

        .match-label {
            color: var(--muted);
            font-size: 9px;
            margin-bottom: 12px;
            display: block;
        }

        .team {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            padding: 9px 0;
            font-size: 12px;
        }

        .team:first-of-type {
            border-bottom: 1px solid #253552;
        }

        .team span:first-child {
            overflow-wrap: anywhere;
        }

        .team span:last-child {
            color: #83b5ff;
            font-weight: 700;
        }

        .team.winner {
            color: #5ee4a0;
        }

        .team.winner span:last-child {
            color: #5ee4a0;
        }

        .empty-match {
            color: var(--muted);
            font-size: 12px;
            text-align: center;
            padding: 20px 10px;
        }

        .lower .round h3 {
            color: var(--purple);
        }

        .lower-round .match,
        .lower-final .match {
            border-color: rgba(167, 139, 250, .25);
        }

        .lower-round .match-label,
        .lower-final .match-label {
            color: #b69aff;
        }

        .final-match {
            border-color: rgba(167, 139, 250, .56);
            background: linear-gradient(145deg, #211d40, #14172e);
            box-shadow: 0 0 24px rgba(139,92,246,.13);
        }

        .final-match .match-label {
            color: #b69aff;
        }

        .grand-final-bridge {
            position: absolute;
            z-index: 0;
            top: -1px;
            left: -1px;
            width: 860px;
            height: 770px;
            pointer-events: none;
        }

        .grand-final-bridge path {
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .upper-final-path {
            stroke: rgba(96, 165, 250, .72);
        }

        .lower-final-path {
            stroke: rgba(167, 139, 250, .78);
        }

        .grand-final > h3 {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
        }

        .grand-final .round-matches {
            position: absolute;
            top: 50%;
            right: 0;
            left: 0;
            height: auto;
            transform: translateY(-50%);
        }

        .grand-final .match {
            width: 100%;
        }

        .champion {
            margin-top: 40px;
            padding: 30px;
            text-align: center;
            background: linear-gradient(145deg, #171d39, #0d1425);
            border: 1px solid var(--purple);
            border-radius: 14px;
        }

        .champion .trophy {
            font-size: 35px;
            margin-bottom: 12px;
        }

        .champion small {
            color: #b69aff;
            letter-spacing: 3px;
            font-size: 10px;
        }

        .champion h2 {
            font-family: 'Orbitron', sans-serif;
            margin-top: 12px;
            font-size: 21px;
        }

        .champion p {
            color: var(--muted);
            font-size: 12px;
            margin-top: 8px;
        }

        .notice {
            margin-top: 35px;
            padding: 22px;
            background: #0d1425;
            border: 1px solid #253552;
            border-radius: 12px;
        }

        .notice h3 {
            font-family: 'Orbitron', sans-serif;
            font-size: 15px;
            margin-bottom: 10px;
        }

        .notice p {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.8;
        }

        footer {
            padding: 30px 8%;
            text-align: center;
            background: #0d1425;
            border-top: 1px solid #1d2a43;
            color: #7e8ba8;
            font-size: 12px;
        }

        @media(max-width: 650px) {
            header {
                padding: 18px 5%;
                flex-wrap: wrap;
                gap: 15px;
            }

            nav {
                width: 100%;
                justify-content: center;
                gap: 15px;
            }

            .container {
                padding: 25px 5% 70px;
            }

            .tournament-info {
                padding: 18px;
            }

            .bracket {
                display: contents;
            }
        }
    </style>
</head>

<body>

@php
    $grandFinal = $schedules->firstWhere('round', 'Grand Final');
    $champion = $grandFinal?->winner;
    $tournamentName = $schedules->first()?->tournament?->name
        ?? 'ARENA Z MOBILE LEGENDS CHAMPIONSHIP';
@endphp

<header>
    <div class="logo">ARENA<span>Z.</span></div>

    <nav>
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ url('/turnamen') }}">Turnamen</a>
        <a href="{{ url('/jadwal') }}">Jadwal</a>
        <a href="{{ url('/bracket') }}" class="active">Bracket</a>
    </nav>

    <a href="{{ url('/') }}" class="back-button">
        ← Kembali ke Home
    </a>
</header>

<section class="hero">
    <small>ARENA Z TOURNAMENT CENTER</small>
    <h1>TOURNAMENT <span>BRACKET.</span></h1>
    <p>Lihat perjalanan setiap tim menuju juara ARENA Z.</p>
</section>

<main class="container">

    <div class="section-title">
        <small>COMPETITION BRACKET</small>
        <h2>BAGAN PERTANDINGAN</h2>
    </div>

    <div class="tournament-info">
        <div>
            <h3>{{ strtoupper($tournamentName) }}</h3>
            <p>Mobile Legends · Format 5 vs 5 · Playoffs</p>
        </div>
        <span class="status">PLAYOFFS</span>
    </div>

    <div class="bracket-board">
        <svg class="grand-final-bridge" viewBox="0 0 860 770" preserveAspectRatio="none" aria-hidden="true">
            <path class="upper-final-path" d="M 545 217 H 580 V 385 H 615"></path>
            <path class="lower-final-path" d="M 545 587 H 580 V 385 H 615"></path>
        </svg>

    <!-- UPPER BRACKET -->
    <section class="bracket-section upper-lane">

        <div class="bracket-heading">
            <h2>UPPER BRACKET</h2>
            <p>Jalur utama menuju Grand Final.</p>
        </div>

        <div class="bracket-wrapper">
            <div class="bracket">

                <!-- UPPER SEMI FINAL -->
                <div class="round upper-semi">
                    <h3>UPPER SEMI FINAL</h3>

                    <div class="round-matches">

                        @forelse($schedules->where('round', 'Upper Semi Final') as $schedule)

                            @php
                                $scores = preg_match(
                                    '/^(\d+)-(\d+)$/',
                                    trim($schedule->result ?? ''),
                                    $scoreParts
                                ) ? $scoreParts : [];

                                $scoreA = $scores[1] ?? '-';
                                $scoreB = $scores[2] ?? '-';
                                $winner = $schedule->winner;
                            @endphp

                            <div class="match">
                                <span class="match-label">
                                    MATCH {{ str_pad($schedule->id, 2, '0', STR_PAD_LEFT) }}
                                    · {{ strtoupper($schedule->status) }}
                                </span>

                                <div class="team {{ $winner && $schedule->teamA && $winner->id === $schedule->teamA->id ? 'winner' : '' }}">
                                    <span>{{ $schedule->teamA->team_name ?? 'Tim belum ditentukan' }}</span>
                                    <span>{{ $scoreA }}</span>
                                </div>

                                <div class="team {{ $winner && $schedule->teamB && $winner->id === $schedule->teamB->id ? 'winner' : '' }}">
                                    <span>{{ $schedule->teamB->team_name ?? 'Tim belum ditentukan' }}</span>
                                    <span>{{ $scoreB }}</span>
                                </div>
                            </div>

                        @empty

                            @for ($slot = 0; $slot < 2; $slot++)
                                <div class="match">
                                    <span class="match-label">SEMIFINAL {{ $slot + 1 }}</span>
                                    <div class="empty-match">Menunggu tim bertanding</div>
                                </div>
                            @endfor

                        @endforelse

                    </div>
                </div>

                <div class="bracket-connector upper-connector {{ $schedules->where('round', 'Upper Semi Final')->count() === 1 ? 'connector-single' : 'connector-pair' }}" aria-hidden="true">
                    <span class="connector-trunk"></span>
                    <span class="connector-top"></span>
                    <span class="connector-bottom"></span>
                    <span class="connector-exit"></span>
                </div>

                <!-- UPPER FINAL -->
                <div class="round upper-final">
                    <h3>UPPER FINAL</h3>

                    <div class="round-matches single-match-list">

                        @forelse($schedules->where('round', 'Upper Final') as $schedule)

                            @php
                                $scores = preg_match(
                                    '/^(\d+)-(\d+)$/',
                                    trim($schedule->result ?? ''),
                                    $scoreParts
                                ) ? $scoreParts : [];

                                $scoreA = $scores[1] ?? '-';
                                $scoreB = $scores[2] ?? '-';
                                $winner = $schedule->winner;
                            @endphp

                            <div class="match">
                                <span class="match-label">
                                    UPPER FINAL · {{ strtoupper($schedule->status) }}
                                </span>

                                <div class="team {{ $winner && $schedule->teamA && $winner->id === $schedule->teamA->id ? 'winner' : '' }}">
                                    <span>{{ $schedule->teamA->team_name ?? 'Tim belum ditentukan' }}</span>
                                    <span>{{ $scoreA }}</span>
                                </div>

                                <div class="team {{ $winner && $schedule->teamB && $winner->id === $schedule->teamB->id ? 'winner' : '' }}">
                                    <span>{{ $schedule->teamB->team_name ?? 'Tim belum ditentukan' }}</span>
                                    <span>{{ $scoreB }}</span>
                                </div>
                            </div>

                        @empty

                            <div class="match">
                                <span class="match-label">UPPER FINAL</span>
                                <div class="empty-match">Belum ada pertandingan.</div>
                            </div>

                        @endforelse

                    </div>
                </div>

                <div class="bracket-connector upper-final-connector connector-single" aria-hidden="true">
                    <span class="connector-exit"></span>
                </div>

                <!-- GRAND FINAL -->
                <div class="round grand-final">
                    <h3>GRAND FINAL</h3>

                    <div class="round-matches single-match-list">

                        @forelse($schedules->where('round', 'Grand Final') as $schedule)

                            @php
                                $scores = preg_match(
                                    '/^(\d+)-(\d+)$/',
                                    trim($schedule->result ?? ''),
                                    $scoreParts
                                ) ? $scoreParts : [];

                                $scoreA = $scores[1] ?? '-';
                                $scoreB = $scores[2] ?? '-';
                                $winner = $schedule->winner;
                            @endphp

                            <div class="match final-match">
                                <span class="match-label">
                                    GRAND FINAL · {{ strtoupper($schedule->status) }}
                                </span>

                                <div class="team {{ $winner && $schedule->teamA && $winner->id === $schedule->teamA->id ? 'winner' : '' }}">
                                    <span>{{ $schedule->teamA->team_name ?? 'Tim belum ditentukan' }}</span>
                                    <span>{{ $scoreA }}</span>
                                </div>

                                <div class="team {{ $winner && $schedule->teamB && $winner->id === $schedule->teamB->id ? 'winner' : '' }}">
                                    <span>{{ $schedule->teamB->team_name ?? 'Tim belum ditentukan' }}</span>
                                    <span>{{ $scoreB }}</span>
                                </div>
                            </div>

                        @empty

                            <div class="match final-match">
                                <span class="match-label">GRAND FINAL</span>
                                <div class="empty-match">Belum ada pertandingan.</div>
                            </div>

                        @endforelse

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- LOWER BRACKET -->
    <section class="bracket-section lower lower-lane">

        <div class="bracket-heading">
            <h2>LOWER BRACKET</h2>
            <p>Jalur kesempatan kedua bagi tim yang kalah di Upper Bracket.</p>
        </div>

        <div class="bracket-wrapper">
            <div class="bracket">

                <!-- LOWER ROUND -->
                <div class="round lower-round">
                    <h3>LOWER ROUND</h3>

                    <div class="round-matches">

                        @forelse($schedules->where('round', 'Lower Round') as $schedule)

                            @php
                                $scores = preg_match(
                                    '/^(\d+)-(\d+)$/',
                                    trim($schedule->result ?? ''),
                                    $scoreParts
                                ) ? $scoreParts : [];

                                $scoreA = $scores[1] ?? '-';
                                $scoreB = $scores[2] ?? '-';
                                $winner = $schedule->winner;
                            @endphp

                            <div class="match">
                                <span class="match-label">
                                    LOWER ROUND · {{ strtoupper($schedule->status) }}
                                </span>

                                <div class="team {{ $winner && $schedule->teamA && $winner->id === $schedule->teamA->id ? 'winner' : '' }}">
                                    <span>{{ $schedule->teamA->team_name ?? 'Tim belum ditentukan' }}</span>
                                    <span>{{ $scoreA }}</span>
                                </div>

                                <div class="team {{ $winner && $schedule->teamB && $winner->id === $schedule->teamB->id ? 'winner' : '' }}">
                                    <span>{{ $schedule->teamB->team_name ?? 'Tim belum ditentukan' }}</span>
                                    <span>{{ $scoreB }}</span>
                                </div>
                            </div>

                        @empty

                            @for ($slot = 0; $slot < 2; $slot++)
                                <div class="match">
                                    <span class="match-label">LOWER MATCH {{ $slot + 1 }}</span>
                                    <div class="empty-match">Menunggu tim bertanding</div>
                                </div>
                            @endfor

                        @endforelse

                    </div>
                </div>

                <div class="bracket-connector lower-connector {{ $schedules->where('round', 'Lower Round')->count() === 1 ? 'connector-single' : 'connector-pair' }}" aria-hidden="true">
                    <span class="connector-trunk"></span>
                    <span class="connector-top"></span>
                    <span class="connector-bottom"></span>
                    <span class="connector-exit"></span>
                </div>

                <!-- LOWER FINAL -->
                <div class="round lower-final">
                    <h3>LOWER FINAL</h3>

                    <div class="round-matches single-match-list">

                        @forelse($schedules->where('round', 'Lower Final') as $schedule)

                            @php
                                $scores = preg_match(
                                    '/^(\d+)-(\d+)$/',
                                    trim($schedule->result ?? ''),
                                    $scoreParts
                                ) ? $scoreParts : [];

                                $scoreA = $scores[1] ?? '-';
                                $scoreB = $scores[2] ?? '-';
                                $winner = $schedule->winner;
                            @endphp

                            <div class="match">
                                <span class="match-label">
                                    LOWER FINAL · {{ strtoupper($schedule->status) }}
                                </span>

                                <div class="team {{ $winner && $schedule->teamA && $winner->id === $schedule->teamA->id ? 'winner' : '' }}">
                                    <span>{{ $schedule->teamA->team_name ?? 'Tim belum ditentukan' }}</span>
                                    <span>{{ $scoreA }}</span>
                                </div>

                                <div class="team {{ $winner && $schedule->teamB && $winner->id === $schedule->teamB->id ? 'winner' : '' }}">
                                    <span>{{ $schedule->teamB->team_name ?? 'Tim belum ditentukan' }}</span>
                                    <span>{{ $scoreB }}</span>
                                </div>
                            </div>

                        @empty

                            <div class="match">
                                <span class="match-label">LOWER FINAL</span>
                                <div class="empty-match">Belum ada pertandingan.</div>
                            </div>

                        @endforelse

                    </div>
                </div>

                <div class="bracket-connector lower-final-connector connector-single" aria-hidden="true">
                    <span class="connector-exit"></span>
                </div>

                <!-- FINALIST -->
                <div class="round lower-finalist">
                    <h3>FINALIST</h3>

                    <div class="round-matches">
                        <div class="match final-match">
                            <span class="match-label">TO GRAND FINAL</span>

                            @php
                                $lowerFinal = $schedules->firstWhere('round', 'Lower Final');
                                $lowerWinner = $lowerFinal?->winner;
                            @endphp

                            <div class="team">
                                <span>{{ $lowerWinner?->team_name ?? 'Menunggu pemenang Lower Final' }}</span>
                                <span>→</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    </div>

    <!-- CHAMPION -->
    <div class="champion">
        <div class="trophy">🏆</div>
        <small>TOURNAMENT CHAMPION</small>

        @if($champion)
            <h2>{{ strtoupper($champion->team_name) }}</h2>
            <p>Selamat! Tim ini menjadi juara ARENA Z.</p>
        @else
            <h2>COMING SOON</h2>
            <p>Juara akan ditampilkan setelah Grand Final selesai.</p>
        @endif
    </div>

    <!-- INFORMATION -->
    <div class="notice">
        <h3>INFORMASI BRACKET</h3>
        <p>
            Bracket ARENA Z menggunakan konsep Upper Bracket dan Lower Bracket.
            Tim yang kalah di Upper Bracket masih memiliki kesempatan melalui
            Lower Bracket. Pemenang Lower Final akan menghadapi pemenang
            Upper Final di Grand Final.
        </p>
    </div>

</main>

<footer>
    © 2026 ARENA Z. STUDENT ESPORTS PLATFORM.
</footer>

</body>
</html>
