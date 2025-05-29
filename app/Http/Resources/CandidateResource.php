<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'vote_id' => $this->vote_id,
            'full_name' => $this->full_name,
            'theme' => $this->theme,
            'university' => $this->university,
            'photo' => $this->photoUrl(),
            'votes_count' => $this->votes_count,
        ];
    }
}
