<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidate extends BaseModel
{
    protected $fillable = [
        'vote_id',
        'name',
        'description',
        'profession',
        'votes',
    ];

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}
