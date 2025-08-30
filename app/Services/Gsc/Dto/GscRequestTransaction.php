<?php

namespace App\Services\Gsc\Dto;

use Carbon\Carbon;
use Spatie\LaravelData\Data;
use App\Services\Gsc\Dto\UnixTimestampCaster;
use Spatie\LaravelData\Attributes\WithCast;


class GscRequestTransaction extends Data
{
    public function __construct(
        // public int $Status,
        // public string $ProductID,
        // public int $GameType,
        // public ?string $TransactionID,
        // public ?string $WagerID,
        // public ?float $BetAmount,
        // public ?float $TransactionAmount,
        // public ?float $PayoutAmount,
        // public ?float $ValidBetAmount,
        // public ?float $Rate,
        // public ?int $ActualGameTypeID,
        // public ?int $ActualProductID,
        // // public int $Status,
        // // public string $ProductID,
        // // public int $GameType,
        // // public ?string $TransactionID,
        // // public ?string $WagerID,
        // // public ?float $BetAmount,
        // // public ?float $TransactionAmount,
        // // public ?float $PayoutAmount,
        // // public ?float $ValidBetAmount,

        public ?string $id,
        public ?string $game_type,
        public ?int $product_code,
        public ?string $action,
        public ?string $wager_code,
        public ?string $wager_status,
        public ?string $wager_type,
        public ?string $round_id,
        #[WithCast(UnixTimestampCaster::class)]
        public ?Carbon $settled_at,
        public ?float $amount,
        public ?float $bet_amount,
        public ?float $valid_bet_amount,
        public ?float $prize_amount,
        public ?float $tip_amount,
        public ?string $game_code,
        public ?int $ActualGameTypeID,
        public ?int $ActualProductID,
    ) {
    }
}
