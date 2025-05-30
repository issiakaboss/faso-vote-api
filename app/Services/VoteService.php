<?php

namespace App\Services;

use App\Models\Candidate;
use App\Models\Enums\VotantStatusEnum;
use App\Models\Votant;
use App\Models\Vote;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;


class VoteService
{
    private Vote $vote;
    private Candidate $candidate;

    public function __construct(Vote $vote, Candidate $candidate)
    {
        $this->vote = $vote;
        $this->candidate = $candidate;
    }

    public function validate(): void
    {
        $messages = $this->getErrorMessage();

        if ($messages) {
            throw ValidationException::withMessages([
                'vote' => $messages,
            ]);
        }
    }

    public function saveVontant(Request $request)
    {
        $votant = Votant::findByIdentity($request->get('identity'))->first();

        $votant->update([
            'vote_id' => $this->vote->id,
            'candidate_id' => $this->candidate->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'country' => $request->headers->get('X-Country', 'Unknown'),
            'status' => VotantStatusEnum::VOTED,
            'is_verified' => true,
        ]);

        return $votant;
    }

    private function getErrorMessage(): ?string
    {
        if (! $this->vote->isActive()) {
            return 'Le vote est terminé ou n\'est pas actif.';
        }

        if (! $this->vote->isStarted()) {
            return 'La période de vote n\'a pas encore commencé.';
        }

        if ($this->vote->isEnded()) {
            return 'Le vote est terminé.';
        }

        if ($this->candidate->vote_id !== $this->vote->id) {
            return 'Le candidat ne correspond pas au vote.';
        }

        return null;
    }
}
