
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tim - ARENA Z</title>

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
            color: #fff;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 850px;
            margin: auto;
        }

        .back {
            display: inline-block;
            color: #9ba8c7;
            text-decoration: none;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .back:hover {
            color: #3685ff;
        }

        .header {
            margin-bottom: 30px;
        }

        .header small {
            color: #3685ff;
            letter-spacing: 3px;
            font-weight: 600;
        }

        .header h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: 30px;
            margin-top: 10px;
        }

        .card {
            background: #10182b;
            border: 1px solid #263653;
            border-radius: 16px;
            padding: 30px;
        }

        .team-name {
            font-family: 'Orbitron', sans-serif;
            font-size: 23px;
            margin-bottom: 10px;
        }

        .status {
            display: inline-block;
            padding: 7px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 25px;
            background: #263653;
        }

        .pending {
            color: #facc15;
            background: #3b3215;
        }

        .approved {
            color: #4ade80;
            background: #143522;
        }

        .rejected {
            color: #f87171;
            background: #3b1c22;
        }

        .section-title {
            color: #3685ff;
            font-size: 13px;
            letter-spacing: 2px;
            margin: 20px 0 15px;
        }

        .detail {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 15px 0;
            border-bottom: 1px solid #263653;
        }

        .detail span:first-child {
            color: #9ba8c7;
        }

        .detail span:last-child {
            text-align: right;
            overflow-wrap: anywhere;
        }

        .success {
            background: #143522;
            border: 1px solid #22c55e;
            color: #4ade80;
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 12px 22px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-edit {
            background: #2563eb;
            color: white;
        }

        .btn-edit:hover {
            background: #1d4ed8;
        }

        .btn-delete {
            background: #dc2626;
            color: white;
        }

        .btn-delete:hover {
            background: #b91c1c;
        }

        .btn-back {
            background: #263653;
            color: white;
        }

        .btn-back:hover {
            background: #344767;
        }

        @media(max-width: 600px) {
            body {
                padding: 25px 15px;
            }

            .card {
                padding: 20px;
            }

            .header h1 {
                font-size: 23px;
            }

            .detail {
                flex-direction: column;
                gap: 5px;
            }

            .detail span:last-child {
                text-align: left;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <a href="{{ url('/admin/teams') }}" class="back">
        ← Kembali ke Kelola Tim
    </a>

    <div class="header">
        <small>ARENA Z / ADMIN PANEL</small>
        <h1>DETAIL PENDAFTARAN</h1>
    </div>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        <h2 class="team-name">{{ $team->team_name }}</h2>

        <span class="status {{ $team->status }}">
            {{ strtoupper($team->status) }}
        </span>

        <h3 class="section-title">INFORMASI TIM</h3>

        <div class="detail">
            <span>Nama Tim</span>
            <span>{{ $team->team_name }}</span>
        </div>

        <div class="detail">
            <span>Asal Sekolah</span>
            <span>{{ $team->school_name }}</span>
        </div>

        <div class="detail">
            <span>Turnamen</span>
            <span>{{ $team->tournament->name ?? '-' }}</span>
        </div>

        <h3 class="section-title">INFORMASI KETUA TIM</h3>

        <div class="detail">
            <span>Nama Ketua</span>
            <span>{{ $team->leader_name }}</span>
        </div>

        <div class="detail">
            <span>Email</span>
            <span>{{ $team->leader_email }}</span>
        </div>

        <div class="detail">
            <span>Nomor WhatsApp</span>
            <span>{{ $team->leader_phone }}</span>
        </div>

        <div class="actions">

            <a href="{{ url('/admin/teams/'.$team->id.'/edit') }}"
               class="btn btn-edit">
                Edit Data Tim
            </a>

            <form action="{{ url('/admin/teams/'.$team->id.'/delete') }}"
                  method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus data tim ini? Data yang dihapus tidak bisa dikembalikan!');">

                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-delete">
                    Hapus Data Tim
                </button>

            </form>

            <a href="{{ url('/admin/teams') }}"
               class="btn btn-back">
                Kembali
            </a>

        </div>

    </div>

</div>

</body>
</html>
