<?php
namespace App\Http\Action;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class SMSPoh
{

    private $customer;
    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    public function sendVerifcationCode()
    {
        $randCode = rand(111111, 999999);
        $this->customer->otp = $randCode;
        $this->customer->save();

        $apiSecret = env('SMS_POH_API_SECRET');
        $apiKey = env('SMS_POH_API_KEY');
        $apiEndPoint = env('SMS_POH_API_END_POINT');

        $combined = "$apiKey:$apiSecret"; // Combine API key and secret in the format <apiKey>:<apiSecret>

        $apiToken = base64_encode($combined);
        $decoded = base64_decode($apiToken);

        //payload
        $payload = [
            "from" => "Uplink-mm", // Sender name
            "to" => $this->customer->phone_number, // Recipient phone number
            "message" => "Your otp code is " . $this->customer->otp, // OTP message
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer $apiToken",
                'Content-Type' => 'application/json',
            ])->post($apiEndPoint, $payload);

            // Check for successful response
            if ($response->successful()) {
                // return response()->json(['success' => true, 'message' => 'OTP sent successfully.']);
                Log::error('OTP sent successfully.');
                return true;
            }

            // Log and return error response if request fails
            Log::error('Failed to send OTP:', ['response' => $response->body()]);
            return false;
            // return response()->json(['success' => false, 'message' => 'Failed to send OTP.'], $response->status());
        } catch (\Exception $e) {
            Log::error('Exception occurred while sending OTP:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'An error occurred while sending OTP.'], 500);
        }

        //         You must combine the API key and API secret using a colon (:) in the format <apiKey>:<apiSecret> and then encode
// this string using Base64 encoding to obtain the API Token. For example: base64encode(apiKey:apiSecret)

        // API Secret hash used blowfish hash algorithm.
// Authorization: Bearer Base64EncodedString==
    }
}