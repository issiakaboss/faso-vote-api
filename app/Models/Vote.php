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
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'status' => ModelStatus::class,
    ];

    public static function validationRules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

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

    public function logoUrl(): ?string
    {

        return $this->logo ? asset(IMAGE_PREFIX.$this->logo) : null;
    }

    public function duration(): string
    {
        return $this->end_date->diff($this->start_date)->forHumans(short: true, parts: 3);
    }

    public function deleteLogo(): void
    {
        if ($this->logo) {
            VoteStorage::delete($this->logo);
        }
    }
}
