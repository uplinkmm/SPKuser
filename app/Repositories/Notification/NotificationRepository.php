<?php

namespace App\Repositories\Notification;

use App\Models\CustomerWallet;
use App\Models\NotificationPerson;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class NotificationRepository implements NotificationInterface
{
    public function notificationList($request)
    {
        $bearerToken = $request->bearerToken();
        $currentAccessToken = $request->user()->currentAccessToken();
        dd($currentAccessToken);
        $guard = auth()->guard();  // Get the current guard
    
        // Check the type of the guard and log its name
        Log::info('Current guard: ' . get_class($guard));
    
        // You can also log the user and access token
        Log::info('Authenticated user: ', [auth()->user()]);
        Log::info('Current access token: ', [auth()->user()?->currentAccessToken()]);


//         Log::info('Auth guard: ' . auth()->guard()->getName());
// Log::info('Authenticated user: ', [auth()->user()]);
// Log::info('Current access token: ', [auth()->user()?->currentAccessToken()]);
//         dd($currentAccessToken);
//         Log::info('Bearer Token: ' . $request->bearerToken());
//         $token = PersonalAccessToken::findToken('58|cHrb0RouqoIWEArRvBQhBHWjq30q9WSri51tCDbJ43f5e703');
// if ($token) {
//     Log::info('Token found: ' . $token->id);
// } else {
//     Log::info('Token not found in the database.');
// }
        // Log::info('Current Access Token: ' . $currentAccessToken);

        // $type = $request->type == 'topup_transaction' ? ['topup_transaction', 'cash_withdrawl_transaction'] : ['betting_win', 'twist_win_number'];
        if($request->type=='topup_transaction'){
            $type=['topup_transaction', 'cash_withdrawl_transaction'];
        }elseif($request->type=='betting_win'){
            $type=['betting_win', 'twist_win_number'];
        }else{
            $type=['ads'] ;
        }
        if($bearerToken){
            $userId =  UserData()->id;
        }else{
            $userId=null;
        }

        if ((int) $request->is_count == 1) {
            NotificationPerson::where('personable_type', 'customer')
                ->where('personable_id', $userId)
                ->where('is_read_count', 0)
                ->update(['is_read_count' => 1]);
        }
        $notificationQuery = NotificationPerson::orderBy('notification_people.id', 'desc')
            ->where('personable_type', 'customer')
            ->where('personable_id', $userId)
            ->join('notifications', 'notification_people.notification_id', 'notifications.id')
            ->select('notification_people.id', 'title', 'preview', 'date_time', 'is_read', 'is_read_count', 'notifications.notificationable_type');
        // Adding status for topup_transaction and cash_withdrawl_transaction
        $notificationQuery->leftJoin('topup_transactions', function ($join) {
            $join->on('notifications.notificationable_id', '=', 'topup_transactions.id')
                ->where('notifications.notificationable_type', 'topup_transaction');
        })
            ->leftJoin('cash_withdrawl_transactions', function ($join) {
                $join->on('notifications.notificationable_id', '=', 'cash_withdrawl_transactions.id')
                    ->where('notifications.notificationable_type', 'cash_withdrawl_transaction');
            })
             ->leftJoin('ads', function ($join) {
                $join->on('notifications.notificationable_id', '=', 'ads.id')
                    ->where('notifications.notificationable_type', 'ads');
            })
            ->leftJoin('accounts as topup_account', function ($join) {
                $join->on('topup_transactions.account_id', '=', 'topup_account.id');
            })
            ->leftJoin('accounts as cash_withdrawl_account', function ($join) {
                $join->on('cash_withdrawl_transactions.account_id', '=', 'cash_withdrawl_account.id');
            })
            ->addSelect(DB::raw("CASE 
    WHEN notifications.notificationable_type = 'topup_transaction' THEN topup_transactions.status 
    WHEN notifications.notificationable_type = 'cash_withdrawl_transaction' THEN cash_withdrawl_transactions.status 
    ELSE null END as status"),
    DB::raw("CASE 
    WHEN notifications.notificationable_type = 'ads' THEN ads.photo 
    ELSE null END as photo"),
    DB::raw("
            CASE 
                WHEN notifications.notificationable_type = 'topup_transaction' AND topup_transactions.status = 'confirmed' THEN topup_transactions.confirmed_at
                WHEN notifications.notificationable_type = 'topup_transaction' AND topup_transactions.status = 'rejected' THEN topup_transactions.rejected_at
                WHEN notifications.notificationable_type = 'cash_withdrawl_transaction' AND cash_withdrawl_transactions.status = 'confirmed' THEN cash_withdrawl_transactions.confirmed_at
                WHEN notifications.notificationable_type = 'cash_withdrawl_transaction' AND cash_withdrawl_transactions.status = 'rejected' THEN cash_withdrawl_transactions.rejected_at
                ELSE null 
            END as transaction_date
        "),
    // DB::raw("CASE 
    // WHEN notifications.notificationable_type = 'topup_transaction' THEN topup_transactions.confirmed_at 
    // WHEN notifications.notificationable_type = 'cash_withdrawl_transaction' THEN cash_withdrawl_transactions.confirmed_at 
    // ELSE null END as confirmed_at"),
    // DB::raw("CASE 
    // WHEN notifications.notificationable_type = 'topup_transaction' THEN topup_transactions.rejected_at 
    // WHEN notifications.notificationable_type = 'cash_withdrawl_transaction' THEN cash_withdrawl_transactions.rejected_at 
    // ELSE null END as rejected_at"),
    DB::raw("CASE 
    WHEN notifications.notificationable_type = 'topup_transaction' THEN topup_transactions.amount 
    WHEN notifications.notificationable_type = 'cash_withdrawl_transaction' THEN cash_withdrawl_transactions.amount 
    ELSE null END as amount"),
    DB::raw("
            CASE 
                WHEN notifications.notificationable_type = 'topup_transaction' THEN topup_account.name
                WHEN notifications.notificationable_type = 'cash_withdrawl_transaction' THEN cash_withdrawl_account.name
                ELSE null 
            END as provider_name
        "),
    DB::raw("CASE 
    WHEN notifications.notificationable_type = 'topup_transaction' THEN topup_transactions.payment_transaction_id 
    ELSE null END as payment_transaction_id"));
        $countOfUnRead = $notificationQuery->clone()->where('is_read_count', 0)->count();
        $notificaitonList = $notificationQuery
            ->whereIn('notifications.notificationable_type', $type)
            ->paginate(20);
        $data['notification_list'] = $notificaitonList;
        $data['count'] = $countOfUnRead;
        $userData = new \stdClass();
        $balance = CustomerWallet::where('customer_id', UserData()->id)->first();
        if($userId){
            $userData->balance = $balance ? $balance->balance : 0;
            $userData->name = UserData()->name;
            $userData->game_money_balance=UserData()->balanceFloat;
        }else{
            // $userData->balance=0;
            // $userData->game_money_balance=0;
            // $userData->name=null;
            $userData=null;
        }
        $data['user'] = $userData;
        return $data;
        // Base query for notification retrieval
        //       $notificationQuery = NotificationPerson::orderBy('notification_people.id', 'desc')
        //       ->where('personable_type', 'customer')
        //       ->where('personable_id', $userId)
        //       ->join('notifications', 'notification_people.notification_id', '=', 'notifications.id')
        //       ->select(
        //           'notification_people.id',
        //           'title',
        //           'preview',
        //           'date_time',
        //           'is_read',
        //           'is_read_count',
        //           \DB::raw('(SELECT COUNT(*) FROM notification_people np
        //                       WHERE np.personable_type = "customer"
        //                       AND np.personable_id = ' . $userId . '
        //                       AND np.is_read_count = 0) as unread_count')
        //       );

        //   // Retrieve notification data
        //   $notificationList = $notificationQuery
        //       ->where('notifications.notificationable_type', $request->type)
        //       ->paginate(20);

        //   // Extract the unread count from the first item (since it's the same for all)
        //   $unreadCount = $notificationList->isNotEmpty() ? $notificationList->first()->unread_count : 0;

        //   $data['notification_list'] = $notificationList;
        //   $data['count'] = $unreadCount;

        // return $data;
    }
}
