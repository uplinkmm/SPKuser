<?php

use App\Http\Controllers\Api\Gsc\BalanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Gsc\GameController;
use App\Http\Controllers\Api\Gsc\WithdrawController;

// Route::middleware('auth:api')->group(function () {
Route::group(['prefix' => 'operators'], function () {
    Route::post('provider_games', [GameController::class, 'gameList']);
    Route::get('available_products', [GameController::class, 'availableProduct']);

});
Route::group(['prefix' => 'v1/api/seamless'], function () {
    Route::post('balance', [BalanceController::class, 'getBalance']);
    Route::post('withdraw', [WithdrawController::class, 'withdraw']);

});

// });