@extends('layouts.app')

@section('title', 'Daftar Turnamen Esports — ARENA Z')

@section('content')
    <!-- Page Header -->
    <section style="padding: 60px 0 40px; background: radial-gradient(circle at 50% 10%, rgba(54, 133, 255, 0.12) 0%, transparent 65%); border-bottom: 1px solid var(--border-color);">
        <div class="container">
            <span class="section-tag">DAFTAR KOMPETISI</span>
            <h1 style="font-size: 36px; color: var(--white); margin-bottom: 12px;">Turnamen Mobile Legends</h1>
            <p style="color: var(--text-muted); max-width: 620px; font-size: 15px;">
                Temukan turnamen resmi Mobile Legends yang sedang membuka pendaftaran atau sedang berlangsung. Daftarkan tim sekolahmu sekarang!
            </p>
        </div>
    </section>

    <!-- Filter & List Section -->
    <section style="padding: 50px 0 90px;">
        <div class="container">
            <!-- Search & Filter Controls -->
            <div style="background-color: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 20px 24px; margin-bottom: 36px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
                <!-- Filter Buttons -->
                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <button type="button" class="btn btn-primary btn-sm active" data-filter="all">
                        Semua Status
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm" data-filter="upcoming">
                        Segera Hadir
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm" data-filter="registration_open">
                        Pendaftaran Buka
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm" data-filter="ongoing">
                        Sedang Berlangsung
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm" data-filter="completed">
                        Selesai
                    </button>
                </div>

                <!-- Search Input -->
                <div style="min-width: 260px; max-width: 340px; width: 100%;">
                    <input 
                        type="text" 
                        id="tournamentSearch" 
                        placeholder="Cari turnamen..." 
                        style="width: 100%; background: var(--bg-primary); border: 1px solid var(--border-color); padding: 9px 16px; border-radius: var(--radius-md); color: var(--white); font-family: inherit; font-size: 14px; outline: none;"
                    >
                </div>
            </div>

            <!-- Tournament Cards Grid -->
            <div class="tournament-grid">
                @forelse ($tournaments as $tournament)
                    <x-tournament-card :tournament="$tournament" />
                @empty
                    <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
                        <div style="font-size: 40px; margin-bottom: 16px; color: var(--text-dim);">🎮</div>
                        <h3 style="font-size: 20px; color: var(--white); margin-bottom: 8px;">Belum Ada Turnamen</h3>
                        <p style="color: var(--text-muted); font-size: 14px;">Saat ini belum ada turnamen yang dijadwalkan. Silakan periksa kembali nanti.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
