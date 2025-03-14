<?php

namespace App\Http\Controllers\Api\V1\Webhook\Traits;

use App\Enums\TransactionName;
use App\Enums\TransactionStatus;
use App\Enums\WagerStatus;
use App\Http\Requests\Slot\SlotWebhookRequest;
use App\Models\Admin\GameType;
use App\Models\Admin\GameTypeProduct;
use App\Models\Admin\Product;
use App\Models\SeamlessEvent;
use App\Models\SeamlessTransaction;
use App\Models\User;
use App\Models\Wager;
use App\Services\Slot\Dto\RequestTransaction;
use App\Services\WalletService;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Support\Facades\Auth;

trait UseWebhook
{
    public function createEvent(
        SlotWebhookRequest $request,
    ): SeamlessEvent {
        return SeamlessEvent::create([
            'customer_id' => $request->getMember()->id, //  change from 'user_id=>$request->getMember()->id
            'message_id' => $request->getMessageID(),
            'product_id' => $request->getProductID(),
            'request_time' => $request->getRequestTime(),
            'raw_data' => $request->all(),
        ]);
    }

    /**
     * @param  array<int,RequestTransaction>  $requestTransactions
     * @return array<int, SeamlessTransaction>
     *
     * @throws MassAssignmentException
     */
    public function createWagerTransactions(
        $requestTransactions,
        SeamlessEvent $event,
        bool $refund = false
    ) {
        $seamless_transactions = [];
        foreach ($requestTransactions as $requestTransaction) {
            // dd($requestTransaction);
            if ($requestTransaction->WagerID == "0" || $requestTransaction->WagerID == 0) {
                    $uniqueNumber = (int)(date('YmdHis', strtotime(now())) . $event->customer_id);
                    $wager = Wager::create(
                        [
                            'customer_id' => $event->customer_id, //change from  'user_id'=> $event->user_id,
                            'seamless_wager_id' => $uniqueNumber,
                        ]
                    );
                // $wager = null;
            } else {
                $wager = Wager::firstOrCreate(
                    [
                        'seamless_wager_id' => $requestTransaction->WagerID,
                        // 'seamless_transaction_id' => $requestTransaction->TransactionID
                    ],
                    [
                        'customer_id' => $event->customer_id, //change from  'user_id'=> $event->user_id,
                        'seamless_wager_id' => $requestTransaction->WagerID,
                        // 'seamless_transaction_id' => $requestTransaction->TransactionID,
                    ]
                );
            }
            if ($refund) {
                $wager->update([
                    'status' => WagerStatus::Refund,
                ]);
            } elseif ($wager && !$wager->wasRecentlyCreated) {
                $wager->update([
                    'status' => $requestTransaction->TransactionAmount > 0 ? WagerStatus::Win : WagerStatus::Lose,
                ]);
            }
            $game_type = GameType::where('code', $requestTransaction->GameType)->first();
            if (!$game_type) {
                throw new Exception("Game type not found for {$requestTransaction->GameType}");
            }
            $product = Product::where('code', $requestTransaction->ProductID)->first();
            if (!$product) {
                throw new Exception("Product not found for {$requestTransaction->ProductID}");
            }

            $game_type_product = GameTypeProduct::where('game_type_id', $game_type->id)
                ->where('product_id', $product->id)
                ->first();
            if (!$game_type_product) {
                throw new Exception("Product And Game Type Combination not found  ");
            }
            $rate = $game_type_product->rate;
            $user = Auth::user(); // Get the authenticated user
            $seamless_transactions[] = $event->transactions()->create([
                'customer_id' => $event->customer_id, // changed from 'user_id' => $event->use_id
                'wager_id' => $wager ? $wager->id : null,
                'game_type_id' => $game_type->id,
                'product_id' => $product->id,
                'seamless_transaction_id' => $requestTransaction->TransactionID,
                'rate' => $rate,
                'transaction_amount' => $requestTransaction->TransactionAmount,
                'bet_amount' => $requestTransaction->BetAmount,
                'valid_amount' => $requestTransaction->ValidBetAmount,
                'payout_amount' => $requestTransaction->PayoutAmount,
                'status' => $requestTransaction->Status,
                //'agent_id' => $user->agent_id
            ]);
        }
        return $seamless_transactions;
    }

    // public function processTransfer(User $from,User $to, TransactionName $transactionName, float $amount, int $rate, array $meta)
    public function processTransfer($from, $to, TransactionName $transactionName, float $amount, int $rate, array $meta)
    {
        // TODO: ask: what if operator doesn't want to pay bonus
        app(WalletService::class)
            ->transfer(
                $from,
                $to,
                abs($amount),
                $transactionName,
                $meta
            );
    }
}
