<?php

namespace App\Console\Commands;

use App\Models\WinningNumber;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class StoreWinningNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:winning-numbers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Call API and store the winning numbers at scheduled lottery times';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        //// Call the API
        // $response = Http::get('https://api.thaistock2d.com/live');
        $response = Http::get('https://admin.2dmyanmarpro.com/api/2d/live');
        $jsonResult = $response->json();
        // return $jsonResult;
        // dd($jsonResult['data']['results']);
        $today = Carbon::now();
        if ($today->isSaturday() || $today->isSunday()) {
            Log::info("No winning numbers stored today because it's a weekend.");
            return; // Exit the script without storing any data
        }
        // return $jsonResult['data']['results'];
        if (isset($jsonResult['data']['results'])) {
            DB::beginTransaction(); // Start the transaction
            try {
                foreach ($jsonResult['data']['results'] as $lottery) {
                    if ($lottery['history_id'] != null) {
                        $lotteryTime = Carbon::parse($lottery['stock_datetime']);
                        $lotteryDate = convertDateFormat($lottery['stock_datetime']);
                        // Store the result in the database
                        $winningNumber = WinningNumber::firstOrCreate(
                            [
                                'lottery_time' => $lottery['open_time'],
                                'date' => $lotteryDate,
                                'type' => 'two_d',

                            ],  // Unique identifier for the record
                            [
                                'two_d' => $lottery['twod'],
                                'modern' => null,  // Add appropriate value if needed
                                'internet' => null,  // Add appropriate value if needed
                                'tw' => null,  // Add appropriate value if needed
                                'set' => $lottery['set'],
                                'value' => $lottery['value'],
                                'date_time' => $lotteryTime,
                                'lottery_time' => $lottery['open_time'],
                                'type' => 'two_d',
                            ]
                        );

                        Log::info("Winning number for time {$lottery['open_time']} stored successfully.");
                    }
                    // Parse the open time and current time to determine if it's time to store

                }

                foreach ($jsonResult['data']['modern_internet']['numbers'] as $number) {
                    $convertedTime = Carbon::parse($number['time'])->format('H:i');
                    $convertedDate = convertDateFormat('now');
                    // return $number;
                    // if ($number['Modern'] != '--') {
                        $winningNumber = WinningNumber::updateOrCreate(
                            [
                                'lottery_time' => $convertedTime,
                                'date' => $convertedDate,
                                'type' => 'internet_modern',
                            ],  // Unique identifier for the record
                            [
                                'modern' => $number['Modern'] != '--' ? $number['Modern'] : null,  // Add appropriate value if needed
                                'internet' => $number['Internet'] != '--' ? $number['Internet'] : null,  // Add appropriate value if needed
                                'date_time' => $convertedDate,
                                'lottery_time' => $convertedTime,
                                'date' => $convertedDate,
                                'type' => 'internet_modern',
                            ]
                        );
                    // }
                }
                // return $jsonResult['data']['modern_internet']['numbers'];

                DB::commit(); // Commit the transaction if everything is successful
            } catch (\Exception $e) {
                DB::rollBack(); // Rollback the transaction if any error occurs
                Log::error('Failed to store winning numbers: ' . $e->getMessage());
                throw $e; // Optionally rethrow the exception to handle it further up the chain
            }
        }
    }
}
