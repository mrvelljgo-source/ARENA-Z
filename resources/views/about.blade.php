@extends('layouts.app')

@section('title', 'Tentang ARENA Z — Student Esports Tournament Platform')

@section('content')
    <!-- Header Banner -->
    <section style="padding: 70px 0 50px; background: radial-gradient(circle at 50% 20%, rgba(54, 133, 255, 0.14) 0%, transparent 60%); border-bottom: 1px solid var(--border-color);">
        <div class="container" style="text-align: center;">
            <span class="section-tag">PROFIL PLATFORM</span>
            <h1 style="font-size: 38px; color: var(--white); margin-bottom: 16px;">TENTANG ARENA Z</h1>
            <p style="color: var(--text-muted); max-width: 650px; margin: 0 auto 36px; font-size: 16px;">
                Platform kompetisi Mobile Legends: Bang Bang nomor satu yang didedikasikan untuk membangun ekosistem esports pelajar yang sehat, terstruktur, dan berprestasi.
            </p>

            <!-- Live Stats -->
            <div style="display: inline-flex; gap: 0; border: 1px solid var(--border-color); border-radius: var(--radius-lg); overflow: hidden; background: var(--bg-card);" class="about-stats-band">
                <div style="padding: 20px 36px; border-right: 1px solid var(--border-color);">
                    <div style="font-family: var(--font-heading); font-size: 28px; font-weight: 800; color: var(--blue-primary);">{{ $totalTournaments }}+</div>
                    <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">Turnamen</div>
                </div>
                <div style="padding: 20px 36px; border-right: 1px solid var(--border-color);">
                    <div style="font-family: var(--font-heading); font-size: 28px; font-weight: 800; color: var(--purple-accent);">{{ $totalTeams }}+</div>
                    <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">Tim Terdaftar</div>
                </div>
                <div style="padding: 20px 36px;">
                    <div style="font-family: var(--font-heading); font-size: 28px; font-weight: 800; color: var(--success);">{{ $totalPlayers }}+</div>
                    <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">Peserta Aktif</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section style="padding: 70px 0;">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 60px; align-items: center;" class="about-two-col">
                <div>
                    <span class="section-tag">LATAR BELAKANG & TUJUAN</span>
                    <h2 style="font-size: 28px; color: var(--white); margin-bottom: 18px; line-height: 1.3;">
                        Mewadahi Talenta Muda Esports Indonesia
                    </h2>
                    <p style="color: var(--text-muted); margin-bottom: 16px; font-size: 15px; line-height: 1.7;">
                        <strong style="color: var(--white);">ARENA Z</strong> didirikan dengan semangat memberikan ruang kompetisi yang adil, profesional, dan terverifikasi bagi para pelajar. Kami meyakini bahwa esports bukan sekadar hiburan, melainkan sarana melatih kepemimpinan, sportivitas, disiplin waktu, dan kerja sama tim antar siswa.
                    </p>
                    <p style="color: var(--text-muted); font-size: 15px; line-height: 1.7;">
                        Melalui sistem registrasi roster 5v5 terpusat dan bagan eliminasi dinamis, ARENA Z menghilangkan kerumitan administrasi turnamen konvensional serta menjamin setiap pertandingan berjalan transparan.
                    </p>
                </div>

                <div class="card" style="border-left: 4px solid var(--blue-primary); padding: 32px;">
                    <h3 style="font-size: 20px; color: var(--white); margin-bottom: 16px;">Fokus Utama ARENA Z</h3>
                    <ul style="list-style: none; display: flex; flex-direction: column; gap: 14px;">
                        <li style="display: flex; gap: 12px; align-items: flex-start;">
                            <span style="color: var(--blue-primary); font-size: 18px;">✓</span>
                            <span style="color: var(--text-muted);"><strong>Verifikasi Pelajar:</strong> Memastikan seluruh peserta adalah siswa aktif dari sekolah yang didaftarkan.</span>
                        </li>
                        <li style="display: flex; gap: 12px; align-items: flex-start;">
                            <span style="color: var(--blue-primary); font-size: 18px;">✓</span>
                            <span style="color: var(--text-muted);"><strong>Sistem Bracket Otomatis:</strong> Pertandingan terjadwal dengan pemenang yang melaju secara dinamis.</span>
                        </li>
                        <li style="display: flex; gap: 12px; align-items: flex-start;">
                            <span style="color: var(--blue-primary); font-size: 18px;">✓</span>
                            <span style="color: var(--text-muted);"><strong>Integritas Roster:</strong> Format 5 pemain inti dengan kepemimpinan kapten yang jelas.</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Visi & Misi Cards -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 28px; margin-bottom: 70px;" class="about-two-col">
                <div class="card" style="padding: 34px;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                        <div style="width: 44px; height: 44px; background: rgba(54, 133, 255, 0.15); border: 1px solid var(--blue-primary); border-radius: var(--radius-md); display:grid; place-items:center; font-size: 20px;">
                            🎯
                        </div>
                        <h3 style="font-size: 22px; color: var(--white); margin: 0;">VISI KAMI</h3>
                    </div>
                    <p style="color: var(--text-muted); font-size: 15px; line-height: 1.8;">
                        Menjadi platform turnamen esports pelajar nomor satu di Indonesia yang melahirkan atlet-atlet esports berbakat, berkarakter, dan berdaya saing tinggi sejak bangku sekolah.
                    </p>
                </div>

                <div class="card" style="padding: 34px;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                        <div style="width: 44px; height: 44px; background: rgba(139, 92, 246, 0.15); border: 1px solid var(--purple-accent); border-radius: var(--radius-md); display:grid; place-items:center; font-size: 20px;">
                            🚀
                        </div>
                        <h3 style="font-size: 22px; color: var(--white); margin: 0;">MISI KAMI</h3>
                    </div>
                    <ul style="color: var(--text-muted); font-size: 14px; line-height: 1.8; padding-left: 20px;">
                        <li>Menyelenggarakan kompetisi Mobile Legends pelajar secara berkala dan terstandar.</li>
                        <li>Menerapkan prinsip fair play tanpa kompromi terhadap cheat dan joki akun.</li>
                        <li>Menyediakan platform digital yang memudahkan sekolah dan siswa mengelola tim esports.</li>
                    </ul>
                </div>
            </div>

            <!-- Target Peserta & Format Pertandingan -->
            <div style="background-color: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 40px;">
                <div style="text-align: center; margin-bottom: 36px;">
                    <span class="section-tag">KETENTUAN KOMPETISI</span>
                    <h2 style="font-size: 26px; color: var(--white);">Format & Target Peserta</h2>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
                    <div style="background: var(--bg-card); padding: 24px; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                        <h4 style="font-size: 16px; color: var(--blue-primary); margin-bottom: 10px;">👥 Target Peserta</h4>
                        <p style="color: var(--text-muted); font-size: 14px; line-height: 1.6;">
                            Terbuka untuk pelajar aktif tingkat <strong>SMP, SMA, dan SMK sederajat</strong> di seluruh wilayah Indonesia yang memiliki kartu pelajar atau surat keterangan sekolah.
                        </p>
                    </div>

                    <div style="background: var(--bg-card); padding: 24px; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                        <h4 style="font-size: 16px; color: var(--purple-accent); margin-bottom: 10px;">🎮 Format Roster</h4>
                        <p style="color: var(--text-muted); font-size: 14px; line-height: 1.6;">
                            Format <strong>5 VS 5</strong> dengan susunan tepat 5 pemain inti (satu di antaranya ditunjuk sebagai kapten) dan maksimal 1 pemain cadangan opsional.
                        </p>
                    </div>

                    <div style="background: var(--bg-card); padding: 24px; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                        <h4 style="font-size: 16px; color: var(--success); margin-bottom: 10px;">⚔️ Sistem Pertandingan</h4>
                        <p style="color: var(--text-muted); font-size: 14px; line-height: 1.6;">
                            <strong>Single Elimination Tournament Mode Custom Draft Pick</strong>. Babak awal hingga Semifinal Best of 3 (BO3), dan Grand Final Best of 5 (BO5).
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section style="padding: 70px 0; border-top: 1px solid var(--border-color); text-align: center; background: var(--bg-secondary);">
        <div class="container">
            <span class="section-tag">BERGABUNGLAH SEKARANG</span>
            <h2 style="font-size: 32px; color: var(--white); margin-bottom: 14px;">Siap Bawa Nama Sekolahmu ke Podium?</h2>
            <p style="color: var(--text-muted); max-width: 580px; margin: 0 auto 30px; font-size: 15px;">
                Daftarkan tim 5v5 sekolahmu, ikuti seleksi, dan buktikan bahwa sekolahmu layak jadi juara di ARENA Z.
            </p>
            <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('user.register') }}" class="btn btn-primary btn-lg">Daftar Sebagai Peserta →</a>
                <a href="{{ route('tournaments.index') }}" class="btn btn-outline btn-lg">Lihat Turnamen</a>
            </div>
        </div>
    </section>
@endsection

