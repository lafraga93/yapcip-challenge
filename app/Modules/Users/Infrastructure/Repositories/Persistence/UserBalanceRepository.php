<?php

declare(strict_types=1);

namespace App\Modules\Users\Infrastructure\Repositories\Persistence;

use App\Modules\Users\Domain\Repositories\Persistence\UserBalanceRepositoryInterface;

final class UserBalanceRepository implements UserBalanceRepositoryInterface
{
    public function increaseUserBalance(int $userId, float $value): bool
    {
        return true;
    }

    public function decreaseUserBalance(int $userId, float $value): bool
    {
        return true;
    }
}
