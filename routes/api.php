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

    // Get Player profile
    Route::get('/profile', [PlayerController::class, 'getProfile']);

    // Get unlocked titles
    Route::get('/unlocked-titles', [PlayerController::class, 'getUnlockedTitles']);

    // Grant title 
    Route::post('/grant-title', [PlayerController::class, 'grantTitle']);

    // Get active title
    Route::get('/active-title', [PlayerController::class, 'getActiveTitle']);

    // Change the active title 
    Route::patch('/active-title', [PlayerController::class, 'setActiveTitle']);
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
