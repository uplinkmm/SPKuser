<?php

namespace App\Http\Controllers\Api\Gsc;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Enums\SlotWebhookResponseCode;
use App\Services\Slot\SlotWebhookService;
use App\Http\Requests\Gsc\GscWebhookRequest;
use App\Http\Requests\Slot\SlotWebhookRequest;

class BalanceController extends Controller
{
    //
    public function getBalance(GscWebhookRequest $request)
    {
        DB::beginTransaction();
        try {


            // $validator = SlotWebhookValidator::make($request)->validate();

            // if ($validator->fails()) {
            //     return $validator->getResponse();
            // }
            $balance = $request->getMember()->balanceFloat;
            $member=$request->getMember();
            DB::commit();
            return SlotWebhookService::buildGscResponse(
                SlotWebhookResponseCode::Success,
                $member->user_name,
                $request->getProductID(),
                $balance,
                $balance
            );
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }
}
