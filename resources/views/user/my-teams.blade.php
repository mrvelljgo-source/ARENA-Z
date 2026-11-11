@extends('layouts.user-dashboard')

@section('title', 'Tim Saya')
@section('page-title', 'Tim Saya')

@section('content')

    <div class="ud-page-header">
        <div class="ud-page-label">MANAJEMEN TIM</div>
        <div class="ud-page-title">Tim Saya</div>
        <div class="ud-page-desc">Daftar tim yang telah kamu daftarkan ke turnamen ARENA Z.</div>
    </div>

    @if ($teams->isEmpty())
        <div class="ud-card">
            <div class="ud-empty">
                <div class="ud-empty-icon"><i class="fas fa-users-slash"></i></div>
                <div class="ud-empty-title">Belum Ada Tim Terdaftar</div>
                <div class="ud-empty-desc">Kamu belum mendaftarkan tim ke turnamen manapun. Mulai dengan mendaftarkan tim sekolahmu sekarang!</div>
                <a href="{{ route('user.team.create') }}" class="ud-btn ud-btn-primary">
                    <i class="fas fa-plus"></i> Daftarkan Tim Sekarang
                </a>
            </div>
        </div>
    @else
        <div style="display: flex; flex-direction: column; gap: 16px;">
            @foreach ($teams as $team)
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

                <div class="ud-card">
                    {{-- Team header --}}
                    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; flex-wrap: wrap; margin-bottom: 20px;">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div class="ud-team-avatar" style="width: 52px; height: 52px; font-size: 22px;">
                                {{ strtoupper(substr($team->team_name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-family: var(--font-heading); font-size: 18px; font-weight: 800; color: var(--white); margin-bottom: 4px;">
                                    {{ $team->team_name }}
                                </div>
                                <div style="font-size: 13px; color: var(--text-muted);">
                                    {{ $team->school_name }}
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                            <span class="ud-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                            <a href="{{ route('user.team-detail', $team->id) }}" class="ud-btn ud-btn-secondary ud-btn-sm">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </div>
                    </div>

                    {{-- Info grid --}}
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 16px;">
                        <div>
                            <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Turnamen</div>
                            <div style="font-size: 13px; font-weight: 600; color: var(--white);">{{ $team->tournament->name ?? '-' }}</div>
                        </div>
                        <div>
                            <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Ketua Tim</div>
                            <div style="font-size: 13px; font-weight: 600; color: var(--white);">{{ $team->leader_name }}</div>
                        </div>
                        <div>
                            <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Kapten Tim</div>
                            <div style="font-size: 13px; font-weight: 600; color: var(--white);">
                                {{ $team->captain?->name ?? '(Belum ada)' }}
                                @if ($team->captain)
                                    <span style="font-size: 11px; color: var(--blue-primary);">({{ $team->captain->in_game_name }})</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Jumlah Pemain</div>
                            <div style="font-size: 13px; font-weight: 600; color: var(--white);">
                                {{ $team->mainPlayers->count() }} Utama
                                @if ($team->substitutePlayer)
                                    + 1 Cadangan
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Admin note if rejected --}}
                    @if ($team->status === 'rejected' && $team->admin_note)
                        <div style="background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.25); border-radius: var(--radius-md); padding: 12px 16px; font-size: 13px; color: #fca5a5;">
                            <strong><i class="fas fa-circle-info"></i> Catatan Admin:</strong> {{ $team->admin_note }}
                        </div>
                    @endif

                    {{-- Pending note --}}
                    @if ($team->status === 'pending')
                        <div style="background: rgba(245, 158, 11, 0.08); border: 1px solid rgba(245, 158, 11, 0.25); border-radius: var(--radius-md); padding: 12px 16px; font-size: 13px; color: #fde68a;">
                            <i class="fas fa-clock"></i> Pendaftaran sedang ditinjau oleh panitia. Harap tunggu konfirmasi.
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div style="margin-top: 20px;">
            <a href="{{ route('user.team.create') }}" class="ud-btn ud-btn-primary">
                <i class="fas fa-plus"></i> Daftarkan Tim Lain
            </a>
        </div>
    @endif

@endsection
