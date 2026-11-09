
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

        .add-button {
            display: inline-block;
            background: #3685ff;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 25px;
        }

        .schedule-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
            margin-bottom: 25px;
        }

        .schedule-actions .add-button {
            margin-bottom: 0;
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
        <a href="{{ url('/admin/schedules/create') }}" class="add-button">
            + Tambah Jadwal Pertandingan
        </a>

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
                        <td>{{ $schedule->teamA->team_name ?? '-' }}</td>
                        <td>{{ $schedule->teamB->team_name ?? '-' }}</td>
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
                            {{ $schedule->result ?? 'Belum ada hasil' }}

                            <form class="result-form"
                                action="{{ url('/admin/schedules/'.$schedule->id.'/result') }}"
                                method="POST">
                                @csrf

                                <input
                                    type="text"
                                    name="result"
                                    placeholder="Contoh: 2-1"
                                    value="{{ $schedule->result }}"
                                    required
                                    maxlength="30"
                                >

                                <button type="submit" class="btn-result">
                                    Simpan
                                </button>
                            </form>
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

                                <form action="{{ url('/admin/schedules/'.$schedule->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-delete">Hapus</button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="empty">
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
