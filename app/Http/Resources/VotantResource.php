<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VotantResource extends JsonResource
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
            'email' => $this->whenNotNull($this->email),
            'phone' => $this->whenNotNull($this->phone),
            'status' => $this->status->label(),
        ];
    }
}
