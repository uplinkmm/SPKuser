<?php
namespace App\Repositories\Betting;

use stdClass;
use Carbon\Carbon;
use App\Models\Game;
use App\Models\Betting;
use App\Models\BettingWin;
use App\Models\GameSetting;
use App\Http\Action\GameData;
use App\Models\BettingNumber;
use App\Models\ClosingNumber;
use App\Models\WinningNumber;
use App\Traits\TimeStatusTrait;
use App\Traits\BettingValidation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Http\Action\CustomerWalletBalance;
use App\Http\Action\WalletTransactionCommon;
use App\Repositories\Betting\BettingInterface;

class BettingRepository implements BettingInterface
{
    use WalletTransactionCommon, TimeStatusTrait, BettingValidation;
    public function createBetting($request)
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
            $betting = Betting::create($data);
            foreach ($betting_numbers as $number) {
                #check closing amount for each betting number
                $betttingAmountAndClosingAmount = $this->calculateTotalBetAmountForNumber(
                    $gameId,
                    $gameSettingId,
                    $number['number']
                );
                // dd($betttingAmountAndClosingAmount);
                $closingAmount = (int) $betttingAmountAndClosingAmount['closing_amount'];
                $totalBetAmount = (int) $betttingAmountAndClosingAmount['total_bet_amount'];
                $newBetAmount = (int)$number['amount'];
                if ($totalBetAmount + $newBetAmount > $closingAmount) {
                    ResponseMessage('Total bet amount for number ' . $number['number'] . ' exceeds the closing amount', 400);
                }
                #end
                $beting_number = $betting->bettingNumbers()->create([
                    'number' => $number['number'],
                    'amount' => (int) $number['amount'],
                    'betting_multiplier' => (int) $request->betting_multiplier,
                    // 'game_setting_id' => (int) $request->game_setting_id,
                ]);
            }
            #store Wallet
            $this->actionOfWalletTransaction($betting, $betting->total_amount, 'out');
            DB::commit();
            // return $betting;
        } catch (\Exception $e) {
            DB::rollback();
            ResponseMessage($e->getMessage(), 402);
            throw $e;
        }
    }

    private function calculateTotalBetAmountForNumber($gameId, $gameSettingId, $number)
    {

        $now = now();
        $date = $now->format('Y-m-d');
        $gameSetting = GameSetting::where('is_active', 1)->find($gameSettingId);
        dd($gameSetting->game->type);
        if (!$gameSetting) {
            ResponseMessage('Game Setting Not Found', status_code: 404);
        }
        $gameType=$gameSetting->game->type;

        $closingNumber = ClosingNumber::orderBy('id', 'desc')->where('number', $number)
            ->where('game_id', $gameId)
            ->where('game_setting_id', $gameSettingId)
            ->when($gameType=='2d',function($q)use($date){
                $q->whereDate('date_time', $date);
            })
            ->where('is_active')
            ->first();

        // $closingAmount = config('2d_setting.max_closing_bet_amount');
        $closingAmount = $closingNumber ? $closingNumber->amount : $gameSetting->closing_amount;


        $startTime = convertDateTimeFormat($date . $gameSetting->opening_time);
        $endTime = convertDateTimeFormat($date . $gameSetting->closing_time);
        $query = DB::table('betting_numbers as bn')
            ->join('bettings as b', 'bn.betting_id', '=', 'b.id')
            ->where('bn.number', $number);

        if ($gameId == 1) {
            $max = config('2d_setting.max_closing_bet_amount');
            $query
                ->whereBetween('b.date_time', [$startTime, $endTime])
                ->where('b.game_id', $gameId)
                ->where('b.game_setting_id', $gameSettingId);
            // ->leftJoin('closing_numbers as cn', function ($join) use ($date) {
            //     $join->on('bn.number', '=', 'cn.number')
            //         // ->where('cn.time_status', $timeStatus)
            //         ->where('cn.game_id', config('2d_setting.game_id'))
            //         ->where('cn.is_active', 1)
            //         ->whereDate('cn.date_time', $date);
            // });
        } else if ($gameId == 2) {
            // $max = config('3d_setting.max_closing_bet_amount');
            $query->where('b.game_setting_id', $gameSettingId);
            // ->leftJoin('closing_numbers as cn', function ($join) {
            //     $join->on('bn.number', '=', 'cn.number')
            //         ->where('cn.game_id', config('3d_setting.game_id'))
            //         ->where('cn.is_active', 1);
            // })
            // ->leftJoin('game_settings as gs', function ($join) use ($now) {
            //     $join->on('gs.game_id', '=', 'b.game_id')
            //         ->where('gs.is_active', 1)
            //         ->where(function ($query) use ($now) {
            //             $query->where('gs.opening_date_time', '<=', $now)
            //                 ->where('gs.closing_date_time', '>=', $now);
            //         });
            // });
        }

        // Retrieve the total bet amount and closing amount
        $query->select(
            DB::raw('COALESCE(SUM(bn.amount), 0) AS total_bet_amount'),
            // DB::raw('COALESCE(SUM(DISTINCT bn.amount), 0) AS total_bet_amount')
        );

        // Execute the query and fetch results
        $result = $query->first();

        return [
            'total_bet_amount' => $result->total_bet_amount,
            'closing_amount' => $closingAmount,
        ];

    }

    public function getBettingNumberList($request)
    {
        // $timeStatus = $request->time_status;
        $gameSettingId = isset($request->game_setting_id) ? $request->game_setting_id : null;
        #game
        $game = (new GameData($request->game_id))->getGame($gameSettingId);
        if (!$game) {
            ResponseMessage('Game is invalid', 419);
        }
        #betting number_list
        // $bettin_number_list = $request->game_id == config('2d_setting.game_id') ? $this->get2dBettingNumberList($game) : $this->get3dBettingNumberList($game);
        $bettin_number_list = $game->type == '2d' ? $this->get2dBettingNumberList($game) : $this->get3dBettingNumberList($game);

        #get wallet money
        $balance = (new CustomerWalletBalance(UserData()->id))->getCustomerWalletBalance();
        #setUp_Response
        $new_data = new stdClass();
        $new_data->bet_list_numbers = $bettin_number_list;
        $new_data->game = $game;
        $new_data->balance = $balance;
        $new_data->bet_limit = $game->type == '2d' ? UserData()->two_d_limit : UserData()->three_d_limit;
        return $new_data;
    }

    public function get2dBettingNumberList($gameSetting)
    {
        // $timeStatus=$gameSetting->time_status;
        // $startTime = convertDateTimeFormat($date . $gameSetting->opening_time);
        // $endTime = convertDateTimeFormat($date . $gameSetting->closing_time);

        $date = now()->format('Y-m-d');
        $max = $gameSetting->closing_amount;
        $min_bet_amount = $gameSetting->min;
        $max_bet_amount = $gameSetting->max;


        $subqueryD1 = DB::table(DB::raw('(SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS d1'));
        $subqueryD2 = DB::table(DB::raw('(SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS d2'));

        // Subquery to calculate total bet amount for all customers
        $filteredBets = DB::table('betting_numbers as bn')
            ->join('bettings as b', 'bn.betting_id', '=', 'b.id')
            // ->whereBetween('b.date_time', [$startTime, $endTime])
            ->whereDate('b.date_time', $date)
            ->where('b.game_setting_id', $gameSetting->id)
            ->select('bn.number', DB::raw('SUM(bn.amount) as total_amount_all'))
            ->groupBy('bn.number');

        // Subquery to calculate total bet amount for a specific customer
        $filteredBetsForCustomer = DB::table('betting_numbers as bn')
            ->join('bettings as b', 'bn.betting_id', '=', 'b.id')
            // ->whereBetween('b.date_time', [$startTime, $endTime])
            ->whereDate('b.date_time', $date)

            ->where('b.game_setting_id', $gameSetting->id)
            ->where('b.customer_id', UserData()->id) // Assuming $specificCustomerId holds the ID of the specific customer
            ->select('bn.number', DB::raw('SUM(bn.amount) as total_amount_customer'))
            ->groupBy('bn.number');

        $latestClosingNumbers = DB::table('closing_numbers as cn')
            ->select('cn.number', DB::raw('MAX(cn.date_time) as latest_date'))
            ->where('cn.game_id', $gameSetting->game_id)
            ->where('cn.game_setting_id', $gameSetting->id)
            ->where('cn.is_active', 1)
            ->whereDate('cn.date_time', $date)
            ->groupBy('cn.number');



        $latestClosingNumbersDetails = DB::table('closing_numbers as cn')
            ->joinSub($latestClosingNumbers, 'lc', function ($join) {
                $join->on('cn.number', '=', 'lc.number')
                    ->on('cn.date_time', '=', 'lc.latest_date');
            })
            ->select('cn.*');
        $betsWithTotalAmount = DB::table(DB::raw('(' . $subqueryD1->toSql() . ') as d1'))
            ->mergeBindings($subqueryD1)
            ->crossJoin(DB::raw('(' . $subqueryD2->toSql() . ') as d2'))
            ->mergeBindings($subqueryD2)
            ->leftJoinSub($filteredBets, 'fb', function ($join) {
                $join->on(DB::raw('LPAD(d1.n * 10 + d2.n, 2, "0")'), '=', 'fb.number');
            })
            ->leftJoinSub($filteredBetsForCustomer, 'fbc', function ($join) {
                $join->on(DB::raw('LPAD(d1.n * 10 + d2.n, 2, "0")'), '=', 'fbc.number');
            })
            ->leftJoinSub($latestClosingNumbersDetails, 'cn', function ($join) {
                $join->on(DB::raw('LPAD(d1.n * 10 + d2.n, 2, "0")'), '=', 'cn.number');
            })
            ->select(
                DB::raw('LPAD(d1.n * 10 + d2.n, 2, "0") AS number'),
                // DB::raw('COALESCE(SUM(fb.total_amount_all), 0) AS total_bet_amount'),
                DB::raw('
                COALESCE(
                    SUM(
                        CASE 
                            WHEN cn.id IS NOT NULL THEN (' . $max . ' - COALESCE(cn.amount, 0)) + COALESCE(fb.total_amount_all, 0)
                            ELSE COALESCE(fb.total_amount_all, 0)
                        END
                    ), 0
                ) AS total_bet_amount
            '),
                DB::raw('COALESCE(SUM(fbc.total_amount_customer), 0) AS total_amount'), // Total amount for the specific customer
                DB::raw('
                CASE
                    WHEN cn.amount IS NOT NULL THEN CAST(cn.amount AS UNSIGNED)
                    ELSE NULL
                END AS closing_amount_of_number'),
                DB::raw(value: $max . ' AS closing_amount'),
                DB::raw($min_bet_amount . ' AS min'),
                DB::raw($max_bet_amount . ' AS max'),
                DB::raw('
                CASE
                    WHEN cn.id IS NOT NULL AND cn.amount IS NULL THEN 0
                    WHEN cn.amount IS NOT NULL AND COALESCE(SUM(fb.total_amount_all), 0) < cn.amount THEN 1
                    ELSE 1
                END AS is_active'),
                DB::raw('
    IF(
        ' . $max . ' > 0, 
        COALESCE(
            SUM(
                CASE 
                    WHEN cn.id IS NOT NULL AND fb.total_amount_all IS NULL THEN (' . $max . ' - cn.amount)
                    WHEN cn.id IS NOT NULL THEN (' . $max . ' - cn.amount) + fb.total_amount_all
                    ELSE fb.total_amount_all
                END
            ), 0
        ) / ' . $max . ' * 100, 
        0
    ) AS total_bet_percentage
')
            )
            ->groupBy(
                DB::raw('LPAD(d1.n * 10 + d2.n, 2, "0")'),
                'cn.id'
            )
            ->orderBy('number')
            ->get();
        return $betsWithTotalAmount;
    }

    public function get3dBettingNumberList($game)
    {
        // dd(UserData());
        $timeStatus = 'morning';

        if (!$game->game_setting) {
            ResponseMessage("Betting isn't available beacause of game setting is missing", 419);
        }
        $gameSettingId = $game->game_setting->id;
        // dd($gameSettingId);
        $now = now();
        // $defaultClosingAmount=config('3d_setting.max_closing_bet_amount');
        $max = $game->game_setting->closing_amount;
        $min_bet_amount = $game->game_setting->min;
        $max_bet_amount = $game->game_setting->max;
        $subqueryD1 = DB::table(DB::raw('(SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS d1'));
        $subqueryD2 = DB::table(DB::raw('(SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS d2'));
        $subqueryD3 = DB::table(DB::raw('(SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS d3'));

        $filteredBets = DB::table('betting_numbers as bn')
            ->join('bettings as b', 'bn.betting_id', '=', 'b.id')
            ->where('b.game_setting_id', $game->game_setting->id)
            ->select('bn.number', DB::raw('SUM(bn.amount) as total_amount_all'))
            ->groupBy('bn.number');

        $filteredBetsForCustomer = DB::table('betting_numbers as bn')
            ->join('bettings as b', 'bn.betting_id', '=', 'b.id')
            ->where('b.game_setting_id', $game->game_setting->id)
            ->where('b.customer_id', UserData()->id)
            ->select('bn.number', DB::raw('SUM(bn.amount) as total_amount_customer'))
            ->groupBy('bn.number');

        $latestClosingNumbers = DB::table('closing_numbers as cn1')
            ->select('cn1.*')
            ->where('cn1.game_id', $game->id)
            ->where('cn1.game_setting_id', $game->game_setting->id)
            ->where('cn1.is_active', 1)
            ->whereRaw('cn1.id = (select max(cn2.id) from closing_numbers as cn2 where cn2.number = cn1.number and cn2.game_id = cn1.game_id and cn2.game_setting_id = cn1.game_setting_id and cn2.is_active = 1)');

        $betsWithTotalAmount = DB::table(DB::raw('(' . $subqueryD1->toSql() . ') as d1'))
            ->mergeBindings($subqueryD1)
            ->crossJoin(DB::raw('(' . $subqueryD2->toSql() . ') as d2'))
            ->mergeBindings($subqueryD2)
            ->crossJoin(DB::raw('(' . $subqueryD3->toSql() . ') as d3'))
            ->mergeBindings($subqueryD3)
            ->leftJoinSub($filteredBets, 'fb', function ($join) {
                $join->on(DB::raw('LPAD(d1.n * 100 + d2.n * 10 + d3.n, 3, "0")'), '=', 'fb.number');
            })
            ->leftJoinSub($filteredBetsForCustomer, 'fbc', function ($join) {
                $join->on(DB::raw('LPAD(d1.n * 100 + d2.n * 10 + d3.n, 3, "0")'), '=', 'fbc.number');
            })
            ->leftJoinSub($latestClosingNumbers, 'latest_cn', function ($join) {
                $join->on(DB::raw('LPAD(d1.n * 100 + d2.n * 10 + d3.n, 3, "0")'), '=', 'latest_cn.number');
            })
            // ->leftJoin('game_settings as gs', function ($join) use ($now,$gameSettingId) {
            // $join->on('gs.id', '=', DB::raw(config('3d_setting.game_id')))
            // $join->on('gs.id', '=', $gameSettingId)
            // ->where('gs.is_active', 1);
            // ->where(function ($query) use ($now) {
            //     $query->where('gs.opening_date_time', '<=', $now)
            //         ->where('gs.closing_date_time', '>=', $now);
            // });
            // })
            ->select(
                DB::raw('LPAD(d1.n * 100 + d2.n * 10 + d3.n, 3, "0") AS number'),
                // 'fb.number as number',

                //     DB::raw('
                //     COALESCE(
                //         SUM(
                //             CASE 
                //                 WHEN latest_cn.id IS NOT NULL THEN (' . $max . ' - latest_cn.amount) + fb.total_amount_all
                //                 ELSE fb.total_amount_all
                //             END
                //         ), 0
                //     ) AS total_bet_amount
                // '),
                DB::raw('COALESCE(SUM(fb.total_amount_all), 0) AS total_bet_amount'),
                // DB::raw('COALESCE(fb.total_amount_all, 0) AS total_bet_amount'),
                DB::raw('COALESCE(fbc.total_amount_customer, 0) AS total_amount'), // Total amount for the specific customer
                DB::raw('
                CASE
                    WHEN latest_cn.id IS NULL THEN ' . $max . '
                    WHEN latest_cn.amount IS NOT NULL THEN CAST(latest_cn.amount AS UNSIGNED)
                    ELSE NULL
                END AS closing_amount'),
                DB::raw('IF(latest_cn.id IS NOT NULL, 1, 0) AS is_closing'), // Define is_closing based on the existence of latest_cn.id
                // DB::raw( 'latest_cn.amount AS current_closing_amount'),
                DB::raw($min_bet_amount . ' AS min'),
                DB::raw($max_bet_amount . ' AS max'),
                // DB::raw('IF(COALESCE(fb.total_amount_all, 0) < COALESCE(latest_cn.amount, ' . $max . '), 1, 0) AS is_active'),
                DB::raw('
                CASE
                    WHEN latest_cn.id IS NOT NULL AND latest_cn.amount IS NULL THEN 0
                    WHEN latest_cn.amount IS NOT NULL AND COALESCE(SUM(fb.total_amount_all), 0) < latest_cn.amount THEN 1
                    ELSE 1
                END AS is_active'),
                //                 DB::raw('
//     ROUND(
//         IF(
//             latest_cn.id IS NOT NULL, 
//             IF(
//                 ' . $max . ' > 0, 
//                 (( ' . $max . ' - (COALESCE(latest_cn.amount, 0) + COALESCE(SUM(fb.total_amount_all), 0))) / ' . $max . ' * 100), 
//                 0
//             ),
//             IF(
//                 COALESCE(SUM(fb.total_amount_all), 0) > 0, 
//                 ((  COALESCE(SUM(fb.total_amount_all), 0)) / ' . $max . ' * 100), 
//                 0
//             )
//         ), 
//         2
//     ) AS total_bet_percentage
// ')

                DB::raw('
    ROUND(
        IF(
            latest_cn.id IS NOT NULL, 
           IF(
    ' . $max . ' > 0, 
    (((' . $max . ' - COALESCE(latest_cn.amount, 0)) + COALESCE(SUM(fb.total_amount_all), 0)) / ' . $max . ' * 100), 
    0
),
            IF(
                COALESCE(SUM(fb.total_amount_all), 0) > 0, 
                ((  COALESCE(SUM(fb.total_amount_all), 0)) / ' . $max . ' * 100), 
                0
            )
        ), 
        2
    ) AS total_bet_percentage
')

                // DB::raw('ROUND(IF(COALESCE(latest_cn.amount, ' . $max . ') > 0, COALESCE(fb.total_amount_all, 0) / COALESCE(latest_cn.amount, ' . $max . ') * 100, 0), 2) AS total_bet_percentage'),
            )
            ->groupBy(
                // 'fb.number',
                DB::raw('LPAD(d1.n * 100 + d2.n * 10 + d3.n, 3, "0")'),
                'fb.total_amount_all',
                'fbc.total_amount_customer',
                'latest_cn.amount',
                'latest_cn.id' // Add latest_cn.id to the group by clause

            )
            ->orderBy('number')
            ->get();
        return $betsWithTotalAmount;
    }

    public function getBettingHistory($request)
    {
        $game = Game::find($request->game_id);
        if ($game) {
            if ($game->type == '2d') {
                $today = convertDateFormat(now());
                return Betting::with([
                    'bettingNumbers:id,number,amount,betting_id',
                    'customer:id,name',
                    'game:id,name',
                    'gameSetting:id,lottery_date_time,time_status',
                ])
                    ->orderBy('bettings.id', 'DESC')
                    ->join('game_settings', 'bettings.game_setting_id', 'game_settings.id')
                    ->where('bettings.game_id', $request->game_id)
                    ->whereDate('bettings.date_time', $today)
                    ->where('customer_id', UserData()->id)
                    ->where('bettings.total_amount', '>', 0) // Ensure total_amount is greater than 0
                    ->select('bettings.id', 'date_time', 'total_amount', 'game_settings.time_status', 'game_settings.lottery_time', 'customer_id', 'bettings.game_id', 'game_setting_id')
                    ->paginate(100);
            }
            if ($game->type == '3d') {
                $gameSettingIds = GameSetting::where('game_id', $request->game_id)->orderBy('id', 'desc')->take(2)->pluck('id')->toArray();
                return Betting::with([
                    'bettingNumbers:id,number,amount,betting_id',
                    'customer:id,name',
                    'game:id,name',
                    'gameSetting:id,lottery_date_time,time_status',
                ])
                    ->orderBy('id', 'DESC')
                    ->where('game_id', $request->game_id)
                    ->where('customer_id', UserData()->id)
                    ->whereIn('game_setting_id', $gameSettingIds)
                    ->where('bettings.total_amount', '>', 0) // Ensure total_amount is greater than 0
                    ->select('id', 'date_time', 'total_amount', 'time_status', 'customer_id', 'game_id', 'game_setting_id')
                    ->paginate(20);
            }

        }

    }

    public function getWinningList($request)
    {
        //correct code
        if (isset($request->game_id)) {
            $bettingWin = BettingWin::orderBy('betting_wins.id', 'desc')
                ->join('game_settings', 'betting_wins.game_setting_id', 'game_settings.id')
                ->join('games', 'game_settings.game_id', 'games.id')
                ->where('game_settings.game_id', $request->game_id)
                ->select('game_settings.id as game_setting_id', 'betting_wins.date_time', 'games.type as type')
                ->first();
            $gameSettingId = $bettingWin ? $bettingWin->game_setting_id : null;
            $whereTime = $bettingWin ? convertDateFormat($bettingWin->date_time) : null;
            $type = $bettingWin ? $bettingWin->type : null;
            $winning_list = BettingNumber::join('bettings', 'betting_numbers.betting_id', 'bettings.id')
                ->join('customers', 'bettings.customer_id', 'customers.id')
                ->where('betting_numbers.is_win', 1)
                ->when($type == '2d', function ($q) use ($whereTime) {
                    $q->whereDate('bettings.date_time', $whereTime);
                })
                ->where('bettings.game_setting_id', $gameSettingId)
                ->select('customers.id', 'customers.name', 'customers.phone_number', 'betting_numbers.number', 'bettings.date_time', DB::raw('SUM(betting_numbers.amount) as total_amount'))
                ->groupBy('customers.id', 'customers.name', 'customers.phone_number', 'betting_numbers.number', 'bettings.date_time')
                ->paginate(20);
            return $winning_list;

        }
        if (isset($request->game_setting_id)) {
            $today = convertDateFormat(now());
            $winning_list = BettingNumber::join('bettings', 'betting_numbers.betting_id', 'bettings.id')
                ->join('customers', 'bettings.customer_id', 'customers.id')
                ->join('game_settings', 'bettings.game_setting_id', 'game_settings.id')
                ->join('games', 'bettings.game_id', 'games.id')
                ->where('betting_numbers.is_win', 1)
                ->where('bettings.game_setting_id', $request->game_setting_id)
                ->whereDate('bettings.date_time', $today)
                ->select(
                    'customers.id',
                    'customers.name',
                    'bettings.date_time',
                    DB::raw('RIGHT(customers.phone_number, 3) as phone_number'), // Get the last 3 characters
                    'game_settings.lottery_date_time',
                    'game_settings.lottery_time',
                    'games.type',
                    DB::raw('SUM(betting_numbers.amount) as total_amount')
                )
                ->groupBy('customers.id', 'customers.name', 'bettings.date_time', 'customers.phone_number', 'game_settings.lottery_date_time', 'game_settings.lottery_time', 'games.type')
                ->paginate(20);
            return $winning_list;
        }
        #end
    }

    public function getWinningNumberList($request)
    {
        if (isset($request->game_id)) {
            $game = Game::find($request->game_id);
            if (!$game) {
                ResponseMessage('Game Id is invalid');
            }
            if ($game->type == '3d') {
                return BettingWin::orderBy('betting_wins.id', 'desc')
                    ->join('game_settings', 'betting_wins.game_setting_id', 'game_settings.id')
                    ->join('games', 'game_settings.game_id', 'games.id')
                    ->where('game_settings.game_id', $request->game_id)
                    ->where('betting_wins.date_time', '>=', Carbon::now()->subMonths(6)) // Last 6 months
                    ->select('betting_wins.number', 'game_settings.id as game_setting_id', 'betting_wins.date_time', 'games.type as type')
                    ->get();
            }
            if ($game->type == '2d') {
                // $response = Http::get('https://admin.2dmyanmarpro.com/api/2d/live');
                // $jsonResult = $response->json();
                // // return $jsonResult;
                // // dd($jsonResult['data']['results']);
                // $today = Carbon::now();
                // if ($today->isSaturday() || $today->isSunday()) {
                //     Log::info("No winning numbers stored today because it's a weekend.");
                //     return; // Exit the script without storing any data
                // }
                // // return $jsonResult['data']['results'];
                // if (isset($jsonResult['data']['results'])) {
                //     DB::beginTransaction(); // Start the transaction
                //     try {
                //         foreach ($jsonResult['data']['results'] as $lottery) {
                //             if ($lottery['history_id'] != null) {
                //                 $lotteryTime = Carbon::parse($lottery['stock_datetime']);
                //                 $lotteryDate = convertDateFormat($lottery['stock_datetime']);
                //                 // Store the result in the database
                //                 $winningNumber = WinningNumber::firstOrCreate(
                //                     [
                //                         'lottery_time' => $lottery['open_time'],
                //                         'date' => $lotteryDate,
                //                         'type' => 'two_d',

                //                     ],  // Unique identifier for the record
                //                     [
                //                         'two_d' => $lottery['twod'],
                //                         'modern' => null,  // Add appropriate value if needed
                //                         'internet' => null,  // Add appropriate value if needed
                //                         'tw' => null,  // Add appropriate value if needed
                //                         'set' => $lottery['set'],
                //                         'value' => $lottery['value'],
                //                         'date_time' => $lotteryTime,
                //                         'lottery_time' => $lottery['open_time'],
                //                         'type' => 'two_d',
                //                     ]
                //                 );

                //                 Log::info("Winning number for time {$lottery['open_time']} stored successfully.");
                //             }
                //             // Parse the open time and current time to determine if it's time to store

                //         }

                //         foreach ($jsonResult['data']['modern_internet']['numbers'] as $number) {
                //             $convertedTime = Carbon::parse($number['time'])->format('H:i');
                //             $convertedDate = convertDateFormat('now');
                //             // return $number;
                //             // if ($number['Modern'] != '--') {
                //                 $winningNumber = WinningNumber::updateOrCreate(
                //                     [
                //                         'lottery_time' => $convertedTime,
                //                         'date' => $convertedDate,
                //                         'type' => 'internet_modern',
                //                     ],  // Unique identifier for the record
                //                     [
                //                         'modern' => $number['Modern'] != '--' ? $number['Modern'] : null,  // Add appropriate value if needed
                //                         'internet' => $number['Internet'] != '--' ? $number['Internet'] : null,  // Add appropriate value if needed
                //                         'date_time' => $convertedDate,
                //                         'lottery_time' => $convertedTime,
                //                         'date' => $convertedDate,
                //                         'type' => 'internet_modern',
                //                     ]
                //                 );
                //             // }
                //         }
                //         // return $jsonResult['data']['modern_internet']['numbers'];

                //         DB::commit(); // Commit the transaction if everything is successful
                //     } catch (\Exception $e) {
                //         DB::rollBack(); // Rollback the transaction if any error occurs
                //         Log::error('Failed to store winning numbers: ' . $e->getMessage());
                //         throw $e; // Optionally rethrow the exception to handle it further up the chain
                //     }
                // }
                return WinningNumber::orderBy('id', 'asc')
                    // ->where('date_time',Carbon::now()->subDays(6))
                    ->whereBetween('date', [Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()])
                    ->get();
            }
        }

        // // Check if the request was successful
        // if ($response->successful()) {
        //     // Return the response data (as JSON, for example)
        //     $data = $response->json();
        //     dd($data['data']);
        //     return response()->json($response->json());
        // } else {
        //     // Handle the error
        //     return response()->json(['error' => 'Failed to fetch live data'], 500);
        // }
    }

}
