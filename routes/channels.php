<?php

use App\Models\Vote;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('newVoice.{vote_uuid}', function ($user, $vote_uuid) {
    /** @var Vote $vote */
    $vote = Vote::byUiid($vote_uuid)->firstOrFail();

    return $vote_uuid === $vote->uuid;
});
