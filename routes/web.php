<?php

use App\Http\Controllers\AdminScheduleController;
use App\Http\Controllers\AdminTeamController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\TeamRegistrationController;
use App\Http\Controllers\UserDashboardController;
use App\Models\MatchSchedule;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Support\Facades\Route;

// ==========================================
// HALAMAN PUBLIK
// ==========================================

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/tentang', [PublicController::class, 'tentang'])->name('about');
Route::get('/turnamen', [PublicController::class, 'turnamen'])->name('tournaments.index');
Route::get('/turnamen/{id}', [PublicController::class, 'showTournament'])->name('tournaments.show');
Route::get('/jadwal', [PublicController::class, 'jadwal'])->name('schedule');
Route::get('/bracket', [PublicController::class, 'bracket'])->name('bracket');

// ==========================================
// AUTENTIKASI (GUEST)
// ==========================================

Route::get('/pilih-login', function () {
    return view('pilih-login');
})->name('login');

// Login Admin
Route::get('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);

// Login User
Route::get('/user/login', [AuthController::class, 'userLogin'])->name('user.login');
Route::post('/user/login', [AuthController::class, 'login']);

// Registrasi User
Route::get('/user/register', [AuthController::class, 'register'])->name('user.register');
Route::post('/user/register', [AuthController::class, 'storeRegister']);

// ==========================================
// ROUTE TERPROTEKSI — KHUSUS ADMIN
// ==========================================
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard Admin
    Route::get('/admin/dashboard', function () {
        $totalTournaments = Tournament::count();
        $totalTeams = Team::count();
        $totalPendingTeams = Team::where('status', 'pending')->count();
        $totalMatches = MatchSchedule::count();
        $totalActiveTournaments = Tournament::where('status', 'active')->count();
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
    })->name('admin.dashboard');

    // Kelola Tim Admin
    Route::get('/admin/teams', [AdminTeamController::class, 'index'])->name('admin.teams.index');
    Route::get('/admin/teams/export', [AdminTeamController::class, 'export'])->name('admin.teams.export');
    Route::get('/admin/teams/{id}', [AdminTeamController::class, 'show'])->name('admin.teams.show');
    Route::get('/admin/teams/{id}/edit', [AdminTeamController::class, 'edit'])->name('admin.teams.edit');
    Route::put('/admin/teams/{id}/update', [AdminTeamController::class, 'update'])->name('admin.teams.update');
    Route::delete('/admin/teams/{id}/delete', [AdminTeamController::class, 'destroy'])->name('admin.teams.destroy');
    Route::post('/admin/teams/{id}/{status}', [AdminTeamController::class, 'updateStatus'])->name('admin.teams.status');

    // Kelola Jadwal Admin
    Route::get('/admin/schedules', [AdminScheduleController::class, 'index'])->name('admin.schedules.index');
    Route::get('/admin/schedules/create', [AdminScheduleController::class, 'create'])->name('admin.schedules.create');
    Route::post('/admin/schedules', [AdminScheduleController::class, 'store'])->name('admin.schedules.store');
    Route::post('/admin/schedules/generate', [AdminScheduleController::class, 'generate'])->name('admin.schedules.generate');
    Route::post('/admin/schedules/{id}/schedule', [AdminScheduleController::class, 'updateSchedule'])->name('admin.schedules.schedule');
    Route::post('/admin/schedules/{id}/result', [AdminScheduleController::class, 'updateResult'])->name('admin.schedules.result');
    Route::post('/admin/schedules/{id}/{status}', [AdminScheduleController::class, 'updateStatus'])->name('admin.schedules.status');
    Route::delete('/admin/schedules/reset', [AdminScheduleController::class, 'resetAll'])->name('admin.schedules.reset');
    Route::delete('/admin/schedules/{id}', [AdminScheduleController::class, 'destroy'])->name('admin.schedules.destroy');
});

// ==========================================
// ROUTE TERPROTEKSI — KHUSUS USER / PESERTA
// ==========================================
Route::middleware(['auth', 'role:user'])->group(function () {

    // Dashboard utama
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

    // Tim saya
    Route::get('/user/my-teams', [UserDashboardController::class, 'myTeams'])->name('user.my-teams');
    Route::get('/user/my-teams/{id}', [UserDashboardController::class, 'teamDetail'])->name('user.team-detail');

    // Jadwal pertandingan milik user
    Route::get('/user/my-schedule', [UserDashboardController::class, 'mySchedule'])->name('user.my-schedule');

    // Bracket milik user
    Route::get('/user/my-bracket', [UserDashboardController::class, 'myBracket'])->name('user.my-bracket');

    // Profil
    Route::get('/user/profile', [UserDashboardController::class, 'profile'])->name('user.profile');
    Route::post('/user/profile', [UserDashboardController::class, 'updateProfile'])->name('user.profile.update');

    // Pendaftaran Tim
    Route::get('/user/team-register', [TeamRegistrationController::class, 'create'])->name('user.team.create');
    Route::post('/user/team-register', [TeamRegistrationController::class, 'store'])->name('user.team.store');
});

// ==========================================
// ROUTE LOGOUT
// ==========================================
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
