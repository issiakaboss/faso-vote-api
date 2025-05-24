<?php

namespace App\Models;

use App\Facades\VoteStorage;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidate extends BaseModel
{
    protected $fillable = [
        'vote_id',
        'full_name',
        'description',
        'profession',
        'votes_count',
        'photo',
        'university',
        'theme',
    ];

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public static function validationRules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'vote_id' => 'required|exists:votes,id',
            'description' => 'nullable|string',
            'profession' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'university' => 'nullable|string|max:255',
            'theme' => 'nullable|string|max:255',
        ];
    }

    public function photoUrl(): ?string
    {
        return $this->photo ? VoteStorage::url($this->photo) : null;
    }

    public function deletePhoto(): void
    {
        if ($this->photo) {
            VoteStorage::delete($this->photo);
        }
    }

    public function incrementVotes(): void
    {
        $this->increment('votes_count');
    }
}
