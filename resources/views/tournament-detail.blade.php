@extends('layouts.app')

@section('title', $tournament->name . ' — ARENA Z')

@section('content')
    <!-- Tournament Banner & Overview Header -->
    <section style="padding: 50px 0 35px; background: linear-gradient(180deg, rgba(16, 24, 39, 0.9) 0%, rgba(8, 13, 25, 1) 100%); border-bottom: 1px solid var(--border-color);">
        <div class="container">
            <div style="margin-bottom: 20px;">
                <a href="{{ route('tournaments.index') }}" style="color: var(--blue-primary); font-size: 14px; display: inline-flex; align-items: center; gap: 6px;">
                    ← Kembali ke Semua Turnamen
                </a>
            </div>

            <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 30px; flex-wrap: wrap;" class="tournament-header-flex">
                <div style="max-width: 740px;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 14px; flex-wrap: wrap;">
                        <span class="badge" style="background: rgba(54, 133, 255, 0.15); color: var(--blue-primary); border: 1px solid rgba(54, 133, 255, 0.3);">
                            {{ $tournament->game }}
                        </span>
                        <x-status-badge :status="$tournament->status" />
                    </div>

                    <h1 style="font-size: 34px; color: var(--white); margin-bottom: 14px; line-height: 1.25;">
                        {{ $tournament->name }}
                    </h1>

                    <p style="color: var(--text-muted); font-size: 15px; line-height: 1.7; margin-bottom: 24px;">
                        {{ $tournament->description ?? 'Turnamen resmi Mobile Legends: Bang Bang pelajar tingkat SMP, SMA, dan SMK.' }}
                    </p>

                    <!-- Quick Meta Badges -->
                    <div style="display: flex; gap: 24px; flex-wrap: wrap;">
                        <div>
                            <div style="font-size: 12px; color: var(--text-muted); text-transform:uppercase;">Total Hadiah</div>
                            <div style="font-family: var(--font-heading); font-size: 20px; font-weight:800; color: var(--blue-primary);">
                                {{ $tournament->prize_pool ?? 'Trophy & Sertifikat' }}
                            </div>
                        </div>
                        <div style="border-left: 1px solid var(--border-color); padding-left: 20px;">
                            <div style="font-size: 12px; color: var(--text-muted); text-transform:uppercase;">Kuota Tim</div>
                            <div style="font-family: var(--font-heading); font-size: 20px; font-weight:800; color: var(--white);">
                                {{ $tournament->approved_teams_count }} / {{ $tournament->max_teams ?? 16 }} Tim
                            </div>
                        </div>
                        <div style="border-left: 1px solid var(--border-color); padding-left: 20px;">
                            <div style="font-size: 12px; color: var(--text-muted); text-transform:uppercase;">Format</div>
                            <div style="font-family: var(--font-heading); font-size: 16px; font-weight:700; color: var(--white); margin-top:3px;">
                                {{ $tournament->format ?? '5 VS 5 Single Elimination' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registration Action Box -->
                <div class="card tournament-registration-box" style="min-width: 300px; max-width: 360px; width: 100%; border-color: rgba(54, 133, 255, 0.4); text-align: center; padding: 28px;">
                    <div style="font-size: 13px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">
                        Status Pendaftaran
                    </div>

                    <div style="margin-bottom: 20px;">
                        <x-status-badge :status="$tournament->status" />
                    </div>

                    <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 20px; line-height: 1.6;">
                        Periode Registrasi:<br>
                        <strong style="color: var(--white);">
                            {{ $tournament->registration_start ? date('d M Y', strtotime($tournament->registration_start)) : '-' }}
                            s/d 
                            {{ $tournament->registration_end ? date('d M Y', strtotime($tournament->registration_end)) : '-' }}
                        </strong>
                    </div>

                    @if (in_array(strtolower($tournament->status), ['upcoming', 'registration_open', 'open', 'active']))
                        @auth
                            @if (auth()->user()->role === 'user')
                                <a href="{{ url('/user/team-register?tournament_id=' . $tournament->id) }}" class="btn btn-primary" style="width: 100%; padding: 13px;">
                                    Daftar Turnamen Ini Sekarang →
                                </a>
                            @else
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" style="width: 100%;">
                                    Kelola Turnamen di Admin Panel
                                </a>
                            @endif
                        @else
                            <a href="{{ route('user.register') }}" class="btn btn-primary" style="width: 100%; padding: 13px;">
                                Daftar Sebagai Peserta →
                            </a>
                            <div style="margin-top: 10px; font-size: 12px; color: var(--text-muted);">
                                Sudah punya akun? <a href="{{ route('user.login') }}" style="color: var(--blue-primary);">Login</a>
                            </div>
                        @endauth
                    @else
                        <button type="button" class="btn btn-secondary" style="width: 100%; opacity: 0.6; cursor: not-allowed;" disabled>
                            Pendaftaran Telah Ditutup
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Detailed Information Sections -->
    <section style="padding: 60px 0 90px;">
        <div class="container">
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 36px;" class="tournament-detail-grid">
                <!-- Left: Rules, Schedule & Information -->
                <div>
                    <!-- Rules Box -->
                    <div class="card" style="margin-bottom: 30px;">
                        <h2 style="font-size: 20px; color: var(--white); margin-bottom: 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
                            📋 Peraturan & Ketentuan Pertandingan
                        </h2>
                        <div style="color: var(--text-muted); font-size: 14px; line-height: 1.8; white-space: pre-line;">
                            {{ $tournament->rules ?? "1. Seluruh anggota tim adalah siswa aktif dari sekolah yang bersangkutan.\n2. Roster terdiri dari 5 pemain utama dan maksimal 1 cadangan.\n3. Kapten tim wajib berasal dari salah satu pemain utama.\n4. Pertandingan room Tournament Mode Custom Draft Pick.\n5. Dilarang menggunakan cheat atau perilaku tidak sportif." }}
                        </div>
                    </div>

                    <!-- Teams List Box -->
                    <div class="card">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
                            <h2 style="font-size: 20px; color: var(--white); margin: 0;">
                                🛡️ Tim Terdaftar ({{ $teams->count() }})
                            </h2>
                            <span style="font-size: 13px; color: var(--text-muted);">Status Terverifikasi</span>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px;">
                            @forelse ($teams as $team)
                                <div style="background: rgba(8, 13, 25, 0.6); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 14px 18px; display: flex; align-items: center; gap: 14px;">
                                    <div class="team-avatar">
                                        {{ strtoupper(substr($team->team_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 700; color: var(--white); font-size: 14px;">{{ $team->team_name }}</div>
                                        <div style="font-size: 12px; color: var(--text-muted);">{{ $team->school_name }}</div>
                                        <div style="font-size: 11px; color: var(--blue-primary); margin-top: 2px;">
                                            Kapten: {{ $team->captain?->name ?? $team->leader_name }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 24px;">
                                    Belum ada tim yang disetujui untuk turnamen ini.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right: Schedule & Bracket Shortcut -->
                <div>
                    <div class="card" style="margin-bottom: 24px;">
                        <h3 style="font-size: 18px; color: var(--white); margin-bottom: 14px; border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">
                            📅 Jadwal Turnamen
                        </h3>
                        <div style="display: flex; flex-direction: column; gap: 14px; font-size: 14px;">
                            <div>
                                <div style="color: var(--text-muted); font-size: 12px;">Batas Pendaftaran</div>
                                <div style="color: var(--white); font-weight: 600;">
                                    {{ $tournament->registration_end ? date('d F Y', strtotime($tournament->registration_end)) : 'Segera Diumumkan' }}
                                </div>
                            </div>
                            <div>
                                <div style="color: var(--text-muted); font-size: 12px;">Kick-off Pertandingan</div>
                                <div style="color: var(--white); font-weight: 600;">
                                    {{ $tournament->tournament_date ? date('d F Y', strtotime($tournament->tournament_date)) : 'Segera Diumumkan' }}
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid var(--border-color);">
                            <a href="{{ route('bracket', ['tournament_id' => $tournament->id]) }}" class="btn btn-secondary" style="width: 100%;">
                                Lihat Bagan Bracket Turnamen →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

