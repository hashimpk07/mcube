<?php

namespace App\Services;

use App\Models\BankAccount;
use App\Repositories\Contracts\BankAccountRepositoryInterface;
use DomainException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class BankAccountService
{
    public function __construct(
        private BankAccountRepositoryInterface $repository
    ) {}

    public function createAccount(int $userId): BankAccount
    {
        if ($this->repository->findByUserId($userId)) {
            throw new DomainException(
                'You already have a bank account.'
            );
        }

        return $this->repository->create([
            'user_id' => $userId,
            'account_number' => 'BA-' . strtoupper(
                str_replace('-', '', (string) Str::uuid())
            ),
            'balance' => '0.00',
            'currency' => 'INR',
        ]);
    }

    public function getBalance(int $userId): BankAccount
    {
        $account = $this->repository->findByUserId($userId);

        if (!$account) {
            throw (new ModelNotFoundException())
                ->setModel(BankAccount::class);
        }

        return $account;
    }
}