<?php

namespace App\Models;

use App\Models\Enums\VotantStatusEnum;
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
        'status',
        'is_verified',
    ];

    protected $casts = [
        'status' => VotantStatusEnum::class,
        'is_verified' => 'boolean',
    ];


    public function isVoted(): bool
    {
        return $this->status->equals(VotantStatusEnum::VOTED);
    }

    public function scopeFindByIdentity(Builder $query, $identity): Builder
    {
        return $query->where('identity', $identity);
    }
}
