<?php

use App\Facades\VoteStorage;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
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
