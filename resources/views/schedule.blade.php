@extends('layouts.app')

@section('title', 'Jadwal Pertandingan Esports — ARENA Z')

@section('content')
    <!-- Page Header -->
    <section style="padding: 60px 0 40px; background: radial-gradient(circle at 50% 10%, rgba(54, 133, 255, 0.12) 0%, transparent 65%); border-bottom: 1px solid var(--border-color);">
        <div class="container">
            <span class="section-tag">JADWAL PERTANDINGAN</span>
            <h1 style="font-size: 36px; color: var(--white); margin-bottom: 12px;">Jadwal Match Mobile Legends</h1>
            <p style="color: var(--text-muted); max-width: 620px; font-size: 15px;">
                Pantau seluruh jadwal pertandingan tim sekolahmu, jam tanding, babak eliminasi, dan hasil skor pertandingan terkini.
            </p>
        </div>
    </section>

    <!-- Schedule List & Filter -->
    <section style="padding: 50px 0 90px;">
        <div class="container">
            <!-- Filter Bar -->
            <div style="background-color: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 18px 24px; margin-bottom: 30px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                <div style="font-size: 14px; color: var(--text-muted);">
                    Menampilkan <strong style="color: var(--white);">{{ $schedules->count() }}</strong> Pertandingan
                </div>

                <form method="GET" action="{{ route('schedule') }}" style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                    <label for="tournament_filter" style="font-size: 13px; color: var(--text-muted);">Filter Turnamen:</label>
                    <select 
                        name="tournament_id" 
                        id="tournament_filter" 
                        onchange="this.form.submit()"
                        style="background: var(--bg-primary); border: 1px solid var(--border-color); color: var(--white); padding: 8px 14px; border-radius: var(--radius-md); font-family: inherit; font-size: 13px; outline: none; cursor: pointer;"
                    >
                        <option value="">Semua Turnamen</option>
                        @foreach ($tournaments as $t)
                            <option value="{{ $t->id }}" {{ ($tournamentId == $t->id) ? 'selected' : '' }}>
                                {{ $t->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- Matches List -->
            @forelse ($schedules as $match)
                <div class="match-card">
                    <div class="match-info-meta">
                        <span class="match-round">{{ $match->round }}</span>
                        <span class="match-time">
                            📅 {{ $match->match_date ? date('d M Y', strtotime($match->match_date)) : 'Tanggal Segera' }}
                        </span>
                        <span class="match-time">
                            ⏰ {{ $match->match_time ? substr($match->match_time, 0, 5) . ' WIB' : 'Jam TBA' }}
                        </span>
                        <span style="font-size: 11px; color: var(--blue-primary); margin-top: 4px;">
                            {{ $match->tournament?->name }}
                        </span>
                    </div>

                    <div class="match-teams-box">
                        <div class="team-entry">
                            <div class="team-avatar">
                                {{ strtoupper(substr($match->teamA?->team_name ?? 'T', 0, 1)) }}
                            </div>
                            <div>
                                <div class="team-detail-name">{{ $match->teamA?->team_name ?? 'Menunggu Tim' }}</div>
                                <div class="team-school-sub">{{ $match->teamA?->school_name ?? 'Slot Eliminasi' }}</div>
                            </div>
                        </div>

                        <div class="match-vs-score">
                            @if ($match->status === 'finished' && $match->result)
                                <div class="match-score-text">{{ $match->result }}</div>
                                <div style="font-size: 11px; color: var(--success); font-weight: 600; text-transform: uppercase;">SELESAI</div>
                            @elseif ($match->status === 'live')
                                <div class="match-score-text" style="color: var(--warning);">LIVE</div>
                            @else
                                <div class="match-vs-tag">VS</div>
                            @endif
                        </div>

                        <div class="team-entry team-right">
                            <div class="team-avatar">
                                {{ strtoupper(substr($match->teamB?->team_name ?? 'T', 0, 1)) }}
                            </div>
                            <div>
                                <div class="team-detail-name">{{ $match->teamB?->team_name ?? 'Menunggu Tim' }}</div>
                                <div class="team-school-sub">{{ $match->teamB?->school_name ?? 'Slot Eliminasi' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="match-action-box">
                        <x-status-badge :status="$match->status" />
                    </div>
                </div>
            @empty
                <div class="card" style="text-align: center; padding: 60px 20px;">
                    <div style="font-size: 40px; margin-bottom: 16px; color: var(--text-dim);">📅</div>
                    <h3 style="font-size: 20px; color: var(--white); margin-bottom: 8px;">Belum Ada Jadwal Pertandingan</h3>
                    <p style="color: var(--text-muted); font-size: 14px;">Jadwal pertandingan akan dirilis oleh panitia setelah bagan bracket di-generate.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection
