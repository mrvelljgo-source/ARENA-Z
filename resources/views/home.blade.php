@extends('layouts.app')

@section('title', 'ARENA Z — Student Esports Tournament Platform | Mobile Legends')

@section('content')
    <!-- 1. Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-grid">
                <div class="hero-content">
                    <div class="hero-tag">
                        <span>⚡</span> STUDENT ESPORTS PLATFORM
                    </div>

                    <h1 class="hero-title">
                        YOUR GAME.<br>
                        <span>YOUR ARENA.</span>
                    </h1>

                    <p class="hero-desc">
                        Platform turnamen Mobile Legends: Bang Bang resmi antar pelajar SMP, SMA, dan SMK. Daftarkan tim sekolahmu, bertanding secara kompetitif, dan raih prestasi di arena esports pelajar tertinggi!
                    </p>

                    <div class="hero-actions">
                        <a href="{{ route('tournaments.index') }}" class="btn btn-primary btn-lg">
                            Lihat Turnamen →
                        </a>
                        <a href="{{ route('user.register') }}" class="btn btn-outline btn-lg">
                            Gabung Sekarang
                        </a>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="hero-image-card">
                        <img src="{{ asset('images/hero-esports.png') }}" 
                             alt="ARENA Z Mobile Legends Championship"
                             onerror="this.style.display='none'; this.parentElement.style.minHeight='380px'; this.parentElement.style.background='linear-gradient(135deg, #101c36 0%, #1b2f5b 50%, #0f1e3a 100%)';">
                        <div class="hero-floating-badge">
                            <div>
                                <div style="font-size: 11px; color: var(--text-muted); text-transform:uppercase;">Game Utama</div>
                                <div style="font-family: var(--font-heading); font-size: 14px; color: var(--white); font-weight:700;">Mobile Legends: Bang Bang</div>
                            </div>
                            <span class="badge badge-open">5 VS 5 FORMAT</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Statistics Section -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">{{ $totalTournaments ?? 1 }}+</div>
                    <div class="stat-label">Turnamen Aktif</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $totalTeams ?? 8 }}+</div>
                    <div class="stat-label">Tim Pelajar Terdaftar</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $totalPlayers ?? 48 }}+</div>
                    <div class="stat-label">Peserta Pelajar</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Fair Play & Anti-Cheat</div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. About Preview Section -->
    <section style="padding: 90px 0 60px;">
        <div class="container">
            <x-section-heading 
                tag="TENTANG PLATFORM"
                title="Panggung Kompetisi Esports Pelajar Indonesia"
                desc="ARENA Z hadir sebagai wadah profesional yang menghubungkan antusiasme gaming pelajar dengan sistem kompetisi terstruktur dan terpercaya."
            />

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">
                <div class="card">
                    <div style="font-size: 32px; margin-bottom: 16px; color: var(--blue-primary);">🏆</div>
                    <h3 style="font-size: 20px; margin-bottom: 10px; color: var(--white);">Ekosistem Kompetitif Sehat</h3>
                    <p style="color: var(--text-muted); font-size: 14px; line-height: 1.7;">
                        Dirancang khusus untuk pelajar SMP, SMA, dan SMK dengan regulasi ketat, verifikasi asal sekolah, dan kepatuhan kode etik kompetisi.
                    </p>
                </div>

                <div class="card">
                    <div style="font-size: 32px; margin-bottom: 16px; color: var(--purple-accent);">⚡</div>
                    <h3 style="font-size: 20px; margin-bottom: 10px; color: var(--white);">Sistem Bracket Dinamis</h3>
                    <p style="color: var(--text-muted); font-size: 14px; line-height: 1.7;">
                        Pengelolaan bagan pertandingan eliminasi otomatis dari database. Skor pertandingan terverifikasi secara transparan dan terstruktur.
                    </p>
                </div>

                <div class="card">
                    <div style="font-size: 32px; margin-bottom: 16px; color: var(--success);">🛡️</div>
                    <h3 style="font-size: 20px; margin-bottom: 10px; color: var(--white);">Roster 5v5 Terverifikasi</h3>
                    <p style="color: var(--text-muted); font-size: 14px; line-height: 1.7;">
                        Mewajibkan 5 pemain inti dengan penunjukan kapten resmi dan maksimal 1 pemain cadangan untuk menjamin integritas pertandingan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. How It Works Section -->
    <section style="padding: 60px 0 90px; background-color: var(--bg-secondary);">
        <div class="container">
            <x-section-heading 
                tag="ALUR KOMPETISI"
                title="Cara Mengikuti Turnamen ARENA Z"
                desc="Ikuti 4 langkah mudah untuk membawa nama sekolahmu menjadi juara di ARENA Z."
            />

            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-num">01</div>
                    <h4 class="step-title">Buat Akun Peserta</h4>
                    <p class="step-desc">Daftarkan akun perwakilan tim atau kapten melalui formulir registrasi online.</p>
                </div>

                <div class="step-card">
                    <div class="step-num">02</div>
                    <h4 class="step-title">Daftarkan Roster 5v5</h4>
                    <p class="step-desc">Pilih turnamen yang terbuka, masukkan nama tim, asal sekolah, dan susunan 5 pemain inti.</p>
                </div>

                <div class="step-card">
                    <div class="step-num">03</div>
                    <h4 class="step-title">Verifikasi Panitia</h4>
                    <p class="step-desc">Admin turnamen memeriksa keabsahan data tim dan menempatkan tim ke slot bracket.</p>
                </div>

                <div class="step-card">
                    <div class="step-num">04</div>
                    <h4 class="step-title">Tanding & Rebut Juara</h4>
                    <p class="step-desc">Pantau jadwal tanding di website, ikuti pertandingan room custom, dan raih trofi kemenangan!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Featured Tournaments Section -->
    <section style="padding: 90px 0;">
        <div class="container">
            <div style="display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 40px; flex-wrap: wrap; gap: 16px;">
                <div>
                    <span class="section-tag">TURNAMEN TERBARU</span>
                    <h2 class="section-title" style="margin-bottom: 0;">Turnamen Mobile Legends Aktif</h2>
                </div>
                <a href="{{ route('tournaments.index') }}" class="btn btn-outline btn-sm">
                    Lihat Semua Turnamen →
                </a>
            </div>

            <div class="tournament-grid">
                @forelse ($tournaments as $tournament)
                    <x-tournament-card :tournament="$tournament" />
                @empty
                    <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 48px;">
                        <p style="color: var(--text-muted);">Belum ada turnamen yang dibuka saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 6. Upcoming Matches Preview -->
    @if ($upcomingMatches->isNotEmpty())
        <section style="padding: 60px 0 90px; background-color: var(--bg-secondary);">
            <div class="container">
                <div style="display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 36px; flex-wrap: wrap; gap: 16px;">
                    <div>
                        <span class="section-tag">JADWAL TANDING</span>
                        <h2 class="section-title" style="margin-bottom: 0;">Pertandingan Mendatang</h2>
                    </div>
                    <a href="{{ route('schedule') }}" class="btn btn-outline btn-sm">
                        Buka Jadwal Lengkap →
                    </a>
                </div>

                <div>
                    @foreach ($upcomingMatches as $match)
                        <div class="match-card">
                            <div class="match-info-meta">
                                <span class="match-round">{{ $match->round }}</span>
                                <span class="match-time">
                                    {{ $match->match_date ? date('d M Y', strtotime($match->match_date)) : 'TBA' }} 
                                    {{ $match->match_time ? '• ' . substr($match->match_time, 0, 5) . ' WIB' : '' }}
                                </span>
                            </div>

                            <div class="match-teams-box">
                                <div class="team-entry">
                                    <div class="team-avatar">
                                        {{ strtoupper(substr($match->teamA?->team_name ?? 'T', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="team-detail-name">{{ $match->teamA?->team_name ?? 'TBD' }}</div>
                                        <div class="team-school-sub">{{ $match->teamA?->school_name ?? '-' }}</div>
                                    </div>
                                </div>

                                <div class="match-vs-score">
                                    @if ($match->status === 'finished' && $match->result)
                                        <div class="match-score-text">{{ $match->result }}</div>
                                    @else
                                        <div class="match-vs-tag">VS</div>
                                    @endif
                                </div>

                                <div class="team-entry team-right">
                                    <div class="team-avatar">
                                        {{ strtoupper(substr($match->teamB?->team_name ?? 'T', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="team-detail-name">{{ $match->teamB?->team_name ?? 'TBD' }}</div>
                                        <div class="team-school-sub">{{ $match->teamB?->school_name ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="match-action-box">
                                <x-status-badge :status="$match->status" />
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- 7. CTA Banner -->
    <section style="padding: 80px 0; background: linear-gradient(135deg, rgba(54, 133, 255, 0.15), rgba(139, 92, 246, 0.15)); border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
        <div class="container" style="text-align: center;">
            <span class="section-tag">SIAPKAN SQUAD TERBAIKMU</span>
            <h2 style="font-size: 36px; margin-bottom: 16px; color: var(--white);">Jadilah Juara di ARENA Z</h2>
            <p style="color: var(--text-muted); max-width: 580px; margin: 0 auto 30px; font-size: 16px;">
                Buktikan kemampuan tim sekolahmu di panggung esports resmi pelajar. Daftarkan tim 5v5 sekarang sebelum kuota penuh!
            </p>
            <div style="display: flex; justify-content: center; gap: 16px; flex-wrap: wrap;">
                <a href="{{ route('user.register') }}" class="btn btn-primary btn-lg">
                    Daftar Sekarang Gratis →
                </a>
                <a href="{{ route('bracket') }}" class="btn btn-secondary btn-lg">
                    Lihat Bagan Bracket
                </a>
            </div>
        </div>
    </section>
@endsection
