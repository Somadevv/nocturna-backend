<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PlayerController;

Route::post("player/register", [PlayerController::class, "register"]);


// Player stats
Route::group(['prefix' => 'auth'], function () {
    Route::get('player-titles', [PlayerController::class, 'getTitles']);
});

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'player'], function () {
    Route::get('/', [PlayerController::class, 'show']);
    Route::post('grant-title/{playerId}', [PlayerController::class, 'grantTitle']);
    Route::patch('title/{id}', [PlayerController::class, 'changeActiveTitle']);
});


Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);


    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

// use App\Http\Requests\PlayerRequest;
// Route::middleware('auth:sanctum')->get('/player/register', function (PlayerRequest $request) {
//     return $request->player();
// });
