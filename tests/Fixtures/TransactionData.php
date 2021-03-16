<?php

declare(strict_types=1);

namespace Tests\Fixtures;

final class TransactionData
{
    public static function getData(): array
    {
        return [
            'payee' => 1,
            'payer' => 1,
            'value' => 1,
        ];
    }
}
