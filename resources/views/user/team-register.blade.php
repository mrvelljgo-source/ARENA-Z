
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tim - ARENA Z</title>

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

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
            padding: 40px 20px;
        }

        .container {
            max-width: 650px;
            margin: auto;
        }

        .back {
            display: inline-block;
            color: #9bbcff;
            text-decoration: none;
            margin-bottom: 25px;
        }

        h1 {
            font-family: 'Orbitron', sans-serif;
            color: #3685ff;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .description {
            color: #aab4c8;
            margin-bottom: 30px;
        }

        .form-box {
            background: #111a2e;
            border: 1px solid #263653;
            border-radius: 15px;
            padding: 30px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        input, select {
            width: 100%;
            padding: 13px;
            background: #080f20;
            border: 1px solid #30415f;
            border-radius: 8px;
            color: white;
            font-family: inherit;
            margin-bottom: 20px;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #3685ff;
        }

        .error {
            color: #ff7777;
            font-size: 13px;
            margin-top: -15px;
            margin-bottom: 15px;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #3685ff;
            border: none;
            border-radius: 8px;
            color: white;
            font-family: inherit;
            font-weight: 700;
            cursor: pointer;
        }

        button:hover {
            background: #246bd6;
        }

        .empty {
            color: #ffcf70;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">

    <a href="/user/dashboard" class="back">← Kembali ke Dashboard</a>

    <h1>DAFTAR TIM</h1>
    <p class="description">Daftarkan tim sekolah lu untuk mengikuti turnamen ARENA Z.</p>

    <div class="form-box">

        @if ($tournaments->isEmpty())
            <p class="empty">Belum ada turnamen yang tersedia untuk pendaftaran.</p>
        @else

            <form action="/user/team-register" method="POST">
                @csrf

                <label>Pilih Turnamen</label>
                <select name="tournament_id" required>
                    <option value="">-- Pilih Turnamen --</option>
                    @foreach ($tournaments as $tournament)
                        <option value="{{ $tournament->id }}"
                            {{ old('tournament_id') == $tournament->id ? 'selected' : '' }}>
                            {{ $tournament->name }}
                        </option>
                    @endforeach
                </select>
                @error('tournament_id')
                    <p class="error">{{ $message }}</p>
                @enderror

                <label>Nama Tim</label>
                <input type="text" name="team_name" value="{{ old('team_name') }}" required>
                @error('team_name')
                    <p class="error">{{ $message }}</p>
                @enderror

                <label>Nama Sekolah</label>
                <input type="text" name="school_name" value="{{ old('school_name') }}" required>
                @error('school_name')
                    <p class="error">{{ $message }}</p>
                @enderror

                <label>Nama Ketua Tim</label>
                <input type="text" name="leader_name" value="{{ old('leader_name') }}" required>
                @error('leader_name')
                    <p class="error">{{ $message }}</p>
                @enderror

                <label>Email Ketua Tim</label>
                <input type="email" name="leader_email" value="{{ old('leader_email') }}" required>
                @error('leader_email')
                    <p class="error">{{ $message }}</p>
                @enderror

                <label>Nomor WhatsApp</label>
                <input type="text" name="leader_phone" value="{{ old('leader_phone') }}" required>
                @error('leader_phone')
                    <p class="error">{{ $message }}</p>
                @enderror

                <button type="submit">KIRIM PENDAFTARAN</button>
            </form>

        @endif

    </div>
</div>

</body>
</html>
