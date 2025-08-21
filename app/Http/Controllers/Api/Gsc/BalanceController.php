<?php

namespace App\Http\Controllers\Api\Gsc;

use App\Enums\CurrencyRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Enums\SlotWebhookResponseCode;
use App\Services\Slot\SlotWebhookService;
use App\Services\Slot\SlotWebhookValidator;
use App\Http\Requests\Gsc\GscWebhookRequest;
use App\Http\Requests\Slot\SlotWebhookRequest;
use App\Services\Gsc\GscWebhookValidator;

class BalanceController extends Controller
{
    //
    public function getBalance(GscWebhookRequest $request)
    {
        DB::beginTransaction();
        try {

            $data = [];
            foreach ($request->input('batch_requests', []) as $batch) {
                $batchRequest = new GscWebhookRequest($batch);
                $balance = $batchRequest->getMember()->balanceFloat;
                $member = $batchRequest->getMember();
                $batchRequest['operator_code'] = $request->operator_code;
                $batchRequest['sign'] = $request->sign;
                $batchRequest['request_time'] = $request->request_time;
                $batchRequest['url'] = $request->url();
                $currencyRate = CurrencyRate::fromName($request->currency);
                $validator = GscWebhookValidator::make($batchRequest)->validate();
                if ($validator->fails()) {
                    return $validator->getResponse();
                }
                if (!$currencyRate) {
                    return SlotWebhookService::buildGscResponse(
                        SlotWebhookResponseCode::InternalServerError,
                        $member->user_name,
                        $request->getProductID(),
                        $balance,
                        $balance,
                        1,
                    );
                }
                // $data[]=[
                //     'member_account'=>$batchRequest->member_account,
                //     'product_code'=>$batchRequest->member_account,
                //     'balance'=>$balance,
                //     'code'=>SlotWebhookResponseCode::Success->value,
                //     'message'=>SlotWebhookResponseCode::Success->name,
                // ];
                $data[] = SlotWebhookService::buildGscResponse(
                    SlotWebhookResponseCode::Success,
                    $member->user_name,
                    $request->getProductID(),
                    $balance,
                    $balance,
                    $currencyRate->value,
                );
            }
            return response()->json([
                'data' => $data
            ]);
            // dd('incorrect');
            // DB::commit();
            // return SlotWebhookService::buildGscResponse(
            //     SlotWebhookResponseCode::Success,
            //     $member->user_name,
            //     $request->getProductID(),
            //     $balance,
            //     $balance
            // );
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }
}
