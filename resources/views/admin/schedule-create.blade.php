
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal - ARENA Z</title>

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #070b16;
            color: white;
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background: #101a2d;
            padding: 20px 7%;
            border-bottom: 1px solid #263653;
        }

        .logo {
            font-family: 'Orbitron', sans-serif;
            font-size: 24px;
            color: #3685ff;
            font-weight: 800;
        }

        .container {
            max-width: 750px;
            margin: 50px auto;
            padding: 0 25px;
        }

        .back {
            color: #60a5fa;
            text-decoration: none;
            font-size: 13px;
        }

        h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: 25px;
            margin: 25px 0 10px;
        }

        .subtitle {
            color: #91a0b8;
            font-size: 13px;
            margin-bottom: 30px;
        }

        .form-card {
            background: #101a2d;
            border: 1px solid #263653;
            padding: 30px;
            border-radius: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 13px;
            margin-bottom: 9px;
            color: #c5cde0;
        }

        input, select {
            width: 100%;
            padding: 13px;
            background: #070b16;
            border: 1px solid #334563;
            border-radius: 8px;
            color: white;
            font-family: inherit;
            outline: none;
        }

        input:focus, select:focus {
            border-color: #3685ff;
        }

        select option {
            background: #101a2d;
        }

        .error {
            color: #fb7185;
            font-size: 11px;
            margin-top: 6px;
        }

        .error-box {
            background: #4b2028;
            border: 1px solid #e34b5b;
            color: #fecdd3;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 12px;
        }

        .submit-button {
            width: 100%;
            background: #3685ff;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-family: inherit;
            font-weight: 700;
            cursor: pointer;
            margin-top: 10px;
        }

        .submit-button:hover {
            background: #2563eb;
        }

        .empty {
            background: #493915;
            border: 1px solid #a87916;
            color: #facc15;
            padding: 15px;
            border-radius: 8px;
            font-size: 12px;
            line-height: 1.7;
        }

        @media(max-width: 600px) {
            .form-card {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<nav class="navbar">
    <div class="logo">ARENA Z</div>
</nav>

<main class="container">

    <a href="{{ url('/admin/schedules') }}" class="back">
        ← Kembali ke Kelola Jadwal
    </a>

    <h1>TAMBAH JADWAL</h1>
    <p class="subtitle">
        Atur pertandingan turnamen Mobile Legends ARENA Z.
    </p>

    @if ($errors->any())
        <div class="error-box">
            <strong>Periksa kembali data berikut:</strong>
            <ul style="margin-left: 20px; margin-top: 8px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($tournaments->isEmpty())
        <div class="empty">
            Belum ada turnamen. Tambahkan data turnamen terlebih dahulu.
        </div>
    @elseif ($teams->count() < 2)
        <div class="empty">
            Minimal harus ada 2 tim yang sudah disetujui admin
            untuk membuat pertandingan.
        </div>
    @else

        <div class="form-card">

            <form action="{{ url('/admin/schedules') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Pilih Turnamen</label>
                    <select name="tournament_id" id="tournament_id" required>
                        <option value="">-- Pilih Turnamen --</option>

                        @foreach ($tournaments as $tournament)
                            <option value="{{ $tournament->id }}"
                                {{ old('tournament_id') == $tournament->id ? 'selected' : '' }}>
                                {{ $tournament->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tournament_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Babak Pertandingan</label>
                    <select name="round" required>
                        <option value="">-- Pilih Babak --</option>
                        <option value="Round of 64" {{ old('round') == 'Round of 64' ? 'selected' : '' }}>
                            Round of 64
                        </option>
                        <option value="Round of 32" {{ old('round') == 'Round of 32' ? 'selected' : '' }}>
                            Round of 32
                        </option>
                        <option value="Round of 16" {{ old('round') == 'Round of 16' ? 'selected' : '' }}>
                            Round of 16
                        </option>
                        <option value="Quarterfinal" {{ old('round') == 'Quarterfinal' ? 'selected' : '' }}>
                            Quarterfinal
                        </option>
                        <option value="Semifinal" {{ old('round') == 'Semifinal' ? 'selected' : '' }}>
                            Semifinal
                        </option>
                        <option value="Final" {{ old('round') == 'Final' ? 'selected' : '' }}>
                            Final
                        </option>
                    </select>
                    @error('round')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Tim A</label>
                    <select name="team_a_id" id="team_a_id" required>
                        <option value="">-- Pilih Tim A --</option>
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}"
                                data-tournament="{{ $team->tournament_id }}"
                                {{ old('team_a_id') == $team->id ? 'selected' : '' }}>
                                {{ $team->team_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('team_a_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Tim B</label>
                    <select name="team_b_id" id="team_b_id" required>
                        <option value="">-- Pilih Tim B --</option>
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}"
                                data-tournament="{{ $team->tournament_id }}"
                                {{ old('team_b_id') == $team->id ? 'selected' : '' }}>
                                {{ $team->team_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('team_b_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Tanggal Pertandingan</label>
                    <input type="date" name="match_date"
                        value="{{ old('match_date') }}">
                    @error('match_date')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Waktu Pertandingan</label>
                    <input type="time" name="match_time"
                        value="{{ old('match_time') }}">
                    @error('match_time')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="submit-button">
                    SIMPAN JADWAL PERTANDINGAN
                </button>

            </form>

        </div>

    @endif

</main>

<script>
    const tournamentSelect = document.getElementById('tournament_id');
    const teamASelect = document.getElementById('team_a_id');
    const teamBSelect = document.getElementById('team_b_id');

    function filterTeams() {
        if (!tournamentSelect || !teamASelect || !teamBSelect) {
            return;
        }

        const tournamentId = tournamentSelect.value;

        [teamASelect, teamBSelect].forEach(select => {
            Array.from(select.options).forEach(option => {
                if (!option.value) return;

                const sameTournament =
                    option.dataset.tournament === tournamentId;

                option.hidden = !sameTournament;
                option.disabled = !sameTournament;
            });

            const selectedOption = select.options[select.selectedIndex];

            if (selectedOption && selectedOption.disabled) {
                select.value = '';
            }
        });

        updateTeamB();
    }

    function updateTeamB() {
        if (!teamASelect || !teamBSelect) return;

        const selectedTeamA = teamASelect.value;

        Array.from(teamBSelect.options).forEach(option => {
            if (!option.value) return;

            const sameTournament =
                option.dataset.tournament === tournamentSelect.value;

            const isSameTeam = option.value === selectedTeamA;

            option.hidden = !sameTournament || isSameTeam;
            option.disabled = !sameTournament || isSameTeam;
        });

        const selectedTeamB = teamBSelect.options[teamBSelect.selectedIndex];

        if (selectedTeamB && selectedTeamB.disabled) {
            teamBSelect.value = '';
        }
    }

    if (tournamentSelect) {
        tournamentSelect.addEventListener('change', filterTeams);
        teamASelect.addEventListener('change', updateTeamB);

        filterTeams();
    }
</script>

</body>
</html>
