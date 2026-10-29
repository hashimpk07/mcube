<?php

namespace App\Repositories\Eloquent;

use App\Models\BankTransaction;
use App\Repositories\Contracts\BankTransactionRepositoryInterface;

class BankTransactionRepository implements BankTransactionRepositoryInterface
{
    public function create(array $data): BankTransaction
    {
        return BankTransaction::create($data);
    }
}