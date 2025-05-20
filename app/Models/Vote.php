<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
