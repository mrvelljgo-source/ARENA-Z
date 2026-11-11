@extends('layouts.user-dashboard')

@section('title', 'Dashboard Saya')
@section('page-title', 'Dashboard')

@section('content')

    {{-- Welcome Card --}}
    <div class="ud-welcome-card">
        <div class="ud-welcome-eyebrow">PLAYER DASHBOARD / ARENA Z</div>
        <div class="ud-welcome-name">Selamat datang, <span>{{ auth()->user()->name }}</span>!</div>
        <div class="ud-welcome-desc">Pantau tim, jadwal pertandingan, dan perjalanan turnamenmu di sini.</div>
    </div>

    {{-- Stats Grid --}}
    <div class="ud-stats-grid">
        <div class="ud-stat-card">
            <div class="ud-stat-top">
                <div class="ud-stat-label">Total Tim</div>
                <div class="ud-stat-icon icon-blue"><i class="fas fa-users"></i></div>
            </div>
            <div class="ud-stat-value">{{ $totalTeams }}</div>
            <div class="ud-stat-sub">Tim yang didaftarkan</div>
        </div>

        <div class="ud-stat-card">
            <div class="ud-stat-top">
                <div class="ud-stat-label">Disetujui</div>
                <div class="ud-stat-icon icon-green"><i class="fas fa-circle-check"></i></div>
            </div>
            <div class="ud-stat-value">{{ $totalApproved }}</div>
            <div class="ud-stat-sub">Tim terverifikasi</div>
        </div>

        <div class="ud-stat-card">
            <div class="ud-stat-top">
                <div class="ud-stat-label">Menunggu</div>
                <div class="ud-stat-icon icon-yellow"><i class="fas fa-clock"></i></div>
            </div>
            <div class="ud-stat-value">{{ $totalPending }}</div>
            <div class="ud-stat-sub">Menunggu verifikasi</div>
        </div>

        <div class="ud-stat-card">
            <div class="ud-stat-top">
                <div class="ud-stat-label">Jadwal Mendatang</div>
                <div class="ud-stat-icon icon-purple"><i class="fas fa-calendar-days"></i></div>
            </div>
            <div class="ud-stat-value">{{ $upcomingMatches->count() }}</div>
            <div class="ud-stat-sub">Pertandingan mendekat</div>
        </div>
    </div>

    {{-- Main Two-col --}}
    <div class="ud-two-col">

        {{-- Left: Teams overview --}}
        <div class="ud-card">
            <div class="ud-card-header">
                <div class="ud-card-title">
                    <i class="fas fa-shield-halved"></i> Tim Saya
                </div>
                <a href="{{ route('user.my-teams') }}" class="ud-card-link">Lihat Semua →</a>
            </div>

            @forelse ($teams as $team)
                <div class="ud-team-card" style="margin-bottom: 10px;">
                    <div class="ud-team-avatar">
                        {{ strtoupper(substr($team->team_name, 0, 1)) }}
                    </div>
                    <div class="ud-team-info">
                        <div class="ud-team-name">{{ $team->team_name }}</div>
                        <div class="ud-team-school">{{ $team->school_name }}</div>
                        <div class="ud-team-tournament">{{ $team->tournament->name ?? '-' }}</div>
                    </div>
                    <div>
                        @php
                            $statusClass = match($team->status) {
                                'approved' => 'ud-badge-approved',
                                'pending' => 'ud-badge-pending',
                                'rejected' => 'ud-badge-rejected',
                                default => 'ud-badge-upcoming',
                            };
                            $statusLabel = match($team->status) {
                                'approved' => 'Disetujui',
                                'pending' => 'Menunggu',
                                'rejected' => 'Ditolak',
                                default => ucfirst($team->status),
                            };
                        @endphp
                        <span class="ud-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                    </div>
                </div>
            @empty
                <div class="ud-empty" style="padding: 32px 20px;">
                    <div class="ud-empty-icon"><i class="fas fa-users-slash"></i></div>
                    <div class="ud-empty-title">Belum Ada Tim</div>
                    <div class="ud-empty-desc">Daftarkan tim sekolahmu untuk ikut turnamen ARENA Z.</div>
                    <a href="{{ route('user.team.create') }}" class="ud-btn ud-btn-primary">
                        <i class="fas fa-plus"></i> Daftar Tim Sekarang
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Right: Upcoming matches + quick actions --}}
        <div>
            {{-- Upcoming Matches --}}
            <div class="ud-card" style="margin-bottom: 20px;">
                <div class="ud-card-header">
                    <div class="ud-card-title">
                        <i class="fas fa-calendar-check"></i> Jadwal Mendatang
                    </div>
                    <a href="{{ route('user.my-schedule') }}" class="ud-card-link">Semua →</a>
                </div>

                @forelse ($upcomingMatches as $match)
                    @php
                        $myTeamIds = $teams->pluck('id');
                        $isTeamA = $myTeamIds->contains($match->team_a_id);
                        $isTeamB = $myTeamIds->contains($match->team_b_id);
                    @endphp
                    <div class="ud-match-card">
                        <div>
                            <div class="ud-match-round">{{ $match->round }}</div>
                            <div class="ud-match-time">
                                {{ $match->match_date ? date('d M', strtotime($match->match_date)) : 'TBA' }}
                                {{ $match->match_time ? '• ' . substr($match->match_time, 0, 5) : '' }}
                            </div>
                        </div>

                        <div class="ud-match-teams">
                            <div class="ud-match-team {{ $isTeamA ? 'is-my-team' : '' }}">
                                <div class="ud-match-team-avatar">
                                    {{ strtoupper(substr($match->teamA?->team_name ?? 'T', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="ud-match-team-name">{{ $match->teamA?->team_name ?? 'TBD' }}</div>
                                </div>
                            </div>

                            <div class="ud-match-vs">VS</div>

                            <div class="ud-match-team right {{ $isTeamB ? 'is-my-team' : '' }}">
                                <div class="ud-match-team-avatar">
                                    {{ strtoupper(substr($match->teamB?->team_name ?? 'T', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="ud-match-team-name">{{ $match->teamB?->team_name ?? 'TBD' }}</div>
                                </div>
                            </div>
                        </div>

                        @php
                            $badgeClass = match($match->status) {
                                'live' => 'ud-badge-live',
                                'finished' => 'ud-badge-finished',
                                default => 'ud-badge-upcoming',
                            };
                        @endphp
                        <span class="ud-badge {{ $badgeClass }}">{{ strtoupper($match->status) }}</span>
                    </div>
                @empty
                    <div class="ud-empty" style="padding: 24px 16px;">
                        <div class="ud-empty-desc">Belum ada jadwal pertandingan untuk tim Anda.</div>
                    </div>
                @endforelse
            </div>

            {{-- Quick Actions --}}
            <div class="ud-card">
                <div class="ud-card-header">
                    <div class="ud-card-title">
                        <i class="fas fa-bolt"></i> Akses Cepat
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <a href="{{ route('user.team.create') }}" class="ud-btn ud-btn-primary" style="justify-content: flex-start;">
                        <i class="fas fa-plus-circle"></i> Daftarkan Tim Baru
                    </a>
                    <a href="{{ route('tournaments.index') }}" class="ud-btn ud-btn-secondary" style="justify-content: flex-start;">
                        <i class="fas fa-trophy"></i> Lihat Turnamen Terbuka
                    </a>
                    <a href="{{ route('user.my-bracket') }}" class="ud-btn ud-btn-secondary" style="justify-content: flex-start;">
                        <i class="fas fa-diagram-project"></i> Lihat Bracket Turnamen
                    </a>
                    <a href="{{ route('user.profile') }}" class="ud-btn ud-btn-outline" style="justify-content: flex-start;">
                        <i class="fas fa-user-pen"></i> Edit Profil
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
