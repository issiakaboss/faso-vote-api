<?php

namespace App\Events;

use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VoteEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Candidate $candidate;

    public Vote $vote;

    public function __construct(Candidate $candidate, Vote $vote)
    {
        $this->candidate = $candidate;

        $this->vote = $vote;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel(sprintf('newVoice.%s', $this->vote->uuid)),
        ];
    }

    public function broadcastAs(): string
    {
        return 'newVoice-event';
    }

    public function broadcastWith(): array
    {
        return [
            'candidat' => [
                'candidat_id' => $this->candidate->id,
                'voix' => $this->candidate->votes_count,
            ],
            'statistics' => $this->vote->statistics,
        ];
    }
}
