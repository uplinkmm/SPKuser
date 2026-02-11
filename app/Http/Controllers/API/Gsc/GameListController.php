<?php

namespace App\Http\Controllers\API\Gsc;

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

    public function gameTypeProducts(Request $request, $gameTypeID)
    {
        $gameLobby = GameType::with(['products' => function ($query) {
            $query->where('status', 1);
            $query->where('game_list_status', 0);
            $query->orderBy('order', 'asc');
        }])->where('id', $gameTypeID)->where('status', 1)
            ->first();
        $search = $request->input('search_input');

        $gameTypes = GameType::query()
            ->with(['products' => function ($query) use ($search) {
                $query->where('status', 1)
                    ->where('game_list_status', 1)
                    ->when($search, function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    ->orderBy('order', 'asc');
            }])
            ->where('id', $gameTypeID)
            ->where('status', 1)
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
    public function gameList(Request $request, $product_id, $game_type_id)
    {
        $search = $request->input('search_input');
        $gameLists = GameList::with('product', 'gameType')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            })
            ->where('product_id', $product_id)
            ->where('game_type_id', $game_type_id)
            ->where('status', 1)
            ->get();

        return $this->success(GameDetailResource::collection($gameLists), 'Game Detail Successfully');
    }
}
