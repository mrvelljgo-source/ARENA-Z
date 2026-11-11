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
            ->assertSee('Semifinal')
            ->assertDontSee('Lower Bracket')
            ->assertDontSee('Babak Penyisihan');
        $this->assertSame(1, substr_count($formResponse->getContent(), 'name="round"'));

        $response = $this->post('/admin/schedules', [
            'tournament_id' => $tournament->id,
            'team_a_id' => $teamA->id,
            'team_b_id' => $teamB->id,
            'round' => 'Semifinal',
        ]);

        $response->assertRedirect('/admin/schedules');
        $this->assertDatabaseHas('match_schedules', [
            'tournament_id' => $tournament->id,
            'team_a_id' => $teamA->id,
            'team_b_id' => $teamB->id,
            'round' => 'Semifinal',
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
            'round' => 'Semifinal',
        ]);

        $response->assertSessionHasErrors('team_b_id');
        $this->assertDatabaseCount('match_schedules', 0);
    }

    public function test_admin_can_generate_and_automatically_advance_a_single_elimination_bracket(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();
        $tournament = $this->createTournament('ARENA Z Single Elimination');

        foreach (['Team Alpha', 'Team Beta', 'Team Gamma', 'Team Delta'] as $teamName) {
            $this->createTeam($tournament, $teamName, 'approved');
        }

        $this->actingAs($admin)
            ->get('/admin/schedules')
            ->assertOk()
            ->assertSee('Buat Bracket Single Elimination')
            ->assertSee($tournament->name);

        $this->actingAs($admin)
            ->post('/admin/schedules/generate', ['tournament_id' => $tournament->id])
            ->assertRedirect('/admin/schedules')
            ->assertSessionHas('success', 'Bracket single elimination berhasil dibuat otomatis (3 slot pertandingan).');

        $this->assertDatabaseCount('match_schedules', 3);
        $this->assertDatabaseHas('match_schedules', [
            'tournament_id' => $tournament->id,
            'round' => 'Semifinal',
            'is_bracket_generated' => true,
        ]);
        $this->assertDatabaseHas('match_schedules', [
            'tournament_id' => $tournament->id,
            'round' => 'Final',
            'is_conditional' => false,
        ]);

        $semifinals = MatchSchedule::query()
            ->where('tournament_id', $tournament->id)
            ->where('round', 'Semifinal')
            ->orderBy('id')
            ->get();
        $final = MatchSchedule::query()
            ->where('tournament_id', $tournament->id)
            ->where('round', 'Final')
            ->firstOrFail();

        $this->post('/admin/schedules/'.$semifinals[0]->id.'/result', ['result' => '2-1'])
            ->assertRedirect('/admin/schedules');

        $this->assertDatabaseHas('match_schedules', [
            'id' => $final->id,
            'team_a_id' => $semifinals[0]->team_a_id,
        ]);

        $this->post('/admin/schedules/'.$semifinals[1]->id.'/result', ['result' => '1-2'])
            ->assertRedirect('/admin/schedules');

        $final->refresh();
        $this->assertNotNull($final->team_a_id);
        $this->assertNotNull($final->team_b_id);
        $this->assertSame($semifinals[0]->team_a_id, $final->team_a_id);
        $this->assertSame($semifinals[1]->team_b_id, $final->team_b_id);

        $loser = Team::findOrFail($semifinals[0]->team_b_id);
        $this->post('/admin/schedules/'.$final->id.'/result', ['result' => '2-0'])
            ->assertRedirect('/admin/schedules');

        $this->assertDatabaseHas('match_schedules', [
            'id' => $final->id,
            'status' => 'finished',
            'result' => '2-0',
        ]);
        $this->get('/bracket?tournament_id='.$tournament->id)
            ->assertOk()
            ->assertSee('SINGLE ELIMINATION')
            ->assertSee('class="round-column has-next-round"', false)
            ->assertSee('class="match-card has-progression"', false)
            ->assertSee(strtoupper($final->fresh()->winner->team_name))
            ->assertDontSee('LOWER BRACKET')
            ->assertDontSee('GRAND FINAL RESET');
        $this->assertNotSame($final->fresh()->winner->id, $loser->id);
    }

    public function test_bracket_generation_uses_approved_teams_and_auto_advances_byes(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();
        $tournament = $this->createTournament('ARENA Z Qualifiers');

        foreach (['Team One', 'Team Two', 'Team Three', 'Team Four', 'Team Five', 'Team Six'] as $teamName) {
            $this->createTeam($tournament, $teamName, 'approved');
        }
        $pendingTeam = $this->createTeam($tournament, 'Pending Team', 'pending');

        $this->actingAs($admin)
            ->post('/admin/schedules/generate', ['tournament_id' => $tournament->id])
            ->assertRedirect('/admin/schedules')
            ->assertSessionHas('success', 'Bracket single elimination berhasil dibuat otomatis (7 slot pertandingan).');

        $this->assertDatabaseCount('match_schedules', 7);
        $this->assertSame(
            2,
            MatchSchedule::query()
                ->where('tournament_id', $tournament->id)
                ->where('result', 'BYE')
                ->count()
        );
        $firstRound = MatchSchedule::query()
            ->where('tournament_id', $tournament->id)
            ->where('round', 'Quarterfinal')
            ->orderBy('id')
            ->get();
        $firstRoundTeamIds = $firstRound
            ->flatMap(fn (MatchSchedule $match) => [$match->team_a_id, $match->team_b_id])
            ->all();

        foreach ($tournament->teams()->where('status', 'approved')->pluck('id') as $approvedTeamId) {
            $this->assertContains($approvedTeamId, $firstRoundTeamIds);
        }
        $this->assertDatabaseMissing('match_schedules', [
            'tournament_id' => $tournament->id,
            'team_a_id' => $pendingTeam->id,
        ]);

        $this->actingAs($admin)
            ->post('/admin/schedules/generate', ['tournament_id' => $tournament->id])
            ->assertSessionHasErrors('tournament_id');

        $this->assertDatabaseCount('match_schedules', 7);

        $this->post('/admin/schedules/generate', [
            'tournament_id' => $tournament->id,
            'replace_existing' => true,
        ])
            ->assertSessionHas('success', 'Bracket single elimination berhasil dibuat otomatis (7 slot pertandingan).');

        $this->assertDatabaseCount('match_schedules', 7);
    }

    public function test_admin_can_set_a_generated_match_schedule_and_it_appears_publicly(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();
        $tournament = $this->createTournament('ARENA Z Schedule');
        $teamA = $this->createTeam($tournament, 'Team Alpha', 'approved');
        $this->createTeam($tournament, 'Team Beta', 'approved');

        $this->actingAs($admin)->post('/admin/schedules/generate', [
            'tournament_id' => $tournament->id,
        ]);

        $match = MatchSchedule::query()
            ->where('tournament_id', $tournament->id)
            ->where('round', 'Final')
            ->firstOrFail();
        $dateResponse = $this->post('/admin/schedules/'.$match->id.'/schedule', [
            'match_date' => '2026-11-25',
            'match_time' => '14:30',
        ]);

        $dateResponse->assertRedirect('/admin/schedules');
        $this->assertDatabaseHas('match_schedules', [
            'id' => $match->id,
            'match_date' => '2026-11-25',
            'match_time' => '14:30',
        ]);

        $this->get('/jadwal')
            ->assertOk()
            ->assertSee('25 Nov 2026')
            ->assertSee('14:30 WIB');
        $this->get('/bracket?tournament_id='.$tournament->id)
            ->assertOk()
            ->assertSee('Team Alpha')
            ->assertSee('FINAL')
            ->assertSee('25 Nov 2026');
    }

    public function test_invalid_match_date_is_rejected_without_changing_the_schedule(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();
        $tournament = $this->createTournament('ARENA Z Invalid Schedule Date');
        $teamA = $this->createTeam($tournament, 'Team Alpha', 'approved');
        $teamB = $this->createTeam($tournament, 'Team Beta', 'approved');
        $match = MatchSchedule::create([
            'tournament_id' => $tournament->id,
            'team_a_id' => $teamA->id,
            'team_b_id' => $teamB->id,
            'round' => 'Final',
            'status' => 'upcoming',
            'match_date' => '2026-11-25',
            'match_time' => '14:30',
        ]);

        $this->actingAs($admin)
            ->post('/admin/schedules/'.$match->id.'/schedule', [
                'match_date' => '20226-11-10',
                'match_time' => '14:30',
            ])
            ->assertSessionHasErrors('match_date');

        $this->assertDatabaseHas('match_schedules', [
            'id' => $match->id,
            'match_date' => '2026-11-25',
            'match_time' => '14:30',
        ]);
    }

    public function test_legacy_double_elimination_bracket_can_be_replaced_with_single_elimination(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();
        $tournament = $this->createTournament('ARENA Z Existing Bracket');
        $teamA = $this->createTeam($tournament, 'Team Alpha', 'approved');
        $teamB = $this->createTeam($tournament, 'Team Beta', 'approved');

        $legacyMatch = MatchSchedule::create([
            'tournament_id' => $tournament->id,
            'team_a_id' => $teamA->id,
            'team_b_id' => $teamB->id,
            'round' => 'Upper Final',
            'status' => 'finished',
            'result' => '2-0',
            'match_date' => '2026-11-20',
            'is_bracket_generated' => true,
        ]);

        $this->get('/bracket?tournament_id='.$tournament->id)
            ->assertOk()
            ->assertSee('BRACKET TURNAMEN INI MASIH FORMAT LAMA')
            ->assertDontSee('LOWER BRACKET');

        $this->actingAs($admin)
            ->post('/admin/schedules/generate', ['tournament_id' => $tournament->id])
            ->assertSessionHasErrors('tournament_id');
        $this->assertModelExists($legacyMatch);

        $this->post('/admin/schedules/generate', [
            'tournament_id' => $tournament->id,
            'replace_existing' => true,
        ])
            ->assertRedirect('/admin/schedules')
            ->assertSessionHas('success', 'Bracket single elimination berhasil dibuat otomatis (1 slot pertandingan).');

        $this->assertDatabaseMissing('match_schedules', ['id' => $legacyMatch->id]);
        $this->assertDatabaseHas('match_schedules', [
            'tournament_id' => $tournament->id,
            'round' => 'Final',
            'result' => null,
        ]);
        $this->assertDatabaseCount('match_schedules', 1);
        $this->get('/bracket?tournament_id='.$tournament->id)
            ->assertOk()
            ->assertDontSee('BRACKET TURNAMEN INI MASIH FORMAT LAMA')
            ->assertSee('SINGLE ELIMINATION');
    }

    public function test_single_elimination_rejects_tied_scores_and_only_a_final_winner_becomes_champion(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();
        $tournament = $this->createTournament('ARENA Z Final');
        $teamA = $this->createTeam($tournament, 'Team Alpha', 'approved');
        $this->createTeam($tournament, 'Team Beta', 'approved');

        $this->actingAs($admin)->post('/admin/schedules/generate', [
            'tournament_id' => $tournament->id,
        ]);

        $final = MatchSchedule::query()
            ->where('tournament_id', $tournament->id)
            ->where('round', 'Final')
            ->firstOrFail();
        $this->post('/admin/schedules/'.$final->id.'/result', ['result' => '1-1'])
            ->assertSessionHasErrors('result');
        $this->assertDatabaseHas('match_schedules', [
            'id' => $final->id,
            'result' => null,
            'status' => 'upcoming',
        ]);

        $this->post('/admin/schedules/'.$final->id.'/result', ['result' => '2-0'])
            ->assertRedirect('/admin/schedules');

        $this->assertSame($teamA->id, $final->fresh()->winner->id);
        $this->get('/bracket?tournament_id='.$tournament->id)
            ->assertOk()
            ->assertSee('TEAM ALPHA')
            ->assertDontSee('FINAL RESET');
    }

    public function test_non_admin_cannot_generate_a_bracket(): void
    {
        $user = User::factory()->create();
        $tournament = $this->createTournament('ARENA Z Restricted');

        $this->actingAs($user)
            ->post('/admin/schedules/generate', ['tournament_id' => $tournament->id])
            ->assertForbidden();

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
            'round' => 'Semifinal',
        ]);
        MatchSchedule::create([
            'tournament_id' => $secondTournament->id,
            'team_a_id' => $secondTeamA->id,
            'team_b_id' => $secondTeamB->id,
            'round' => 'Semifinal',
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
