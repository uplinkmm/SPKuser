<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Gsc\GameController;

// Route::middleware('auth:api')->group(function () {
    Route::group(['prefix' => 'operators'], function () {
        Route::post('provider_games', [GameController::class, 'gameList']);
        Route::get('available_products', [GameController::class, 'availableProduct']);

    });

// });