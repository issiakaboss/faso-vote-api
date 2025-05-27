<?php

use App\Events\VoteUpdated;
use App\Facades\VoteStorage;
use App\Models\Candidate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-vote-event', function () {
    $candidate1 = Candidate::find(10);
    $candidate2 = Candidate::find(1);
    if (!$candidate1 || !$candidate2) {
        return 'No candidate found.';
    }
    $candidate1->votes_count += 1;
    $candidate2->votes_count += 1;
    $candidate1->save();
    $candidate2->save();

    broadcast(new VoteUpdated($candidate1));
    broadcast(new VoteUpdated($candidate2));

    return "VoteUpdated event dispatched!";
});

Route::get('/swagger', function () {
    return redirect('api/documentation?urls.primaryName=User API v1 Documentation');
})->name('swagger');

Route::get('images/{path}', function ($path) {
    if (VoteStorage::exists($path)) {
        return VoteStorage::response($path, null, [
            'Cache-Control' => 'public, max-age=86400',
            'Expires' => now()->addDay()->toRfc7231String(),
            'Access-Control-Allow-Origin' => '*',
        ]);
    }
    abort(404);
})->where('path', '.*')->name('images');
