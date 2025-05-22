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
            'title' => $this->title,
            'uuid' => $this->uuid,
            'logo' => $this->logo(),
            'status' => $this->status->label(),
            'description' => $this->description,
        ];
    }
}
