
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - ARENA Z</title>

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: #070b16;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
            color: white;
            padding: 20px;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
            background: #101a2d;
            padding: 40px;
            border-radius: 18px;
            border: 1px solid #263653;
            box-shadow: 0 0 35px rgba(54, 133, 255, 0.12);
        }

        .logo {
            font-family: 'Orbitron', sans-serif;
            color: #3685ff;
            font-size: 30px;
            font-weight: 800;
            text-align: center;
            margin-bottom: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            color: #91a0b8;
            font-size: 13px;
            margin-bottom: 28px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            color: #cbd5e1;
        }

        input {
            width: 100%;
            padding: 13px;
            background: #070f20;
            border: 1px solid #2b3c58;
            border-radius: 9px;
            color: white;
            outline: none;
            font-family: inherit;
        }

        input:focus {
            border-color: #3685ff;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 9px;
            background: #3685ff;
            color: white;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            margin-top: 8px;
        }

        button:hover {
            background: #2469d8;
        }

        .error {
            background: #451b26;
            color: #ffb4c0;
            padding: 12px;
            border-radius: 8px;
            font-size: 12px;
            margin-bottom: 18px;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 22px;
            color: #91a0b8;
            text-decoration: none;
            font-size: 13px;
        }

        body {
            background:
                radial-gradient(ellipse at 15% 15%, rgba(54, 133, 255, .2), transparent 34%),
                radial-gradient(ellipse at 90% 85%, rgba(139, 92, 246, .12), transparent 30%),
                #070b16;
        }

        .login-box {
            position: relative;
            overflow: hidden;
            max-width: 460px;
            padding: 42px;
            border-color: rgba(96, 165, 250, .2);
            border-radius: 24px;
            background: linear-gradient(150deg, rgba(18, 30, 51, .98), rgba(10, 17, 31, .98));
            box-shadow: 0 30px 90px rgba(0, 0, 0, .4), 0 0 45px rgba(54, 133, 255, .08);
        }

        .login-box::before {
            content: '';
            position: absolute;
            width: 190px;
            height: 190px;
            right: -95px;
            top: -110px;
            border-radius: 50%;
            background: rgba(54, 133, 255, .18);
            filter: blur(30px);
            pointer-events: none;
        }

        .login-mark {
            width: 62px;
            height: 62px;
            display: grid;
            place-items: center;
            margin: 0 auto 15px;
            border: 1px solid rgba(96, 165, 250, .24);
            border-radius: 19px;
            background: linear-gradient(145deg, rgba(54, 133, 255, .22), rgba(54, 133, 255, .06));
            font-size: 27px;
        }

        .logo {
            color: #fff;
            font-size: 25px;
            letter-spacing: 2px;
            text-shadow: 0 0 24px rgba(54, 133, 255, .42);
        }

        h2 {
            margin-top: 26px;
            font-size: 24px;
            letter-spacing: -.4px;
        }

        .subtitle {
            margin-bottom: 30px;
        }

        label {
            font-weight: 500;
        }

        input {
            padding: 14px 15px;
            border-color: #2b3c58;
            border-radius: 11px;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }

        input:focus {
            background: #091528;
            border-color: #60a5fa;
            box-shadow: 0 0 0 4px rgba(54, 133, 255, .12);
        }

        button {
            padding: 14px;
            margin-top: 6px;
            border-radius: 11px;
            background: linear-gradient(100deg, #2563eb, #3685ff);
            box-shadow: 0 10px 24px rgba(54, 133, 255, .22);
            transition: transform .2s, filter .2s;
        }

        button:hover {
            background: linear-gradient(100deg, #2563eb, #3685ff);
            filter: brightness(1.1);
            transform: translateY(-1px);
        }

        .error {
            border: 1px solid rgba(251, 113, 133, .25);
            line-height: 1.65;
        }

        .back {
            transition: color .2s;
        }

        .back:hover {
            color: #fff;
        }

        a:focus-visible,
        button:focus-visible,
        input:focus-visible {
            outline: 2px solid #93c5fd;
            outline-offset: 3px;
        }

        @media (max-width: 520px) {
            .login-box {
                padding: 34px 25px;
            }
        }
    </style>
</head>

<body>

    <div class="login-box">

        <div class="login-mark" aria-hidden="true">🛡️</div>
        <div class="logo">ARENA Z</div>

        <h2>Admin Login</h2>
        <p class="subtitle">Masuk ke panel pengelolaan ARENA Z</p>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ url('/admin/login') }}" method="POST">
            @csrf

            <input type="hidden" name="role" value="admin">

            <div class="form-group">
                <label>Email Admin</label>
                <input
                    type="email"
                    name="email"
                    placeholder="Masukkan email admin"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label>Password</label>
                <input
                    type="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >
            </div>

            <button type="submit">LOGIN ADMIN</button>
        </form>

        <a href="{{ url('/pilih-login') }}" class="back">
            ← Kembali ke Pilihan Login
        </a>

    </div>

</body>
</html>
