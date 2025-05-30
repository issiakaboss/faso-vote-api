<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Votant extends BaseModel
{
    protected $fillable = [
        'vote_id',
        'candidate_id',
        'otp',
        'identity',
        'ip_address',
        'user_agent',
        'country',
        'is_voted',
        'is_verified',
    ];

    protected $casts = [
        'is_voted' => 'boolean',
        'is_verified' => 'boolean',
    ];

    public function scopeFindByIdentity(Builder $query, string $vote_id, string $identity): Builder
    {
        return $query->where('identity', $identity)->where('vote_id', $vote_id);
    }
}
