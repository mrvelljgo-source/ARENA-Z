<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'name',
        'in_game_name',
        'game_id',
        'role_in_game',
        'student_grade',
        'phone_number',
        'is_captain',
        'is_substitute',
    ];

    protected function casts(): array
    {
        return [
            'is_captain' => 'boolean',
            'is_substitute' => 'boolean',
        ];
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function scopeMain(Builder $query): Builder
    {
        return $query->where('is_substitute', false);
    }

    public function scopeSubstitutes(Builder $query): Builder
    {
        return $query->where('is_substitute', true);
    }

    public function scopeCaptains(Builder $query): Builder
    {
        return $query->where('is_captain', true);
    }
}
