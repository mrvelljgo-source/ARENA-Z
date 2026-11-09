<?php

namespace App\Http\Controllers;

use App\Models\MatchSchedule;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Http\Request;

class AdminScheduleController extends Controller
{
    // Menampilkan semua jadwal pertandingan
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        $schedules = MatchSchedule::with([
            'tournament',
            'teamA',
            'teamB',
        ])->latest()->get();

        return view('admin.schedules', compact('schedules'));
    }

    // Menampilkan form tambah jadwal
    public function create()
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
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        $validated = $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'team_a_id' => 'required|exists:teams,id|different:team_b_id',
            'team_b_id' => 'required|exists:teams,id',
            'match_date' => 'nullable|date',
            'match_time' => 'nullable|date_format:H:i',
            'round' => 'required|in:Upper Semi Final,Upper Final,Lower Round,Lower Final,Grand Final',
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

    // Mengubah status pertandingan
    public function updateStatus($id, $status)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        if (! in_array($status, ['upcoming', 'live', 'finished'])) {
            abort(404);
        }

        $schedule = MatchSchedule::findOrFail($id);

        $schedule->status = $status;
        $schedule->save();

        return redirect('/admin/schedules')
            ->with('success', 'Status pertandingan berhasil diperbarui!');
    }

    public function updateResult(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        $validated = $request->validate([
            'result' => 'required|string|max:30',
        ]);

        $schedule = MatchSchedule::findOrFail($id);

        $schedule->result = $validated['result'];
        $schedule->save();

        return redirect('/admin/schedules')
            ->with('success', 'Hasil pertandingan berhasil disimpan!');
    }

    public function resetAll()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        $deletedSchedules = MatchSchedule::query()->delete();

        return redirect('/admin/schedules')
            ->with('success', "Reset selesai. {$deletedSchedules} jadwal dihapus.");
    }

    // Menghapus jadwal pertandingan
    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        $schedule = MatchSchedule::findOrFail($id);
        $schedule->delete();

        return redirect('/admin/schedules')
            ->with('success', 'Jadwal pertandingan berhasil dihapus!');
    }
}
