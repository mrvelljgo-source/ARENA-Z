
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Tim - ARENA Z</title>

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

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
        }

        .sidebar {
            width: 245px;
            background: #0d1425;
            border-right: 1px solid #202e47;
            padding: 30px 20px;
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 10;
        }

        .logo {
            font-family: 'Orbitron', sans-serif;
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .logo span { color: #3685ff; }

        .sidebar-label {
            color: #65738f;
            font-size: 10px;
            letter-spacing: 2px;
            margin: 35px 0 15px 12px;
        }

        .sidebar a {
            display: block;
            color: #aab5ca;
            text-decoration: none;
            padding: 13px 15px;
            margin-bottom: 8px;
            border-radius: 9px;
            font-size: 13px;
            transition: .3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(54,133,255,.13);
            color: #69a5ff;
            border-left: 3px solid #3685ff;
        }

        .logout {
            width: 100%;
            margin-top: 35px;
            padding: 12px;
            background: rgba(229,57,80,.1);
            border: 1px solid rgba(229,57,80,.3);
            border-radius: 8px;
            color: #ff7185;
            cursor: pointer;
            font-family: inherit;
        }

        .main {
            margin-left: 245px;
            padding: 40px;
            max-width: 1600px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 35px;
        }

        .header small {
            color: #3685ff;
            font-size: 10px;
            letter-spacing: 3px;
        }

        .header h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: 25px;
            margin: 10px 0;
        }

        .header p {
            color: #8d9bb5;
            font-size: 12px;
        }

        .admin-label {
            padding: 10px 16px;
            background: #121d34;
            border: 1px solid #253552;
            border-radius: 8px;
            color: #83b5ff;
            font-size: 11px;
        }

        .alert {
            background: rgba(46,204,113,.1);
            border: 1px solid rgba(46,204,113,.3);
            color: #5ee4a0;
            padding: 14px 18px;
            border-radius: 9px;
            margin-bottom: 25px;
            font-size: 12px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 30px;
        }

        .stat-box {
            padding: 22px;
            background: linear-gradient(145deg,#121d34,#0c1323);
            border: 1px solid #253552;
            border-radius: 13px;
            transition: .3s;
        }

        .stat-box:hover {
            transform: translateY(-4px);
            border-color: #3685ff;
        }

        .stat-box p {
            color: #8d9bb5;
            font-size: 11px;
        }

        .stat-box h2 {
            font-family: 'Orbitron', sans-serif;
            font-size: 28px;
            margin-top: 12px;
        }

        .total h2 { color: #83b5ff; }
        .pending h2 { color: #ffcf70; }
        .approved h2 { color: #5ee4a0; }
        .rejected h2 { color: #ff7185; }

        .card {
            background: #101a2d;
            border: 1px solid #202e47;
            padding: 25px;
            border-radius: 14px;
        }

        .card-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .card-heading h2 {
            font-family: 'Orbitron', sans-serif;
            font-size: 16px;
        }

        .card-heading span {
            color: #8d9bb5;
            font-size: 11px;
        }

        .btn-export {
            padding: 11px 17px;
            background: linear-gradient(135deg, #16865b, #20a875);
            border: 1px solid rgba(94,228,160,.3);
            border-radius: 8px;
            color: white;
            text-decoration: none;
            font-family: inherit;
            font-size: 11px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: .3s;
        }

        .btn-export:hover {
            background: #20a875;
            transform: translateY(-2px);
        }

        .filter-form {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        .filter-form input,
        .filter-form select {
            padding: 13px 15px;
            background: #0b1425;
            border: 1px solid #253552;
            border-radius: 8px;
            color: white;
            font-family: inherit;
            font-size: 12px;
            outline: none;
        }

        .filter-form input {
            flex: 1;
            min-width: 220px;
        }

        .filter-form input:focus,
        .filter-form select:focus {
            border-color: #3685ff;
        }

        .filter-form select {
            min-width: 160px;
        }

        .filter-form select option {
            background: #101a2d;
            color: white;
        }

        .btn-search,
        .btn-reset {
            padding: 13px 20px;
            border: none;
            border-radius: 8px;
            color: white;
            font-family: inherit;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-search {
            background: #3685ff;
        }

        .btn-search:hover {
            background: #246bd6;
        }

        .btn-reset {
            background: #253552;
        }

        .btn-reset:hover {
            background: #344969;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1050px;
        }

        th, td {
            padding: 15px 12px;
            text-align: left;
            border-bottom: 1px solid #253149;
            font-size: 11px;
        }

        th {
            color: #8d9bb5;
            font-weight: 500;
            letter-spacing: .5px;
        }

        td { color: #e1e8f5; }

        tbody tr:hover {
            background: rgba(54,133,255,.035);
        }

        .status {
            display: inline-block;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
        }

        .status.pending {
            background: rgba(255,190,70,.12);
            color: #ffcf70;
        }

        .status.approved {
            background: rgba(46,204,113,.12);
            color: #5ee4a0;
        }

        .status.rejected {
            background: rgba(229,57,80,.12);
            color: #ff7185;
        }

        .actions {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: nowrap;
            min-width: max-content;
        }

        .actions form {
            display: flex;
            margin: 0;
        }

        .btn {
            min-width: 82px;
            min-height: 36px;
            padding: 0 12px;
            border: 1px solid transparent;
            border-radius: 8px;
            color: white;
            font-family: inherit;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: transform .2s, filter .2s, border-color .2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            white-space: nowrap;
        }

        .btn:hover {
            transform: translateY(-1px);
            filter: brightness(1.12);
        }

        .btn:focus-visible {
            outline: 2px solid #ffffff;
            outline-offset: 2px;
        }

        .btn-detail { background: #2563eb; }
        .btn-approve { background: #16865b; }
        .btn-reject { background: #c8324a; }

        .empty {
            text-align: center;
            color: #8d9bb5;
            padding: 40px;
        }

        .back {
            color: #69a5ff;
            text-decoration: none;
            display: inline-block;
            margin-top: 25px;
            font-size: 12px;
        }

        @media(max-width: 1050px) {
            .stats { grid-template-columns: repeat(2,1fr); }
            .main { padding: 25px; }
        }

        @media(max-width: 650px) {
            .sidebar {
                position: relative;
                width: 100%;
                padding: 20px;
            }

            .sidebar-label { margin-top: 20px; }

            .sidebar a {
                display: inline-block;
                padding: 10px;
                font-size: 11px;
            }

            .logout { margin-top: 10px; }

            .main {
                margin-left: 0;
                padding: 20px 15px;
            }

            .stats { gap: 10px; }
            .stat-box { padding: 15px; }
            .stat-box h2 { font-size: 23px; }
            .header h1 { font-size: 21px; }
            .card { padding: 15px; }

            .filter-form {
                flex-direction: column;
            }

            .filter-form input,
            .filter-form select,
            .btn-search,
            .btn-reset {
                width: 100%;
            }

            .card-heading {
                align-items: flex-start;
            }

            .btn-export {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<aside class="sidebar">

    <div class="logo">ARENA<span>Z.</span></div>

    <div class="sidebar-label">MAIN MENU</div>

    <a href="{{ url('/admin/dashboard') }}">▦ Dashboard</a>
    <a href="{{ url('/admin/teams') }}" class="active">♧ Kelola Tim</a>
    <a href="{{ url('/admin/schedules') }}">◷ Kelola Jadwal</a>
    <a href="{{ url('/jadwal') }}">▤ Jadwal Publik</a>

    <form action="{{ url('/logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout">↪ Logout</button>
    </form>

</aside>

<main class="main">

    <div class="header">
        <div>
            <small>ARENA Z ADMIN PANEL</small>
            <h1>TEAM MANAGEMENT</h1>
            <p>Kelola dan verifikasi pendaftaran tim Mobile Legends.</p>
        </div>

        <div class="admin-label">● ADMINISTRATOR</div>
    </div>

    @if (session('success'))
        <div class="alert">
            ✓ {{ session('success') }}
        </div>
    @endif

    <div class="stats">

        <div class="stat-box total">
            <p>Total Tim Terdaftar</p>
            <h2>{{ $totalTeams }}</h2>
        </div>

        <div class="stat-box pending">
            <p>Menunggu Persetujuan</p>
            <h2>{{ $totalPending }}</h2>
        </div>

        <div class="stat-box approved">
            <p>Tim Disetujui</p>
            <h2>{{ $totalApproved }}</h2>
        </div>

        <div class="stat-box rejected">
            <p>Tim Ditolak</p>
            <h2>{{ $totalRejected }}</h2>
        </div>

    </div>

    <section class="card">

        <div class="card-heading">
            <div>
                <h2>DAFTAR PENDAFTARAN TIM</h2>
                <span>{{ $teams->count() }} pendaftaran ditemukan</span>
            </div>

            <a href="{{ url('/admin/teams/export') }}" class="btn-export">
                ↓ Download Excel
            </a>
        </div>

        <form action="{{ url('/admin/teams') }}" method="GET" class="filter-form">

            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Cari nama tim, sekolah, atau ketua..."
            >

            <select name="status">
                <option value="">Semua Status</option>
                <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>
                    Pending
                </option>
                <option value="approved" {{ $status == 'approved' ? 'selected' : '' }}>
                    Approved
                </option>
                <option value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>
                    Rejected
                </option>
            </select>

            <button type="submit" class="btn-search">
                Cari / Filter
            </button>

            <a href="{{ url('/admin/teams') }}" class="btn-reset">
                Reset
            </a>

        </form>

        <div class="table-container">

            <table>
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NAMA TIM</th>
                        <th>SEKOLAH</th>
                        <th>KETUA TIM</th>
                        <th>EMAIL</th>
                        <th>WHATSAPP</th>
                        <th>TURNAMEN</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($teams as $index => $team)

                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $team->team_name }}</strong></td>
                            <td>{{ $team->school_name }}</td>
                            <td>{{ $team->leader_name }}</td>
                            <td>{{ $team->leader_email }}</td>
                            <td>{{ $team->leader_phone }}</td>
                            <td>{{ $team->tournament->name ?? '-' }}</td>

                            <td>
                                @if ($team->status === 'pending')
                                    <span class="status pending">PENDING</span>
                                @elseif ($team->status === 'approved')
                                    <span class="status approved">APPROVED</span>
                                @else
                                    <span class="status rejected">REJECTED</span>
                                @endif
                            </td>

                            <td>
                                <div class="actions">

                                    <a href="{{ url('/admin/teams/'.$team->id) }}"
                                       class="btn btn-detail">
                                        Detail
                                    </a>

                                    <form action="{{ url('/admin/teams/'.$team->id.'/approved') }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menyetujui pendaftaran tim ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-approve">
                                            Setujui
                                        </button>
                                    </form>

                                    <form action="{{ url('/admin/teams/'.$team->id.'/rejected') }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menolak pendaftaran tim ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-reject">
                                            Tolak
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="9" class="empty">
                                Tidak ada pendaftaran yang cocok dengan pencarian atau filter.
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>

        </div>

    </section>

    <a href="{{ url('/admin/dashboard') }}" class="back">
        ← Kembali ke Dashboard
    </a>

</main>

</body>
</html>
