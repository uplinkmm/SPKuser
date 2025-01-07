<?php

namespace App\Http\Controllers\API;

use Exception;

use App\Models\User;
use App\Models\Agent;

use App\Models\Customer;

use Illuminate\Http\Request;

use App\Models\PersonFcmToken;

use Illuminate\Support\Facades\DB;
use App\Actions\Auth\APILoginAction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Customer\CustomerRequest;
use App\Http\Requests\Customer\ForgetPasswordRequest;
use App\Repositories\CustomerMoney\CustomerMoneyRepositoryInterface;

class AuthController extends Controller
{
    //
    private $moneyRepo;

    public function __construct(CustomerMoneyRepositoryInterface $repo)
    {
        $this->moneyRepo = $repo;
    }

    public function login(Request $request)
    {
        $loginResponse = (new APILoginAction('phone_number', $request->phone_number, $request->password, 'App\Models\Customer'))->run('customer_token');
        $loginResponse['user']['login_type'] = 'customer';
        if ($loginResponse["code"] != 200) {
            ResponseMessage($loginResponse["message"], 401);
        } else {
            $this->storeFcmToken($request->fcm_token, $loginResponse['user']['id']);
            ResponseData($loginResponse, 200, true, 'Success, logging in');
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        ResponseMessage('Successfully logged out');
    }

    public function initialRegister(Request $request)
    {
        $customerData = [
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'password' => rand(0000, 9999),
            // 'otp' => rand(000000, 999999),
            'otp' => '000000',
        ];

        try {
            Customer::firstOrCreate(
                ['phone_number' => $request->phone_number, 'is_verified' => 0],
                $customerData // Default values to create a new user
            );
            ResponseMessage('OTP sent, check SMS message');
        } catch (Exception $e) {
            ResponseMessage($e->getMessage(), 400);
        }
    }

    public function getCodeWithPhoneNumber(Request $request)
    {
        $phoneNumber = $request->phone_number;
        $customer = Customer::where('phone_number', $phoneNumber)->first();
        if (!$customer) {
            return ResponseMessage('Customer not found with given phone number', 404);
        }
        if ($customer->provider_id != null || $customer->provider_name != null) {
            ResponseMessage('Forget password is invalid,', 419);
        }
        $customer->otp = '000000';
        $customer->save();
        ResponseMessage('OTP sent, check SMS message');
    }
    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $phoneNumber = $request->phone_number;
        $customer = Customer::where('phone_number', $phoneNumber)->first();
        if (!$customer) {
            ResponseMessage('Customer not found with given phone number', 404);
        }
        if ($customer->getOtpCode() !== $request->otp) {
            ResponseMessage('OTP is incorrect, check SMS message again', 400);
        }
        DB::beginTransaction();

        try {
            $customer->password = Hash::make($request->password);
            $customer->save();
            $customer->tokens()->delete();
            $login_response = [
                "user" => $customer,
                "token" => $customer->createToken('customer_token')->plainTextToken,
                "code" => 200,
                "success" => true,
                "message" => 'Authenticated'
            ];

            DB::commit();
            ResponseData($login_response, 201, true, 'Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseMessage($e->getMessage(), 500);
        }
        ResponseMessage('Something went wrong!', 400);

    }
    public function register(Request $request)
    {
        $customer = Customer::where('phone_number', $request->phone_number)->first();
        if (!$customer) {
            ResponseMessage('Customer not found with given phone number', 400);
        }

        if ($customer->getOtpCode() != $request->otp) {
            // $customer->otp = rand(000000, 999999);
            // $customer->save();

            ResponseMessage('OTP not correct, check SMS message again', 400);
        }
        if ($customer->getOtpCode() == $request->otp) {
            DB::beginTransaction();
            try {
                $customer->password = $request->password;
                $customer->is_verified = 1;
                // $customer->agggent
                $customer->verified_at = CurrentTime();
                $customer->save();

                // $this->moneyRepo->createPointBag($customer->id);
                // $this->moneyRepo->createGameWallet($customer);
                $this->moneyRepo->createWallet($customer->id);

                $loginResponse = (new APILoginAction('phone_number', $request->phone_number, $request->password, 'App\Models\Customer'))->run('customer_token');
                $loginResponse['user']['login_type'] = 'customer';
                DB::commit();
                $this->storeFcmToken($request->fcm_token, $customer->id);
                #implement agent to user
                $this->storeAgent($request->code, $customer->id);
                ResponseData($loginResponse, 201, true, 'Successfully registered and verified');
            } catch (Exception $e) {
                DB::rollBack();
                ResponseMessage($e->getMessage(), 500);
            }
        }
    }
    public function storeFcmToken($token, $customerId)
    {
        // Log::info('token ' , (array)$token);
        if ($token && $token != "null") {
            $personToken = PersonFcmToken::firstOrCreate(
                [
                    'fcm_token' => $token,
                    'personable_id' => $customerId,
                    'personable_type' => 'customer',

                ],
                [
                    'fcm_token' => $token,
                    'personable_id' => $customerId,
                    'personable_type' => 'customer'
                ]
            );
            return $personToken;
        }
    }

    public function storeAgent($code, $customer_id)
    {
        if ($code !== null && $code !== "" && $code !== "null") {
            $agent = Agent::where('code', $code)->first();
            if ($agent) {
                $customer = Customer::find($customer_id);
                $customer->agent_id = $agent->id;
                $customer->save();
            } else {
                ResponseMessage('Code is missing', 419);
            }
        }
    }

    public function socialRegister(Request $request)
    {
        // dd($request->customer);
        DB::beginTransaction();
        try {
            $phoneNumber = $request->phone_number;
            // $socailCustomer = json_decode($request->customer);
            $existingUser = Customer::where('phone_number', $phoneNumber)
                // ->where('is_verified', $request->is_verified)
                ->first();
            if ($existingUser && $existingUser->is_verified && $existingUser->email === $request->email) {
                $customer = $existingUser;
            } elseif ($existingUser && $existingUser->email !== $request->email) {
                ResponseMessage('Register Fail !Phone number is already exist');
            } else {
                $customer = new Customer();
                $customer->name = $request->name;
                $customer->phone_number = $phoneNumber;
                $customer->provider_name = $request->provider_name;
                $customer->provider_id = $request->provider_id;
                $customer->email = $request->email;
                $customer->email_verified_at = now();
                $customer->created_at = now();
                $customer->updated_at = now();
                $customer->is_verified = 1;
                $customer->otp = 000000;
                $customer->save();
            }
            $this->storeFcmToken($request->fcm_token, $customer->id);
            $this->storeAgent($request->code, $customer->id);
            $login_response = [
                "token" => null,
                "code" => 401,
                "success" => false,
                "message" => null
            ];
            $login_response["user"] = $customer;
            $login_response["token"] = $customer->createToken('App\Models\Customer')->plainTextToken;
            $login_response["code"] = 200;
            $login_response["success"] = true;
            $login_response["message"] = 'Authenticated';
            DB::commit();
            ResponseData($login_response, 201, true, 'Successfully registered and verified');
            // return $betting;
        } catch (\Exception $e) {
            DB::rollback();
            ResponseMessage($e->getMessage(), 402);
            throw $e;
        }
        // $newUser = new Customer;
        //     $newUser->provider_name = $driver;
        //     $newUser->provider_id = $customer->getId();
        //     $newUser->name = $customer->getName();
        //     $newUser->email = $customer->getEmail();
        //     // we set email_verified_at because the user's email is already veridied by social login portal
        //     $newUser->email_verified_at = now();
        //     // you can also get avatar, so create avatar column in database it you want to save profile image
        //     // $newUser->avatar            = $user->getAvatar();
        //     return view('Auth.social_phone_number', ['customer' => $newUser]);

        //     $newUser->save();

        //     auth()->login($newUser, true);
    }

    public function checkRegister(Request $request)
    {
        // dd($request->customer);
        DB::beginTransaction();
        try {
            $existingUser = Customer::where('email', $request->email)
                ->where('is_verified', operator: 1)
                ->first();
            if ($existingUser) {
                ResponseData($existingUser);
            }
            // ResponseMessage('User is already regisered with this email', 409);
            ResponseMessage('Check email fail', 419);
        } catch (\Exception $e) {
            DB::rollback();
            ResponseMessage($e->getMessage(), 402);
            throw $e;
        }
        // $newUser = new Customer;
        //     $newUser->provider_name = $driver;
        //     $newUser->provider_id = $customer->getId();
        //     $newUser->name = $customer->getName();
        //     $newUser->email = $customer->getEmail();
        //     // we set email_verified_at because the user's email is already veridied by social login portal
        //     $newUser->email_verified_at = now();
        //     // you can also get avatar, so create avatar column in database it you want to save profile image
        //     // $newUser->avatar            = $user->getAvatar();
        //     return view('Auth.social_phone_number', ['customer' => $newUser]);

        //     $newUser->save();

        //     auth()->login($newUser, true);
    }
}
