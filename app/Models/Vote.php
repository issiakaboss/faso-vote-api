<?php

namespace App\Models;

use App\Facades\VoteStorage;
use App\Models\Enums\ModelStatus;
use App\Models\Enums\VotantStatusEnum;
use Illuminate\Database\Eloquent\Builder;
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

        return $this->logo ? asset(IMAGE_PREFIX . $this->logo) : null;
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

    public function isEnded(): bool
    {
        return $this->end_date->isPast();
    }

    public function isStarted(): bool
    {
        return $this->start_date->isPast();
    }

    public function isActive(): bool
    {
        return $this->status->equals(ModelStatus::ACTIVE);
    }

    public function lock(): void
    {
        $this->status = ModelStatus::INACTIVE;
        $this->save();
    }

    public function url(): string
    {
        return str(env('CLIENT_URL'))->append('/vote/', $this->uuid)->toString();
    }

    public function getVotantCounts(): array
    {
        $result = $this->votants()
            ->selectRaw('
                COUNT(CASE WHEN is_voted = 1 THEN 1 END) as voted_count,
                COUNT(CASE WHEN is_voted = 0 THEN 1 END) as not_voted_count,
                COUNT(*) as total_count
            ')
            ->first();

        return  [
            'voted' => $result->voted_count ?? 0,
            'not_voted' => $result->not_voted_count ?? 0,
            'total' => $result->total_count ?? 0,
        ];
    }

    public function loadStatistics(): void
    {
        $this->statistics = $this->getVotantCounts();
    }

    public function scopeByUiid(Builder $query, string $uuid): Builder
    {
        return $query->where('uuid', $uuid);
    }
}
