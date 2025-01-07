<?php

namespace App\Http\Requests\Topup;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Http\Requests\APIRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CreateTopupRequest extends APIRequest
{
    public function rules()
    {
        return [
            'amount' => 'required',
            'payment_provider' => 'required',
            'payment_transaction_id' => [
                'required',
                // Rule::unique('topup_transactions'),
                Rule::unique('topup_transactions')->where(function ($query) {
                    return $query->where('payment_provider', request('payment_provider'))
                        ->whereDate('created_at', Carbon::today());
                }),
            ],
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

    public function messages()
    {
        return [
            'payment_transaction_id.unique' => 'The payment transaction ID is Invalid.',
        ];
    }

    
}
