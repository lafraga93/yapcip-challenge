<?php

declare(strict_types=1);

namespace Tests\App\Modules\Transactions\Domain\Services\Validators\Criterias;

use App\Modules\Transactions\Domain\Validators\Criterias\TransactionCriteriasChecker;
use Exception;
use Tests\Fixtures\UserData;
use Tests\TestCase;

final class TransactionCriteriasCheckerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testCheckPayerUserTypeThrowExceptionWhenUserIsNotCommonUserType(): void
    {
        $user = UserData::getData();
        $user->type = 'shopkeeper';

        $criteriaValidator = $this->app->make(TransactionCriteriasChecker::class);

        $this->expectExceptionObject(
            new Exception('Somente usuários comuns podem realizar transferências.', 422)
        );

        $criteriaValidator->checkPayerUserType($user);
    }

    public function testCheckPayerFundsThrowExceptionWhenInsuficientFunds(): void
    {
        $user = UserData::getData();
        $user->balance = 10.00;

        $criteriaValidator = $this->app->make(TransactionCriteriasChecker::class);

        $this->expectExceptionObject(
            new Exception('Saldo insuficiente para realizar a transação.', 422)
        );

        $criteriaValidator->checkPayerFunds($user, 11.00);
    }

    public function testCheckMinimalTrasnferValueThrowExceptionWhenTransferValueIsLessThanLimit(): void
    {
        $criteriaValidator = $this->app->make(TransactionCriteriasChecker::class);

        $this->expectException(Exception::class);

        $value = TransactionCriteriasChecker::MIN_TRANSFER_VALUE - 0.10;
        $criteriaValidator->checkMinimalTrasnferValue($value);        
    }
}
