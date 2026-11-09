
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Login - ARENA Z</title>

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #070b16;
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 25px;
        }

        .container {
            width: 100%;
            max-width: 950px;
            text-align: center;
        }

        .logo {
            font-family: 'Orbitron', sans-serif;
            font-size: 35px;
            font-weight: 800;
            color: #3685ff;
            margin-bottom: 12px;
        }

        .subtitle {
            color: #aab4c8;
            font-size: 14px;
            margin-bottom: 45px;
        }

        .heading {
            font-size: 30px;
            margin-bottom: 10px;
        }

        .description {
            color: #929db2;
            font-size: 14px;
            margin-bottom: 35px;
        }

        .login-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .login-card {
            background: #101a2d;
            border: 1px solid #263650;
            border-radius: 18px;
            padding: 40px 25px;
            transition: 0.3s;
        }

        .login-card:hover {
            transform: translateY(-8px);
            border-color: #3685ff;
            box-shadow: 0 10px 35px #3685ff20;
        }

        .icon {
            font-size: 55px;
            margin-bottom: 20px;
        }

        .login-card h2 {
            font-size: 23px;
            margin-bottom: 12px;
        }

        .login-card p {
            color: #9aa8bd;
            font-size: 13px;
            line-height: 1.8;
            min-height: 50px;
            margin-bottom: 25px;
        }

        .btn {
            display: block;
            text-decoration: none;
            padding: 13px;
            border-radius: 9px;
            font-weight: 600;
            transition: 0.3s;
        }

        .admin-btn {
            background: #3685ff;
            color: white;
        }

        .user-btn {
            background: #8b5cf6;
            color: white;
        }

        .btn:hover {
            opacity: 0.8;
            transform: scale(1.02);
        }

        .back {
            display: inline-block;
            margin-top: 35px;
            color: #9aa8bd;
            text-decoration: none;
            font-size: 13px;
        }

        .back:hover {
            color: white;
        }

        body {
            background:
                radial-gradient(ellipse at 18% 18%, rgba(54, 133, 255, .18), transparent 34%),
                radial-gradient(ellipse at 82% 76%, rgba(139, 92, 246, .16), transparent 32%),
                #070b16;
        }

        .container {
            max-width: 1040px;
            padding: 45px 0;
        }

        .logo {
            display: inline-block;
            color: #fff;
            letter-spacing: 3px;
            text-shadow: 0 0 28px rgba(54, 133, 255, .5);
        }

        .logo::first-letter {
            color: #60a5fa;
        }

        .subtitle {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 4px;
            margin-bottom: 48px;
        }

        .heading {
            font-size: clamp(28px, 4vw, 40px);
            letter-spacing: -.8px;
        }

        .description {
            font-size: 14px;
            margin-bottom: 38px;
        }

        .login-options {
            gap: 22px;
        }

        .login-card {
            position: relative;
            overflow: hidden;
            min-height: 330px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(145deg, rgba(20, 33, 56, .96), rgba(11, 19, 34, .98));
            border-color: rgba(148, 163, 184, .16);
            border-radius: 22px;
            padding: 38px;
            box-shadow: 0 24px 70px rgba(0, 0, 0, .24);
        }

        .login-card::before {
            content: '';
            position: absolute;
            width: 220px;
            height: 220px;
            top: -145px;
            right: -80px;
            border-radius: 50%;
            background: var(--card-glow, rgba(54, 133, 255, .28));
            filter: blur(35px);
            pointer-events: none;
        }

        .login-card:last-child {
            --card-glow: rgba(139, 92, 246, .3);
        }

        .login-card:hover {
            transform: translateY(-6px);
            border-color: rgba(96, 165, 250, .55);
            box-shadow: 0 24px 65px rgba(30, 93, 181, .2);
        }

        .icon {
            width: 82px;
            height: 82px;
            display: grid;
            place-items: center;
            margin-bottom: 22px;
            border: 1px solid rgba(96, 165, 250, .22);
            border-radius: 24px;
            background: linear-gradient(145deg, rgba(54, 133, 255, .2), rgba(54, 133, 255, .06));
            box-shadow: inset 0 1px rgba(255, 255, 255, .08);
        }

        .login-card:last-child .icon {
            border-color: rgba(167, 139, 250, .25);
            background: linear-gradient(145deg, rgba(139, 92, 246, .22), rgba(139, 92, 246, .06));
        }

        .login-card h2 {
            font-size: 22px;
            letter-spacing: -.3px;
        }

        .login-card p {
            max-width: 340px;
            min-height: 48px;
            margin-bottom: 26px;
        }

        .btn {
            width: 100%;
            max-width: 310px;
            padding: 14px 18px;
            border-radius: 11px;
            box-shadow: 0 8px 24px rgba(54, 133, 255, .2);
        }

        .user-btn {
            background: linear-gradient(100deg, #7c3aed, #a855f7);
            box-shadow: 0 8px 24px rgba(139, 92, 246, .2);
        }

        .btn:hover {
            opacity: 1;
            filter: brightness(1.1);
        }

        .back {
            margin-top: 30px;
        }

        a:focus-visible {
            outline: 2px solid #93c5fd;
            outline-offset: 4px;
        }

        @media(max-width: 650px) {
            .login-options {
                grid-template-columns: 1fr;
            }

            .container {
                padding: 24px 0;
            }

            .subtitle {
                margin-bottom: 35px;
            }

            .login-card {
                min-height: 0;
                padding: 32px 22px;
            }

            .heading {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="logo">ARENA Z</div>
        <div class="subtitle">STUDENT ESPORTS PLATFORM</div>

        <h1 class="heading">Pilih Jenis Login</h1>
        <p class="description">
            Silakan pilih akses sesuai dengan akun yang kamu miliki.
        </p>

        <div class="login-options">

            <div class="login-card">
                <div class="icon">🛡️</div>
                <h2>Admin</h2>
                <p>
                    Masuk sebagai admin untuk mengelola turnamen,
                    jadwal pertandingan, bracket, dan tim.
                </p>

                <a href="{{ url('/admin/login') }}" class="btn admin-btn">
                    Login Admin
                </a>
            </div>

            <div class="login-card">
                <div class="icon">🎮</div>
                <h2>User / Peserta</h2>
                <p>
                    Masuk sebagai peserta untuk melihat informasi
                    turnamen dan mengikuti kompetisi ARENA Z.
                </p>

                <a href="{{ url('/user/login') }}" class="btn user-btn">
                    Login User
                </a>
            </div>

        </div>

        <a href="{{ url('/') }}" class="back">
            ← Kembali ke Halaman Utama
        </a>

    </div>

</body>
</html>
