<?php

use App\Http\Controllers\API\SeamlessController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SlotController;

Route::middleware('auth:api')->group(function () {

});

// Route::get('/get_game_list', [SlotController::class, 'getGameList']);
// Route::get('/game_launch', [SlotController::class, 'launchGame']);
// Route::post('/testjson', [SlotController::class, 'testjson']);

// Route::controller(SeamlessController::class)->group(callback: function () {
//     Route::post('/Seamless/GetBalance', 'getGameBalance');
//     Route::post('/Seamless/PlaceBet', 'placeBet');
//     Route::post('/Seamless/GameResult', 'gameResult');
// });



