
<?php

use App\Http\Controllers\AdminScheduleController;
use App\Http\Controllers\AdminTeamController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeamRegistrationController;
use App\Models\MatchSchedule;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Support\Facades\Route;

// HALAMAN UTAMA
Route::get('/', function () {
    return view('home');
});

// HALAMAN TURNAMEN
Route::get('/turnamen', function () {
    return view('tournament');
});

// HALAMAN JADWAL
Route::get('/jadwal', function () {
    $schedules = MatchSchedule::with([
        'tournament',
        'teamA',
        'teamB',
    ])
        ->orderBy('match_date')
        ->orderBy('match_time')
        ->get();

    return view('schedule', compact('schedules'));
});

// HALAMAN BRACKET
Route::get('/bracket', function () {
    $schedules = MatchSchedule::with([
        'tournament',
        'teamA',
        'teamB',
    ])
        ->orderBy('match_date')
        ->orderBy('match_time')
        ->get();

    return view('bracket', compact('schedules'));
});

// PILIH LOGIN
Route::get('/pilih-login', function () {
    return view('pilih-login');
})->name('login');

// LOGIN ADMIN
Route::get('/admin/login', [AuthController::class, 'adminLogin']);
Route::post('/admin/login', [AuthController::class, 'login']);

// LOGIN USER
Route::get('/user/login', [AuthController::class, 'userLogin']);
Route::post('/user/login', [AuthController::class, 'login']);

// REGISTRASI USER
Route::get('/user/register', [AuthController::class, 'register']);
Route::post('/user/register', [AuthController::class, 'storeRegister']);

// ROUTE YANG MEMBUTUHKAN LOGIN
Route::middleware('auth')->group(function () {

    // DASHBOARD ADMIN
    Route::get('/admin/dashboard', function () {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        $totalTournaments = Tournament::count();
        $totalTeams = Team::count();

        $totalPendingTeams = Team::where(
            'status',
            'pending'
        )->count();

        $totalMatches = MatchSchedule::count();

        $totalActiveTournaments = Tournament::where(
            'status',
            'active'
        )->count();

        $tournaments = Tournament::latest()->get();

        $recentMatches = MatchSchedule::with([
            'tournament',
            'teamA',
            'teamB',
        ])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalTournaments',
            'totalTeams',
            'totalPendingTeams',
            'totalMatches',
            'totalActiveTournaments',
            'tournaments',
            'recentMatches'
        ));
    });

    // KELOLA TIM ADMIN
    Route::get('/admin/teams', [
        AdminTeamController::class,
        'index',
    ]);

    // EXPORT DATA TIM
    Route::get('/admin/teams/export', [
        AdminTeamController::class,
        'export',
    ]);

    // DETAIL TIM
    Route::get('/admin/teams/{id}', [
        AdminTeamController::class,
        'show',
    ]);

    // EDIT DATA TIM
    Route::get('/admin/teams/{id}/edit', [
        AdminTeamController::class,
        'edit',
    ]);

    Route::put('/admin/teams/{id}/update', [
        AdminTeamController::class,
        'update',
    ]);

    // HAPUS DATA TIM
    Route::delete('/admin/teams/{id}/delete', [
        AdminTeamController::class,
        'destroy',
    ]);

    // KELOLA JADWAL ADMIN
    Route::get('/admin/schedules', [
        AdminScheduleController::class,
        'index',
    ]);

    Route::get('/admin/schedules/create', [
        AdminScheduleController::class,
        'create',
    ]);

    Route::post('/admin/schedules', [
        AdminScheduleController::class,
        'store',
    ]);

    Route::post('/admin/schedules/{id}/result', [
        AdminScheduleController::class,
        'updateResult',
    ]);

    Route::post('/admin/schedules/{id}/{status}', [
        AdminScheduleController::class,
        'updateStatus',
    ]);

    Route::delete('/admin/schedules/reset', [
        AdminScheduleController::class,
        'resetAll',
    ]);

    Route::delete('/admin/schedules/{id}', [
        AdminScheduleController::class,
        'destroy',
    ]);

    // UPDATE STATUS TIM
    Route::post('/admin/teams/{id}/{status}', [
        AdminTeamController::class,
        'updateStatus',
    ]);

    // PENDAFTARAN TIM USER
    Route::get('/user/team-register', [
        TeamRegistrationController::class,
        'create',
    ]);

    Route::post('/user/team-register', [
        TeamRegistrationController::class,
        'store',
    ]);

    // DASHBOARD USER
    Route::get('/user/dashboard', function () {
        if (auth()->user()->role !== 'user') {
            abort(403, 'Akses khusus user.');
        }

        $teams = Team::with('tournament')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.dashboard', compact('teams'));
    });

    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout']);

});
