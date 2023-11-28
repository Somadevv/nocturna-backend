<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TitleController;
use Illuminate\Support\Facades\Route;

// Authenticated Routes


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Authenticated Routes
Route::middleware('jwt')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
    // Player Routes
    Route::prefix('player')->group(function () {
        // Profile
        Route::post('/profile', [PlayerController::class, 'getProfile']);

        // Titles
        Route::get('/unlocked-titles', [TitleController::class, 'getUnlockedTitles']);
        Route::post('/grant-title', [TitleController::class, 'grantTitle']);
        Route::get('/active-title', [TitleController::class, 'getActiveTitle']);
        Route::patch('/active-title', [TitleController::class, 'setActiveTitle']);

        // Inventory
        Route::prefix('inventory')->group(function () {
            Route::post('/', [InventoryController::class, 'getInventory']);
            Route::post('add-item/{itemId}/{amount}', [InventoryController::class, 'addItem']);
            Route::post('remove-item/{itemId}/{amount}', [InventoryController::class, 'removeItem']);
        });
    });
});
