<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Domain\Repositories\Persistence;

interface TransactionRepositoryInterface
{
    /**
     * @return object|null
     */
    public function getTransactionById(int $transactionId);
    public function persiste(object $transaction, string $transactionTypeSlug): object;
}
