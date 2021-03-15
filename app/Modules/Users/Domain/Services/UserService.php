<?php

declare(strict_types=1);

namespace App\Modules\Users\Domain\Services;

use App\Modules\Users\Infrastructure\Repositories\Persistence\UserBalanceRepository;
use App\Modules\Users\Infrastructure\Repositories\Persistence\UserRepository;

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
        return $this->userRepository->getUserById($userId);
    }

    public function updateUserBalance(object $payload): bool
    {
        if ($payload->type === 'transfer') {
            $increaseUserId = $payload->payee;
            $decreaseUserId = $payload->payer;
        }

        if ($payload->type === 'rollback') {
            $increaseUserId = $payload->payer;
            $decreaseUserId = $payload->payee;
        }

        $this->userBalanceRepository->increaseUserBalance($increaseUserId, $payload->value);
        $this->userBalanceRepository->decreaseUserBalance($decreaseUserId, $payload->value);

        return true;
    }
}
