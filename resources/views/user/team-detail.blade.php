@extends('layouts.user-dashboard')

@section('title', $team->team_name . ' — Detail Tim')
@section('page-title', 'Detail Tim')

@section('content')

    {{-- Back --}}
    <div style="margin-bottom: 20px;">
        <a href="{{ route('user.my-teams') }}" class="ud-btn ud-btn-outline ud-btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Tim Saya
        </a>
    </div>

    @php
        $statusClass = match($team->status) {
            'approved' => 'ud-badge-approved',
            'pending' => 'ud-badge-pending',
            'rejected' => 'ud-badge-rejected',
            default => 'ud-badge-upcoming',
        };
        $statusLabel = match($team->status) {
            'approved' => 'Disetujui',
            'pending' => 'Menunggu Verifikasi',
            'rejected' => 'Ditolak',
            default => ucfirst($team->status),
        };
    @endphp

    {{-- Team Overview --}}
    <div class="ud-card" style="margin-bottom: 20px;">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; flex-wrap: wrap; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div class="ud-team-avatar" style="width: 60px; height: 60px; font-size: 26px; border-radius: 14px;">
                    {{ strtoupper(substr($team->team_name, 0, 1)) }}
                </div>
                <div>
                    <div style="font-family: var(--font-heading); font-size: 22px; font-weight: 800; color: var(--white); margin-bottom: 4px;">
                        {{ strtoupper($team->team_name) }}
                    </div>
                    <div style="font-size: 13px; color: var(--text-muted);">{{ $team->school_name }}</div>
                    <div style="font-size: 12px; color: var(--blue-primary); margin-top: 2px;">
                        {{ $team->tournament->name ?? 'Turnamen tidak diketahui' }}
                    </div>
                </div>
            </div>
            <span class="ud-badge {{ $statusClass }}" style="font-size: 12px; padding: 6px 14px;">{{ $statusLabel }}</span>
        </div>

        {{-- Admin note --}}
        @if ($team->status === 'rejected' && $team->admin_note)
            <div style="background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.25); border-radius: var(--radius-md); padding: 14px 18px; margin-bottom: 20px; font-size: 13px; color: #fca5a5;">
                <strong><i class="fas fa-circle-xmark"></i> Alasan Penolakan:</strong> {{ $team->admin_note }}
            </div>
        @endif

        {{-- Info table --}}
        <div class="ud-form-section-title" style="margin-bottom: 14px;">
            <i class="fas fa-circle-info"></i> Informasi Tim
        </div>
        <table class="ud-detail-table" style="margin-bottom: 24px;">
            <tr>
                <td>Nama Tim</td>
                <td>{{ $team->team_name }}</td>
            </tr>
            <tr>
                <td>Asal Sekolah</td>
                <td>{{ $team->school_name }}</td>
            </tr>
            <tr>
                <td>Turnamen</td>
                <td>{{ $team->tournament->name ?? '-' }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td><span class="ud-badge {{ $statusClass }}">{{ $statusLabel }}</span></td>
            </tr>
        </table>

        <div class="ud-form-section-title" style="margin-bottom: 14px;">
            <i class="fas fa-user-tie"></i> Informasi Ketua Tim
        </div>
        <table class="ud-detail-table">
            <tr>
                <td>Nama Ketua</td>
                <td>{{ $team->leader_name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $team->leader_email }}</td>
            </tr>
            <tr>
                <td>Nomor WhatsApp</td>
                <td>{{ $team->leader_phone }}</td>
            </tr>
        </table>
    </div>

    {{-- Roster Pemain --}}
    <div class="ud-card">
        <div class="ud-card-header">
            <div class="ud-card-title">
                <i class="fas fa-users"></i> Roster Pemain
                <span style="font-size: 12px; font-weight: 400; color: var(--text-muted); margin-left: 6px;">
                    ({{ $team->mainPlayers->count() }} Utama{{ $team->substitutePlayer ? ' + 1 Cadangan' : '' }})
                </span>
            </div>
        </div>

        @if ($team->players->isEmpty())
            <div class="ud-empty" style="padding: 32px;">
                <div class="ud-empty-desc">Belum ada data pemain yang tersimpan untuk tim ini.</div>
            </div>
        @else
            {{-- Main Players --}}
            @if ($team->mainPlayers->isNotEmpty())
                <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">PEMAIN UTAMA</div>
                @foreach ($team->mainPlayers as $index => $player)
                    <div class="ud-player-list-item">
                        <div class="ud-player-idx">{{ $index + 1 }}</div>
                        <div class="ud-player-details">
                            <div class="ud-player-name-main">
                                {{ $player->name }}
                                @if ($player->is_captain)
                                    <span class="ud-badge ud-badge-approved" style="font-size: 10px; padding: 2px 8px; margin-left: 6px;">
                                        <i class="fas fa-crown" style="font-size: 9px;"></i> Kapten
                                    </span>
                                @endif
                            </div>
                            <div class="ud-player-ign">{{ $player->in_game_name }} · ID: {{ $player->game_id }}</div>
                            <div class="ud-player-meta">
                                <span><i class="fas fa-gamepad" style="font-size: 10px;"></i> {{ $player->role_in_game }}</span>
                                <span><i class="fas fa-graduation-cap" style="font-size: 10px;"></i> {{ $player->student_grade }}</span>
                                @if ($player->phone_number)
                                    <span><i class="fab fa-whatsapp" style="font-size: 10px;"></i> {{ $player->phone_number }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            {{-- Substitute --}}
            @if ($team->substitutePlayer)
                <div style="font-size: 11px; color: var(--purple-accent); text-transform: uppercase; letter-spacing: 1px; margin-top: 20px; margin-bottom: 10px;">PEMAIN CADANGAN</div>
                @php $sub = $team->substitutePlayer; @endphp
                <div class="ud-player-list-item" style="border-color: rgba(139, 92, 246, 0.3); background: rgba(139, 92, 246, 0.05);">
                    <div class="ud-player-idx" style="background: rgba(139, 92, 246, 0.15); color: var(--purple-accent);">C</div>
                    <div class="ud-player-details">
                        <div class="ud-player-name-main">{{ $sub->name }}</div>
                        <div class="ud-player-ign" style="color: var(--purple-accent);">{{ $sub->in_game_name }} · ID: {{ $sub->game_id }}</div>
                        <div class="ud-player-meta">
                            <span>{{ $sub->role_in_game }}</span>
                            <span>{{ $sub->student_grade }}</span>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>

@endsection
