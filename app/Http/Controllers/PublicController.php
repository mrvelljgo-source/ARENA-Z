<?php

namespace App\Http\Controllers;

use App\Models\MatchSchedule;
use App\Models\Player;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicController extends Controller
{
    /**
     * Halaman Utama (Homepage)
     */
    public function home(): View
    {
        $totalTournaments = Tournament::count();
        $totalTeams = Team::where('status', 'approved')->count();
        $totalPlayers = Player::count();

        // Ambil turnamen aktif atau terbaru
        $tournaments = Tournament::withCount([
            'teams as approved_teams_count' => fn ($query) => $query->where('status', 'approved'),
        ])->latest()->take(3)->get();

        // Jadwal pertandingan terdekat
        $upcomingMatches = MatchSchedule::with(['tournament', 'teamA', 'teamB'])
            ->where('status', '!=', 'finished')
            ->whereNotNull('team_a_id')
            ->whereNotNull('team_b_id')
            ->orderBy('match_date')
            ->orderBy('match_time')
            ->take(4)
            ->get();

        return view('home', compact(
            'totalTournaments',
            'totalTeams',
            'totalPlayers',
            'tournaments',
            'upcomingMatches'
        ));
    }

    /**
     * Halaman Tentang ARENA Z
     */
    public function tentang(): View
    {
        $totalTournaments = Tournament::count();
        $totalTeams = Team::where('status', 'approved')->count();
        $totalPlayers = Player::count();

        return view('about', compact(
            'totalTournaments',
            'totalTeams',
            'totalPlayers'
        ));
    }

    /**
     * Halaman Daftar Turnamen
     */
    public function turnamen(): View
    {
        $tournaments = Tournament::withCount([
            'teams as approved_teams_count' => fn ($query) => $query->where('status', 'approved'),
            'registrations',
        ])->latest()->get();

        return view('tournament', compact('tournaments'));
    }

    /**
     * Halaman Detail Turnamen
     */
    public function showTournament(int $id): View
    {
        $tournament = Tournament::withCount([
            'teams as approved_teams_count' => fn ($query) => $query->where('status', 'approved'),
        ])->findOrFail($id);

        $teams = Team::where('tournament_id', $tournament->id)
            ->where('status', 'approved')
            ->with(['players', 'captain'])
            ->get();

        $recentMatches = MatchSchedule::where('tournament_id', $tournament->id)
            ->with(['teamA', 'teamB', 'winner'])
            ->orderBy('id')
            ->take(6)
            ->get();

        return view('tournament-detail', compact(
            'tournament',
            'teams',
            'recentMatches'
        ));
    }

    /**
     * Halaman Jadwal Pertandingan
     */
    public function jadwal(Request $request): View
    {
        $tournamentId = $request->query('tournament_id');

        $query = MatchSchedule::with(['tournament', 'teamA', 'teamB', 'winner'])
            ->where(function ($q) {
                $q->whereNull('result')
                    ->orWhereNotIn('result', ['BYE', 'SKIPPED']);
            });

        if ($tournamentId) {
            $query->where('tournament_id', $tournamentId);
        }

        $schedules = $query->orderBy('match_date')
            ->orderBy('match_time')
            ->get();

        $tournaments = Tournament::orderBy('name')->get();

        return view('schedule', compact('schedules', 'tournaments', 'tournamentId'));
    }

    /**
     * Halaman Dynamic Bracket
     */
    public function bracket(Request $request): View
    {
        $tournaments = Tournament::query()
            ->whereHas('matchSchedules')
            ->orderBy('name')
            ->get();

        $selectedTournament = $tournaments->firstWhere('id', $request->integer('tournament_id'))
            ?? $tournaments->first();

        $schedules = $selectedTournament
            ? $selectedTournament->matchSchedules()
                ->with(['teamA', 'teamB', 'winner'])
                ->orderBy('id')
                ->get()
            : collect();

        $hasLegacyDoubleElimination = $schedules->contains(
            fn (MatchSchedule $schedule) => str_starts_with($schedule->round, 'Upper')
                || str_starts_with($schedule->round, 'Lower')
                || str_starts_with($schedule->round, 'Grand Final')
        );

        $rounds = $hasLegacyDoubleElimination ? collect() : $schedules->groupBy('round');

        return view('bracket', compact(
            'tournaments',
            'selectedTournament',
            'schedules',
            'rounds',
            'hasLegacyDoubleElimination'
        ));
    }
}

