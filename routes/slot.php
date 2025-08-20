<?php
use App\Http\Controllers\Api\V1\AgentLogoController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Bank\BankController;
use App\Http\Controllers\Api\V1\BannerController;
use App\Http\Controllers\Api\V1\Game\DirectLaunchGameController;
use App\Http\Controllers\Api\V1\Game\GameController;
use App\Http\Controllers\Api\V1\Game\LaunchGameController;
use App\Http\Controllers\Api\V1\NewVersion\PlaceBetNewVersionController;
use App\Http\Controllers\Api\V1\Player\DepositRequestController;
use App\Http\Controllers\Api\V1\Player\PaymentTypeController;
use App\Http\Controllers\Api\V1\Player\PlayerTransactionLogController;
use App\Http\Controllers\Api\V1\Player\TransactionController;
use App\Http\Controllers\Api\V1\Player\WagerController;
use App\Http\Controllers\Api\V1\Player\WithDrawRequestController;
use App\Http\Controllers\Api\V1\PromotionController;
use App\Http\Controllers\Api\V1\Webhook\BonusController;
use App\Http\Controllers\Api\V1\Webhook\BuyInController;
use App\Http\Controllers\Api\V1\Webhook\BuyOutController;
use App\Http\Controllers\Api\V1\Webhook\CancelBetController;
use App\Http\Controllers\Api\V1\Webhook\GameResultController;
use App\Http\Controllers\Api\V1\Webhook\GetBalanceController;
use App\Http\Controllers\Api\V1\Webhook\JackPotController;
use App\Http\Controllers\Api\V1\Webhook\MobileLoginController;
use App\Http\Controllers\Api\V1\Webhook\PlaceBetController;
use App\Http\Controllers\Api\V1\Webhook\PushBetController;
use App\Http\Controllers\Api\V1\Webhook\RollbackController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;


// Route::get('gameTypeProducts/{id}', [GameController::class, 'gameTypeProducts']);
// Route::get('allGameProducts', [GameController::class, 'allGameProducts']);
// Route::get('gameType', [GameController::class, 'gameType']);
// Route::get('hotgamelist', [GameController::class, 'HotgameList']);
// Route::post('Seamless/PullReport', [LaunchGameController::class, 'pullReport']);

// Route::group(['prefix' => 'Seamless'], function () {
//     Route::post('GetBalance', [GetBalanceController::class, 'getBalance']);

//     // Route::group(["middleware" => ["webhook_log"]], function(){
//     // Route::post('GetGameList', [LaunchGameController::class, 'getGameList']);
//     Route::post('GameResult', [GameResultController::class, 'gameResult']);
//     Route::post('Rollback', [RollbackController::class, 'rollback']);
//     // Route::post('PlaceBet', [PlaceBetController::class, 'placeBet']);
//     Route::post('PlaceBet', [PlaceBetNewVersionController::class, 'placeBetNew']);

//     Route::post('CancelBet', [CancelBetController::class, 'cancelBet']);
//     Route::post('BuyIn', [BuyInController::class, 'buyIn']);
//     Route::post('BuyOut', [BuyOutController::class, 'buyOut']);
//     Route::post('PushBet', [PushBetController::class, 'pushBet']);
//     Route::post('Bonus', [BonusController::class, 'bonus']);
//     Route::post('Jackpot', [JackPotController::class, 'jackPot']);

//     Route::post('MobileLogin', [MobileLoginController::class, 'MobileLogin']);
//     // });
// });




// // Route::group(['middleware' => ['auth:sanctum']], function () {
// Route::middleware('auth:api')->group(function () {
//     Route::group(['prefix' => 'Seamless'], function () {
    
//         // Route::group(["middleware" => ["webhook_log"]], function(){
//         Route::post('GetGameList', [LaunchGameController::class, 'getGameList']);
//     });
//     Route::group(['prefix' => 'game'], function () {
//         Route::post('Seamless/LaunchGame', [LaunchGameController::class, 'launchGame']);
//         Route::get('gamelist/{provider_id}/{game_type_id}', [GameController::class, 'gameList']);
//     });
//     Route::group(['prefix' => 'direct'], function () {
//         Route::post('Seamless/LaunchGame', [DirectLaunchGameController::class, 'launchGame']);
//     });
// });
// Route::group(['prefix' => 'game'], function () {
//     Route::get('search_game', [GameController::class, 'searchGameList']);
// });

// Route::middleware('auth:api')->group(function () {
//     Route::group(['prefix' => 'game'], function () {
//         Route::get('provider_game/{provider_id}/{game_type_id}', [GameController::class, 'gameList']);
//     });

// });