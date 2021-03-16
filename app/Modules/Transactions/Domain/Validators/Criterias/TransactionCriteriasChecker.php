<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Domain\Validators\Criterias;

use Exception;

final class TransactionCriteriasChecker
{
    /** @var string */
    const MIN_TRANSFER_VALUE = 5.00;

    /** @var string */
    const COMMON_USER_TYPE_SLUG = 'common';

    public function checkPayerUserType(object $user): bool
    {
        if ($user->type !== self::COMMON_USER_TYPE_SLUG) {
            throw new Exception("Somente usuários comuns podem realizar transferências.", 422);
        }

        return true;
    }

    public function checkPayerFunds(object $user, float $transactionValue): bool
    {
        if ($user->balance < $transactionValue) {
            throw new Exception("Saldo insuficiente para realizar a transação.", 422);
        }

        return true;
    }

    public function checkMinimalTrasnferValue(float $value): bool
    {
        if ($value < self::MIN_TRANSFER_VALUE) {
            $formattedDecimalValue = number_format(self::MIN_TRANSFER_VALUE, 2, ',', '');
            throw new Exception("O valor da transferência não pode ser inferior a R$ {$formattedDecimalValue}!", 422);
        }

        return true;
    }
}
