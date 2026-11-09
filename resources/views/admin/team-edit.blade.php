
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tim - ARENA Z</title>

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
            max-width: 750px;
            margin: auto;
        }

        .back {
            display: inline-block;
            color: #83b5ff;
            text-decoration: none;
            font-size: 13px;
            margin-bottom: 25px;
        }

        .header small {
            color: #3685ff;
            letter-spacing: 3px;
            font-size: 11px;
        }

        .header h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: 27px;
            margin: 12px 0;
        }

        .header p {
            color: #8d9bb5;
            font-size: 12px;
            margin-bottom: 25px;
        }

        .card {
            background: #101a2d;
            border: 1px solid #253552;
            border-radius: 15px;
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 12px;
            color: #b9c7df;
            margin-bottom: 9px;
        }

        input {
            width: 100%;
            padding: 14px;
            background: #0b1425;
            border: 1px solid #253552;
            border-radius: 8px;
            color: white;
            font-family: inherit;
            font-size: 13px;
            outline: none;
        }

        input:focus {
            border-color: #3685ff;
        }

        .error {
            color: #ff7185;
            font-size: 11px;
            margin-top: 6px;
        }

        .alert {
            background: rgba(229,57,80,.1);
            border: 1px solid rgba(229,57,80,.3);
            color: #ff7185;
            padding: 13px;
            border-radius: 8px;
            font-size: 12px;
            margin-bottom: 20px;
        }

        .buttons {
            display: flex;
            gap: 12px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 13px 22px;
            border-radius: 8px;
            border: none;
            text-decoration: none;
            font-family: inherit;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
        }

        .btn-save {
            background: #3685ff;
            color: white;
            flex: 1;
        }

        .btn-save:hover {
            background: #246bd6;
        }

        .btn-cancel {
            background: #253552;
            color: white;
        }

        @media(max-width: 600px) {
            body {
                padding: 25px 15px;
            }

            .card {
                padding: 20px;
            }

            .header h1 {
                font-size: 22px;
            }

            .buttons {
                flex-direction: column;
            }

            .btn-save,
            .btn-cancel {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <a href="{{ url('/admin/teams/'.$team->id) }}" class="back">
        ← Kembali ke Detail Tim
    </a>

    <div class="header">
        <small>ARENA Z / ADMIN PANEL</small>
        <h1>EDIT DATA TIM</h1>
        <p>Perbarui informasi pendaftaran tim Mobile Legends.</p>
    </div>

    <div class="card">

        @if ($errors->any())
            <div class="alert">
                <strong>Periksa kembali data berikut:</strong>
                <ul style="margin-left: 20px; margin-top: 8px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/admin/teams/'.$team->id.'/update') }}" method="POST">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Tim</label>
                <input
                    type="text"
                    name="team_name"
                    value="{{ old('team_name', $team->team_name) }}"
                    required
                >
                @error('team_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Asal Sekolah</label>
                <input
                    type="text"
                    name="school_name"
                    value="{{ old('school_name', $team->school_name) }}"
                    required
                >
                @error('school_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Nama Ketua Tim</label>
                <input
                    type="text"
                    name="leader_name"
                    value="{{ old('leader_name', $team->leader_name) }}"
                    required
                >
                @error('leader_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Email Ketua Tim</label>
                <input
                    type="email"
                    name="leader_email"
                    value="{{ old('leader_email', $team->leader_email) }}"
                    required
                >
                @error('leader_email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Nomor WhatsApp</label>
                <input
                    type="text"
                    name="leader_phone"
                    value="{{ old('leader_phone', $team->leader_phone) }}"
                    required
                >
                @error('leader_phone')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="buttons">

                <a href="{{ url('/admin/teams/'.$team->id) }}" class="btn btn-cancel">
                    Batal
                </a>

                <button type="submit" class="btn btn-save">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>
