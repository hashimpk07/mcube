<?php

namespace App\Repositories\Eloquent;

use App\Models\BankAccount;
use App\Repositories\Contracts\BankAccountRepositoryInterface;

class BankAccountRepository implements BankAccountRepositoryInterface
{
    public function create(array $data): BankAccount
    {
        return BankAccount::create($data);
    }

    public function findByUserId(int $userId): ?BankAccount
    {
        return BankAccount::where('user_id', $userId)->first();
    }

    public function findByUserIdForUpdate(int $userId): BankAccount
    {
        return BankAccount::where('user_id', $userId)
            ->lockForUpdate()
            ->firstOrFail();
    }
}