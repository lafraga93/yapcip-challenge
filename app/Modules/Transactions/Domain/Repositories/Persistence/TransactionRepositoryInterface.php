<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Domain\Repositories\Persistence;

interface TransactionRepositoryInterface
{
    public function getTransactionById(int $transactionId): object;
    public function persiste(object $transaction, string $transactionTypeSlug): object;
}
