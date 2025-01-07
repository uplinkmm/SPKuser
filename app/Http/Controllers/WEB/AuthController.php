<?php

namespace App\Http\Controllers\WEB;

use App\Models\Agent;
use App\Models\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $credentials = ['phone_number' => $request->phone_number, 'password' => $request->password];
        $remember = false;
        if($request->remember){
            $remember = true;
        }

        if(Auth::attempt($credentials, $remember)){
            return redirect()->route('home');
        }
        else{
            return redirect()->route('login');
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $request->session()->invalidate();
        Auth::logout();

        return redirect()->route('login');
    }

    public function redirectToProvider($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    public function handleProviderCallback($driver)
    {
        $isRegistered = false;
        Log::info('reach callback');
        Log::info($driver);
        try {
        Log::info('Before Retrieve Userdatda');
            $customer = Socialite::driver( $driver)->user();
            Log::info('Facebook User Data:', (array) $customer);

            if ($driver == 'facebook') {
                Log::info('Facebook User:', (array) $customer);
            }

        } catch (\Exception $e) {
            Log::info('Fail login');
            Log::error('Facebook login failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => request()->all(),
            ]);
            // return redirect()->route('login');
        }
        $existingUser = Customer::where('email', $customer->getEmail())
            ->first();
        if(!$existingUser){
            return redirect()->route('login_register');
        }
        if ($existingUser && $existingUser->is_verified == 1) {
            auth()->login($existingUser, true);
            Log::info('Social Login Page');
            return redirect()->route('social_phone_number')->with('customer', $existingUser);
            // ResponseData($existingUser, 201, true, 'Successfully registered and verified');
        } else {

            $newUser = new Customer;
            $newUser->provider_name = $driver;
            $newUser->provider_id = $customer->getId();
            $newUser->name = $customer->getName();
            $newUser->email = $customer->getEmail();
            $newUser->is_verified = 0;
            // $newUser->otp = 000000;
            // we set email_verified_at because the user's email is already veridied by social login portal
            // you can also get avatar, so create avatar column in database it you want to save profile image
            // $newUser->avatar            = $user->getAvatar();
            // return response()->json(['message' => 'Login successful', 'customer' => $newUser]);
            // Auth::login($newUser, true);
            // return redirect('/');
            // ResponseData($newUser);
            // return $newUser;
            return redirect()->route('social_phone_number')->with('customer', $newUser);
            // $newUser->save();
            // auth()->login($newUser, true);
        }
        // ResponseMessage('Yo');
        return redirect()->route('social_phone_number')->with('customer', $newUser);
        // ResponseData($existingUser);
        // return redirect('home');
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
}
