<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Infrastructure\Repositories\Persistence;

use App\Modules\Transactions\Domain\Repositories\Persistence\TransactionRepositoryInterface;

final class TransactionRepository implements TransactionRepositoryInterface
{
    public function getTransactionById(int $transactionId): object
    {
        return (object) [];
    }

    public function persiste(object $transaction): object
    {
        return $transaction;
    }
}
