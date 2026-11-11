<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Akses Ditolak | ARENA Z</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;800&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: #080D19;
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 24px;
        }
        .container { max-width: 480px; width: 100%; }
        .code {
            font-family: 'Orbitron', sans-serif;
            font-size: 96px;
            font-weight: 800;
            color: #EF4444;
            line-height: 1;
            margin-bottom: 12px;
            opacity: 0.9;
        }
        h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 12px;
        }
        p {
            color: #9BA8C7;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 32px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 24px;
            background: #3685FF;
            color: #fff;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.2s;
        }
        .btn:hover { background: #2563EB; }
        .btn-secondary {
            background: transparent;
            border: 1px solid #25334A;
            color: #9BA8C7;
            margin-left: 10px;
        }
        .btn-secondary:hover { border-color: #3685FF; color: #fff; background: rgba(54,133,255,0.08); }
    </style>
</head>
<body>
    <div class="container">
        <div class="code">403</div>
        <h1>AKSES DITOLAK</h1>
        <p>{{ $exception->getMessage() ?: 'Anda tidak memiliki izin untuk mengakses halaman ini.' }}</p>
        <div>
            <a href="{{ url('/') }}" class="btn">Ke Halaman Utama</a>
            <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</body>
</html>
