<?php

namespace App\Http\Requests\Auth;

use Illuminate\Validation\Rule;
use App\Http\Requests\APIRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OTPRequest extends APIRequest
{
    public function rules()
    {
        dd('abc');
        return [
            'phone_number' => [
                'required',
                Rule::unique('customers', 'phone_number')->where(function ($query) {
                    return $query->where('is_verified', 1);
                }),
            ],
        ];
    }
    public function messages()
    {
        return [
            'phone_number.unique' => 'The phone number has already been taken by a verified customer.',
        ];
    }
    public function authorize()
    {
        return parent::authorize();
    }

    public function failedValidation(Validator $validator)
    {
        parent::failedValidation($validator);
    //     $errors = $validator->errors();

    // throw new HttpResponseException(response()->json([
    //     'success' => false,
    //     'errors' => $errors,
    // ], 422));
    }
}
