<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchSchedule extends Model
{
    protected $fillable = [
        'tournament_id',
        'team_a_id',
        'team_b_id',
        'match_date',
        'match_time',
        'round',
        'status',
        'result',
    ];

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

    // Membaca skor dan menentukan pemenang
    public function getWinnerAttribute()
    {
        if ($this->status !== 'finished' || !$this->result) {
            return null;
        }

        if (!preg_match('/^(\d+)-(\d+)$/', trim($this->result), $scores)) {
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
}
