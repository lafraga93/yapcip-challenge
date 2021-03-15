<?php

declare(strict_types=1);

namespace App\Modules\Users\Domain\Repositories\Persistence;

interface UserBalanceRepositoryInterface
{
    public function increaseUserBalance(int $userId, float $value): bool;
    public function decreaseUserBalance(int $userId, float $value): bool;
}
