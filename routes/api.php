<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AdsController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GameController;
use App\Http\Controllers\API\SlotController;
use App\Http\Controllers\API\TestController;
use App\Http\Controllers\API\CommonController;
use App\Http\Controllers\API\BettingController;
use App\Http\Controllers\API\LotteryController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\FeedbackController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\WalletTransferController;
use App\Http\Controllers\API\TermAndConditionController;
use App\Http\Controllers\API\BettingTransactionController;
use App\Http\Controllers\API\TopupTransactionAPIController;
use App\Http\Controllers\API\CustomerMoneyBalanceController;
use App\Http\Controllers\API\CashWithdrawlTransactionAPIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */
Route::post('/login', [AuthController::class, 'login']);
Route::post('/initial_register', [AuthController::class, 'initialRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/social_register', [AuthController::class, 'socialRegister']);
Route::post('/check_register', [AuthController::class, 'chec kRegister']);
Route::get('/winning_number_list', [BettingController::class, 'getWinningNumberList']);
//forget password
Route::post('/get_code', [AuthController::class, 'getCodeWithPhoneNumber']);
Route::post('/forget_password', [AuthController::class, 'forgetPassword']);
// Route::get('winning_number_list', 'getWinningNumberList');

Route::controller(AdsController::class)->group(function () {
    Route::get('get_ads', 'index');
    Route::get('get_marquee_ads', 'getMarqueeAds');
});
Route::controller(TermAndConditionController::class)->group(function () {
    Route::get('get_term_and_condition', 'index');
});
Route::middleware('auth:sanctum')->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('get_profile', 'getProfile');
        Route::post('change_password', 'changePassword');
    });
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout']);
    // Route::get('/money_balances', [CustomerMoneyBalanceController::class, 'getBalances']);
    // Route::get('/customer_wallet_money', [CustomerMoneyBalanceController::class, 'getCustomerWalletMoney']);
    Route::controller(CustomerMoneyBalanceController::class)->group(function () {
        Route::post('/money_balances', 'getBalances');
        Route::post('/customer_wallet_money', 'getCustomerWalletMoney');
        Route::get('/transaction_history','getTransactionHistory');
    });
    Route::controller(TopupTransactionAPIController::class)->group(function () {
        Route::post('/topup_transactions/create', 'createTopup');
    });
    Route::controller(CashWithdrawlTransactionAPIController::class)->group(function () {
        Route::post('/cash_withdrawl_transactions/create',  'createWithdrawl');
    });
    Route::controller(BettingController::class)->group(function () {
        Route::post('betting', 'createBetting');
        Route::get('bet_number_list', 'getBetNumberList');
        Route::get('betting_history', 'getBettingHistory');
        Route::get('winning_list','getWinningList');
        // Route::get('winning_number_list', 'getWinningNumberList');
    });
    Route::controller(BettingTransactionController::class)->group(function () {
        Route::post('createTransaction', 'createTransaction');
    });
    // Route::controller(NotificationController::class)->group(function () {
    //     Route::get('notification_list', 'index');
    // }); 
    Route::get('/game_list', [GameController::class, 'index']);
    Route::controller(GameController::class)->group(function () {
        Route::get('game_setting_by_game_id', 'getGameSetting');
    });
    Route::controller(CommonController::class)->group(function () {
        Route::get('accounts', 'getAccount');
    }); 
    Route::controller(WalletTransferController::class)->group(function () {
        Route::post('create_wallet_transfer', 'createWalletTransfer');
    }); 
    Route::resource('feedbacks', FeedbackController::class)->only(['index', 'store','destroy']);
    Route::controller(LotteryController::class)->group(function () {
        Route::get('lottery_list', 'index');
        Route::post('create_lottery', 'createLottery');
        Route::get('lottery_detail/{id}', 'detail');
    });
});
Route::get('/generate_hash', [SlotController::class, 'getGameList']);
Route::middleware('auth:sanctum')->get('/notification_list', [NotificationController::class, 'index']);



Route::get('send_noti',[TestController::class,'testNoti']);


Route::get('test_redis',[TestController::class,'testRedis']);

