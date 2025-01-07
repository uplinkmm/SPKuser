<?php

namespace App\Http\Requests\CashWithdrawl;

use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class CreateWithdrawlRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId=UserData();
        return [
            //
            'amount' => 'required',
            'account_name' => 'required',
            'phone_number' => 'required',
            'password' => 'required',
            // 'password' => ['required',   
            //     function ($attribute, $value, $fail)use($userId) {
            //        if (!Hash::check($value, \App\Models\Customer::find($userId)->password)) {
            //            $fail('Password is invalid');
            //        }
            //    },
            // ],
        ];
    }
}
