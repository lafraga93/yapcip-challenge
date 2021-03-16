<?php

declare(strict_types=1);

namespace Tests\App\Modules\Transactions\Domain\Services;

use App\Modules\Transactions\Domain\Services\TransactionService;
use App\Modules\Transactions\Domain\Validators\Criterias\TransactionCriteriasChecker;
use App\Modules\Transactions\Infrastructure\Repositories\Api\TransactionAuthorizationRepository;
use App\Modules\Transactions\Infrastructure\Repositories\Persistence\TransactionRepository;
use Exception;
use ReflectionProperty;
use Tests\BaseFactory;
use Tests\Fixtures\TransactionData;
use Tests\Fixtures\UserData;
use Tests\TestCase;

final class TransactionServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testSetCurrentTransactionPayloadIsProviderAValidPayload(): void
    {
        $transaction = (object) TransactionData::getData();
        $payer = UserData::getData();

        $expected = [
            'transaction' => $transaction,
            'payer' => $payer,
        ];

        $service = $this->app->make(TransactionService::class);
        $service->setCurrentTransactionPayload($transaction, $payer);

        $property = new ReflectionProperty(TransactionService::class, 'payload');
        $property->setAccessible(true);

        $this->assertEquals(
            $expected,
            $property->getValue($service)
        );
    }

    public function testExecuteThrowExceptionWhenIsNotAuthorizedTransaction(): void
    {
        $criteriasCheckerMock = $this->createMock(
            TransactionCriteriasChecker::class
        );

        $authorizationRepositoryMock = $this->createMock(
            TransactionAuthorizationRepository::class
        );

        $repositoryMock = $this->createMock(
            TransactionRepository::class
        );

        $authorizationRepositoryMock->method('check')->willReturn(false);

        $service = BaseFactory::create(TransactionService::class, [
            $criteriasCheckerMock,
            $authorizationRepositoryMock,
            $repositoryMock,
        ]);

        $this->expectExceptionObject(
            new Exception('Erro: Transação não autorizada.', 401)
        );

        $service->execute();
    }

    public function testGetTransactionByIdThrowExceptionWhenTransactionNotFound(): void
    {
        $criteriasCheckerMock = $this->createMock(
            TransactionCriteriasChecker::class
        );

        $authorizationRepositoryMock = $this->createMock(
            TransactionAuthorizationRepository::class
        );

        $repositoryMock = $this->createMock(
            TransactionRepository::class
        );

        $repositoryMock->method('getTransactionById')->willReturn(null);

        $service = BaseFactory::create(TransactionService::class, [
            $criteriasCheckerMock,
            $authorizationRepositoryMock,
            $repositoryMock,
        ]);

        $this->expectExceptionObject(
            new Exception('Não foi possível recuperar a transação.', 500)
        );

        $service->getTransactionById(1);
    }

    public function testGetTransactionByIdMustReturnAValidPayload(): void
    {
        $transaction = (object) TransactionData::getData();

        $criteriasCheckerMock = $this->createMock(
            TransactionCriteriasChecker::class
        );

        $authorizationRepositoryMock = $this->createMock(
            TransactionAuthorizationRepository::class
        );

        $repositoryMock = $this->createMock(
            TransactionRepository::class
        );

        $repositoryMock->method('getTransactionById')->willReturn($transaction);

        $service = BaseFactory::create(TransactionService::class, [
            $criteriasCheckerMock,
            $authorizationRepositoryMock,
            $repositoryMock,
        ]);

        $this->assertEquals(
            $transaction,
            $service->getTransactionById(1)
        );
    }
}
