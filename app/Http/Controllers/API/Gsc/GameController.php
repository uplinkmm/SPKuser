<?php

namespace App\Http\Controllers\API\Gsc;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class GameController extends Controller
{
    //
    private const WEB_PLAT_FORM = 0;

    private const ENG_LANGUAGE_CODE = 1;
    public function gameList(Request $request)
    {
        //Log::info($request->all());
        // Validate the request data
        $validatedData = $request->validate([
            'product_code' => 'required',
            'game_type' => 'required',
        ]);

        // Retrieve user and configuration settings
        $user = Auth::user();
        $operatorCode = Config::get('game.api.operator_code');
        $secretKey = Config::get('game.api.secret_key');
        $apiUrl = Config::get('game.api.url') . '/api/operators/provider-games';
        $password = Config::get('game.api.password');
        // Generate the signature
        $requestTime = now()->format('YmdHis');
        $signature = md5($requestTime . $secretKey . 'gamelist' . $operatorCode);

        // Prepare the payload
        $data = [
            'product_code' => $request->product_code,
            'operator_code' => $operatorCode,
            'sign' => $signature,
            'game_type' => $request->game_type,
            'request_time' => $requestTime,
        ];
        try {
            // Send the request
            $response = Http::withHeaders([
                // 'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
                ->timeout(120) // wait up to 120 seconds
                ->get($apiUrl, $data);
            if ($response->successful()) {
                return $response->json();
            }

            return response()->json(['error' => 'API request failed', 'details' => $response->body()], $response->status());
        } catch (\Throwable $e) {

            return response()->json(['error' => 'An unexpected error occurred', 'exception' => $e->getMessage()], 500);
        }
    }
    public function availableProduct(Request $request)
    {
        $user = Auth::user();
            $operatorCode = Config::get('game.api.operator_code');
            $secretKey = Config::get('game.api.secret_key');
            $apiUrl = Config::get('game.api.url') . '/api/operators/available-products';
            $password = Config::get('game.api.password');
            // Generate the signature
            $requestTime = now()->format('YmdHis');
            $signature = md5($requestTime . $secretKey . 'productlist' . $operatorCode);
            // Prepare the payload
            $data = [
                'operator_code' => $operatorCode,
                'sign' => $signature,
                'request_time' => $requestTime,
            ];
        try {
            // Send the request
            $response = Http::withHeaders([
                // 'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->get($apiUrl, $data);

            if ($response->successful()) {
                return $response->json();
            }

            return response()->json(['error' => 'API request failed', 'details' => $response->body()], $response->status());
        } catch (\Throwable $e) {

            return response()->json(['error' => 'An unexpected error occurred', 'exception' => $e->getMessage()], 500);
        }
    }

    public function launchGame(Request $request)
    {
        $user = Auth::user();
        $operatorCode = Config::get('game.api.operator_code');
        $secretKey = Config::get('game.api.secret_key');
        $apiUrl = Config::get('game.api.url') . '/api/operators/launch-game';
        $password = Config::get('game.api.password');
        // Generate the signature
        $requestTime = now()->format('YmdHis');
        $gameCode = $request->game_code;
        $productCode = $request->product_code;
        $gameType = $request->game_type;
        $signature = md5($requestTime . $secretKey . 'launchgame' . $operatorCode);
        $data = [
            'operator_code' => $operatorCode,
            'member_account' => $user->user_name,
            'nickname' => $user->name,
            'password' => $password,
            'currency' => 'MMK',
            'game_code' => $gameCode,
            'product_code' => $productCode,
            "language_code" => 0,
            'game_type' => $gameType,
            'ip' => request()->ip(),
            'platform' => 'WEB',
            'sign' => $signature,
            'request_time' => $requestTime,
            // 'operator_lobby_url' => Config::get('game.api.url'),
            'operator_lobby_url' => 'https://shwepaukkan.com',
        ];
        Log::info('Payload Data',[
            'data'=>$data,
            'api-url'=>$apiUrl
        ]);
        try {
            // Send the request
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($apiUrl, $data);
            Log::info('Response',[
                'body'=>$response->body(),
                'status'=>$response->status(),
            ]);
            if ($response->successful()) {
                return $response->json();
            }
            return response()->json(['error' => 'API request failed', 'details' => $response->body()], $response->status());
        } catch (\Throwable $e) {

            return response()->json(['error' => 'An unexpected error occurred', 'exception' => $e->getMessage()], 500);
        }
    }
}
