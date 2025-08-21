<?php

namespace App\Services\Slot;

use App\Enums\SlotWebhookResponseCode;

class SlotWebhookService
{
    public static function buildResponse(SlotWebhookResponseCode $responseCode, $balance, $before_balance)
    {
        return [
            'ErrorCode' => $responseCode->value,
            'ErrorMessage' => $responseCode->name,
            'Balance' => $balance,
            'BeforeBalance' => $before_balance,
        ];
    }

    public static function buildGscResponse(SlotWebhookResponseCode $responseCode, $memberCode, $productCode, $balance, $before_balance,$currencyRate)
    {
        $rate=$currencyRate->value;
        $convertedBalance = round($balance / $rate, 4);
        $convertedBeforeBalance = round($before_balance / $rate, 4);
        $data = [

            'member_account' => $memberCode,
            'product_code' => $productCode,
            'balance' => (float)$convertedBalance,
            'before_balance' => (float)$convertedBeforeBalance,
            'code' => $responseCode->value,
            'message' => $responseCode->name,
        ];
        return $data;
        // return ['data'=>[$data]];
    }
}
