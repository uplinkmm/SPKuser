<?php

namespace App\Repositories\TopupTransaction;

use Exception;

use App\Models\User;

use App\Models\TopupTransaction;
use App\Traits\SendNotification;
use Illuminate\Support\Facades\DB;

class TopupTransactionRepository implements TopupTransactionRepositoryInterface
{
    use SendNotification;
    public function createTransaction(array $data)
    {
        $transactionId = 'TP' . now()->format('YmdHis');
        $data['transactionId'] = $transactionId;
        $data['createdable_id']=UserData()->id;
        $data['createdable_type']='customer';
        try{
            DB::beginTransaction();
            $topup = TopupTransaction::create($data);
            if($topup){
                $data['title']=$topup->customer->name;
                $data['body']='has just deposit from '.$topup->account->name;
                $data['date_time']=now();
                $users=User::all();
                $this->send($topup,$users,$data);
             }
            DB::commit();
            return $topup;
        }catch(Exception $e){
            DB::rollBack();
            ResponseMessage($e->getMessage(), 500);
        }
    }
}
