<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    /** @use HasFactory<\Database\Factories\VoteFactory> */
    use HasFactory;

     protected $fillable = ['candidate_id', 'vote_group_id', 'voter_email', 'voter_phone'];

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }

    public function voteGroup(): BelongsTo
    {
        return $this->belongsTo(VoteGroup::class);
    }
}
