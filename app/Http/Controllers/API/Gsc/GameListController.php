<?php

namespace App\Http\Controllers\Api\Gsc;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Models\Admin\GameList;
use App\Models\Admin\GameType;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameDetailResource;

class GameListController extends Controller
{
    //
    use HttpResponses;

    public function gameType()
    {
        $gameType = GameType::with('products')
        ->whereHas('products')
        ->where('status',  1)
        ->get();

        return $this->success($gameType);
    }

    public function gameTypeProducts($gameTypeID)
    {
        $gameLobby = GameType::with(['products' => function ($query) {
            $query->where('status', 1);
            $query->where('game_list_status', 0);
            $query->orderBy('order', 'asc');
        }])->where('id', $gameTypeID)->where('status', 1)
            ->first();

        $gameTypes = GameType::with(['products' => function ($query) {
            $query->where('status', 1);
            $query->where('game_list_status', 1);
            $query->orderBy('order', 'asc');
        }])->where('id', $gameTypeID)->where('status', 1)
            ->first();

        return $this->success([
            'game_lobby' => $gameLobby,
            'game_type' => $gameTypes,
        ]);
    }

    public function allGameProducts()
    {
        $gameTypes = GameType::with(['products' => function ($query) {
            $query->where('status', 1);
            $query->orderBy('order', 'asc');
        }])->where('status', 1)
            ->get();

        return $this->success($gameTypes);
    }
    public function gameList($product_id, $game_type_id)
    {
        $gameLists = GameList::with('product','gameType')
            ->where('product_id', $product_id)
            ->where('game_type_id', $game_type_id)
            ->where('status', 1)
            ->get();

        return $this->success(GameDetailResource::collection($gameLists), 'Game Detail Successfully');

    }
}
