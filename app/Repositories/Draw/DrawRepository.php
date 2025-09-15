<?php

namespace App\Repositories\Draw;

use Exception;

use Carbon\Carbon;
use App\Models\Draw;

use App\Models\Game;

use App\Models\Prize;
use Google\Service\Games;
use App\Models\GameSetting;
use Illuminate\Http\Request;
use App\Models\PrizeItemImage;
use App\Models\LotteryPromotion;
use Illuminate\Support\Facades\DB;
use App\Models\LotteryWinningNumber;
use App\Models\LotteryPromotionTicket;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Draw\DrawInterface;

class DrawRepository implements DrawInterface
{
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


}