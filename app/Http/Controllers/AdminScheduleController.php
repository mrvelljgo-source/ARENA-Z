<?php

namespace App\Http\Controllers;

use App\Models\MatchSchedule;
use App\Models\Team;
use App\Models\Tournament;
use App\Services\TournamentBracketGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminScheduleController extends Controller
{
    // Menampilkan semua jadwal pertandingan
    public function index(): View
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        $schedules = MatchSchedule::with([
            'tournament',
            'teamA',
            'teamB',
        ])
            ->orderBy('tournament_id')
            ->orderBy('id')
            ->get();

        $tournaments = Tournament::query()
            ->withCount([
                'teams as approved_teams_count' => fn ($query) => $query->where('status', 'approved'),
                'matchSchedules',
            ])
            ->orderBy('name')
            ->get();

        return view('admin.schedules', compact('schedules', 'tournaments'));
    }

    // Menampilkan form tambah jadwal
    public function create(): View
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        $tournaments = Tournament::all();

        $teams = Team::where('status', 'approved')->get();

        return view('admin.schedule-create', compact(
            'tournaments',
            'teams'
        ));
    }

    // Menyimpan jadwal pertandingan
    public function store(Request $request): RedirectResponse
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        $validated = $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'team_a_id' => 'required|exists:teams,id|different:team_b_id',
            'team_b_id' => 'required|exists:teams,id',
            'match_date' => 'nullable|date_format:Y-m-d',
            'match_time' => 'nullable|date_format:H:i',
            'round' => 'required|in:Round of 64,Round of 32,Round of 16,Quarterfinal,Semifinal,Final',
        ]);

        $teamA = Team::findOrFail($validated['team_a_id']);
        $teamB = Team::findOrFail($validated['team_b_id']);

        $errors = [];

        if ($teamA->status !== 'approved') {
            $errors['team_a_id'] = 'Tim A harus sudah disetujui admin.';
        }

        if ($teamB->status !== 'approved') {
            $errors['team_b_id'] = 'Tim B harus sudah disetujui admin.';
        }

        if ($errors !== []) {
            return back()
                ->withInput()
                ->withErrors($errors);
        }

        if (
            $teamA->tournament_id !== $teamB->tournament_id ||
            $teamA->tournament_id != $validated['tournament_id']
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'team_a_id' => 'Kedua tim harus terdaftar pada turnamen yang sama.',
                ]);
        }

        MatchSchedule::create([
            ...$validated,
            'status' => 'upcoming',
        ]);

        return redirect('/admin/schedules')
            ->with('success', 'Jadwal pertandingan berhasil ditambahkan!');
    }

    public function generate(Request $request, TournamentBracketGenerator $generator): RedirectResponse
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        $validated = $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'replace_existing' => 'nullable|boolean',
        ]);
        $tournament = Tournament::findOrFail($validated['tournament_id']);
        $matchCount = $generator->generate(
            $tournament,
            (bool) ($validated['replace_existing'] ?? false)
        );

        return redirect('/admin/schedules')
            ->with('success', "Bracket single elimination berhasil dibuat otomatis ({$matchCount} slot pertandingan).");
    }

    // Mengubah status pertandingan
    public function updateStatus(
        int $id,
        string $status,
        TournamentBracketGenerator $generator
    ): RedirectResponse {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        if (! in_array($status, ['upcoming', 'live', 'finished'])) {
            abort(404);
        }

        $schedule = MatchSchedule::findOrFail($id);

        if ($status === 'finished' && ! $schedule->result) {
            return back()->withErrors([
                'result' => 'Masukkan hasil pertandingan sebelum mengubah status menjadi selesai.',
            ]);
        }

        DB::transaction(function () use ($schedule, $status, $generator): void {
            $schedule->status = $status;

            if ($status !== 'finished') {
                $schedule->result = null;
            }

            $schedule->save();

            if ($schedule->is_bracket_generated) {
                $generator->synchronize($schedule->tournament);
            }
        });

        return redirect('/admin/schedules')
            ->with('success', 'Status pertandingan berhasil diperbarui!');
    }

    public function updateResult(
        Request $request,
        int $id,
        TournamentBracketGenerator $generator
    ): RedirectResponse {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        $validated = $request->validate([
            'result' => ['required', 'regex:/^\d+-\d+$/'],
        ]);

        $schedule = MatchSchedule::findOrFail($id);

        if (! $schedule->team_a_id || ! $schedule->team_b_id) {
            return back()->withErrors([
                'result' => 'Hasil hanya dapat dicatat setelah kedua tim ditentukan.',
            ]);
        }

        [$scoreA, $scoreB] = array_map('intval', explode('-', $validated['result']));

        if ($scoreA === $scoreB) {
            return back()->withErrors([
                'result' => 'Skor pertandingan tidak boleh seri.',
            ]);
        }

        DB::transaction(function () use ($schedule, $validated, $generator): void {
            $schedule->result = $validated['result'];
            $schedule->status = 'finished';
            $schedule->save();

            if ($schedule->is_bracket_generated) {
                $generator->synchronize($schedule->tournament);
            }
        });

        return redirect('/admin/schedules')
            ->with('success', 'Hasil pertandingan disimpan dan bracket diperbarui otomatis!');
    }

    public function updateSchedule(Request $request, int $id): RedirectResponse
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        $validated = $request->validate([
            'match_date' => 'nullable|date_format:Y-m-d',
            'match_time' => 'nullable|date_format:H:i',
        ]);
        $schedule = MatchSchedule::findOrFail($id);

        if (in_array($schedule->result, ['BYE', 'SKIPPED'], true)) {
            return back()->withErrors([
                'schedule' => 'Pertandingan otomatis atau yang tidak diperlukan tidak dapat dijadwalkan.',
            ]);
        }

        $schedule->update($validated);

        return redirect('/admin/schedules')
            ->with('success', 'Tanggal dan waktu pertandingan berhasil diperbarui.');
    }

    public function resetAll(): RedirectResponse
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        $deletedSchedules = MatchSchedule::query()->delete();

        return redirect('/admin/schedules')
            ->with('success', "Reset selesai. {$deletedSchedules} jadwal dihapus.");
    }

    // Menghapus jadwal pertandingan
    public function destroy(int $id): RedirectResponse
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        $schedule = MatchSchedule::findOrFail($id);

        if ($schedule->is_bracket_generated) {
            return back()->withErrors([
                'schedule' => 'Pertandingan bracket tidak dapat dihapus satu per satu. Gunakan reset jadwal untuk menghapus seluruh bracket.',
            ]);
        }

        $schedule->delete();

        return redirect('/admin/schedules')
            ->with('success', 'Jadwal pertandingan berhasil dihapus!');
    }
}
