<?php

namespace App\Repositories\Profile;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class ProfileRepository implements ProfileInterface
{
    public function getProfile($request)
    {
        $customer = Customer::select(['id', 'name', 'phone_number', 'verified_at'])
        ->with(['main_wallet'])
        ->findOrFail(UserData()->id);
        $customer->main_money_balance=$customer->main_wallet->balance;
        $customer->game_money_balance=$customer->balanceFloat;
        unset($customer['wallet']);
        unset($customer['main_wallet']);
        return $customer;
    }
    public function changePassword($request)
    {
        try {
            DB::beginTransaction();
            $customer = Customer::find(UserData()->id);
            if (!$customer) {
                ResponseMessage('Customer Not found', 404);
            }
            $customer->fill([
                'password' => $request->new_password,
            ])->save();
            // $data["user"] = $customer;
            // $data["token"] = $customer->createToken('customer_token')->plainTextToken;
            // $data["code"] = 200;
            // $data["success"] = true;
            // $data["message"] = 'Authenticated';
            // ResponseData($data, 200, true, 'Password updated successfully');
            DB::commit();
            ResponseMessage('Password updated successfully',200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
