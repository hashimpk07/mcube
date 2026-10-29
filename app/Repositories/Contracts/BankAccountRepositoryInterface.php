<?php

namespace App\Repositories\Contracts;

use App\Models\BankAccount;

interface BankAccountRepositoryInterface
{
    public function create(array $data): BankAccount;

    public function findByUserId(int $userId): ?BankAccount;

    public function findByUserIdForUpdate(int $userId): BankAccount;
}