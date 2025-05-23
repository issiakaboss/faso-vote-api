<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/swagger', function () {
    return redirect('api/documentation?urls.primaryName=User API v1 Documentation');
})->name('swagger');
