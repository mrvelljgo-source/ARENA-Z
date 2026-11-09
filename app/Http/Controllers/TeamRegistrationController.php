<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TeamRegistrationController extends Controller
{
    public function create()
    {
        if (auth()->user()->role !== 'user') {
            abort(403, 'Akses khusus user.');
        }

        $tournaments = Tournament::where('status', 'upcoming')->get();

        return view('user.team-register', compact('tournaments'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'user') {
            abort(403, 'Akses khusus user.');
        }

        $validated = $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'team_name' => 'required|string|max:255',
            'school_name' => 'required|string|max:255',
            'leader_name' => 'required|string|max:255',
            'leader_email' => 'required|email|max:255',
            'leader_phone' => 'required|string|max:20',
        ]);

        Team::create([
            'user_id' => auth()->id(),
            'tournament_id' => $validated['tournament_id'],
            'team_name' => $validated['team_name'],
            'school_name' => $validated['school_name'],
            'leader_name' => $validated['leader_name'],
            'leader_email' => $validated['leader_email'],
            'leader_phone' => $validated['leader_phone'],
            'status' => 'pending',
        ]);

        return redirect('/user/dashboard')
            ->with('success', 'Pendaftaran tim berhasil dikirim!');
    }
}