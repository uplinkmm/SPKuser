<?php

namespace App\Repositories\Lottery;

use Carbon\Carbon;
use App\Models\Game;
use App\Models\Lottery;
use App\Models\GameSetting;
use App\Traits\BettingValidation;
use Illuminate\Support\Facades\DB;
use App\Http\Action\WalletTransactionCommon;
use App\Models\LotteryBettingPromotion;
use App\Repositories\Lottery\LotteryInterface;

class LotteryRepository implements LotteryInterface
{
    use WalletTransactionCommon, BettingValidation;
    private $select = ['id', 'name', 'photo', 'opening_date_time', 'closing_date_time', 'lottery_date_time', 'photo', 'price', 'limitation_quantity', 'description', 'terms_and_condition', 'game_id', 'is_active'];
    public function list($request)
    {
        $game = Game::where('type', 'draw')->first();
        if (!$game) {
            ResponseMessage('Game Not found', 404);
        }
        $perPage = $request->per_page ?? config('common.per_page');
        $now = Carbon::now();
        $drawListQuery = GameSetting::with('prizes.prizes_images')
            ->where('game_id', $game->id)
            ->where(function ($query) use ($now) {
                $query->where('opening_date_time', '<=', $now)
                    ->where('closing_date_time', '>=', $now);
            })
            ->select($this->select)
            ->latest();
        if (isset($request->page)) {
            return $drawListQuery->paginate($perPage);
        }
        return $drawListQuery->where('is_active', 1)->get();
    }

    public function createLottery($request)
    {
        $gameSettingId = $request->input('game_setting_id');
        $gameId = $request->input('game_id');
        $this->checkValidTimeByGameSetting($gameId, $gameSettingId);
        $betting_numbers = json_decode($request->numbers, true);
        if (empty($betting_numbers) || !is_array($betting_numbers)) {
            ResponseMessage('Invalid or empty betting numbers', 419);
        }
        DB::beginTransaction();
        try {
            // $gameId = $request->input('game_id');
            // $gameSettingId = $request->input('game_setting_id');
            // $timeStatus = $request->input('time_status'); // Assuming 'timeStatus' is passed in the request
            #validate closing amount
            // $totalBetAmount = $this->calculateTotalBetAmount($gameId, $gameSettingId, $timeStatus);
            $data = $request->all();
            $customer = UserData();
            $data['customer_id'] = $customer->id;
            $data['date_time'] = now();
            $lottery = Lottery::create($data);
            foreach ($betting_numbers as $number) {
                //check lottery number already exist
                $this->checkLotteryNumberExist($gameSettingId, $number['number']);
                #end
                $lotteryNumbers = $lottery->lotteryNumbers()->create([
                    'number' => $number['number'],
                    'amount' => (int) $number['amount'],
                    // 'game_setting_id' => (int) $request->game_setting_id,
                ]);
            }
            $promtionTickets = json_decode($request->promotion_ticket_ids, true);
            if (isset($request->promotion_ticket_ids) && count($promtionTickets) > 0) {
                foreach ($promtionTickets as $ticket) {
                    $ticket = LotteryBettingPromotion::create([
                        'lottery_promotion_ticket_id' => $ticket,
                        'lottery_id' => $lottery->id,
                    ]);
                }
            }
            #store Wallet
            $this->actionOfWalletTransaction($lottery, $lottery->total_amount, 'out');
            DB::commit();
            return $lottery;
        } catch (\Exception $e) {
            DB::rollback();
            ResponseMessage($e->getMessage(), 402);
            throw $e;
        }
    }

    public function detail($id)
    {
        $lottery = GameSetting::with('prizes.prizes_images')
            ->where('is_active', 1)
            ->find($id);
        if (!$lottery) {
            ResponseMessage("Data does not exist", 419);
        }
        return $lottery;
    }
}