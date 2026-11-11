<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchSchedule extends Model
{
    use HasFactory;

    protected $table = 'match_schedules';

    protected $fillable = [
        'tournament_id',
        'team_a_id',
        'team_b_id',
        'winner_id',
        'team_a_score',
        'team_b_score',
        'team_a_source_match_id',
        'team_a_source_outcome',
        'team_b_source_match_id',
        'team_b_source_outcome',
        'is_bracket_generated',
        'is_conditional',
        'match_date',
        'match_time',
        'round',
        'status',
        'result',
    ];

    protected function casts(): array
    {
        return [
            'team_a_score' => 'integer',
            'team_b_score' => 'integer',
            'is_bracket_generated' => 'boolean',
            'is_conditional' => 'boolean',
        ];
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    public function teamA(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_a_id');
    }

    public function teamB(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_b_id');
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'winner_id');
    }

    public function teamASourceMatch(): BelongsTo
    {
        return $this->belongsTo(self::class, 'team_a_source_match_id');
    }

    public function teamBSourceMatch(): BelongsTo
    {
        return $this->belongsTo(self::class, 'team_b_source_match_id');
    }

    public function getWinnerAttribute(): ?Team
    {
        if ($this->winner_id) {
            return $this->getRelationValue('winner') ?? Team::find($this->winner_id);
        }

        if ($this->status !== 'finished' || ! $this->result) {
            return null;
        }

        if ($this->result === 'BYE') {
            return $this->teamA ?? $this->teamB;
        }

        if (! preg_match('/^(\d+)-(\d+)$/', trim($this->result), $scores)) {
            return null;
        }

        $scoreA = (int) $scores[1];
        $scoreB = (int) $scores[2];

        if ($scoreA === $scoreB) {
            return null;
        }

        return $scoreA > $scoreB
            ? $this->teamA
            : $this->teamB;
    }

    public function getLoserAttribute(): ?Team
    {
        if ($this->status !== 'finished' || ! $this->result || $this->result === 'BYE') {
            return null;
        }

        if (! preg_match('/^(\d+)-(\d+)$/', trim($this->result), $scores)) {
            return null;
        }

        $scoreA = (int) $scores[1];
        $scoreB = (int) $scores[2];

        if ($scoreA === $scoreB) {
            return null;
        }

        return $scoreA < $scoreB
            ? $this->teamA
            : $this->teamB;
    }
}
