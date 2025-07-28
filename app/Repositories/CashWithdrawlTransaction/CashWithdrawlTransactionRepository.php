<?php

namespace App\Repositories\CashWithdrawlTransaction;

use App\Http\Action\WalletTransactionCommon;
use Exception;

use App\Models\User;

use App\Models\CustomerWallet;
use App\Traits\SendNotification;

use Illuminate\Support\Facades\DB;
use App\Models\CashWithdrawlTransaction;
use App\Repositories\CashWithdrawlTransaction\CashWithdrawlTransactionRepositoryInterface;

class CashWithdrawlTransactionRepository implements CashWithdrawlTransactionRepositoryInterface
{
    use WalletTransactionCommon, SendNotification;
    public function createTransaction(array $data)
    {
        $wallet = CustomerWallet::where('customer_id', $data['customer_id'])->first();
        if (!$wallet || $wallet->balance < 1) {
            ResponseMessage('Cash withdrawal request failed, you have zero balance', 402);
        }
        if ($data['amount'] > $wallet->balance) {
            ResponseMessage('Cash withdrawal request failed, insufficient balance', 402);
        }
        $transactionId = 'CW' . now()->format('YmdHis');
        $data['transactionId'] = $transactionId;
        $data['createdable_id'] = UserData()->id;
        $data['createdable_type'] = 'customer';
        try {
            DB::beginTransaction();
            $withdrawl = CashWithdrawlTransaction::create($data);
            if ($withdrawl) {
                $data['title'] = 'Admin';
                $data['body'] = 'has just withdrawal by ' . $withdrawl->account->name;
                $data['date_time'] = now();
                $users = User::all();
                $this->send($withdrawl, $users, $data);
                $this->actionOfWalletTransaction($withdrawl, $withdrawl->amount, 'out');
            }
            DB::commit();
            return $withdrawl;
        } catch (Exception $e) {
            DB::rollBack();
            return null;
        }
    }
}
