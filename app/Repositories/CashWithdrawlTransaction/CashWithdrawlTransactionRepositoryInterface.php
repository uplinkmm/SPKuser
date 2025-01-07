<?php

namespace App\Repositories\CashWithdrawlTransaction;

interface CashWithdrawlTransactionRepositoryInterface
{
    public function createTransaction(array $data);
}
