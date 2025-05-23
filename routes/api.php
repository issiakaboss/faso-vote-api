<?php

use App\Http\Controllers\Api\VoteController;
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

Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login'])->name('login');

Route::prefix('vote')->middleware('auth:sanctum')->group(function () {
    Route::get('', [VoteController::class, 'getVotes'])->name('vote.getVotes');
    Route::post('', [VoteController::class, 'store'])->name('vote.strore');
    Route::put('/{vote}', [VoteController::class, 'update'])->name('vote.update')->whereNumber('vote');
    Route::delete('/{vote}', [VoteController::class, 'destroy'])->name('vote.destroy')->whereNumber('vote');
});
