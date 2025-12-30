<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Game\BuffaloGameController;
Route::prefix('buffalo')->group(function () {
    // Public webhook endpoints (no authentication required)
    Route::post('/get-user-balance', [BuffaloGameController::class, 'getUserBalance']);
    Route::post('/change-balance', [BuffaloGameController::class, 'changeBalance']);
    
    // Protected endpoints for frontend integration
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/game-auth', [BuffaloGameController::class, 'generateGameAuth']);
        Route::post('/game-url', [BuffaloGameController::class, 'generateGameUrl']);
        Route::post('/launch-game', [BuffaloGameController::class, 'launchGame']);
        // Route::get('/proxy-game', [BuffaloGameController::class, 'proxyGame']);
    });

    //  Route::get('/proxy-game', [BuffaloGameController::class, 'proxyGame']);
});

// Buffalo Game Proxy Routes (NO AUTH - called from game iframe)
Route::get('/buffalo/proxy-game', [BuffaloGameController::class, 'proxyGame']);
Route::get('/buffalo/proxy-resource', [BuffaloGameController::class, 'proxyResource']);