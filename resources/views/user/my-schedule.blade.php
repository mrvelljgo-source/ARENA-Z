@extends('layouts.user-dashboard')

@section('title', 'Jadwal Saya')
@section('page-title', 'Jadwal Saya')

@section('content')

    <div class="ud-page-header">
        <div class="ud-page-label">PERTANDINGAN</div>
        <div class="ud-page-title">Jadwal Pertandingan Tim Saya</div>
        <div class="ud-page-desc">Jadwal pertandingan khusus tim yang telah kamu daftarkan. Tim lawan, babak, waktu, dan status terkini.</div>
    </div>

    @if ($schedules->isEmpty())
        <div class="ud-card">
            <div class="ud-empty">
                <div class="ud-empty-icon"><i class="fas fa-calendar-xmark"></i></div>
                <div class="ud-empty-title">Belum Ada Jadwal Pertandingan</div>
                <div class="ud-empty-desc">
                    Jadwal akan muncul di sini setelah tim kamu disetujui oleh panitia dan bracket dibuat.
                    @if ($teamIds->isEmpty())
                        Pastikan kamu sudah mendaftarkan tim terlebih dahulu.
                    @endif
                </div>
                @if ($teamIds->isEmpty())
                    <a href="{{ route('user.team.create') }}" class="ud-btn ud-btn-primary">
                        <i class="fas fa-plus"></i> Daftarkan Tim Dulu
                    </a>
                @endif
            </div>
        </div>
    @else
        {{-- Group by tournament --}}
        @php
            $byTournament = $schedules->groupBy(fn($s) => $s->tournament?->name ?? 'Turnamen Lainnya');
        @endphp

        @foreach ($byTournament as $tournamentName => $matches)
            <div style="margin-bottom: 28px;">
                <div style="font-family: var(--font-heading); font-size: 13px; font-weight: 700; color: var(--blue-primary); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-trophy"></i> {{ $tournamentName }}
                </div>

                @foreach ($matches as $match)
                    @php
                        $isTeamA = $teamIds->contains($match->team_a_id);
                        $isTeamB = $teamIds->contains($match->team_b_id);
                        $myTeam = $isTeamA ? $match->teamA : $match->teamB;
                        $opponent = $isTeamA ? $match->teamB : $match->teamA;
                        $isWinner = $match->winner_id && (
                            ($isTeamA && $match->winner_id === $match->team_a_id) ||
                            ($isTeamB && $match->winner_id === $match->team_b_id)
                        );
                        $isLoser = $match->status === 'finished' && $match->winner_id && !$isWinner;

                        $badgeClass = match($match->status) {
                            'live' => 'ud-badge-live',
                            'finished' => 'ud-badge-finished',
                            default => 'ud-badge-upcoming',
                        };
                    @endphp

                    <div class="ud-card" style="margin-bottom: 12px; {{ $isWinner ? 'border-color: rgba(34, 197, 94, 0.4);' : ($isLoser ? 'border-color: rgba(239, 68, 68, 0.3);' : '') }}">
                        <div style="display: grid; grid-template-columns: 130px 1fr auto; gap: 16px; align-items: center;">

                            {{-- Meta --}}
                            <div>
                                <div style="font-family: var(--font-heading); font-size: 12px; font-weight: 700; color: var(--blue-primary); text-transform: uppercase; margin-bottom: 6px;">
                                    {{ $match->round }}
                                </div>
                                <div style="font-size: 12px; color: var(--text-muted);">
                                    <i class="fas fa-calendar" style="font-size: 11px;"></i>
                                    {{ $match->match_date ? date('d M Y', strtotime($match->match_date)) : 'TBA' }}
                                </div>
                                <div style="font-size: 12px; color: var(--text-muted);">
                                    <i class="fas fa-clock" style="font-size: 11px;"></i>
                                    {{ $match->match_time ? substr($match->match_time, 0, 5) . ' WIB' : 'Jam TBA' }}
                                </div>
                            </div>

                            {{-- Teams --}}
                            <div style="display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; gap: 12px; background: rgba(8, 13, 25, 0.5); padding: 12px 16px; border-radius: var(--radius-md); border: 1px solid var(--border-color);">

                                {{-- My team (left or right depending on position) --}}
                                <div style="display: flex; align-items: center; gap: 10px;" class="{{ $isTeamA ? 'is-my-team' : '' }}">
                                    <div class="ud-match-team-avatar" style="{{ $isTeamA ? 'border-color: var(--blue-primary); background: rgba(54, 133, 255, 0.15);' : '' }}">
                                        {{ strtoupper(substr($match->teamA?->team_name ?? 'T', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-size: 13px; font-weight: 600; color: {{ $isTeamA ? '#93c5fd' : 'var(--white)' }};">
                                            {{ $match->teamA?->team_name ?? 'TBD' }}
                                            @if ($isTeamA) <span style="font-size: 10px; color: var(--blue-primary);">(Tim Kamu)</span> @endif
                                        </div>
                                        <div style="font-size: 11px; color: var(--text-muted);">{{ $match->teamA?->school_name ?? '-' }}</div>
                                    </div>
                                </div>

                                {{-- Score / VS --}}
                                <div style="text-align: center;">
                                    @if ($match->status === 'finished' && $match->result)
                                        <div style="font-family: var(--font-heading); font-size: 20px; font-weight: 800; color: var(--white);">{{ $match->result }}</div>
                                        @if ($isWinner)
                                            <div style="font-size: 10px; color: var(--success); font-weight: 700;">MENANG</div>
                                        @elseif ($isLoser)
                                            <div style="font-size: 10px; color: var(--danger); font-weight: 700;">KALAH</div>
                                        @endif
                                    @elseif ($match->status === 'live')
                                        <div style="font-family: var(--font-heading); font-size: 14px; font-weight: 800; color: var(--warning);">LIVE</div>
                                    @else
                                        <div style="font-family: var(--font-heading); font-size: 14px; color: var(--text-muted);">VS</div>
                                    @endif
                                </div>

                                {{-- Opponent --}}
                                <div style="display: flex; align-items: center; gap: 10px; flex-direction: row-reverse; text-align: right;" class="{{ $isTeamB ? 'is-my-team' : '' }}">
                                    <div class="ud-match-team-avatar" style="{{ $isTeamB ? 'border-color: var(--blue-primary); background: rgba(54, 133, 255, 0.15);' : '' }}">
                                        {{ strtoupper(substr($match->teamB?->team_name ?? 'T', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-size: 13px; font-weight: 600; color: {{ $isTeamB ? '#93c5fd' : 'var(--white)' }}; text-align: right;">
                                            {{ $match->teamB?->team_name ?? 'TBD' }}
                                            @if ($isTeamB) <span style="font-size: 10px; color: var(--blue-primary);">(Tim Kamu)</span> @endif
                                        </div>
                                        <div style="font-size: 11px; color: var(--text-muted); text-align: right;">{{ $match->teamB?->school_name ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Status badge --}}
                            <span class="ud-badge {{ $badgeClass }}">{{ strtoupper($match->status) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif

@endsection
