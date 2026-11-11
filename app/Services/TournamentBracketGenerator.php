<?php

namespace App\Services;

use App\Models\MatchSchedule;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TournamentBracketGenerator
{
    public function generate(Tournament $tournament, bool $replaceExisting = false): int
    {
        return DB::transaction(function () use ($tournament, $replaceExisting): int {
            $lockedTournament = Tournament::query()
                ->whereKey($tournament->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (MatchSchedule::query()->where('tournament_id', $lockedTournament->id)->exists()) {
                if (! $replaceExisting) {
                    throw ValidationException::withMessages([
                        'tournament_id' => 'Turnamen ini sudah memiliki jadwal. Centang konfirmasi untuk menggantinya dengan bracket otomatis.',
                    ]);
                }

                MatchSchedule::query()
                    ->where('tournament_id', $lockedTournament->id)
                    ->delete();
            }

            $teams = Team::query()
                ->where('tournament_id', $lockedTournament->id)
                ->where('status', 'approved')
                ->orderBy('id')
                ->get();

            if ($teams->count() < 2) {
                throw ValidationException::withMessages([
                    'tournament_id' => 'Minimal perlu 2 tim yang sudah disetujui untuk membuat bracket.',
                ]);
            }

            $capacity = 1;

            while ($capacity < $teams->count()) {
                $capacity *= 2;
            }

            $seedOrder = $this->seedOrder($capacity);
            $seedSlots = array_fill(1, $capacity, null);

            foreach ($teams as $index => $team) {
                $seedSlots[$index + 1] = $team->id;
            }

            $upperSlots = array_map(
                fn (int $seed): ?int => $seedSlots[$seed],
                $seedOrder
            );

            $previousRound = [];
            $roundEntrants = $capacity;

            while ($roundEntrants > 1) {
                $matchCount = intdiv($roundEntrants, 2);
                $roundName = $this->roundName($roundEntrants);
                $nextRound = [];

                for ($matchIndex = 0; $matchIndex < $matchCount; $matchIndex++) {
                    if ($previousRound === []) {
                        $slotA = ['team_a_id' => $upperSlots[$matchIndex * 2]];
                        $slotB = ['team_b_id' => $upperSlots[$matchIndex * 2 + 1]];
                    } else {
                        $slotA = $this->sourceSlot($previousRound[$matchIndex * 2], 'winner', 'a');
                        $slotB = $this->sourceSlot($previousRound[$matchIndex * 2 + 1], 'winner', 'b');
                    }

                    $nextRound[] = $this->createMatch(
                        $lockedTournament,
                        $roundName,
                        [...$slotA, ...$slotB]
                    );
                }

                $previousRound = $nextRound;
                $upperSlots = [];
                $roundEntrants = $matchCount;
            }

            $this->synchronize($lockedTournament);

            return MatchSchedule::query()
                ->where('tournament_id', $lockedTournament->id)
                ->where('is_bracket_generated', true)
                ->count();
        });
    }

    public function synchronize(Tournament $tournament): void
    {
        $matches = MatchSchedule::query()
            ->where('tournament_id', $tournament->id)
            ->where('is_bracket_generated', true)
            ->orderBy('id')
            ->get();
        $outcomes = [];
        $matchesById = [];

        foreach ($matches as $match) {
            $matchesById[$match->id] = $match;
            $slotA = $this->resolveSlot($match, 'a', $outcomes);
            $slotB = $this->resolveSlot($match, 'b', $outcomes);
            $teamAId = $slotA['team_id'];
            $teamBId = $slotB['team_id'];
            $inputsResolved = $slotA['resolved'] && $slotB['resolved'];
            $skipConditionalMatch = false;

            if ($match->is_conditional) {
                $grandFinal = $matchesById[$match->team_a_source_match_id] ?? null;
                $grandFinalOutcome = $outcomes[$match->team_a_source_match_id] ?? null;

                if ($grandFinalOutcome !== null && $grandFinalOutcome['resolved']) {
                    $skipConditionalMatch = $grandFinalOutcome['winner_id'] !== $grandFinal?->team_b_id;

                    if ($skipConditionalMatch) {
                        $teamAId = null;
                        $teamBId = null;
                        $inputsResolved = true;
                    }
                }
            }

            $teamsChanged = $match->team_a_id !== $teamAId || $match->team_b_id !== $teamBId;

            if ($teamsChanged) {
                $match->team_a_id = $teamAId;
                $match->team_b_id = $teamBId;
                $match->result = null;
                $match->status = 'upcoming';
            }

            if (! $inputsResolved && ! $teamsChanged) {
                $match->result = null;
                $match->status = 'upcoming';
            } elseif ($skipConditionalMatch) {
                $match->result = 'SKIPPED';
                $match->status = 'finished';
            } elseif ($inputsResolved && ($teamAId === null || $teamBId === null)) {
                $match->result = 'BYE';
                $match->status = 'finished';
            } elseif (in_array($match->result, ['BYE', 'SKIPPED'], true)) {
                $match->result = null;
                $match->status = 'upcoming';
            }

            if ($match->isDirty()) {
                $match->save();
            }

            $outcomes[$match->id] = $this->outcome($match, $inputsResolved);
        }
    }

    private function seedOrder(int $capacity): array
    {
        $seeds = [1, 2];
        $size = 2;

        while ($size < $capacity) {
            $expandedSeeds = [];

            foreach ($seeds as $seed) {
                $expandedSeeds[] = $seed;
                $expandedSeeds[] = $size * 2 + 1 - $seed;
            }

            $seeds = $expandedSeeds;
            $size *= 2;
        }

        return $seeds;
    }

    private function roundName(int $entrants): string
    {
        return match ($entrants) {
            2 => 'Final',
            4 => 'Semifinal',
            8 => 'Quarterfinal',
            default => 'Round of '.$entrants,
        };
    }

    private function createMatch(
        Tournament $tournament,
        string $round,
        array $slots
    ): MatchSchedule {
        return MatchSchedule::query()->create([
            'tournament_id' => $tournament->id,
            'round' => $round,
            'status' => 'upcoming',
            'is_bracket_generated' => true,
            ...$slots,
        ]);
    }

    private function sourceSlot(MatchSchedule $match, string $outcome, string $slot): array
    {
        return [
            "team_{$slot}_source_match_id" => $match->id,
            "team_{$slot}_source_outcome" => $outcome,
        ];
    }

    /**
     * @param  array<int, array{resolved: bool, winner_id: ?int, loser_id: ?int}>  $outcomes
     * @return array{resolved: bool, team_id: ?int}
     */
    private function resolveSlot(MatchSchedule $match, string $slot, array $outcomes): array
    {
        $sourceId = $match->{"team_{$slot}_source_match_id"};

        if ($sourceId === null) {
            return [
                'resolved' => true,
                'team_id' => $match->{"team_{$slot}_id"},
            ];
        }

        $source = $outcomes[$sourceId] ?? null;

        if ($source === null || ! $source['resolved']) {
            return ['resolved' => false, 'team_id' => null];
        }

        $outcome = $match->{"team_{$slot}_source_outcome"};

        return [
            'resolved' => true,
            'team_id' => $source[$outcome.'_id'],
        ];
    }

    /**
     * @return array{resolved: bool, winner_id: ?int, loser_id: ?int}
     */
    private function outcome(MatchSchedule $match, bool $inputsResolved): array
    {
        if (! $inputsResolved) {
            return ['resolved' => false, 'winner_id' => null, 'loser_id' => null];
        }

        if ($match->result === 'BYE' && $match->status === 'finished') {
            return [
                'resolved' => true,
                'winner_id' => $match->team_a_id ?? $match->team_b_id,
                'loser_id' => null,
            ];
        }

        if ($match->result === 'SKIPPED' && $match->status === 'finished') {
            return ['resolved' => true, 'winner_id' => null, 'loser_id' => null];
        }

        if (
            $match->status !== 'finished'
            || ! preg_match('/^(\d+)-(\d+)$/', trim($match->result ?? ''), $scores)
            || $scores[1] === $scores[2]
        ) {
            return ['resolved' => false, 'winner_id' => null, 'loser_id' => null];
        }

        $teamAId = $match->team_a_id;
        $teamBId = $match->team_b_id;
        $teamAWon = (int) $scores[1] > (int) $scores[2];

        return [
            'resolved' => true,
            'winner_id' => $teamAWon ? $teamAId : $teamBId,
            'loser_id' => $teamAWon ? $teamBId : $teamAId,
        ];
    }
}
