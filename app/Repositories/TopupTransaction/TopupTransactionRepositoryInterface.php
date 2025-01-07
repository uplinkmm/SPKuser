<?php

namespace App\Repositories\TopupTransaction;

interface TopupTransactionRepositoryInterface
{
    public function createTransaction(array $data);
}
