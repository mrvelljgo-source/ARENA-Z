@extends('layouts.user-dashboard')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')

    <div class="ud-page-header">
        <div class="ud-page-label">AKUN PESERTA</div>
        <div class="ud-page-title">Profil & Pengaturan Akun</div>
        <div class="ud-page-desc">Kelola informasi akun dan keamanan login ARENA Z kamu.</div>
    </div>

    <div class="ud-two-col" style="align-items: flex-start;">

        {{-- Left: Profile Info + Edit Form --}}
        <div>
            <div class="ud-card" style="margin-bottom: 20px;">
                <div class="ud-card-header">
                    <div class="ud-card-title">
                        <i class="fas fa-user-circle"></i> Informasi Akun
                    </div>
                </div>

                {{-- Avatar --}}
                <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid var(--border-color);">
                    <div class="ud-avatar" style="width: 64px; height: 64px; font-size: 28px; border-radius: 16px;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-family: var(--font-heading); font-size: 18px; font-weight: 800; color: var(--white);">
                            {{ $user->name }}
                        </div>
                        <div style="font-size: 13px; color: var(--text-muted); margin-top: 2px;">{{ $user->email }}</div>
                        <div style="margin-top: 6px;">
                            <span class="ud-badge ud-badge-approved">Peserta Aktif</span>
                        </div>
                    </div>
                </div>

                {{-- Current info --}}
                <table class="ud-detail-table">
                    <tr>
                        <td>Nama Lengkap</td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td>Asal Sekolah</td>
                        <td>{{ $user->school_name ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td>Nomor HP</td>
                        <td>{{ $user->phone ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td>Peran</td>
                        <td>Peserta / User</td>
                    </tr>
                    <tr>
                        <td>Terdaftar Sejak</td>
                        <td>{{ $user->created_at ? date('d F Y', strtotime($user->created_at)) : '—' }}</td>
                    </tr>
                </table>
            </div>

            {{-- Edit Form --}}
            <div class="ud-card">
                <div class="ud-card-header">
                    <div class="ud-card-title">
                        <i class="fas fa-user-pen"></i> Edit Profil
                    </div>
                </div>

                <form action="{{ route('user.profile.update') }}" method="POST">
                    @csrf

                    <div class="ud-form-section-title">
                        <i class="fas fa-id-card"></i> Data Pribadi
                    </div>

                    <div class="ud-form-grid" style="margin-bottom: 24px;">
                        <div class="ud-form-group">
                            <label class="ud-label">Nama Lengkap <span class="required">*</span></label>
                            <input type="text" name="name" class="ud-input {{ $errors->has('name') ? 'ud-input-error' : '' }}"
                                value="{{ old('name', $user->name) }}" required placeholder="Nama lengkap kamu">
                            @error('name')
                                <div class="ud-field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="ud-form-group">
                            <label class="ud-label">Email <span class="required">*</span></label>
                            <input type="email" name="email" class="ud-input {{ $errors->has('email') ? 'ud-input-error' : '' }}"
                                value="{{ old('email', $user->email) }}" required placeholder="email@contoh.com">
                            @error('email')
                                <div class="ud-field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="ud-form-group">
                            <label class="ud-label">Asal Sekolah</label>
                            <input type="text" name="school_name" class="ud-input"
                                value="{{ old('school_name', $user->school_name) }}" placeholder="SMA/SMK/SMP kamu">
                        </div>

                        <div class="ud-form-group">
                            <label class="ud-label">Nomor HP / WhatsApp</label>
                            <input type="text" name="phone" class="ud-input"
                                value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx">
                        </div>
                    </div>

                    <div class="ud-form-section-title">
                        <i class="fas fa-lock"></i> Ganti Password
                        <span style="font-size: 11px; font-weight: 400; color: var(--text-muted); margin-left: 8px;">(Kosongkan jika tidak ingin mengganti)</span>
                    </div>

                    <div class="ud-form-grid" style="margin-bottom: 24px;">
                        <div class="ud-form-group">
                            <label class="ud-label">Password Saat Ini</label>
                            <div style="position: relative;">
                                <input type="password" name="current_password"
                                    class="ud-input {{ $errors->has('current_password') ? 'ud-input-error' : '' }}"
                                    id="currentPassInput" placeholder="Password yang sekarang dipakai">
                                <button type="button" data-password-toggle="#currentPassInput"
                                    style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 4px;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <div class="ud-field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="ud-form-group" style="grid-column: 1 / 2;">
                            <label class="ud-label">Password Baru</label>
                            <div style="position: relative;">
                                <input type="password" name="new_password"
                                    class="ud-input {{ $errors->has('new_password') ? 'ud-input-error' : '' }}"
                                    id="newPassInput" placeholder="Minimal 8 karakter">
                                <button type="button" data-password-toggle="#newPassInput"
                                    style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 4px;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('new_password')
                                <div class="ud-field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="ud-form-group" style="grid-column: 2 / 3; margin-top: auto;">
                            <label class="ud-label">Konfirmasi Password Baru</label>
                            <input type="password" name="new_password_confirmation"
                                class="ud-input" placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                        <button type="submit" class="ud-btn ud-btn-primary">
                            <i class="fas fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                        <button type="reset" class="ud-btn ud-btn-outline">
                            <i class="fas fa-rotate-left"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Right: Account summary --}}
        <div>
            <div class="ud-card" style="margin-bottom: 16px;">
                <div class="ud-card-header">
                    <div class="ud-card-title">
                        <i class="fas fa-shield-halved"></i> Keamanan Akun
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 14px;">
                    <div style="display: flex; align-items: center; gap: 10px; font-size: 13px;">
                        <i class="fas fa-circle-check" style="color: var(--success); width: 16px;"></i>
                        <span style="color: var(--text-muted);">Email terverifikasi</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px; font-size: 13px;">
                        <i class="fas fa-circle-check" style="color: var(--success); width: 16px;"></i>
                        <span style="color: var(--text-muted);">Password aktif</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px; font-size: 13px;">
                        <i class="fas fa-circle-check" style="color: var(--success); width: 16px;"></i>
                        <span style="color: var(--text-muted);">CSRF protection aktif</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px; font-size: 13px;">
                        <i class="fas fa-{{ $user->school_name ? 'circle-check' : 'circle-exclamation' }}"
                           style="color: {{ $user->school_name ? 'var(--success)' : 'var(--warning)' }}; width: 16px;"></i>
                        <span style="color: var(--text-muted);">
                            Asal sekolah {{ $user->school_name ? 'terisi' : 'belum diisi' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="ud-card" style="margin-bottom: 16px;">
                <div class="ud-card-header">
                    <div class="ud-card-title">
                        <i class="fas fa-circle-info"></i> Panduan Password
                    </div>
                </div>
                <div style="font-size: 12px; color: var(--text-muted); line-height: 1.8;">
                    <div style="margin-bottom: 6px;"><i class="fas fa-check" style="color: var(--success); font-size: 10px; margin-right: 6px;"></i>Minimal 8 karakter</div>
                    <div style="margin-bottom: 6px;"><i class="fas fa-check" style="color: var(--success); font-size: 10px; margin-right: 6px;"></i>Kombinasi huruf dan angka direkomendasikan</div>
                    <div style="margin-bottom: 6px;"><i class="fas fa-check" style="color: var(--success); font-size: 10px; margin-right: 6px;"></i>Jangan gunakan password yang mudah ditebak</div>
                    <div><i class="fas fa-check" style="color: var(--success); font-size: 10px; margin-right: 6px;"></i>Konfirmasi password harus sama persis</div>
                </div>
            </div>

            <div class="ud-card">
                <div class="ud-card-header">
                    <div class="ud-card-title">
                        <i class="fas fa-link"></i> Link Cepat
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <a href="{{ route('user.dashboard') }}" class="ud-btn ud-btn-secondary" style="justify-content: flex-start;">
                        <i class="fas fa-chart-pie"></i> Kembali ke Dashboard
                    </a>
                    <a href="{{ route('user.my-teams') }}" class="ud-btn ud-btn-secondary" style="justify-content: flex-start;">
                        <i class="fas fa-users"></i> Lihat Tim Saya
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="ud-btn ud-btn-danger" style="width: 100%; justify-content: flex-start;">
                            <i class="fas fa-right-from-bracket"></i> Logout dari ARENA Z
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
// Password toggle — override karena selector pakai string bukan dataset
document.querySelectorAll('[data-password-toggle]').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const selector = this.getAttribute('data-password-toggle');
        const target = document.querySelector(selector);
        if (!target) return;
        const isPass = target.type === 'password';
        target.type = isPass ? 'text' : 'password';
        const icon = this.querySelector('i');
        if (icon) icon.className = isPass ? 'fas fa-eye-slash' : 'fas fa-eye';
    });
});
</script>
@endpush
