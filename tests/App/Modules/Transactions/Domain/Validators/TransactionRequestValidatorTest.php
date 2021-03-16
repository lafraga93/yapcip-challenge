<?php

declare(strict_types=1);

namespace Tests\App\Modules\Transactions\Domain\Services\Validators;

use App\Modules\Transactions\Domain\Validators\TransactionRequestValidator;
use Exception;
use Tests\TestCase;

final class TransactionRequestValidatorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testValidateThrowExceptionWhenDataIsNull(): void
    {
        $data = [];
        $validator = $this->app->make(TransactionRequestValidator::class);

        $this->expectExceptionObject(new Exception('Não foi possível processar o payload.', 422));
        $validator->validate($data);
    }

    public function testValidateThrowExceptionWhenTransactionValueIsNotADecimalFormat(): void
    {
        $data = [
            'value' => 'not_float',
        ];

        $validator = $this->app->make(TransactionRequestValidator::class);

        $this->expectExceptionObject(
            new Exception('O valor da transferência deve ser um numero em formato decimal.', 422)
        );

        $validator->validate($data);
    }

    public function testValidateThrowExceptionWhenTransactionPayerIsNullOrEmpty(): void
    {
        $data = [
            'value' => 1.00,
        ];

        $validator = $this->app->make(TransactionRequestValidator::class);

        $this->expectExceptionObject(new Exception('Não foi possível recuperar o pagador.', 422));
        $validator->validate($data);

        $data = [
            'value' => 1.00,
            'payer' => '',
        ];

        $this->expectExceptionObject(new Exception('Não foi possível recuperar o pagador.', 422));
        $validator->validate($data);
    }

    public function testValidateThrowExceptionWhenTransactionPayeeIsNullOrEmpty(): void
    {
        $data = [
            'value' => 1.00,
            'payer' => 1,
        ];

        $validator = $this->app->make(TransactionRequestValidator::class);

        $this->expectExceptionObject(
            new Exception('Informe o destinatário da transferência antes de continuar.', 422)
        );

        $validator->validate($data);

        $data = [
            'value' => 1.00,
            'payer' => 1,
            'payee' => '',

        ];

        $this->expectExceptionObject(
            new Exception('Informe o destinatário da transferência antes de continuar.', 422)
        );

        $validator->validate($data);
    }
}
