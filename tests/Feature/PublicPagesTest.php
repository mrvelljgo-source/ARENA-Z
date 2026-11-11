<?php

namespace Tests\Feature;

use App\Models\Tournament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_is_accessible(): void
    {
        $response = $this->get('/');
        $response->assertOk();
        $response->assertSee('YOUR GAME.');
        $response->assertSee('YOUR ARENA.');
        $response->assertSee('STUDENT ESPORTS PLATFORM');
    }

    public function test_about_page_is_accessible(): void
    {
        $response = $this->get('/tentang');
        $response->assertOk();
        $response->assertSee('TENTANG ARENA Z');
        $response->assertSee('VISI KAMI');
        $response->assertSee('MISI KAMI');
    }

    public function test_tournaments_page_is_accessible(): void
    {
        Tournament::create([
            'name' => 'Turnamen MLBB Pelajar Test',
            'game' => 'Mobile Legends: Bang Bang',
            'registration_start' => now()->toDateString(),
            'registration_end' => now()->addDays(10)->toDateString(),
            'tournament_date' => now()->addDays(15)->toDateString(),
            'status' => 'upcoming',
        ]);

        $response = $this->get('/turnamen');
        $response->assertOk();
        $response->assertSee('Turnamen MLBB Pelajar Test');
        $response->assertSee('Detail Turnamen');
    }

    public function test_tournament_detail_page_is_accessible(): void
    {
        $tournament = Tournament::create([
            'name' => 'Championship Pelajar Surabaya',
            'game' => 'Mobile Legends: Bang Bang',
            'description' => 'Turnamen tingkat SMA/SMK se-Surabaya.',
            'rules' => 'Format 5v5 Custom Draft Pick.',
            'prize_pool' => 'Rp 5.000.000',
            'registration_start' => now()->toDateString(),
            'registration_end' => now()->addDays(10)->toDateString(),
            'tournament_date' => now()->addDays(15)->toDateString(),
            'status' => 'upcoming',
        ]);

        $response = $this->get('/turnamen/' . $tournament->id);
        $response->assertOk();
        $response->assertSee('Championship Pelajar Surabaya');
        $response->assertSee('Format 5v5 Custom Draft Pick');
        $response->assertSee('Rp 5.000.000');
    }

    public function test_schedule_page_is_accessible(): void
    {
        $response = $this->get('/jadwal');
        $response->assertOk();
        $response->assertSee('Jadwal Match Mobile Legends');
    }

    public function test_bracket_page_is_accessible(): void
    {
        $response = $this->get('/bracket');
        $response->assertOk();
        $response->assertSee('Bagan Bracket Turnamen');
    }
}
