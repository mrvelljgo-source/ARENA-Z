<?php

namespace App\Http\Controllers;

use App\Models\MatchSchedule;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserDashboardController extends Controller
{
    /**
     * Pastikan hanya user biasa yang dapat mengakses.
     */
    private function authorizeUser(): void
    {
        if (auth()->user()->role !== 'user') {
            abort(403, 'Akses khusus peserta.');
        }
    }

    /**
     * Halaman utama dashboard user.
     */
    public function index(): View
    {
        $this->authorizeUser();

        $user = auth()->user();

        $teams = Team::with(['tournament', 'players', 'captain', 'mainPlayers', 'substitutePlayer'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $totalTeams = $teams->count();
        $totalApproved = $teams->where('status', 'approved')->count();
        $totalPending = $teams->where('status', 'pending')->count();
        $totalRejected = $teams->where('status', 'rejected')->count();

        // Jadwal pertandingan terdekat milik tim user
        $teamIds = $teams->pluck('id');

        $upcomingMatches = MatchSchedule::with(['tournament', 'teamA', 'teamB'])
            ->where(function ($q) use ($teamIds) {
                $q->whereIn('team_a_id', $teamIds)
                    ->orWhereIn('team_b_id', $teamIds);
            })
            ->where('status', '!=', 'finished')
            ->where(function ($q) {
                $q->whereNull('result')
                    ->orWhereNotIn('result', ['BYE', 'SKIPPED']);
            })
            ->orderBy('match_date')
            ->orderBy('match_time')
            ->take(5)
            ->get();

        // Aktivitas terbaru (teams terbaru)
        $recentActivity = $teams->take(3);

        return view('user.dashboard-new', compact(
            'user',
            'teams',
            'totalTeams',
            'totalApproved',
            'totalPending',
            'totalRejected',
            'upcomingMatches',
            'recentActivity',
        ));
    }

    /**
     * Halaman daftar tim milik user.
     */
    public function myTeams(): View
    {
        $this->authorizeUser();

        $teams = Team::with(['tournament', 'players', 'captain', 'mainPlayers', 'substitutePlayer'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.my-teams', compact('teams'));
    }

    /**
     * Halaman detail satu tim milik user.
     */
    public function teamDetail(int $id): View
    {
        $this->authorizeUser();

        $team = Team::with(['tournament', 'players', 'captain', 'mainPlayers', 'substitutePlayer'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('user.team-detail', compact('team'));
    }

    /**
     * Halaman jadwal pertandingan milik tim user.
     */
    public function mySchedule(): View
    {
        $this->authorizeUser();

        $teamIds = Team::where('user_id', auth()->id())->pluck('id');

        $schedules = MatchSchedule::with(['tournament', 'teamA', 'teamB', 'winner'])
            ->where(function ($q) use ($teamIds) {
                $q->whereIn('team_a_id', $teamIds)
                    ->orWhereIn('team_b_id', $teamIds);
            })
            ->where(function ($q) {
                $q->whereNull('result')
                    ->orWhereNotIn('result', ['BYE', 'SKIPPED']);
            })
            ->orderBy('match_date')
            ->orderBy('match_time')
            ->get();

        return view('user.my-schedule', compact('schedules', 'teamIds'));
    }

    /**
     * Halaman bracket — diarahkan ke halaman bracket publik berdasarkan turnamen user.
     */
    public function myBracket(): View
    {
        $this->authorizeUser();

        $myTeams = Team::with('tournament')
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->get();

        $teamIds = $myTeams->pluck('id');

        // Semua turnamen yang diikuti user
        $myTournaments = $myTeams->pluck('tournament')->filter()->unique('id')->values();

        // Pilih turnamen berdasarkan query param atau default ke pertama
        $requestedId = request()->integer('tournament_id');
        $selectedTournament = $requestedId
            ? $myTournaments->firstWhere('id', $requestedId) ?? $myTournaments->first()
            : $myTournaments->first();

        $schedules = collect();
        $rounds = collect();
        $hasLegacyDoubleElimination = false;

        if ($selectedTournament) {
            $schedules = $selectedTournament->matchSchedules()
                ->with(['teamA', 'teamB', 'winner'])
                ->orderBy('id')
                ->get();

            $hasLegacyDoubleElimination = $schedules->contains(
                fn (MatchSchedule $s) => str_starts_with($s->round, 'Upper')
                    || str_starts_with($s->round, 'Lower')
                    || str_starts_with($s->round, 'Grand Final')
            );

            $rounds = $hasLegacyDoubleElimination ? collect() : $schedules->groupBy('round');
        }

        return view('user.my-bracket', compact(
            'myTournaments',
            'selectedTournament',
            'schedules',
            'rounds',
            'hasLegacyDoubleElimination',
            'teamIds',
        ));
    }

    /**
     * Halaman profil user.
     */
    public function profile(): View
    {
        $this->authorizeUser();

        $user = auth()->user();

        return view('user.profile', compact('user'));
    }

    /**
     * Simpan perubahan profil user.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $this->authorizeUser();

        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'school_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:25'],
            'current_password' => ['nullable', 'string'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan akun lain.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Jika user ingin ganti password
        if ($request->filled('new_password')) {
            if (! $request->filled('current_password') || ! Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'Password saat ini tidak sesuai.',
                ])->withInput();
            }

            $user->password = Hash::make($validated['new_password']);
        }

        $user->name = $validated['name'];
        $user->email = strtolower(trim($validated['email']));
        $user->school_name = $validated['school_name'] ?? null;
        $user->phone = $validated['phone'] ?? null;
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
