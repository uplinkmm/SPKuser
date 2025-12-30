<?php

namespace App\Http\Controllers\Api\Gsc;

use App\Enums\CurrencyRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Enums\SlotWebhookResponseCode;
use App\Services\Slot\SlotWebhookService;
use App\Http\Requests\Gsc\GscWebhookRequest;
use App\Http\Controllers\Api\V1\Webhook\Traits\GscWebhook;

class PushBetDataController extends Controller
{
  //
  use GscWebhook;
  public function pushBetData(GscWebhookRequest $batchRequest)
  {
    // $data=[];
    foreach ($batchRequest['wagers'] as $batch) {
      $request = new GscWebhookRequest($batch);
      $request['operator_code'] = $batchRequest->operator_code;
      $request['sign'] = $batchRequest->sign;
      $request['request_time'] = $batchRequest->request_time;
      $request['url'] = $batchRequest->url();
      $request['currency'] = $batch['currency'];
      $userId = $request->getMember() ? $request->getMember()->id : null;
      $currencyRate = CurrencyRate::fromName($batch['currency']);
      if (!$currencyRate) {
        return SlotWebhookService::buildGscResponse(
          SlotWebhookResponseCode::InternalServerError,
          $request->getMember()->user_name,
          $request->getProductID(),
          $request->getMember() ? $request->getMember()->balanceFloat : 0,
          $request->getMember() ? $request->getMember()->balanceFloat : 0,
          1,
        );
      }
      $validator = $request->check();

      if ($validator->fails()) {
        // Release Redis lock and return validation error response
        // tem redis
        // Redis::del("wallet:lock:$userId");
        // temp redis 
        return $validator->getResponse();
      }

      $before_balance = $request->getMember() ? $request->getMember()->balanceFloat : 0;

      DB::beginTransaction();
      try {
        // Create and store the event in the database

        $event = $this->createEvent($request);
        // Insert bets using chunking for better performance
        // $seamless_transactions = $this->createWagerTransactions($validator->getRequestTransactions(), $event);
        $seamless_transactions = $this->updateAndCreateWager($batch, $event);
        $request->getMember()->wallet->refreshBalance();
        $after_balance = $request->getMember()->balanceFloat;
        DB::commit();  // Commit only the bet insertion
        $data[] = SlotWebhookService::buildGscResponse(
          SlotWebhookResponseCode::Success,
          $request->getMember()->user_name,
          $request->getProductID(),
          $after_balance,
          $before_balance,
          $currencyRate->value
        );
      } catch (\Exception $e) {
        DB::rollBack();
        Redis::del("wallet:lock:$userId");
        Log::error('Error during placeBet', ['error' => $e]);

        return response()->json(['message' => $e->getMessage()], 500);
      }

    }
    return response()->json([
      'data' => $data
    ]);
  }
}
