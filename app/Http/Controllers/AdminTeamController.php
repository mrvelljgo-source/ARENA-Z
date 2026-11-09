<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class AdminTeamController extends Controller
{
    // MENAMPILKAN DAFTAR TIM
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        // Statistik seluruh pendaftaran
        $totalTeams = Team::count();
        $totalPending = Team::where('status', 'pending')->count();
        $totalApproved = Team::where('status', 'approved')->count();
        $totalRejected = Team::where('status', 'rejected')->count();

        // Kata pencarian dan filter
        $search = $request->input('search');
        $status = $request->input('status');

        // Query daftar tim
        $query = Team::with(['user', 'tournament']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('team_name', 'like', "%{$search}%")
                    ->orWhere('school_name', 'like', "%{$search}%")
                    ->orWhere('leader_name', 'like', "%{$search}%");
            });
        }

        if (in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        } else {
            $status = '';
        }

        $teams = $query->latest()->get();

        return view('admin.teams', compact(
            'teams',
            'search',
            'status',
            'totalTeams',
            'totalPending',
            'totalApproved',
            'totalRejected'
        ));
    }

    // MENAMPILKAN DETAIL TIM
    public function show($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        $team = Team::with(['tournament'])->findOrFail($id);

        return view('admin.team-detail', compact('team'));
    }

    // MENAMPILKAN FORM EDIT TIM
    public function edit($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        $team = Team::findOrFail($id);

        return view('admin.team-edit', compact('team'));
    }

    // MENYIMPAN PERUBAHAN DATA TIM
    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        $request->validate([
            'team_name' => 'required|string|max:255',
            'school_name' => 'required|string|max:255',
            'leader_name' => 'required|string|max:255',
            'leader_email' => 'required|email|max:255',
            'leader_phone' => 'required|string|max:20',
        ], [
            'team_name.required' => 'Nama tim wajib diisi.',
            'school_name.required' => 'Nama sekolah wajib diisi.',
            'leader_name.required' => 'Nama ketua wajib diisi.',
            'leader_email.required' => 'Email wajib diisi.',
            'leader_email.email' => 'Format email tidak valid.',
            'leader_phone.required' => 'Nomor WhatsApp wajib diisi.',
        ]);

        $team = Team::findOrFail($id);

        $team->update([
            'team_name' => $request->team_name,
            'school_name' => $request->school_name,
            'leader_name' => $request->leader_name,
            'leader_email' => $request->leader_email,
            'leader_phone' => $request->leader_phone,
        ]);

        return redirect('/admin/teams/' . $team->id)
            ->with('success', 'Data tim berhasil diperbarui!');
    }

    // MENGUBAH STATUS PENDAFTARAN
    public function updateStatus($id, $status)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        if (!in_array($status, ['approved', 'rejected'])) {
            abort(404);
        }

        $team = Team::findOrFail($id);

        $team->status = $status;
        $team->save();

        return redirect('/admin/teams')
            ->with('success', 'Status pendaftaran berhasil diperbarui!');
    }

    // MENGHAPUS DATA TIM
    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        $team = Team::findOrFail($id);

        $team->delete();

        return redirect('/admin/teams')
            ->with('success', 'Data tim berhasil dihapus!');
    }

    // EXPORT DATA TIM KE EXCEL (CSV)
    public function export()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        $teams = Team::with('tournament')->get();

        $filename = 'data-pendaftaran-arena-z.csv';

        return response()->streamDownload(function () use ($teams) {
            $file = fopen('php://output', 'w');

            // Agar Excel membaca karakter UTF-8
            fwrite($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'No',
                'Nama Tim',
                'Asal Sekolah',
                'Nama Ketua',
                'Email',
                'Nomor WhatsApp',
                'Turnamen',
                'Status'
            ], ';');

            foreach ($teams as $index => $team) {
                fputcsv($file, [
                    $index + 1,
                    $team->team_name,
                    $team->school_name,
                    $team->leader_name,
                    $team->leader_email,
                    $team->leader_phone,
                    $team->tournament->name ?? '-',
                    $team->status
                ], ';');
            }

            fclose($file);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8'
        ]);
    }
}
