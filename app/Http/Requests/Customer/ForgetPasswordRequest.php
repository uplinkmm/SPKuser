<?php

namespace App\Http\Requests\Customer;
use Illuminate\Validation\Rule;
use App\Http\Requests\APIRequest;
use Illuminate\Contracts\Validation\Validator;

class ForgetPasswordRequest extends APIRequest
{
    public function rules()
    {
        // $phoneNumber = $this->get('phone_number');
        return [
            'phone_number' => [
                'required',
            ],
            'otp' => [
                'required',
            ],
            'password' => ['required', 'min:6', 'confirmed'],

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
