<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WEB\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});


Route::post('/login', [AuthController::class, 'login']);
Route::view('/login_register', 'Auth.login_register')->name('login');
Route::view('/social_phone_number', 'Auth.social_phone_number')->name('social_phone_number');
Route::controller(AuthController::class)->group(function () {
    Route::get('/redirect/{driver}','redirectToProvider');
    Route::get('/{driver}/callback','handleProviderCallback');
});
Route::middleware('auth')->group(function () {
    // Route::view('/home', 'home.index')->name('home');
    // Route::view('/', 'home.index')->name('home');
    Route::view('/wallet', 'wallet.index')->name('wallet');
    Route::view('/topup', 'money_in.index');
    Route::view('/cash_withdraw', 'money_out.index');
    Route::view('/2D_betting', 'betting.two_d_betting');
    Route::view('/3D_betting', 'betting.three_d_betting');
    Route::get('/winner_lists/{game_type}', function ($game_type) {
        return view('betting.winner_lists', ['game_type' => $game_type]);
    });
    Route::view('/notifications', 'notifications.index');
    Route::view('/history', 'betting_history.bet_history');
    Route::view('/deposit_withdrawal_histories', 'betting_history.deposit_withdrawal_histories');
    Route::view('/profile', 'profile.index');
});
Route::view('/home', 'home.index')->name('home');
Route::view('/test', 'Test.test')->name('test');

//test

Route::view('/2d/live', 'twod.live')->name('twoD.live');
Route::view('/2d/dream_numbers', 'twod.dream_number')->name('twoD.dream_numbers');
Route::view('/2d/calendar', 'twod.calendar')->name('twoD.calendar');
Route::view('/2d/analysis', 'twod.analysis')->name('twoD.analysis');
Route::view('/2d/pro_analysis', 'twod.pro_analysis')->name('twoD.pro_analysis');

Route::view('/3d', 'threed.live')->name('threeD.live');
Route::view('/3d/calendar', 'threed.calendar')->name('threeD.calendar');
Route::view('/3d/analysis', 'threed.analysis')->name('threeD.analysis');
Route::view('/lottery_history', 'betting_history.lottery_history')->name('betting_history.lottery_history');


Route::view('/privacypolicy', 'privacy_and_policy.privacy_and_policy')->name('privacypolicy');
Route::view('/tnc', 'term_and_condition.term_and_condition')->name('tnc');
Route::view('/slots', 'slots.index')->name('slots');
Route::view('/slots/game_lists', 'slots.slots_games')->name('slots_games');
Route::view('/slots/providers', 'slots.slots_providers')->name('slots_providers');
Route::view('/lottery', 'lottery.index')->name('lottery');
