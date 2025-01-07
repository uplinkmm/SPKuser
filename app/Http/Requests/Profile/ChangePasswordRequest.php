<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\APIRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ChangePasswordRequest extends APIRequest
{
    public function rules()
    {
        $userId=UserData()->id;
        return [
            'current_password' => ['required',
            function ($attribute, $value, $fail)use($userId) {
               if (!Hash::check($value, \App\Models\Customer::find($userId)->password)) {
                   $fail('Current Password didn\'t match');
               }
           },
        ],
           'new_password'=>['required','min:6','confirmed','different:current_password'],
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
