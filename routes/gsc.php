<?php

use App\Http\Controllers\Api\Gsc\GameListController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Gsc\GameController;
use App\Http\Controllers\Api\Gsc\BalanceController;
use App\Http\Controllers\Api\Gsc\DepositController;
use App\Http\Controllers\Api\Gsc\WithdrawController;

Route::get('gameTypeProducts/{id}', [GameListController::class, 'gameTypeProducts']);
Route::get('allGameProducts', [GameListController::class, 'allGameProducts']);
Route::get('gameType', [GameListController::class, 'gameType']);

Route::middleware('auth:api')->group(callback: function () {
    Route::group(['prefix' => 'operators'], function () {
        Route::post('provider_games', [GameController::class, 'gameList']);
        Route::get('available_products', [GameController::class, 'availableProduct']);
        Route::post('launch_game', [GameController::class, 'launchGame']);
    });
    Route::group(['prefix' => 'game'], function () {
        // Route::post('GetGameList', [GameListController::class, 'getGameList']);
        Route::get('gamelist/{provider_id}/{game_type_id}', [GameListController::class, 'gameList']);
    });

});

Route::group(['prefix' => 'v1/api/seamless'], function () {
    Route::post('balance', [BalanceController::class, 'getBalance']);
    Route::post('withdraw', [WithdrawController::class, 'withdraw']);
    Route::post('deposit', [DepositController::class, 'deposit']);

});