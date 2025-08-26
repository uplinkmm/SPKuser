<?php

namespace App\Http\Controllers\Api\Gsc;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Http\Requests\Gsc\GscWebhookRequest;
use App\Http\Controllers\Api\V1\Webhook\Traits\GscWebhook;

class PushBetDataController extends Controller
{
  //
    use GscWebhook;
  public function pushBetData(GscWebhookRequest $batchRequest)
  {
    foreach ($batchRequest['wagers'] as $batch) {
      $request = new GscWebhookRequest($batch);
      $request['operator_code'] = $batchRequest->operator_code;
      $request['sign'] = $batchRequest->sign;
      $request['request_time'] = $batchRequest->request_time;
      $request['url'] = $batchRequest->url();
      $userId = $request->getMember() ? $request->getMember()->id : null;

       $validator = $request->check();

        if ($validator->fails()) {
          // Release Redis lock and return validation error response
          // tem redis
          // Redis::del("wallet:lock:$userId");
          // temp redis
          $data[] = $validator->getResponse();
          return response()->json([
            'data' => $data
          ]);
        }
      DB::beginTransaction();
      try {
        // Create and store the event in the database
       
        $event = $this->createEvent($request);
        // Insert bets using chunking for better performance
        // $seamless_transactions = $this->createWagerTransactions($validator->getRequestTransactions(), $event);
        $seamless_transactions = $this->updateAndCreateWager($batch, $event);
      } catch (\Exception $e) {
        DB::rollBack();
        Redis::del("wallet:lock:$userId");
        Log::error('Error during placeBet', ['error' => $e]);

        return response()->json(['message' => $e->getMessage()], 500);
      }

    }
  }
}
