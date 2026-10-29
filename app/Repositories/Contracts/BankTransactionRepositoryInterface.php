<?php

namespace App\Repositories\Contracts;

use App\Models\BankTransaction;

interface BankTransactionRepositoryInterface
{
    public function create(array $data): BankTransaction;
}