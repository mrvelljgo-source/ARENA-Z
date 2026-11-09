
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turnamen - ARENA Z</title>

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
            --border: #253552;
        }

        body {
            background: #070b16;
            color: white;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        /* NAVBAR */
        header {
            padding: 20px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(7,11,22,.96);
            border-bottom: 1px solid rgba(255,255,255,.08);
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(15px);
        }

        .logo {
            font-family: 'Orbitron', sans-serif;
            font-size: 25px;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .logo span {
            color: var(--blue);
        }

        nav {
            display: flex;
            gap: 30px;
        }

        nav a {
            color: #c5cde0;
            text-decoration: none;
            font-size: 13px;
            transition: .3s;
        }

        nav a:hover,
        nav a.active {
            color: var(--blue);
        }

        .back-button {
            background: rgba(54,133,255,.12);
            color: #83b5ff;
            padding: 10px 18px;
            border: 1px solid var(--blue);
            border-radius: 8px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: .3s;
        }

        .back-button:hover {
            background: var(--blue);
            color: white;
            box-shadow: 0 0 20px rgba(54,133,255,.3);
        }

        /* HERO */
        .page-hero {
            padding: 90px 8% 75px;
            text-align: center;
            background:
                radial-gradient(ellipse at 50% 30%, rgba(54,133,255,.22), transparent 60%),
                radial-gradient(ellipse at 80% 100%, rgba(139,92,246,.10), transparent 50%);
        }

        .hero-label {
            display: inline-block;
            color: #83b5ff;
            background: rgba(54,133,255,.12);
            border: 1px solid rgba(54,133,255,.3);
            padding: 8px 17px;
            border-radius: 30px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 3px;
        }

        .page-hero h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: clamp(32px, 5vw, 52px);
            margin: 22px 0 15px;
        }

        .page-hero h1 span {
            color: var(--blue);
            text-shadow: 0 0 25px rgba(54,133,255,.4);
        }

        .page-hero p {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.9;
            max-width: 580px;
            margin: auto;
        }

        /* MAIN */
        .container {
            padding: 25px 8% 100px;
            max-width: 1500px;
            margin: auto;
        }

        .section-heading {
            margin-bottom: 28px;
        }

        .section-heading small {
            color: var(--blue);
            font-size: 10px;
            letter-spacing: 3px;
            font-weight: 600;
        }

        .section-heading h2 {
            font-family: 'Orbitron', sans-serif;
            font-size: 25px;
            margin-top: 10px;
        }

        /* TOURNAMENT CARD */
        .tournament-card {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            background: linear-gradient(135deg, #121d34, #0b1221);
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            transition: .3s;
        }

        .tournament-card:hover {
            border-color: var(--blue);
            box-shadow: 0 15px 45px rgba(54,133,255,.12);
            transform: translateY(-4px);
        }

        .card-banner {
            min-height: 390px;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            background:
                radial-gradient(circle at center, rgba(54,133,255,.35), transparent 55%),
                linear-gradient(145deg, #172d52, #0a1020);
        }

        .card-banner::before,
        .card-banner::after {
            content: "";
            position: absolute;
            border: 1px solid rgba(94,157,255,.2);
            transform: rotate(45deg);
        }

        .card-banner::before {
            width: 300px;
            height: 300px;
        }

        .card-banner::after {
            width: 220px;
            height: 220px;
        }

        .banner-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .ml-logo {
            font-family: 'Orbitron', sans-serif;
            font-size: clamp(55px, 7vw, 85px);
            font-weight: 800;
            letter-spacing: 5px;
            color: #b9d8ff;
            text-shadow:
                0 0 15px rgba(54,133,255,.8),
                0 0 45px rgba(54,133,255,.5);
        }

        .banner-content p {
            color: #a8caff;
            font-size: 11px;
            letter-spacing: 5px;
            margin-top: 8px;
        }

        .banner-tag {
            position: absolute;
            bottom: 22px;
            left: 22px;
            z-index: 3;
            background: rgba(7,11,22,.7);
            border: 1px solid rgba(255,255,255,.15);
            padding: 8px 13px;
            border-radius: 7px;
            font-size: 10px;
            color: #c9dcff;
        }

        /* CARD INFO */
        .card-info {
            padding: 38px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .status {
            display: inline-block;
            width: fit-content;
            padding: 7px 13px;
            background: rgba(54,133,255,.13);
            color: #83b5ff;
            border: 1px solid rgba(54,133,255,.25);
            border-radius: 30px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        .card-info h3 {
            font-family: 'Orbitron', sans-serif;
            font-size: clamp(21px, 3vw, 28px);
            margin-bottom: 14px;
        }

        .card-info > p {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.9;
        }

        /* DETAILS */
        .details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin: 28px 0;
        }

        .detail-item {
            padding: 15px;
            background: rgba(255,255,255,.035);
            border: 1px solid rgba(255,255,255,.07);
            border-radius: 10px;
        }

        .detail-item small {
            display: block;
            color: var(--muted);
            font-size: 9px;
            letter-spacing: 1px;
            margin-bottom: 7px;
        }

        .detail-item strong {
            font-size: 13px;
        }

        .detail-item strong.blue {
            color: #83b5ff;
        }

        /* BUTTON */
        .detail-button {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            width: fit-content;
            padding: 14px 24px;
            background: linear-gradient(100deg, #3685ff, #6255e7);
            color: white;
            border-radius: 9px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .5px;
            transition: .3s;
            box-shadow: 0 5px 20px rgba(54,133,255,.2);
        }

        .detail-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(54,133,255,.4);
        }

        /* BOTTOM INFO */
        .info-box {
            margin-top: 35px;
            padding: 28px 32px;
            display: flex;
            align-items: center;
            gap: 20px;
            background: linear-gradient(100deg, #101d35, #0d1425);
            border: 1px solid var(--border);
            border-radius: 14px;
        }

        .info-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            background: rgba(54,133,255,.15);
            border-radius: 12px;
            color: #83b5ff;
            font-size: 23px;
        }

        .info-box h3 {
            font-family: 'Orbitron', sans-serif;
            font-size: 15px;
            margin-bottom: 8px;
        }

        .info-box p {
            color: var(--muted);
            font-size: 11px;
            line-height: 1.8;
        }

        footer {
            padding: 30px 8%;
            text-align: center;
            background: #0d1425;
            border-top: 1px solid #1d2a43;
            color: #7e8ba8;
            font-size: 11px;
        }

        /* RESPONSIVE */
        @media(max-width: 800px) {
            header {
                padding: 18px 5%;
                flex-wrap: wrap;
                gap: 15px;
            }

            nav {
                order: 3;
                width: 100%;
                justify-content: center;
                gap: 20px;
            }

            .container {
                padding: 25px 5% 70px;
            }

            .tournament-card {
                grid-template-columns: 1fr;
            }

            .card-banner {
                min-height: 240px;
            }

            .card-info {
                padding: 28px;
            }

            .info-box {
                align-items: flex-start;
                padding: 22px;
            }
        }

        @media(max-width: 480px) {
            .back-button {
                padding: 9px 12px;
                font-size: 10px;
            }

            .logo {
                font-size: 21px;
            }

            nav {
                gap: 15px;
            }

            nav a {
                font-size: 11px;
            }

            .details {
                gap: 10px;
            }

            .detail-item {
                padding: 12px;
            }

            .detail-item strong {
                font-size: 11px;
            }

            .card-info {
                padding: 22px;
            }

            .detail-button {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<header>
    <div class="logo">ARENA<span>Z.</span></div>

    <nav>
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ url('/#tentang') }}">Tentang</a>
        <a href="{{ url('/turnamen') }}" class="active">Turnamen</a>
    </nav>

    <a href="{{ url('/') }}" class="back-button">
        ← Kembali ke Home
    </a>
</header>

<section class="page-hero">
    <div class="hero-label">ARENA Z COMPETITION</div>

    <h1>OUR <span>TOURNAMENTS.</span></h1>

    <p>
        Saatnya tunjukkan kemampuan timmu.
        Bergabung dalam kompetisi Mobile Legends pelajar
        dan buktikan siapa yang terbaik di arena.
    </p>
</section>

<main class="container">

    <div class="section-heading">
        <small>AVAILABLE COMPETITION</small>
        <h2>DAFTAR TURNAMEN</h2>
    </div>

    <div class="tournament-card">

        <div class="card-banner">
            <div class="banner-content">
                <div class="ml-logo">MLBB</div>
                <p>STUDENT ESPORTS</p>
            </div>

            <div class="banner-tag">ARENA Z OFFICIAL TOURNAMENT</div>
        </div>

        <div class="card-info">

            <div class="status">● STUDENT COMPETITION</div>

            <h3>STUDENT MLBB CUP</h3>

            <p>
                Turnamen Mobile Legends 5 vs 5 khusus pelajar.
                Bentuk tim terbaikmu, susun strategi bersama,
                dan bersiaplah menjadi juara ARENA Z.
            </p>

            <div class="details">

                <div class="detail-item">
                    <small>GAME</small>
                    <strong>Mobile Legends</strong>
                </div>

                <div class="detail-item">
                    <small>FORMAT</small>
                    <strong>5 VS 5</strong>
                </div>

                <div class="detail-item">
                    <small>PESERTA</small>
                    <strong>Pelajar</strong>
                </div>

                <div class="detail-item">
                    <small>KATEGORI</small>
                    <strong class="blue">Team Tournament</strong>
                </div>

            </div>

            <a href="{{ url('/user/team-register') }}" class="detail-button">
                DAFTAR TIM SEKARANG <span>→</span>
            </a>

        </div>
    </div>

    <div class="info-box">
        <div class="info-icon">⚡</div>

        <div>
            <h3>SIAP MEMBENTUK TIM?</h3>

            <p>
                Siapkan lima pemain terbaikmu dan daftarkan tim
                melalui akun ARENA Z. Pastikan data tim dan anggota
                sudah benar sebelum mengirim pendaftaran.
            </p>
        </div>
    </div>

</main>

<footer>
    © 2026 ARENA Z. STUDENT ESPORTS PLATFORM.
</footer>

</body>
</html>
