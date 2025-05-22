<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vote extends BaseModel
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
    ];

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }

    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class);
    }

    public function votants(): HasMany
    {
        return $this->hasMany(Votant::class);
    }
}
