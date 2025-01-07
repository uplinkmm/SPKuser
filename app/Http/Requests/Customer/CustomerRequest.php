<?php

namespace App\Http\Requests\Customer;

use Illuminate\Validation\Rule;
use App\Http\Requests\APIRequest;
use Illuminate\Contracts\Validation\Validator;

class CustomerRequest extends APIRequest
{
    public function rules()
    {
        return [
            'phone_number' => [
                'required',
                Rule::unique('customers', 'phone_number')->where(function ($query) {
                    return $query->where('is_verified', 1);
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
}
