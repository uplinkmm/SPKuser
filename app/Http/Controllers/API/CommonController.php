<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    //
    public function getAccount(Request $request)
    {
        $data = Account::orderBy('accounts.id', 'ASC')
            ->whereIn('account_type',['kpay','wave','aya_pay'])
            ->where('is_active', 1)
            ->get();
        ResponseData($data);
    }
}
