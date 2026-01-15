<?php

namespace App\Repositories\Profile;

use App\Models\Contact;
use App\Models\Customer;
use App\Http\Action\SMSPoh;
use Illuminate\Support\Facades\DB;

class ProfileRepository implements ProfileInterface
{
    public function getProfile($request)
    {
        $customer = Customer::select(['id', 'name', 'phone_number', 'verified_at'])
            ->with(['main_wallet'])
            ->findOrFail(UserData()->id);
        $contact = Contact::orderBy('id', 'asc')->get();
        $customer->main_money_balance = $customer->main_wallet->balance;
        $customer->game_money_balance = $customer->balanceFloat;
        $customer->contact = $contact;
        unset($customer['wallet']);
        unset($customer['main_wallet']);
        return $customer;
    }
    public function changePassword($request)
    {
        try {
            DB::beginTransaction();
            $customer = Customer::find(UserData()->id);

            // if (isset($request->otp)) {
                if (!$customer) {
                    ResponseMessage('Customer Not found', 404);
                }
                // if ($customer->getOtpCode() !== $request->otp) {
                //     ResponseMessage('OTP is incorrect, check SMS message again', 400);
                // }
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
                ResponseMessage('Password updated successfully', 200);
            // }
            // $isSuccess = (new SMSPoh($customer))->sendVerifcationCode();
            // if ($isSuccess) {
                // DB::commit();
            //     return response()->json(['success' => true, 'message' => 'OTP sent successfully.']);
            // }



        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
