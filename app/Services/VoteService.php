<?php

namespace App\Services;

use App\Models\Candidate;
use App\Models\Votant;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VoteService
{
    private Vote $vote;

    private Candidate $candidate;

    private Request $request;

    private Votant $votant;

    public function __construct(Request $request, Candidate $candidate)
    {
        $this->vote = $candidate->vote;
        $this->candidate = $candidate;
        $this->request = $request;
        $this->setVotant();
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

    public function saveVontant(): Votant
    {

        $this->votant->update([
            'is_voted' => true,
            'candidate_id' => $this->candidate->id,
        ]);

        return $this->votant;
    }

    private function setVotant(): void
    {
        $this->votant = Votant::findByIdentity($this->vote->id, $this->request->identity)->firstOrFail();
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

        if ($this->votant->is_verified === false) {
            return "Vous n'avez pas encore ete vérifié.";
        }

        if ($this->votant->is_voted) {
            return 'Vous avez déjà voté pour ce candidat.';
        }

        if ($this->votant->identity !== $this->request->get('identity')) {
            return 'L\'identité fournie ne correspond pas à celle du votant.';
        }

        return null;
    }
}
