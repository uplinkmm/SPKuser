<?php

namespace App\Http\Resources\WalletTransfer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletTransferListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'amount'=>$this->amount,
            'status'=>$this->status ?? 'completed',
            'account'=>$this->account ?? null,
            'date'=>$this->created_at,
            'transfer_type'=>$this->transfer_type == 'to_wallet' ?'Game To Main' : 'Main To Game',
        ];
    }
}
