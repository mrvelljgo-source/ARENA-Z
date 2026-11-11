<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tournament_id',
        'team_name',
        'school_name',
        'leader_name',
        'leader_email',
        'leader_phone',
        'status',
        'admin_note',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function mainPlayers(): HasMany
    {
        return $this->hasMany(Player::class)->where('is_substitute', false);
    }

    public function substitutePlayer(): HasOne
    {
        return $this->hasOne(Player::class)->where('is_substitute', true);
    }

    public function captain(): HasOne
    {
        return $this->hasOne(Player::class)->where('is_captain', true);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function matchesAsTeamA(): HasMany
    {
        return $this->hasMany(MatchSchedule::class, 'team_a_id');
    }

    public function matchesAsTeamB(): HasMany
    {
        return $this->hasMany(MatchSchedule::class, 'team_b_id');
    }

    public function matchesWon(): HasMany
    {
        return $this->hasMany(MatchSchedule::class, 'winner_id');
    }
}
