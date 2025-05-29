<?php

namespace App\Models;

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
    ];
}
