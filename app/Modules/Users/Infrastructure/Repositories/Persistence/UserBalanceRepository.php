<?php

declare(strict_types=1);

namespace App\Modules\Users\Infrastructure\Repositories\Persistence;

use App\Modules\Users\Domain\Repositories\Persistence\UserBalanceRepositoryInterface;
use DateTime;
use Illuminate\Support\Facades\DB;

final class UserBalanceRepository implements UserBalanceRepositoryInterface
{
    public function __construct(DB $persistence)
    {
        $this->persistence = $persistence;
    }

    public function increaseUserBalance(int $userId, float $value): bool
    {
        return (bool) $this->persistence::table('wallets')
            ->where('user_id', $userId)
            ->increment('balance', $value, ['updated_at' => new DateTime()]);
    }

    public function decreaseUserBalance(int $userId, float $value): bool
    {
        return (bool) $this->persistence::table('wallets')
            ->where('user_id', $userId)
            ->decrement('balance', $value, ['updated_at' => new DateTime()]);
    }
}
