@extends('layouts.user-dashboard')

@section('title', 'Bracket Saya')
@section('page-title', 'Bracket Saya')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/bracket.css') }}">
@endpush

@section('content')

    <div class="ud-page-header">
        <div class="ud-page-label">PERJALANAN TURNAMEN</div>
        <div class="ud-page-title">Bracket Tim Saya</div>
        <div class="ud-page-desc">Pantau perjalanan timmu di bagan eliminasi turnamen. Tim kamu ditandai dengan warna biru.</div>
    </div>

    @if ($myTournaments->isEmpty())
        <div class="ud-card">
            <div class="ud-empty">
                <div class="ud-empty-icon"><i class="fas fa-diagram-project"></i></div>
                <div class="ud-empty-title">Belum Masuk Bracket</div>
                <div class="ud-empty-desc">
                    Bracket akan tersedia setelah tim kamu disetujui dan panitia membuat bagan pertandingan.
                </div>
                <a href="{{ route('user.team.create') }}" class="ud-btn ud-btn-primary">
                    <i class="fas fa-plus"></i> Daftarkan Tim
                </a>
            </div>
        </div>
    @else

        {{-- Tournament selector --}}
        @if ($myTournaments->count() > 1)
            <div class="ud-card" style="margin-bottom: 20px; padding: 16px 20px;">
                <form method="GET" action="{{ route('user.my-bracket') }}" style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                    <label style="font-size: 13px; color: var(--text-muted); font-weight: 500;">Pilih Turnamen:</label>
                    <select name="tournament_id" onchange="this.form.submit()"
                        style="background: var(--bg-primary); border: 1px solid var(--border-color); color: var(--white); padding: 8px 14px; border-radius: var(--radius-md); font-family: inherit; font-size: 13px; outline: none; cursor: pointer; min-width: 240px;">
                        @foreach ($myTournaments as $t)
                            <option value="{{ $t->id }}" {{ optional($selectedTournament)->id === $t->id ? 'selected' : '' }}>
                                {{ $t->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        @endif

        {{-- Tournament info band --}}
        @if ($selectedTournament)
            <div class="ud-card" style="margin-bottom: 20px; padding: 16px 20px; background: rgba(54, 133, 255, 0.06); border-color: rgba(54, 133, 255, 0.2);">
                <div style="display: flex; align-items: center; gap: 24px; flex-wrap: wrap;">
                    <div>
                        <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Turnamen</div>
                        <div style="font-family: var(--font-heading); font-size: 15px; font-weight: 700; color: var(--white);">{{ $selectedTournament->name }}</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Game</div>
                        <div style="font-size: 13px; font-weight: 600; color: var(--blue-primary);">{{ $selectedTournament->game }}</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Format</div>
                        <div style="font-size: 13px; font-weight: 600; color: var(--white);">Single Elimination</div>
                    </div>
                    <div style="margin-left: auto;">
                        <a href="{{ route('bracket', ['tournament_id' => $selectedTournament->id]) }}" class="ud-btn ud-btn-outline ud-btn-sm" target="_blank">
                            <i class="fas fa-external-link-alt"></i> Lihat Bracket Publik
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- Legend --}}
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px; flex-wrap: wrap; font-size: 12px; color: var(--text-muted);">
            <span><span style="display:inline-block; width: 12px; height: 12px; background: rgba(54, 133, 255, 0.3); border: 1px solid var(--blue-primary); border-radius: 2px; vertical-align: middle; margin-right: 4px;"></span>Tim Kamu</span>
            <span><span style="display:inline-block; width: 12px; height: 12px; background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 2px; vertical-align: middle; margin-right: 4px;"></span>Pemenang</span>
            <span><span style="display:inline-block; width: 12px; height: 12px; background: rgba(100, 116, 139, 0.15); border: 1px solid var(--border-color); border-radius: 2px; vertical-align: middle; margin-right: 4px;"></span>Menunggu / Belum Tanding</span>
        </div>

        @if ($schedules->isEmpty())
            <div class="ud-card">
                <div class="ud-empty">
                    <div class="ud-empty-icon"><i class="fas fa-diagram-project"></i></div>
                    <div class="ud-empty-title">Bracket Belum Dibuat</div>
                    <div class="ud-empty-desc">Panitia belum membuat bagan bracket untuk turnamen ini. Pantau terus!</div>
                </div>
            </div>

        @elseif ($hasLegacyDoubleElimination)
            <div class="ud-card" style="border-color: var(--warning); text-align: center; padding: 40px;">
                <div style="font-size: 36px; margin-bottom: 12px;">⚠️</div>
                <h3 style="font-size: 18px; color: var(--white); margin-bottom: 8px;">Format Bracket Lama</h3>
                <p style="color: var(--text-muted); font-size: 13px;">Turnamen ini menggunakan format bracket lama yang belum diperbarui oleh admin.</p>
            </div>

        @elseif ($rounds->isNotEmpty())
            <div class="bracket-container">
                <div class="bracket-tree">
                    @php
                        $roundKeys = $rounds->keys()->toArray();
                        $lastRoundKey = end($roundKeys);
                    @endphp

                    @foreach ($rounds as $roundName => $matches)
                        @php
                            $hasNextRound = ($roundName !== $lastRoundKey && $roundName !== 'Final');
                            $roundClass = 'bracket-round round-column' . ($hasNextRound ? ' has-next-round' : '');
                        @endphp

                        <div class="{{ $roundClass }}">
                            <div class="round-header">
                                <div class="round-title">{{ $roundName }}</div>
                                <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">
                                    {{ $matches->count() }} Match
                                </div>
                            </div>

                            <div class="round-matches">
                                @foreach ($matches as $match)
                                    @php
                                        $myTeamIsA = $teamIds->contains($match->team_a_id);
                                        $myTeamIsB = $teamIds->contains($match->team_b_id);
                                        $myTeamInMatch = $myTeamIsA || $myTeamIsB;

                                        $isWinnerA = ($match->status === 'finished')
                                            && $match->winner
                                            && $match->teamA
                                            && $match->winner->id === $match->teamA->id;

                                        $isWinnerB = ($match->status === 'finished')
                                            && $match->winner
                                            && $match->teamB
                                            && $match->winner->id === $match->teamB->id;

                                        $scoreA = '-';
                                        $scoreB = '-';
                                        if ($match->result && preg_match('/^(\d+)-(\d+)$/', trim($match->result), $m)) {
                                            $scoreA = $m[1];
                                            $scoreB = $m[2];
                                        } elseif ($match->team_a_score !== null) {
                                            $scoreA = $match->team_a_score;
                                            $scoreB = $match->team_b_score ?? 0;
                                        }
                                    @endphp

                                    <div class="bracket-match" style="{{ $myTeamInMatch ? 'border-color: rgba(54, 133, 255, 0.5); box-shadow: 0 0 16px rgba(54, 133, 255, 0.12);' : '' }}">
                                        <div class="match-header-bar">
                                            <span>Match #{{ $match->id }}</span>
                                            <span style="font-size: 10px; color: {{ $myTeamInMatch ? 'var(--blue-primary)' : 'var(--text-dim)' }}; font-weight: 600;">
                                                {{ $myTeamInMatch ? 'TIM KAMU' : '' }}
                                            </span>
                                        </div>

                                        {{-- Team A --}}
                                        <div class="match-team-row {{ $isWinnerA ? 'winner' : '' }}"
                                            style="{{ $myTeamIsA ? 'background: rgba(54, 133, 255, 0.08);' : '' }}">
                                            <div class="team-info">
                                                @if ($match->teamA)
                                                    <span class="team-name" title="{{ $match->teamA->team_name }}"
                                                        style="{{ $myTeamIsA ? 'color: #93c5fd; font-weight: 700;' : '' }}">
                                                        {{ $match->teamA->team_name }}
                                                    </span>
                                                @else
                                                    <span class="team-name match-tbd">Menunggu Pemenang</span>
                                                @endif
                                            </div>
                                            <span class="team-score">{{ $scoreA }}</span>
                                        </div>

                                        {{-- Team B --}}
                                        <div class="match-team-row {{ $isWinnerB ? 'winner' : '' }}"
                                            style="{{ $myTeamIsB ? 'background: rgba(54, 133, 255, 0.08);' : '' }}">
                                            <div class="team-info">
                                                @if ($match->teamB)
                                                    <span class="team-name" title="{{ $match->teamB->team_name }}"
                                                        style="{{ $myTeamIsB ? 'color: #93c5fd; font-weight: 700;' : '' }}">
                                                        {{ $match->teamB->team_name }}
                                                    </span>
                                                @else
                                                    <span class="team-name match-tbd">Menunggu Pemenang</span>
                                                @endif
                                            </div>
                                            <span class="team-score">{{ $scoreB }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Champion banner --}}
            @php
                $finalMatch = $schedules->firstWhere('round', 'Final') ?? $schedules->firstWhere('round', 'Grand Final');
                $champion = $finalMatch?->winner;
                $isMyChampion = $champion && $teamIds->contains($champion->id);
            @endphp

            @if ($champion)
                <div class="bracket-champion-box" style="{{ $isMyChampion ? 'border-color: var(--warning); background: linear-gradient(135deg, rgba(245, 158, 11, 0.12), rgba(54, 133, 255, 0.12));' : '' }}">
                    @if ($isMyChampion)
                        <div style="font-size: 32px; margin-bottom: 10px;">🏆</div>
                        <div class="champion-tag" style="color: var(--warning);">SELAMAT! TIM KAMU JUARA TURNAMEN!</div>
                    @else
                        <div class="champion-tag">👑 JUARA TURNAMEN</div>
                    @endif
                    <div class="champion-name">{{ strtoupper($champion->team_name) }}</div>
                    <div class="champion-school">{{ $champion->school_name }}</div>
                </div>
            @endif
        @endif

    @endif

@endsection
