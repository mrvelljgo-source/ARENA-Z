<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Registration;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ArenaZSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Pastikan Admin Default Tersedia (tanpa mengubah password jika sudah ada)
        $admin = User::firstOrCreate(
            ['email' => 'admin@arenaz.com'],
            [
                'name' => 'Admin ARENA Z',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'school_name' => 'Panitia Pusat ARENA Z',
                'phone' => '081234567890',
            ]
        );

        // 2. Lengkapi Data Turnamen Utama
        $tournament = Tournament::firstOrCreate(
            ['name' => 'ARENA Z Mobile Legends Championship'],
            [
                'game' => 'Mobile Legends: Bang Bang',
                'registration_start' => now()->subDays(5)->toDateString(),
                'registration_end' => now()->addDays(20)->toDateString(),
                'tournament_date' => now()->addDays(25)->toDateString(),
                'status' => 'upcoming',
            ]
        );

        $tournament->update([
            'description' => 'Turnamen Mobile Legends: Bang Bang bergengsi tingkat pelajar SMP, SMA, dan SMK se-Indonesia. Tunjukkan kekompakan tim sekolahmu dan rebut gelar juara ARENA Z musim ini!',
            'rules' => "1. Setiap tim terdiri dari 5 pemain inti dan maksimal 1 pemain cadangan.\n2. Seluruh pemain wajib merupakan siswa aktif dari sekolah yang bersangkutan.\n3. Pertandingan menggunakan sistem 5 VS 5 Tournament Mode Custom Draft Pick.\n4. Babak Penyisihan hingga Semifinal menggunakan sistem Best of 3 (BO3).\n5. Babak Grand Final menggunakan sistem Best of 5 (BO5).\n6. Dilarang keras menggunakan cheat, bug exploit, atau perilaku tidak sportif.",
            'prize_pool' => 'Rp 15.000.000',
            'max_teams' => 16,
            'format' => '5 VS 5 Single Elimination',
        ]);

        // 3. Pastikan Semua Tim Memiliki Data Registrasi dan Roster Pemain Lengkap (5 Inti + 1 Cadangan)
        $teams = Team::all();

        $roles = ['Jungler', 'Roamer', 'Mid Laner', 'EXP Laner', 'Gold Laner'];

        foreach ($teams as $team) {
            // Sinkronkan registrasi jika belum tercatat di tabel registrations
            Registration::firstOrCreate(
                [
                    'tournament_id' => $team->tournament_id ?? $tournament->id,
                    'team_id' => $team->id,
                ],
                [
                    'user_id' => $team->user_id,
                    'status' => $team->status,
                    'registration_date' => $team->created_at ?? now(),
                    'verified_at' => $team->status === 'approved' ? now() : null,
                    'admin_note' => 'Pendaftaran telah terverifikasi oleh panitia ARENA Z.',
                ]
            );

            // Jika tim belum memiliki pemain, buatkan 5 pemain inti + 1 pemain cadangan
            if ($team->players()->count() === 0) {
                // Pemain 1: Kapten (menggunakan leader_name tim)
                Player::create([
                    'team_id' => $team->id,
                    'name' => ucfirst($team->leader_name),
                    'in_game_name' => strtoupper(explode('#', $team->leader_name)[0] ?? $team->leader_name).'•CPT',
                    'game_id' => rand(10000000, 99999999).' ('.rand(2000, 2999).')',
                    'role_in_game' => $roles[0],
                    'student_grade' => 'Kelas XI',
                    'phone_number' => $team->leader_phone,
                    'is_captain' => true,
                    'is_substitute' => false,
                ]);

                // Pemain 2 - 5: Pemain Inti Lainnya
                for ($i = 1; $i < 5; $i++) {
                    $playerName = 'Player '.($i + 1).' '.$team->team_name;
                    Player::create([
                        'team_id' => $team->id,
                        'name' => $playerName,
                        'in_game_name' => strtoupper(substr(str_replace(' ', '', $team->team_name), 0, 4)).'•'.$roles[$i],
                        'game_id' => rand(10000000, 99999999).' ('.rand(2000, 2999).')',
                        'role_in_game' => $roles[$i],
                        'student_grade' => 'Kelas XI',
                        'phone_number' => '08'.rand(1111111111, 9999999999),
                        'is_captain' => false,
                        'is_substitute' => false,
                    ]);
                }

                // Pemain 6: Pemain Cadangan (1 pemain)
                Player::create([
                    'team_id' => $team->id,
                    'name' => 'Cadangan '.$team->team_name,
                    'in_game_name' => strtoupper(substr(str_replace(' ', '', $team->team_name), 0, 4)).'•SUB',
                    'game_id' => rand(10000000, 99999999).' ('.rand(2000, 2999).')',
                    'role_in_game' => 'Flexible Sub',
                    'student_grade' => 'Kelas X',
                    'phone_number' => '08'.rand(1111111111, 9999999999),
                    'is_captain' => false,
                    'is_substitute' => true,
                ]);
            }
        }
    }
}
