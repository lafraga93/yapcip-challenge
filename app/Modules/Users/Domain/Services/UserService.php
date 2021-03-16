<?php

declare(strict_types=1);

namespace App\Modules\Users\Domain\Services;

use App\Modules\Transactions\Domain\Services\TransactionService;
use App\Modules\Users\Infrastructure\Repositories\Persistence\UserBalanceRepository;
use App\Modules\Users\Infrastructure\Repositories\Persistence\UserRepository;
use Exception;

final class UserService
{
    private UserBalanceRepository $userBalanceRepository;
    private UserRepository $userRepository;

    public function __construct(UserBalanceRepository $userBalanceRepository, UserRepository $userRepository)
    {
        $this->userBalanceRepository = $userBalanceRepository;
        $this->userRepository = $userRepository;
    }

    public function getUserById(int $userId): object
    {
        $user = $this->userRepository->getUserById($userId);

        if (!$user) {
            throw new Exception('Não foi possível recuperar o destinatário da transferência.', 500);
        }

        return $user;
    }

    public function updateUserBalance(object $payload): bool
    {
        if ($payload->type === TransactionService::TRANSFER_SLUG) { 
            $increaseUserId = $payload->payee;
            $decreaseUserId = $payload->payer;
        }

        if ($payload->type === TransactionService::ROLLBACK_SLUG) {
            $increaseUserId = $payload->payer;
            $decreaseUserId = $payload->payee;
        }

        $increaseBalanceStatus = $this->userBalanceRepository->increaseUserBalance(
            $increaseUserId,
            (float) $payload->value
        );

        $decreaseBalanceStatus = $this->userBalanceRepository->decreaseUserBalance(
            $decreaseUserId,
            (float) $payload->value
        );

        if (!$increaseBalanceStatus || !$decreaseBalanceStatus) {
            throw new Exception('Erro: Não foi possível atualizar o saldo das carteiras.', 500);
        }

        return true;
    }
}
