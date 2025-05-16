<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidate extends Model
{
    /** @use HasFactory<\Database\Factories\CandidateFactory> */
    use HasFactory;
   
    protected $fillable = ['vote_group_id', 'name', 'description'];

    public function voteGroup():BelongsTo
    {
        return $this->belongsTo(VoteGroup::class);
    }

    public function votes():HasMany
    {
        return $this->hasMany(Vote::class);
    }
}
