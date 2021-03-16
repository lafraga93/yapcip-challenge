<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Domain\Validators;

use Exception;

final class TransactionRequestValidator
{
    public function validate(array $data): object
    {
        if (!$data) {
            throw new Exception('Não foi possível processar o payload.', 422);
        }

        if (!isset($data['value']) || empty($data['value'])) {
            throw new Exception('Informe o valor da transferência antes de continuar.', 422);
        }

        if (!is_float($data['value'])) {
            throw new Exception('O valor da transferência deve ser um numero em formato decimal.', 422);
        }

        if (!isset($data['payer']) || empty($data['payer'])) {
            throw new Exception('Não foi possível recuperar o pagador.', 422);
        }

        if (!isset($data['payee']) || empty($data['payee'])) {
            throw new Exception('Informe o destinatário da transferência antes de continuar.', 422);
        }

        return (object) $data;
    } 
}
