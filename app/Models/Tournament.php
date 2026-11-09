<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tournament extends Model
{
    protected $fillable = [
        'name',
        'game',
        'registration_start',
        'registration_end',
        'tournament_date',
        'status',
    ];

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }
}
