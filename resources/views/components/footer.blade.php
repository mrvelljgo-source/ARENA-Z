<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <a href="{{ route('home') }}" class="brand-logo" style="margin-bottom: 14px; display:inline-flex;">
                    ARENA<span class="accent">Z</span>
                </a>
                <p>
                    Platform turnamen Mobile Legends: Bang Bang khusus pelajar SMP, SMA, dan SMK. Mewadahi talenta muda esports Indonesia secara terstruktur, adil, dan profesional.
                </p>
                <div style="color: var(--blue-primary); font-family: var(--font-heading); font-size: 13px; font-weight:700;">
                    YOUR GAME. YOUR ARENA.
                </div>
            </div>

            <div class="footer-col">
                <h4>Navigasi</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('about') }}">Tentang ARENA Z</a></li>
                    <li><a href="{{ route('tournaments.index') }}">Daftar Turnamen</a></li>
                    <li><a href="{{ route('schedule') }}">Jadwal Pertandingan</a></li>
                    <li><a href="{{ route('bracket') }}">Bagan Bracket</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Kompetisi</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('tournaments.index') }}">Mobile Legends 5 VS 5</a></li>
                    <li><a href="{{ route('about') }}">Peraturan Pertandingan</a></li>
                    <li><a href="{{ route('about') }}">Format Single Elimination</a></li>
                    <li><a href="{{ route('user.register') }}">Pendaftaran Roster Pelajar</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Akses Akun</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('user.login') }}">Login Peserta</a></li>
                    <li><a href="{{ route('user.register') }}">Daftar Akun Baru</a></li>
                    <li><a href="{{ route('admin.login') }}">Portal Panitia / Admin</a></li>
                    <li><a href="{{ route('login') }}">Pilihan Gerbang Login</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div>
                &copy; {{ date('Y') }} ARENA Z — Student Esports Tournament Platform. All rights reserved.
            </div>
            <div>
                Dirancang untuk ekosistem kompetisi esports pelajar Indonesia.
            </div>
        </div>
    </div>
</footer>

