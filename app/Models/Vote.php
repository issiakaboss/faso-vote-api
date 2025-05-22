<?php

namespace App\Models;

use App\Facades\VoteStorage;
use App\Models\Enums\ModelStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vote extends BaseModel
{
    protected $fillable = [
        'user_id',
        'title',
        'uuid',
        'description',
        'start_date',
        'end_date',
        'status',
        'logo',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => ModelStatus::class,
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

    public function logo(): ?string
    {
        return VoteStorage::url($this->logo);
    }
}
