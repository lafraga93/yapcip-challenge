<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Infrastructure\Repositories\Persistence;

use App\Modules\Transactions\Domain\Repositories\Persistence\TransactionRepositoryInterface;
use Illuminate\Support\Facades\DB;

final class TransactionRepository implements TransactionRepositoryInterface
{
    public function __construct(DB $persistence)
    {
        $this->persistence = $persistence;
    }

    /**
     * @return object|null
     */
    public function getTransactionById(int $transactionId)
    {
        return $this->persistence::table('transactions')
            ->select('value', 'payer_id AS payer', 'payee_id AS payee')
            ->where('id', $transactionId)->first();
    }

    public function persiste(object $transaction, string $transactionTypeSlug): object
    {
        $transactionType = $this->getTransactionType($transactionTypeSlug);

        $this->persistence::table('transactions')->insert([
            'value' => $transaction->value,
            'payer_id' => $transaction->payer,
            'payee_id' => $transaction->payee,
            'transaction_type_id' => $transactionType->id,
        ]);

        $transaction->type = $transactionType->slug;
        return $transaction;
    }

    /**
     * @return object|null
     */
    private function getTransactionType(string $slug)
    {
        return $this->persistence::table('transaction_types')->where('slug', $slug)->first();
    }
}
