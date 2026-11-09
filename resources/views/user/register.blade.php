
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User - ARENA Z</title>

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
            padding: 25px;
        }

        .register-box {
            width: 100%;
            max-width: 430px;
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
            margin-bottom: 17px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 13px;
            color: #cbd5e1;
        }

        input {
            width: 100%;
            padding: 13px 15px;
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

        .footer {
            text-align: center;
            margin-top: 22px;
            font-size: 13px;
            color: #91a0b8;
        }

        a {
            color: #3685ff;
            text-decoration: none;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 17px;
            color: #91a0b8;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="register-box">

        <div class="logo">ARENA Z</div>

        <h2>Buat Akun Baru</h2>
        <p class="subtitle">Daftar untuk mengikuti turnamen Mobile Legends</p>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ url('/user/register') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name"
                    value="{{ old('name') }}"
                    placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password"
                    placeholder="Minimal 8 karakter" required>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    placeholder="Ulangi password" required>
            </div>

            <button type="submit">DAFTAR SEKARANG</button>
        </form>

        <div class="footer">
            Sudah punya akun?
            <a href="{{ url('/user/login') }}">Login</a>
        </div>

        <a class="back" href="{{ url('/pilih-login') }}">
            ← Kembali
        </a>

    </div>

</body>
</html>
