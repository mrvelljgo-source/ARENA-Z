@extends('layouts.app')

@section('title', 'Bagan Bracket Turnamen — ARENA Z')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/bracket.css') }}">
@endpush

@section('content')
    <!-- Page Header -->
    <section style="padding: 60px 0 35px; background: radial-gradient(circle at 50% 10%, rgba(54, 133, 255, 0.12) 0%, transparent 65%); border-bottom: 1px solid var(--border-color);">
        <div class="container">
            <span class="section-tag">SINGLE ELIMINATION</span>
            <h1 style="font-size: 36px; color: var(--white); margin-bottom: 12px;">Bagan Bracket Turnamen</h1>
            <p style="color: var(--text-muted); max-width: 650px; font-size: 15px;">
                Visualisasi bagan sistem gugur dinamis. Setiap kemenangan akan otomatis melaju ke babak berikutnya hingga babak Final.
            </p>
        </div>
    </section>

    <!-- Tournament Selector Bar -->
    <section style="padding: 24px 0; background-color: var(--bg-secondary); border-bottom: 1px solid var(--border-color);">
        <div class="container">
            @if ($tournaments->isNotEmpty())
                <form method="GET" action="{{ route('bracket') }}" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <label for="tournament_select" style="font-size: 13px; color: var(--text-muted); font-weight: 500;">Pilih Turnamen:</label>
                        <select
                            name="tournament_id"
                            id="tournament_select"
                            onchange="this.form.submit()"
                            style="background: var(--bg-primary); border: 1px solid var(--border-color); color: var(--white); padding: 8px 16px; border-radius: var(--radius-md); font-family: inherit; font-size: 14px; outline: none; cursor: pointer; min-width: 260px;"
                        >
                            @foreach ($tournaments as $t)
                                <option value="{{ $t->id }}" {{ optional($selectedTournament)->id === $t->id ? 'selected' : '' }}>
                                    {{ $t->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if ($selectedTournament)
                        <div style="font-size: 13px; color: var(--text-muted);">
                            Game: <strong style="color: var(--blue-primary);">{{ $selectedTournament->game }}</strong>
                            &bull; Format: <strong style="color: var(--white);">SINGLE ELIMINATION</strong>
                            &bull; Kuota: <strong style="color: var(--white);">{{ $selectedTournament->max_teams ?? 16 }} Tim</strong>
                        </div>
                    @endif
                </form>
            @else
                <p style="font-size: 14px; color: var(--text-muted);">Belum ada turnamen dengan bracket aktif.</p>
            @endif
        </div>
    </section>

    <!-- Bracket Content -->
    <section style="padding: 40px 0 90px;">
        <div class="container">

            {{-- No tournaments at all --}}
            @if ($tournaments->isEmpty())
                <div class="no-bracket-state">
                    <div style="font-size: 44px; margin-bottom: 16px; color: var(--text-dim);">🏆</div>
                    <h3 style="font-size: 20px; color: var(--white); margin-bottom: 8px;">Belum Ada Bracket Tersedia</h3>
                    <p style="color: var(--text-muted); font-size: 14px; max-width: 500px; margin: 0 auto 24px;">
                        Bracket akan muncul di sini setelah admin membuat jadwal pertandingan untuk turnamen yang aktif.
                    </p>
                    <a href="{{ route('tournaments.index') }}" class="btn btn-primary">Lihat Daftar Turnamen</a>
                </div>

            {{-- Tournament has matches but uses legacy double elimination format --}}
            @elseif (!empty($hasLegacyDoubleElimination) && $hasLegacyDoubleElimination)
                <div class="card" style="text-align: center; padding: 50px 20px; border-color: var(--warning);">
                    <div style="font-size: 36px; margin-bottom: 12px;">⚠️</div>
                    <h3 style="font-size: 20px; color: var(--white); margin-bottom: 8px;">BRACKET FORMAT LAMA</h3>
                    <p style="color: var(--text-muted); font-size: 14px; max-width: 580px; margin: 0 auto;">
                        Turnamen ini menggunakan format bracket lama. Admin dapat memperbaruinya menjadi format Single Elimination melalui panel kelola jadwal.
                    </p>
                </div>

            {{-- No schedules generated yet for this tournament --}}
            @elseif ($schedules->isEmpty())
                <div class="no-bracket-state">
                    <div style="font-size: 44px; margin-bottom: 16px; color: var(--text-dim);">🛡️</div>
                    <h3 style="font-size: 20px; color: var(--white); margin-bottom: 8px;">Bagan Bracket Belum Dibuat</h3>
                    <p style="color: var(--text-muted); font-size: 14px; max-width: 500px; margin: 0 auto;">
                        Panitia turnamen belum melakukan <em>generate bracket</em> untuk turnamen ini. Bagan akan tampil otomatis setelah tim terverifikasi dan bracket diundi.
                    </p>
                </div>

            {{-- Render the bracket tree --}}
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
                                            $isWinnerA = ($match->status === 'finished' && $match->winner_id && $match->winner_id === $match->team_a_id)
                                                || ($match->winner && $match->teamA && $match->winner->id === $match->teamA->id);

                                            $isWinnerB = ($match->status === 'finished' && $match->winner_id && $match->winner_id === $match->team_b_id)
                                                || ($match->winner && $match->teamB && $match->winner->id === $match->teamB->id);

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

                                        <div class="bracket-match">
                                            <div class="match-header-bar">
                                                <span>Match #{{ $match->id }}</span>
                                                <x-status-badge :status="$match->status" />
                                            </div>

                                            {{-- Team A --}}
                                            <div class="match-team-row {{ $isWinnerA ? 'winner' : '' }}">
                                                <div class="team-info">
                                                    @if ($match->teamA)
                                                        <span class="team-name" title="{{ $match->teamA->team_name }}">
                                                            {{ $match->teamA->team_name }}
                                                        </span>
                                                    @else
                                                        <span class="team-name match-tbd">Menunggu Pemenang</span>
                                                    @endif
                                                </div>
                                                <span class="team-score">{{ $scoreA }}</span>
                                            </div>

                                            {{-- Team B --}}
                                            <div class="match-team-row {{ $isWinnerB ? 'winner' : '' }}">
                                                <div class="team-info">
                                                    @if ($match->teamB)
                                                        <span class="team-name" title="{{ $match->teamB->team_name }}">
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
                @endphp

                @if ($champion)
                    <div class="bracket-champion-box">
                        <div class="champion-tag">👑 JUARA TURNAMEN</div>
                        <div class="champion-name">{{ strtoupper($champion->team_name) }}</div>
                        <div class="champion-school">{{ $champion->school_name }}</div>
                    </div>
                @endif
            @endif

        </div>
    </section>
@endsection
