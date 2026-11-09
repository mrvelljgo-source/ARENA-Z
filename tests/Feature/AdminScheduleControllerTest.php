<?php

namespace Tests\Feature;

use App\Models\MatchSchedule;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminScheduleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_approved_team_match_appears_in_the_bracket(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        $tournament = Tournament::create([
            'name' => 'ARENA Z Cup',
            'registration_start' => '2026-11-01',
            'registration_end' => '2026-11-15',
            'tournament_date' => '2026-11-20',
            'status' => 'active',
        ]);

        $teamA = $this->createTeam($tournament, 'Team Alpha', 'approved');
        $teamB = $this->createTeam($tournament, 'Team Beta', 'approved');

        $formResponse = $this->actingAs($admin)->get('/admin/schedules/create');

        $formResponse->assertOk()
            ->assertSee('name="team_a_id"', false)
            ->assertSee('name="team_b_id"', false)
            ->assertSee('Upper Semi Final')
            ->assertDontSee('Babak Penyisihan');
        $this->assertSame(1, substr_count($formResponse->getContent(), 'name="round"'));

        $response = $this->post('/admin/schedules', [
            'tournament_id' => $tournament->id,
            'team_a_id' => $teamA->id,
            'team_b_id' => $teamB->id,
            'round' => 'Upper Semi Final',
        ]);

        $response->assertRedirect('/admin/schedules');
        $this->assertDatabaseHas('match_schedules', [
            'tournament_id' => $tournament->id,
            'team_a_id' => $teamA->id,
            'team_b_id' => $teamB->id,
            'round' => 'Upper Semi Final',
        ]);

        $this->get('/bracket')
            ->assertOk()
            ->assertSee('Team Alpha')
            ->assertSee('Team Beta');
    }

    public function test_pending_teams_cannot_be_added_to_a_bracket_match(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        $tournament = Tournament::create([
            'name' => 'ARENA Z Cup',
            'registration_start' => '2026-11-01',
            'registration_end' => '2026-11-15',
            'tournament_date' => '2026-11-20',
            'status' => 'active',
        ]);

        $teamA = $this->createTeam($tournament, 'Team Alpha', 'approved');
        $teamB = $this->createTeam($tournament, 'Team Beta', 'pending');

        $response = $this->actingAs($admin)->post('/admin/schedules', [
            'tournament_id' => $tournament->id,
            'team_a_id' => $teamA->id,
            'team_b_id' => $teamB->id,
            'round' => 'Upper Semi Final',
        ]);

        $response->assertSessionHasErrors('team_b_id');
        $this->assertDatabaseCount('match_schedules', 0);
    }

    public function test_admin_can_reset_all_schedules_without_deleting_teams_or_tournaments(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        $firstTournament = $this->createTournament('ARENA Z Cup');
        $secondTournament = $this->createTournament('ARENA Z Open');
        $firstTeamA = $this->createTeam($firstTournament, 'Team Alpha', 'approved');
        $firstTeamB = $this->createTeam($firstTournament, 'Team Beta', 'approved');
        $secondTeamA = $this->createTeam($secondTournament, 'Team Gamma', 'approved');
        $secondTeamB = $this->createTeam($secondTournament, 'Team Delta', 'approved');

        MatchSchedule::create([
            'tournament_id' => $firstTournament->id,
            'team_a_id' => $firstTeamA->id,
            'team_b_id' => $firstTeamB->id,
            'round' => 'Upper Semi Final',
        ]);
        MatchSchedule::create([
            'tournament_id' => $secondTournament->id,
            'team_a_id' => $secondTeamA->id,
            'team_b_id' => $secondTeamB->id,
            'round' => 'Upper Semi Final',
        ]);

        $this->actingAs($admin)
            ->get('/admin/schedules')
            ->assertOk()
            ->assertSee('Reset Semua Jadwal')
            ->assertSee('return confirm(', false);

        $response = $this->delete('/admin/schedules/reset');

        $response->assertRedirect('/admin/schedules')
            ->assertSessionHas('success', 'Reset selesai. 2 jadwal dihapus.');
        $this->assertDatabaseCount('match_schedules', 0);
        $this->assertModelExists($firstTournament);
        $this->assertModelExists($secondTournament);
        $this->assertModelExists($firstTeamA);
        $this->assertModelExists($firstTeamB);
        $this->assertModelExists($secondTeamA);
        $this->assertModelExists($secondTeamB);
    }

    public function test_non_admin_cannot_reset_all_schedules(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->delete('/admin/schedules/reset')
            ->assertForbidden();
    }

    public function test_guest_is_redirected_before_resetting_all_schedules(): void
    {
        $this->delete('/admin/schedules/reset')
            ->assertRedirect('/pilih-login');
    }

    private function createTeam(Tournament $tournament, string $teamName, string $status): Team
    {
        return Team::create([
            'tournament_id' => $tournament->id,
            'team_name' => $teamName,
            'school_name' => 'Arena School',
            'leader_name' => 'Team Leader',
            'leader_email' => strtolower(str_replace(' ', '.', $teamName)).'@example.com',
            'leader_phone' => '08123456789',
            'status' => $status,
        ]);
    }

    private function createTournament(string $name): Tournament
    {
        return Tournament::create([
            'name' => $name,
            'registration_start' => '2026-11-01',
            'registration_end' => '2026-11-15',
            'tournament_date' => '2026-11-20',
            'status' => 'active',
        ]);
    }
}
