<?php

namespace App\Http\Requests\Gsc;

use App\Models\Customer;
use App\Services\Gsc\GscWebhookValidator;
use Illuminate\Foundation\Http\FormRequest;

class GscWebhookRequest extends FormRequest
{
    private ?Customer $member;

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
         // if (in_array($this->getMethodName(), ['balance'])) {
        //     $transaction_rules['batch_requests'] = ['required'];
        //     if ($this->getMethodName() !== 'getbalance') {
        //         $transaction_rules['Transaction'] = ['required'];
        //     }
        // } else {
        //     $transaction_rules['Transactions'] = ['required'];
        // }
        $transaction_rules = [];
        $transaction_rules['batch_requests'] = ['required'];
        return [
            'operator_code' => ['required'],
            'currency' => ['required'],
            'sign' => ['required'],
            'request_time' => ['required'],
            ...$transaction_rules,
        ];
    }
    public function check()
    {
        $validator = GscWebhookValidator::make($this)->validate();

        return $validator;
    }

    public function getMember()
    {
        // dd($this->member);
        if (! isset($this->member)) {
            $this->member = Customer::where('user_name', $this->getMemberName())->first();
        }

        return $this->member;
    }

    public function getMemberName()
    {
        // dd(collect($this->input('batch_requests'))->pluck('member_account'));
        $memberName=$this->input('batch_requests.0.member_account');
        // dd($memberName);
        return $memberName;
    }

    public function getProductID()
    {
        return $this->input('batch_requests.0.product_code');
    }

    public function getGameCode()
    {
        return $this->input('batch_requests.0.game_type');
    }

    public function getMessageID()
    {
        return $this->get('request_time');
    }

    public function getMethodName()
    {
        return strtolower(str($this->url())->explode('/')->last());
    }

    public function getOperatorCode()
    {
        return $this->get('operator_code');
    }

    public function getRequestTime()
    {
        return $this->get('request_time');
    }

    public function getSign()
    {
        return $this->get('sign');
    }

    public function getTransactions()
    {
        $transactions = $this->input('batch_requests.0.transactions', []);

        if ($transactions) {
            return $transactions;
        }

        $transaction = $this->get('batch_requests.0.transaction', []);

        if ($transaction) {
            return [$transaction];
        }

        return [];
    }
    public function getBatchRequest()
    {
        $transactions = $this->get('batch_requests', []);

        if ($transactions) {
            return $transactions;
        }

        $transaction = $this->get('batch_requests', []);

        if ($transaction) {
            return [$transaction];
        }

        return [];
    }
}
