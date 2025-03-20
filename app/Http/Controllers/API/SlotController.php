<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class SlotController extends Controller
{
    //
    public function getGameList(Request $request)
    {
        $name=$request->name;
        $productCode=$request->product_code;
        $gameType=$request->game_type;
        $requestDateTime = requestDateTimeFormat();
        // $requestDateTime='2024-11-05 09:30:00';
        $hash = GenerateMD5Hash($name, $requestDateTime, null);
        // return [$hash,$requestDateTime];
        $url = env('SEAMLESS_API_URL') . '/Seamless/GetGameList';
        $data = [
            'OperatorCode' => env('SEAMLESS_OPERATOR_CODE'),
            'MemberName	' => 'Tester',
            'DisplayName' => 'f61bd50815a4c3656ae5b4e46c2bfc08',
            'RequestTime' => $requestDateTime,
            'Sign' => $hash,
            'Password' => "TESTERPASSWORD",
            'ProductID' => $productCode,
            'GameType' => $gameType,
            'LanguageCode' => "1",
            'Platform' => "0",
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, $data);

        if ($response->successful()) {
            // Handle successful response
            return response()->json([
                'status' => 'success',
                'data' => $response->json()
            ]);
        } else {
            // Handle error
            return response()->json([
                'status' => 'error',
                'message' => $response->body()
            ], $response->status());
        }
        // ResponseData($response->json());
    }

    // public function launchGame()
    // {
    //     $requestDateTime = requestDateTimeFormat();
    //     $hash = GenerateMD5Hash('LaunchGame', $requestDateTime, null);
    //     $url = env('STAGING_URL') . 'Seamless/LaunchGame';
    //     $data = [
    //         'OperatorCode' => env('OPERATOR_ID'),
    //         'MemberName	' => 'Tester',
    //         'DisplayName' => 'f61bd50815a4c3656ae5b4e46c2bfc08',
    //         'RequestTime' => $requestDateTime,
    //         'Sign' => $hash,
    //         'Password' => "TESTERPASSWORD",
    //         'ProductID' => "1091",
    //         "GameID" => "2",
    //         'GameType' => "1",
    //         'LanguageCode' => "1",
    //         'Platform' => "0",
    //     ];

    //     $response = Http::withHeaders([
    //         'Content-Type' => 'application/json',
    //     ])->post($url, $data);
    //     if ($response->successful()) {
    //         // Handle successful response
    //         return response()->json([
    //             'status' => 'success',
    //             'data' => $response->json()
    //         ]);
    //     } else {
    //         // Handle error
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $response->body()
    //         ], $response->status());
    //     }
    // }

    // public function getGameList()
    // {
    //     $requestDateTime = requestDateTimeFormat();
    //     $hash = GenerateMD5Hash('GetGameProvider', $requestDateTime, null);
    //     $data = [
    //         'OperatorCode' => env('OPERATOR_ID'),
    //         'MemberName' => 'Tester',
    //         'DisplayName' => 'f61bd50815a4c3656ae5b4e46c2bfc08',
    //         'RequestTime' => $requestDateTime,
    //         'Sign' => $hash,
    //         'Password' => "TESTERPASSWORD",
    //         'ProductID' => "1091",
    //         'GameType' => "1",
    //         'LanguageCode' => "1",
    //         'Platform' => "0",
    //     ];
    //     return $this->makeRequest('Seamless/GetGameList', $data);
    // }

    public function launchGame()
    {
        $requestDateTime = requestDateTimeFormat();
        $hash = GenerateMD5Hash('LaunchGame', $requestDateTime, null);
        $data = [
            'OperatorCode' => env('OPERATOR_ID'),
            'MemberName' => 'Tester',
            'DisplayName' => 'f61bd50815a4c3656ae5b4e46c2bfc08',
            'RequestTime' => $requestDateTime,
            'Sign' => $hash,
            'Password' => "TESTERPASSWORD",
            'ProductID' => "2",
            // 'GameID' => "2",
            'GameType' => "1",
            'LanguageCode' => "1",
            'Platform' => "0",
        ];
        return $this->makeRequest('Seamless/LaunchGame', $data);
    }

    private function makeRequest($endpoint, $data)
    {
        $url = env('STAGING_URL') . $endpoint;
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, $data);

        if ($response->successful()) {
            return response()->json([
                'status' => 'success',
                'data' => $response->json()
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => $response->body()
            ], $response->status());
        }
    }

}
