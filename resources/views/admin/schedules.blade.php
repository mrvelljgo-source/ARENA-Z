
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jadwal - ARENA Z</title>

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #070b16;
            color: white;
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background: #101a2d;
            padding: 20px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #263653;
        }

        .logo {
            font-family: 'Orbitron', sans-serif;
            font-size: 24px;
            color: #3685ff;
            font-weight: 800;
        }

        .logout button {
            background: #e34b5b;
            color: white;
            border: none;
            padding: 10px 17px;
            border-radius: 7px;
            cursor: pointer;
            font-weight: 600;
        }

        .container {
            max-width: 1300px;
            margin: 45px auto;
            padding: 0 25px;
        }

        h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: 25px;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #91a0b8;
            font-size: 13px;
            margin-bottom: 30px;
        }

        .success {
            background: #123d2b;
            color: #4ade80;
            border: 1px solid #22c55e;
            padding: 15px;
            border-radius: 9px;
            margin-bottom: 20px;
        }

        .errors {
            background: #451a1a;
            color: #fca5a5;
            border: 1px solid #dc3545;
            padding: 15px;
            border-radius: 9px;
            margin-bottom: 20px;
        }

        .schedule-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: stretch;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 25px;
        }

        .generate-form {
            flex: 1;
            min-width: 290px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            padding: 16px;
            background: #101a2d;
            border: 1px solid #263653;
            border-radius: 10px;
        }

        .generate-form p {
            flex: 1 1 100%;
            color: #91a0b8;
            font-size: 11px;
            line-height: 1.6;
        }

        .replace-option {
            flex: 1 1 100%;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            color: #fca5a5;
            font-size: 10px;
            line-height: 1.6;
        }

        .replace-option input {
            margin-top: 2px;
        }

        .generate-form select {
            flex: 1;
            min-width: 210px;
            padding: 11px;
            background: #070b16;
            border: 1px solid #334563;
            border-radius: 7px;
            color: white;
            font: inherit;
            font-size: 12px;
        }

        .generate-button {
            background: #3685ff;
            color: white;
            border: 0;
            padding: 12px 18px;
            border-radius: 7px;
            font: inherit;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .no-tournament {
            flex: 1;
            min-width: 290px;
            padding: 16px;
            background: #101a2d;
            border: 1px solid #263653;
            border-radius: 10px;
            color: #91a0b8;
            font-size: 12px;
            line-height: 1.7;
        }

        .schedule-form {
            display: grid;
            gap: 6px;
            min-width: 155px;
        }

        .schedule-form input {
            min-width: 0;
            padding: 7px;
            background: #070b16;
            border: 1px solid #334766;
            border-radius: 6px;
            color: white;
            font: inherit;
            font-size: 10px;
        }

        .schedule-form button {
            background: #2563eb;
            color: white;
            border: 0;
            padding: 7px;
            border-radius: 6px;
            font: inherit;
            font-size: 10px;
            font-weight: 600;
            cursor: pointer;
        }

        .bracket-generated {
            color: #91a0b8;
            font-size: 10px;
        }

        .reset-button {
            background: #8f2737;
            border: 1px solid #c8324a;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s, border-color .2s;
        }

        .reset-button:hover {
            background: #b52e43;
            border-color: #ef5268;
        }

        .table-wrapper {
            overflow-x: auto;
            background: #101a2d;
            border: 1px solid #263653;
            border-radius: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1100px;
        }

        th, td {
            padding: 15px 12px;
            text-align: left;
            border-bottom: 1px solid #263653;
            font-size: 12px;
        }

        th {
            color: #60a5fa;
            background: #14223a;
        }

        td { color: #c5cde0; }

        .status {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
        }

        .upcoming { background: #493915; color: #facc15; }
        .live { background: #123d2b; color: #4ade80; }
        .finished { background: #263653; color: #aab5cb; }

        .actions {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .actions form { display: inline; }

        .actions button {
            border: none;
            padding: 7px 9px;
            border-radius: 6px;
            cursor: pointer;
            color: white;
            font-size: 10px;
            font-weight: 600;
        }

        .btn-upcoming { background: #a87916; }
        .btn-live { background: #16834b; }
        .btn-finished { background: #475569; }
        .btn-delete { background: #dc3545; }
        .btn-result { background: #2563eb; }

        .result-form {
            display: flex;
            gap: 5px;
            min-width: 190px;
        }

        .result-form input {
            width: 120px;
            padding: 8px;
            border: 1px solid #334766;
            border-radius: 6px;
            background: #070b16;
            color: white;
            font-family: 'Poppins', sans-serif;
            font-size: 11px;
        }

        .result-form input:focus {
            outline: 1px solid #3685ff;
        }

        .empty {
            text-align: center;
            padding: 35px;
            color: #91a0b8;
        }

        .back {
            display: inline-block;
            color: #60a5fa;
            text-decoration: none;
            font-size: 13px;
            margin-bottom: 20px;
        }

        @media(max-width: 650px) {
            .navbar { padding: 18px 5%; }
            .container { margin-top: 30px; }
        }
    </style>
</head>

<body>

<nav class="navbar">
    <div class="logo">ARENA Z</div>

    <form class="logout" action="{{ url('/logout') }}" method="POST">
        @csrf
        <button type="submit">LOGOUT</button>
    </form>
</nav>

<main class="container">

    <a href="{{ url('/admin/dashboard') }}" class="back">
        ← Kembali ke Dashboard
    </a>

    <h1>KELOLA JADWAL</h1>
    <p class="subtitle">
        Kelola jadwal dan hasil pertandingan Mobile Legends ARENA Z.
    </p>

    @if (session('success'))
        <div class="success">✓ {{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="errors">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="schedule-actions">
        @php
            $eligibleTournaments = $tournaments->filter(
                fn ($tournament) => $tournament->approved_teams_count >= 2
            );
        @endphp

        @if ($eligibleTournaments->isNotEmpty())
            <form class="generate-form"
                action="{{ url('/admin/schedules/generate') }}"
                method="POST"
                onsubmit="return confirm('Buat bracket otomatis? Jika jadwal turnamen ini sudah ada, semua jadwal dan hasil lamanya akan diganti.')">
                @csrf
                <p>
                    Bracket single elimination dibuat dari tim yang sudah disetujui.
                    Tim yang kalah langsung gugur, pemenang otomatis maju ke babak berikutnya.
                    Atur tanggal dan waktu pertandingan di tabel ini.
                </p>
                <select name="tournament_id" required>
                    <option value="">-- Pilih turnamen --</option>
                    @foreach ($eligibleTournaments as $tournament)
                        <option value="{{ $tournament->id }}">
                            {{ $tournament->name }} ({{ $tournament->approved_teams_count }} tim
                            @if ($tournament->match_schedules_count > 0)
                                · {{ $tournament->match_schedules_count }} jadwal akan diganti
                            @endif
                            )
                        </option>
                    @endforeach
                </select>
                <label class="replace-option">
                    <input type="checkbox" name="replace_existing" value="1">
                    Saya paham jadwal dan hasil turnamen yang dipilih akan dihapus jika bracket lama diganti.
                </label>
                <button type="submit" class="generate-button">Buat Bracket Single Elimination</button>
            </form>
        @else
            <div class="no-tournament">
                Belum ada turnamen yang siap dibuat bracket. Pastikan minimal 2 tim sudah disetujui admin.
            </div>
        @endif

        @if ($schedules->isNotEmpty())
            <form action="{{ url('/admin/schedules/reset') }}"
                method="POST"
                onsubmit="return confirm('Reset semua jadwal dan hasil pertandingan di seluruh turnamen? Data tim dan turnamen tidak akan dihapus.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="reset-button">
                    Reset Semua Jadwal
                </button>
            </form>
        @endif
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Turnamen</th>
                    <th>Tim A</th>
                    <th>Tim B</th>
                    <th>Babak</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Atur Jadwal</th>
                    <th>Hasil</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($schedules as $index => $schedule)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $schedule->tournament->name ?? '-' }}</td>
                        <td>{{ $schedule->teamA->team_name ?? ($schedule->result === 'BYE' ? 'BYE' : ($schedule->result === 'SKIPPED' ? 'Tidak dimainkan' : 'Menunggu tim')) }}</td>
                        <td>{{ $schedule->teamB->team_name ?? ($schedule->result === 'BYE' ? 'BYE' : ($schedule->result === 'SKIPPED' ? 'Tidak dimainkan' : 'Menunggu tim')) }}</td>
                        <td>{{ $schedule->round }}</td>

                        <td>
                            {{ $schedule->match_date
                                ? \Carbon\Carbon::parse($schedule->match_date)->format('d-m-Y')
                                : 'Belum ditentukan' }}
                        </td>

                        <td>
                            {{ $schedule->match_time
                                ? substr($schedule->match_time, 0, 5)
                                : 'Belum ditentukan' }}
                        </td>

                        <td>
                            @if (in_array($schedule->result, ['BYE', 'SKIPPED'], true))
                                <span class="bracket-generated">
                                    {{ $schedule->result === 'BYE' ? 'Lolos otomatis' : 'Tidak diperlukan' }}
                                </span>
                            @else
                                <form class="schedule-form"
                                    action="{{ url('/admin/schedules/'.$schedule->id.'/schedule') }}"
                                    method="POST">
                                    @csrf
                                    <input type="date" name="match_date"
                                        value="{{ $schedule->match_date }}">
                                    <input type="time" name="match_time"
                                        value="{{ $schedule->match_time ? substr($schedule->match_time, 0, 5) : '' }}">
                                    <button type="submit">Simpan Jadwal</button>
                                </form>
                            @endif
                        </td>

                        <td>
                            {{ $schedule->result && ! in_array($schedule->result, ['BYE', 'SKIPPED'], true)
                                ? $schedule->result
                                : (in_array($schedule->result, ['BYE', 'SKIPPED'], true)
                                    ? ($schedule->result === 'BYE' ? 'BYE (auto)' : 'Tidak dimainkan')
                                    : 'Belum ada hasil') }}

                            @if ($schedule->team_a_id && $schedule->team_b_id)
                                <form class="result-form"
                                    action="{{ url('/admin/schedules/'.$schedule->id.'/result') }}"
                                    method="POST">
                                    @csrf

                                    <input
                                        type="text"
                                        name="result"
                                        placeholder="Contoh: 2-1"
                                        value="{{ $schedule->result === 'BYE' ? '' : $schedule->result }}"
                                        required
                                        pattern="[0-9]+-[0-9]+"
                                        title="Masukkan skor seperti 2-1"
                                    >

                                    <button type="submit" class="btn-result">
                                        Simpan
                                    </button>
                                </form>
                            @else
                                <span class="bracket-generated">Menunggu kedua tim ditentukan</span>
                            @endif
                        </td>

                        <td>
                            @if ($schedule->status == 'upcoming')
                                <span class="status upcoming">UPCOMING</span>
                            @elseif ($schedule->status == 'live')
                                <span class="status live">LIVE</span>
                            @else
                                <span class="status finished">FINISHED</span>
                            @endif
                        </td>

                        <td>
                            <div class="actions">

                                @if ($schedule->status != 'upcoming')
                                    <form action="{{ url('/admin/schedules/'.$schedule->id.'/upcoming') }}" method="POST">
                                        @csrf
                                        <button class="btn-upcoming">Upcoming</button>
                                    </form>
                                @endif

                                @if ($schedule->status != 'live')
                                    <form action="{{ url('/admin/schedules/'.$schedule->id.'/live') }}" method="POST">
                                        @csrf
                                        <button class="btn-live">Live</button>
                                    </form>
                                @endif

                                @if ($schedule->status != 'finished')
                                    <form action="{{ url('/admin/schedules/'.$schedule->id.'/finished') }}" method="POST">
                                        @csrf
                                        <button class="btn-finished">Finished</button>
                                    </form>
                                @endif

                                @if ($schedule->is_bracket_generated)
                                    <span class="bracket-generated">Bagian dari bracket</span>
                                @else
                                    <form action="{{ url('/admin/schedules/'.$schedule->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-delete">Hapus</button>
                                    </form>
                                @endif

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="empty">
                            Belum ada jadwal pertandingan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</main>

</body>
</html>
