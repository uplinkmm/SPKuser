<?php

namespace App\Http\Requests\WalletTransfer;

use App\Http\Requests\APIRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class WalletTransferRequest extends APIRequest
{
    public function rules()
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:1',
            'transfer_type' => 'required|in:to_game,to_wallet',
        ];
    }
    public function authorize()
    {
        return parent::authorize();
    }

    public function failedValidation(Validator $validator)
    {
        parent::failedValidation($validator);
    }
}
