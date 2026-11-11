@props(['tournament'])

<div class="tournament-card" data-status="{{ strtolower($tournament->status) }}">
    <div class="tournament-banner">
        <img src="{{ asset('images/tournament-banner.png') }}" 
             alt="{{ $tournament->name }}"
             onerror="this.style.display='none';">
        <div class="tournament-banner-badge">
            <x-status-badge :status="$tournament->status" />
        </div>
        <span class="tournament-game-tag">{{ $tournament->game }}</span>
    </div>

    <div class="tournament-body">
        <h3 class="tournament-title">{{ $tournament->name }}</h3>

        <div class="tournament-meta">
            <div class="meta-item">
                <span class="meta-label">Format Game</span>
                <span class="meta-value">{{ $tournament->format ?? '5 VS 5 Single Elimination' }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Total Hadiah</span>
                <span class="meta-value" style="color: var(--blue-primary);">{{ $tournament->prize_pool ?? 'Trophy & Sertifikat' }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Pendaftaran</span>
                <span class="meta-value">
                    {{ $tournament->registration_start ? date('d M', strtotime($tournament->registration_start)) : '-' }} - 
                    {{ $tournament->registration_end ? date('d M Y', strtotime($tournament->registration_end)) : '-' }}
                </span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Pertandingan</span>
                <span class="meta-value">
                    {{ $tournament->tournament_date ? date('d M Y', strtotime($tournament->tournament_date)) : 'Segera' }}
                </span>
            </div>
        </div>

        <div class="tournament-footer">
            <span style="font-size: 13px; color: var(--text-muted);">
                <strong style="color: var(--white);">{{ $tournament->approved_teams_count ?? $tournament->teams->count() }}</strong> / {{ $tournament->max_teams ?? 16 }} Tim
            </span>

            <a href="{{ route('tournaments.show', $tournament->id) }}" class="btn btn-primary btn-sm">
                Detail Turnamen →
            </a>
        </div>
    </div>
</div>

