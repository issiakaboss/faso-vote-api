<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VoteController;
use App\Http\Controllers\CandidateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth:sanctum')->name('logout');
});

Route::middleware('auth:sanctum')->group(function () {



    Route::prefix('candidates')->group(function () {
        Route::post('', [CandidateController::class, 'store'])->name('candidate.store');
        Route::put('/{candidate}', [CandidateController::class, 'update'])->name('candidate.update')->whereNumber('candidate');
        Route::delete('/{candidate}', [CandidateController::class, 'destroy'])->name('candidate.destroy')->whereNumber('candidate');
    });
});


Route::prefix('votes')->group(function () {
    Route::get('', [VoteController::class, 'getVotes'])->name('vote.getVotes');
    Route::get('/{vote}', [VoteController::class, 'show'])->name('vote.show')->whereNumber('vote');
    Route::post('', [VoteController::class, 'store'])->name('vote.store');
    Route::put('/{vote}', [VoteController::class, 'update'])->name('vote.update')->whereNumber('vote');
    Route::delete('/{vote}', [VoteController::class, 'destroy'])->name('vote.destroy')->whereNumber('vote');
});
