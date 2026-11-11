<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'game',
        'description',
        'rules',
        'prize_pool',
        'max_teams',
        'banner_image',
        'format',
        'registration_start',
        'registration_end',
        'tournament_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'registration_start' => 'date',
            'registration_end' => 'date',
            'tournament_date' => 'date',
            'max_teams' => 'integer',
        ];
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function matchSchedules(): HasMany
    {
        return $this->hasMany(MatchSchedule::class);
    }
}
