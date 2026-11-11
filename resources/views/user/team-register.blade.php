@extends('layouts.user-dashboard')

@section('title', 'Daftar Tim')
@section('page-title', 'Pendaftaran Tim')

@section('content')

    <div class="ud-page-header">
        <div class="ud-page-label">PENDAFTARAN PESERTA</div>
        <div class="ud-page-title">Daftarkan Tim Sekolahmu</div>
        <div class="ud-page-desc">Isi formulir berikut untuk mendaftarkan tim 5v5 ke turnamen ARENA Z. Pastikan data semua pemain benar sebelum mengirim.</div>
    </div>

    @if ($tournaments->isEmpty())
        <div class="ud-card">
            <div class="ud-empty">
                <div class="ud-empty-icon"><i class="fas fa-trophy"></i></div>
                <div class="ud-empty-title">Tidak Ada Turnamen Tersedia</div>
                <div class="ud-empty-desc">Saat ini belum ada turnamen yang membuka pendaftaran. Pantau terus halaman turnamen untuk info terbaru.</div>
                <a href="{{ route('tournaments.index') }}" class="ud-btn ud-btn-primary">
                    <i class="fas fa-search"></i> Cek Turnamen
                </a>
            </div>
        </div>
    @else

    <form action="{{ route('user.team.store') }}" method="POST" id="teamRegistrationForm">
        @csrf

        {{-- SECTION 1: Info Tim --}}
        <div class="ud-card" style="margin-bottom: 20px;">
            <div class="ud-form-section-title">
                <i class="fas fa-shield-halved"></i> Informasi Tim
            </div>

            <div class="ud-form-grid">
                <div class="ud-form-group ud-form-group full-width">
                    <label class="ud-label">Turnamen <span class="required">*</span></label>
                    <select name="tournament_id" class="ud-select {{ $errors->has('tournament_id') ? 'ud-input-error' : '' }}" required>
                        <option value="">-- Pilih Turnamen --</option>
                        @foreach ($tournaments as $tournament)
                            @php $isRegistered = in_array($tournament->id, $registeredTournamentIds); @endphp
                            <option value="{{ $tournament->id }}"
                                {{ old('tournament_id') == $tournament->id ? 'selected' : '' }}
                                {{ $isRegistered ? 'disabled' : '' }}>
                                {{ $tournament->name }}
                                @if ($isRegistered) (Sudah Didaftarkan) @endif
                            </option>
                        @endforeach
                    </select>
                    @error('tournament_id')
                        <div class="ud-field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="ud-form-group">
                    <label class="ud-label">Nama Tim <span class="required">*</span></label>
                    <input type="text" name="team_name" class="ud-input {{ $errors->has('team_name') ? 'ud-input-error' : '' }}"
                        value="{{ old('team_name') }}" placeholder="Contoh: Alpha Wolves" required>
                    @error('team_name')
                        <div class="ud-field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="ud-form-group">
                    <label class="ud-label">Asal Sekolah <span class="required">*</span></label>
                    <input type="text" name="school_name" class="ud-input {{ $errors->has('school_name') ? 'ud-input-error' : '' }}"
                        value="{{ old('school_name') }}" placeholder="Contoh: SMA Negeri 1 Jakarta" required>
                    @error('school_name')
                        <div class="ud-field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="ud-form-group">
                    <label class="ud-label">Nama Ketua Tim <span class="required">*</span></label>
                    <input type="text" name="leader_name" class="ud-input {{ $errors->has('leader_name') ? 'ud-input-error' : '' }}"
                        value="{{ old('leader_name') }}" placeholder="Nama lengkap ketua tim" required>
                    @error('leader_name')
                        <div class="ud-field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="ud-form-group">
                    <label class="ud-label">Email Ketua Tim <span class="required">*</span></label>
                    <input type="email" name="leader_email" class="ud-input {{ $errors->has('leader_email') ? 'ud-input-error' : '' }}"
                        value="{{ old('leader_email') }}" placeholder="email@contoh.com" required>
                    @error('leader_email')
                        <div class="ud-field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="ud-form-group">
                    <label class="ud-label">Nomor WhatsApp Ketua <span class="required">*</span></label>
                    <input type="text" name="leader_phone" class="ud-input {{ $errors->has('leader_phone') ? 'ud-input-error' : '' }}"
                        value="{{ old('leader_phone') }}" placeholder="Contoh: 08123456789" required>
                    @error('leader_phone')
                        <div class="ud-field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- SECTION 2: Roster 5 Pemain Utama --}}
        <div class="ud-card" style="margin-bottom: 20px;">
            <div class="ud-form-section-title">
                <i class="fas fa-users"></i> Roster 5 Pemain Utama
                <span style="font-size: 11px; font-weight: 400; color: var(--text-muted); margin-left: 8px;">Pilih tepat 1 pemain sebagai Kapten</span>
            </div>

            @error('players')
                <div class="ud-alert ud-alert-danger" style="margin-bottom: 16px;">
                    <i class="fas fa-triangle-exclamation"></i> {{ $message }}
                </div>
            @enderror

            @error('captain_index')
                <div class="ud-alert ud-alert-danger" style="margin-bottom: 16px;">
                    <i class="fas fa-crown"></i> {{ $message }}
                </div>
            @enderror

            @php
                $playerFields = [
                    ['name' => 'Nama Lengkap', 'key' => 'name', 'placeholder' => 'Nama lengkap pemain'],
                    ['name' => 'Username In-Game', 'key' => 'in_game_name', 'placeholder' => 'Nama di dalam game'],
                    ['name' => 'ID Game', 'key' => 'game_id', 'placeholder' => 'ID unik Mobile Legends'],
                    ['name' => 'Role', 'key' => 'role_in_game', 'placeholder' => 'Contoh: EXP, Gold, Jungler'],
                    ['name' => 'Kelas', 'key' => 'student_grade', 'placeholder' => 'Contoh: XII IPA 1'],
                    ['name' => 'WhatsApp (opsional)', 'key' => 'phone_number', 'placeholder' => '08xxxxxxxx', 'optional' => true],
                ];
                $roles = ['Roamer', 'EXP Lane', 'Mid Lane', 'Gold Lane', 'Jungler'];
            @endphp

            @for ($i = 0; $i < 5; $i++)
                @php $old = old('players.' . $i, []); @endphp
                <div class="ud-player-row">
                    <div class="ud-player-header">
                        <div class="ud-player-num">{{ $i + 1 }}</div>
                        <div class="ud-player-label">Pemain {{ $i + 1 }}</div>
                        {{-- Radio captain_index langsung — backend membaca nilai ini --}}
                        <label class="ud-captain-toggle" title="Jadikan kapten tim">
                            <input type="radio"
                                name="captain_index"
                                value="{{ $i }}"
                                {{ (string) old('captain_index', '') === (string) $i ? 'checked' : '' }}
                                required>
                            <span>Kapten</span>
                            <i class="fas fa-crown" style="color: var(--warning); font-size: 12px;"></i>
                        </label>
                    </div>

                    <div class="ud-form-grid">
                        <div class="ud-form-group">
                            <label class="ud-label">Nama Lengkap <span class="required">*</span></label>
                            <input type="text" name="players[{{ $i }}][name]"
                                class="ud-input {{ $errors->has('players.' . $i . '.name') ? 'ud-input-error' : '' }}"
                                value="{{ $old['name'] ?? '' }}" placeholder="Nama lengkap pemain" required>
                            @error('players.' . $i . '.name')
                                <div class="ud-field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="ud-form-group">
                            <label class="ud-label">Username In-Game <span class="required">*</span></label>
                            <input type="text" name="players[{{ $i }}][in_game_name]"
                                class="ud-input {{ $errors->has('players.' . $i . '.in_game_name') ? 'ud-input-error' : '' }}"
                                value="{{ $old['in_game_name'] ?? '' }}" placeholder="Nama di dalam game" required>
                            @error('players.' . $i . '.in_game_name')
                                <div class="ud-field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="ud-form-group">
                            <label class="ud-label">ID Game <span class="required">*</span></label>
                            <input type="text" name="players[{{ $i }}][game_id]"
                                class="ud-input {{ $errors->has('players.' . $i . '.game_id') ? 'ud-input-error' : '' }}"
                                value="{{ $old['game_id'] ?? '' }}" placeholder="ID unik Mobile Legends" required>
                            @error('players.' . $i . '.game_id')
                                <div class="ud-field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="ud-form-group">
                            <label class="ud-label">Role <span class="required">*</span></label>
                            <select name="players[{{ $i }}][role_in_game]"
                                class="ud-select {{ $errors->has('players.' . $i . '.role_in_game') ? 'ud-input-error' : '' }}" required>
                                <option value="">-- Pilih Role --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role }}" {{ ($old['role_in_game'] ?? '') === $role ? 'selected' : '' }}>
                                        {{ $role }}
                                    </option>
                                @endforeach
                            </select>
                            @error('players.' . $i . '.role_in_game')
                                <div class="ud-field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="ud-form-group">
                            <label class="ud-label">Kelas <span class="required">*</span></label>
                            <input type="text" name="players[{{ $i }}][student_grade]"
                                class="ud-input {{ $errors->has('players.' . $i . '.student_grade') ? 'ud-input-error' : '' }}"
                                value="{{ $old['student_grade'] ?? '' }}" placeholder="Contoh: XII IPA 1" required>
                            @error('players.' . $i . '.student_grade')
                                <div class="ud-field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="ud-form-group">
                            <label class="ud-label">WhatsApp <span style="color: var(--text-dim); font-size: 11px;">(Opsional)</span></label>
                            <input type="text" name="players[{{ $i }}][phone_number]"
                                class="ud-input"
                                value="{{ $old['phone_number'] ?? '' }}" placeholder="08xxxxxxxx">
                        </div>
                    </div>
                </div>
            @endfor
        </div>

        {{-- SECTION 3: Pemain Cadangan (opsional) --}}
        <div class="ud-card" style="margin-bottom: 24px;">
            <div class="ud-form-section-title">
                <i class="fas fa-user-plus"></i> Pemain Cadangan
                <span style="font-size: 11px; font-weight: 400; color: var(--text-muted); margin-left: 8px;">Opsional — maksimal 1 pemain</span>
            </div>

            @error('substitute')
                <div class="ud-alert ud-alert-danger" style="margin-bottom: 16px;">
                    <i class="fas fa-triangle-exclamation"></i> {{ $message }}
                </div>
            @enderror

            <div class="ud-substitute-box">
                <label class="ud-substitute-toggle">
                    <input type="checkbox" id="subToggle" {{ old('substitute.name') ? 'checked' : '' }}>
                    <span class="ud-substitute-label">Daftarkan pemain cadangan</span>
                </label>

                <div class="ud-substitute-fields {{ old('substitute.name') ? 'show' : '' }}" id="subFields">
                    @php $oldSub = old('substitute', []); @endphp
                    <div class="ud-form-grid" style="margin-top: 16px;">
                        <div class="ud-form-group">
                            <label class="ud-label">Nama Lengkap</label>
                            <input type="text" name="substitute[name]" class="ud-input"
                                value="{{ $oldSub['name'] ?? '' }}" placeholder="Nama cadangan" data-required="true">
                        </div>
                        <div class="ud-form-group">
                            <label class="ud-label">Username In-Game</label>
                            <input type="text" name="substitute[in_game_name]" class="ud-input"
                                value="{{ $oldSub['in_game_name'] ?? '' }}" placeholder="Username in-game" data-required="true">
                        </div>
                        <div class="ud-form-group">
                            <label class="ud-label">ID Game</label>
                            <input type="text" name="substitute[game_id]" class="ud-input"
                                value="{{ $oldSub['game_id'] ?? '' }}" placeholder="ID Game" data-required="true">
                        </div>
                        <div class="ud-form-group">
                            <label class="ud-label">Role</label>
                            <select name="substitute[role_in_game]" class="ud-select" data-required="true">
                                <option value="">-- Pilih Role --</option>
                                @foreach (['Roamer', 'EXP Lane', 'Mid Lane', 'Gold Lane', 'Jungler'] as $role)
                                    <option value="{{ $role }}" {{ ($oldSub['role_in_game'] ?? '') === $role ? 'selected' : '' }}>{{ $role }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="ud-form-group">
                            <label class="ud-label">Kelas</label>
                            <input type="text" name="substitute[student_grade]" class="ud-input"
                                value="{{ $oldSub['student_grade'] ?? '' }}" placeholder="Contoh: XI IPA 2" data-required="true">
                        </div>
                        <div class="ud-form-group">
                            <label class="ud-label">WhatsApp <span style="color: var(--text-dim); font-size: 11px;">(Opsional)</span></label>
                            <input type="text" name="substitute[phone_number]" class="ud-input"
                                value="{{ $oldSub['phone_number'] ?? '' }}" placeholder="08xxxxxxxx">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <button type="submit" class="ud-btn ud-btn-primary" style="font-size: 15px; padding: 12px 28px;">
                <i class="fas fa-paper-plane"></i> Kirim Pendaftaran Tim
            </button>
            <a href="{{ route('user.dashboard') }}" class="ud-btn ud-btn-outline">
                Batal
            </a>
        </div>

        <div style="margin-top: 14px; font-size: 12px; color: var(--text-muted);">
            <i class="fas fa-circle-info"></i>
            Pendaftaran akan diverifikasi oleh panitia. Pastikan semua data sudah benar sebelum mengirim.
        </div>

    </form>

    @endif

@endsection
