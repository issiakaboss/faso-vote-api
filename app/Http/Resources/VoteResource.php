<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoteResource extends JsonResource
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
            'title' => $this->title,
            'uuid' => $this->uuid,
            'url' => $this->url(),
            'statistics' => $this->whenNotNull($this->statistics),
            'duration' => $this->duration(),
            'logo' => $this->logoUrl(),
            'status' => $this->status->label(),
            'status_color' => $this->status->getFlutterColor(),
            'date' => $this->start_date->translatedFormat('D d M Y \à H\hi'),
            'description' => $this->description,
            'candidates' => $this->whenNotNull(CandidateResource::collection($this->whenLoaded('candidates'))),
        ];
    }
}
