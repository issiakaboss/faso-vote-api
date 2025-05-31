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
        'country_code',
        'country_iso_code',
        'verification_key',
    ];

    protected $casts = [
        'is_voted' => 'boolean',
        'is_verified' => 'boolean',
    ];

    public function verify(): void
    {
        $this->update(['is_verified' => true]);
    }

    public function scopeFindByIdentity(Builder $query, string $vote_id, string $identity): Builder
    {
        return $query->where('identity', $identity)->where('vote_id', $vote_id);
    }
}
