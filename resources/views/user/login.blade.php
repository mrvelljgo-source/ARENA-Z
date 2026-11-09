
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User - ARENA Z</title>

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
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background: #101a2d;
            padding: 40px;
            border-radius: 18px;
            border: 1px solid #263650;
            box-shadow: 0 15px 50px #0005;
        }

        .logo {
            font-family: 'Orbitron', sans-serif;
            color: #3685ff;
            font-size: 30px;
            font-weight: 800;
            text-align: center;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #9aa8bd;
            text-align: center;
            font-size: 12px;
            margin-bottom: 35px;
        }

        h2 {
            text-align: center;
            margin-bottom: 8px;
        }

        .description {
            text-align: center;
            color: #9aa8bd;
            font-size: 13px;
            margin-bottom: 28px;
        }

        label {
            display: block;
            font-size: 13px;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 13px;
            background: #070b16;
            border: 1px solid #34445f;
            border-radius: 8px;
            color: white;
            outline: none;
            margin-bottom: 20px;
        }

        input:focus {
            border-color: #3685ff;
        }

        button {
            width: 100%;
            padding: 13px;
            background: #3685ff;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 700;
            cursor: pointer;
            font-size: 14px;
            transition: 0.3s;
        }

        button:hover {
            background: #236bd8;
        }

        .register {
            text-align: center;
            font-size: 13px;
            color: #9aa8bd;
            margin-top: 23px;
        }

        .register a {
            color: #60a5fa;
            text-decoration: none;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: #9aa8bd;
            font-size: 12px;
            text-decoration: none;
        }

        .error {
            color: #ff7777;
            font-size: 12px;
            margin-bottom: 15px;
        }

        body {
            background:
                radial-gradient(ellipse at 14% 16%, rgba(139, 92, 246, .2), transparent 34%),
                radial-gradient(ellipse at 88% 82%, rgba(54, 133, 255, .16), transparent 30%),
                #070b16;
        }

        .login-container {
            position: relative;
            overflow: hidden;
            max-width: 460px;
            padding: 42px;
            border-color: rgba(167, 139, 250, .2);
            border-radius: 24px;
            background: linear-gradient(150deg, rgba(22, 27, 49, .98), rgba(10, 17, 31, .98));
            box-shadow: 0 30px 90px rgba(0, 0, 0, .4), 0 0 45px rgba(139, 92, 246, .08);
        }

        .login-container::before {
            content: '';
            position: absolute;
            width: 190px;
            height: 190px;
            right: -95px;
            top: -110px;
            border-radius: 50%;
            background: rgba(139, 92, 246, .2);
            filter: blur(30px);
            pointer-events: none;
        }

        .login-mark {
            width: 62px;
            height: 62px;
            display: grid;
            place-items: center;
            margin: 0 auto 15px;
            border: 1px solid rgba(167, 139, 250, .24);
            border-radius: 19px;
            background: linear-gradient(145deg, rgba(139, 92, 246, .24), rgba(139, 92, 246, .06));
            font-size: 27px;
        }

        .logo {
            color: #fff;
            font-size: 25px;
            letter-spacing: 2px;
            text-shadow: 0 0 24px rgba(139, 92, 246, .42);
        }

        .subtitle {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 3px;
            margin-bottom: 28px;
        }

        h2 {
            margin-top: 25px;
            font-size: 24px;
            letter-spacing: -.4px;
        }

        .description {
            margin-bottom: 28px;
        }

        label {
            font-weight: 500;
        }

        input {
            padding: 14px 15px;
            border-color: #34445f;
            border-radius: 11px;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }

        input:focus {
            background: #0c1327;
            border-color: #a78bfa;
            box-shadow: 0 0 0 4px rgba(139, 92, 246, .12);
        }

        button {
            padding: 14px;
            border-radius: 11px;
            background: linear-gradient(100deg, #7c3aed, #8b5cf6);
            box-shadow: 0 10px 24px rgba(139, 92, 246, .22);
            transition: transform .2s, filter .2s;
        }

        button:hover {
            background: linear-gradient(100deg, #7c3aed, #8b5cf6);
            filter: brightness(1.1);
            transform: translateY(-1px);
        }

        .register a {
            color: #c4b5fd;
        }

        .back {
            transition: color .2s;
        }

        .back:hover {
            color: #fff;
        }

        .error {
            padding: 12px;
            color: #ffb4c0;
            border: 1px solid rgba(251, 113, 133, .25);
            border-radius: 9px;
            background: rgba(69, 27, 38, .72);
            line-height: 1.65;
        }

        a:focus-visible,
        button:focus-visible,
        input:focus-visible {
            outline: 2px solid #c4b5fd;
            outline-offset: 3px;
        }

        @media (max-width: 520px) {
            .login-container {
                padding: 34px 25px;
            }
        }
    </style>
</head>

<body>

<div class="login-container">

    <div class="login-mark" aria-hidden="true">🎮</div>
    <div class="logo">ARENA Z</div>
    <div class="subtitle">STUDENT ESPORTS PLATFORM</div>

    <h2>Login User</h2>
    <p class="description">Masuk ke akun peserta ARENA Z</p>

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ url('/user/login') }}" method="POST">
        @csrf

        <input type="hidden" name="role" value="user">

        <label>Email</label>
        <input type="email" name="email" placeholder="Masukkan email" value="{{ old('email') }}" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Masukkan password" required>

        <button type="submit">LOGIN SEKARANG</button>
    </form>

    <div class="register">
        Belum punya akun?
        <a href="{{ url('/user/register') }}">Daftar sekarang</a>
    </div>

    <a href="{{ url('/pilih-login') }}" class="back">
        ← Kembali
    </a>

</div>

</body>
</html>
