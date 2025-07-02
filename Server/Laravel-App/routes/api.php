<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayersController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/prueba', function () {
    return 'Todo bien :D';
});

Route::prefix('/players')->group(function () {
    Route::get('/', [PlayersController::class, 'index']);
    Route::post('/', [PlayersController::class, 'store']);
    Route::get('/{id}', [PlayersController::class, 'show']);
    Route::put('/{id}', [PlayersController::class, 'update']);
    Route::delete('/{id}', [PlayersController::class, 'destroy']);
});
Route::prefix('/tournaments')->group(function () {
    Route::get('/', [TournamentController::class, 'index']);
    Route::post('/', [TournamentController::class, 'store']);
    Route::get('/{id}', [TournamentController::class, 'show']);
    Route::put('/{id}', [TournamentController::class, 'update']);
    Route::delete('/{id}', [TournamentController::class, 'destroy']);
});
Route::prefix('/registrations')->group(function () {
    Route::post('/', [RegistrationController::class, 'store']); // Inscripción
    Route::get('/tournament/{id}', [RegistrationController::class, 'getByTournament']);
});

Route::prefix('/matches')->group(function () {
    Route::get('/tournament/{id}', [MatchController::class, 'getByTournament']);
    Route::post('/', [MatchController::class, 'store']);
    Route::put('{id}', [MatchController::class, 'updateScore']);
});

Route::prefix('rankings')->group(function () {
    Route::get('/tournament/{id}', [RankingController::class, 'getByTournament']);
});

Route::prefix('/rounds')->group(function () {
    Route::post('/generate', [RoundController::class, 'generate']);
});