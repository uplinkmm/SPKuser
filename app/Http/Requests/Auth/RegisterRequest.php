<?php

namespace App\Http\Requests\Auth;

use Illuminate\Validation\Rule;
use App\Http\Requests\APIRequest;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends APIRequest
{
    public function rules()
    {
        return [
            'name'=>'required|string',
            'phone_number' => [
                'required',
                'starts_with:09',
                Rule::unique('customers', 'phone_number')->where(function ($query) {
                    return $query->where('is_verified', 1);
                }),
            ],
            'password' => 'required|confirmed|min:6',
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
