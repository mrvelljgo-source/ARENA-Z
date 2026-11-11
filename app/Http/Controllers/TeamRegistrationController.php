<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TeamRegistrationController extends Controller
{
    /**
     * Tampilkan form pendaftaran tim.
     */
    public function create(): View
    {
        if (auth()->user()->role !== 'user') {
            abort(403, 'Akses khusus peserta.');
        }

        // Hanya turnamen dengan status pendaftaran terbuka
        $tournaments = Tournament::whereIn('status', ['upcoming', 'registration_open', 'active'])
            ->get();

        // Turnamen yang sudah didaftarkan user (untuk mencegah duplikat)
        $registeredTournamentIds = Team::where('user_id', auth()->id())
            ->pluck('tournament_id')
            ->toArray();

        return view('user.team-register', compact('tournaments', 'registeredTournamentIds'));
    }

    /**
     * Simpan pendaftaran tim beserta roster pemain.
     */
    public function store(Request $request): RedirectResponse
    {
        if (auth()->user()->role !== 'user') {
            abort(403, 'Akses khusus peserta.');
        }

        // Validasi data tim
        $validated = $request->validate([
            'tournament_id'   => ['required', 'exists:tournaments,id'],
            'team_name'       => ['required', 'string', 'max:255'],
            'school_name'     => ['required', 'string', 'max:255'],
            'leader_name'     => ['required', 'string', 'max:255'],
            'leader_email'    => ['required', 'email', 'max:255'],
            'leader_phone'    => ['required', 'string', 'max:20'],
            'captain_index'   => ['required', 'integer', 'min:0', 'max:4'],

            // 5 pemain utama (index 0–4)
            'players'                   => ['required', 'array', 'size:5'],
            'players.*.name'            => ['required', 'string', 'max:255'],
            'players.*.in_game_name'    => ['required', 'string', 'max:255'],
            'players.*.game_id'         => ['required', 'string', 'max:100'],
            'players.*.role_in_game'    => ['required', 'string', 'max:100'],
            'players.*.student_grade'   => ['required', 'string', 'max:50'],
            'players.*.phone_number'    => ['nullable', 'string', 'max:20'],
            // is_captain tidak dikirim dari form — ditentukan via captain_index

            // Pemain cadangan (opsional)
            'substitute.name'           => ['nullable', 'string', 'max:255'],
            'substitute.in_game_name'   => ['nullable', 'string', 'max:255'],
            'substitute.game_id'        => ['nullable', 'string', 'max:100'],
            'substitute.role_in_game'   => ['nullable', 'string', 'max:100'],
            'substitute.student_grade'  => ['nullable', 'string', 'max:50'],
            'substitute.phone_number'   => ['nullable', 'string', 'max:20'],
        ], [
            'tournament_id.required'            => 'Silakan pilih turnamen.',
            'tournament_id.exists'              => 'Turnamen tidak ditemukan.',
            'team_name.required'                => 'Nama tim wajib diisi.',
            'school_name.required'              => 'Nama sekolah wajib diisi.',
            'leader_name.required'              => 'Nama ketua tim wajib diisi.',
            'leader_email.required'             => 'Email ketua tim wajib diisi.',
            'leader_phone.required'             => 'Nomor WhatsApp wajib diisi.',
            'captain_index.required'            => 'Pilih 1 pemain sebagai kapten tim.',
            'captain_index.integer'             => 'Data kapten tidak valid.',
            'captain_index.min'                 => 'Data kapten tidak valid.',
            'captain_index.max'                 => 'Data kapten tidak valid.',
            'players.required'                  => 'Data 5 pemain utama wajib diisi.',
            'players.size'                      => 'Harus ada tepat 5 pemain utama.',
            'players.*.name.required'           => 'Nama pemain wajib diisi.',
            'players.*.in_game_name.required'   => 'Username in-game wajib diisi.',
            'players.*.game_id.required'        => 'ID Game wajib diisi.',
            'players.*.role_in_game.required'   => 'Role pemain wajib diisi.',
            'players.*.student_grade.required'  => 'Kelas pemain wajib diisi.',
        ]);

        // Cek turnamen masih buka pendaftaran
        $tournament = Tournament::findOrFail($validated['tournament_id']);

        if (! in_array($tournament->status, ['upcoming', 'registration_open', 'active'])) {
            return back()
                ->withInput()
                ->withErrors(['tournament_id' => 'Turnamen ini sudah tidak menerima pendaftaran.']);
        }

        // Cek user tidak mendaftar dua kali di turnamen yang sama
        $alreadyRegistered = Team::where('user_id', auth()->id())
            ->where('tournament_id', $validated['tournament_id'])
            ->exists();

        if ($alreadyRegistered) {
            return back()
                ->withInput()
                ->withErrors(['tournament_id' => 'Anda sudah mendaftarkan tim untuk turnamen ini.']);
        }

        // captain_index sudah divalidasi oleh validator (required, integer, 0–4)
        $captainIndex = (int) $validated['captain_index'];

        // Jika ada pemain cadangan, pastikan semua field wajibnya terisi
        $hasSubstitute = $request->filled('substitute.name');

        if ($hasSubstitute) {
            $substituteFields = ['substitute.name', 'substitute.in_game_name', 'substitute.game_id', 'substitute.role_in_game', 'substitute.student_grade'];

            foreach ($substituteFields as $field) {
                if (! $request->filled($field)) {
                    return back()
                        ->withInput()
                        ->withErrors(['substitute' => 'Jika mendaftarkan pemain cadangan, semua data wajib diisi lengkap.']);
                }
            }
        }

        // Simpan ke database dalam satu transaksi
        DB::transaction(function () use ($validated, $request, $hasSubstitute, $captainIndex): void {
            $team = Team::create([
                'user_id' => auth()->id(),
                'tournament_id' => $validated['tournament_id'],
                'team_name' => $validated['team_name'],
                'school_name' => $validated['school_name'],
                'leader_name' => $validated['leader_name'],
                'leader_email' => $validated['leader_email'],
                'leader_phone' => $validated['leader_phone'],
                'status' => 'pending',
            ]);

            // Simpan 5 pemain utama
            foreach ($request->players as $index => $playerData) {
                $isCaptain = (int) $index === $captainIndex;

                Player::create([
                    'team_id' => $team->id,
                    'name' => $playerData['name'],
                    'in_game_name' => $playerData['in_game_name'],
                    'game_id' => $playerData['game_id'],
                    'role_in_game' => $playerData['role_in_game'],
                    'student_grade' => $playerData['student_grade'],
                    'phone_number' => $playerData['phone_number'] ?? null,
                    'is_captain' => $isCaptain,
                    'is_substitute' => false,
                ]);
            }

            // Simpan pemain cadangan jika ada
            if ($hasSubstitute) {
                $sub = $request->input('substitute');
                Player::create([
                    'team_id' => $team->id,
                    'name' => $sub['name'],
                    'in_game_name' => $sub['in_game_name'],
                    'game_id' => $sub['game_id'],
                    'role_in_game' => $sub['role_in_game'],
                    'student_grade' => $sub['student_grade'],
                    'phone_number' => $sub['phone_number'] ?? null,
                    'is_captain' => false,
                    'is_substitute' => true,
                ]);
            }
        });

        return redirect()->route('user.dashboard')
            ->with('success', 'Pendaftaran tim berhasil dikirim! Tunggu verifikasi dari panitia.');
    }
}
