<?php

use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('newVoice.{vote_id}', function ($user, $vote_id) {
    /** @var Vote $vote */
    $vote = Vote::findOrFail($vote_id);
    return $vote_id == $vote->id;
});
