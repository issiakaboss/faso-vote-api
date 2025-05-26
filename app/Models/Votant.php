<?php

namespace App\Models;

class Votant extends BaseModel
{
    protected $fillable = [
        'vote_id',
        'candidate_id',
        'email',
        'phone',
        'status',
        'ip_address',
        'user_agent',
        'country',
        'access_token',
    ];
}
