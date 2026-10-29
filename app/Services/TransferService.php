<?php

namespace App\Services;

use App\Models\BankTransaction;
use App\Repositories\Contracts\BankAccountRepositoryInterface;
use App\Repositories\Contracts\BankTransactionRepositoryInterface;
use DomainException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

class TransferService
{
    public function __construct(
        private BankAccountRepositoryInterface $accountRepository,
        private BankTransactionRepositoryInterface $transactionRepository
    ) {}

    public function transfer(
        int $fromUserId,
        int $toUserId,
        string $amount
    ): BankTransaction {
        if ($fromUserId === $toUserId) {
            throw new DomainException(
                'You cannot transfer money to yourself.'
            );
        }

        if (!extension_loaded('bcmath')) {
            throw new RuntimeException(
                'Enable the PHP BCMath extension.'
            );
        }

        return DB::transaction(function () use (
            $fromUserId,
            $toUserId,
            $amount
        ) {
            // Lock both accounts in a consistent order.
            $userIds = [$fromUserId, $toUserId];
            sort($userIds);

            $accounts = [];

            foreach ($userIds as $userId) {
                $accounts[$userId] =
                    $this->accountRepository
                        ->findByUserIdForUpdate($userId);
            }

            $sender = $accounts[$fromUserId];
            $receiver = $accounts[$toUserId];

            if (bccomp((string) $sender->balance, $amount, 2) < 0) {
                throw new DomainException('Insufficient balance.');
            }

            $sender->balance = bcsub(
                (string) $sender->balance,
                $amount,
                2
            );

            $receiver->balance = bcadd(
                (string) $receiver->balance,
                $amount,
                2
            );

            $sender->save();
            $receiver->save();

            return $this->transactionRepository->create([
                'from_account_id' => $sender->id,
                'to_account_id' => $receiver->id,
                'amount' => $amount,
                'status' => 'completed',
                'reference' => (string) Str::uuid(),
            ]);
        }, 3);
    }
}