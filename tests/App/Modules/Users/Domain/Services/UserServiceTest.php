<?php

declare(strict_types=1);

namespace Tests\App\Modules\Users\Domain\Services;

use App\Modules\Users\Domain\Services\UserService;
use App\Modules\Users\Infrastructure\Repositories\Persistence\UserBalanceRepository;
use App\Modules\Users\Infrastructure\Repositories\Persistence\UserRepository;
use Exception;
use Tests\BaseFactory;
use Tests\Fixtures\TransactionData;
use Tests\Fixtures\UserData;
use Tests\TestCase;

final class UserServiceTest extends TestCase
{
    public function testGetUserByIdMustReturnsAValidUserPayload(): void
    {
        $expected = UserData::getData();

        $userBalanceRepositoryMock = $this->createMock(
            UserBalanceRepository::class
        );

        $userRepositoryMock = $this->createMock(
            UserRepository::class
        );

        $userRepositoryMock->method('getUserById')->willReturn($expected);

        $service = BaseFactory::create(UserService::class, [
            $userBalanceRepositoryMock,
            $userRepositoryMock
        ]);

        $this->assertEquals($expected, $service->getUserById(1));        
    }

    public function testGetUserByThrowExceptionWhenUserNotFound(): void
    {
        $userBalanceRepositoryMock = $this->createMock(
            UserBalanceRepository::class
        );

        $userRepositoryMock = $this->createMock(
            UserRepository::class
        );

        $userRepositoryMock->method('getUserById')->willReturn(null);

        $service = BaseFactory::create(UserService::class, [
            $userBalanceRepositoryMock,
            $userRepositoryMock
        ]);

        $this->expectExceptionObject(
            new Exception('Não foi possível recuperar o destinatário da transferência.', 500)
        );

        $service->getUserById(1);
    }

    public function testUpdateUserBalanceMustReturnsTrueWhenRepositoryBalanceMethodsReturnsTrue(): void
    {
        $fixture = TransactionData::getData();
        $fixture['type'] = 'transfer';

        $userBalanceRepositoryMock = $this->createMock(
            UserBalanceRepository::class
        );

        $userBalanceRepositoryMock->method('increaseUserBalance')->willReturn(true);
        $userBalanceRepositoryMock->method('decreaseUserBalance')->willReturn(true);

        $userRepositoryMock = $this->createMock(
            UserRepository::class
        );

        $service = BaseFactory::create(UserService::class, [
            $userBalanceRepositoryMock,
            $userRepositoryMock
        ]);

        $this->assertTrue($service->updateUserBalance((object) $fixture));
    }

    public function testUpdateUserBalanceThrowExceptionWhenRepositoryBalanceMethodsReturnsFalse(): void
    {
        $fixture = TransactionData::getData();
        $fixture['type'] = 'rollback';

        $userBalanceRepositoryMock = $this->createMock(
            UserBalanceRepository::class
        );

        $userBalanceRepositoryMock->method('increaseUserBalance')->willReturn(false);
        $userBalanceRepositoryMock->method('decreaseUserBalance')->willReturn(false);

        $userRepositoryMock = $this->createMock(
            UserRepository::class
        );

        $service = BaseFactory::create(UserService::class, [
            $userBalanceRepositoryMock,
            $userRepositoryMock
        ]);

        $this->expectExceptionObject(new Exception('Erro: Não foi possível atualizar o saldo das carteiras.', 500));
        $service->updateUserBalance((object) $fixture);
    }
}
