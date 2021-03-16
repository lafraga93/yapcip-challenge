<?php

declare(strict_types=1);

namespace App\Modules\Users\Infrastructure\Repositories\Persistence;

use App\Modules\Users\Domain\Repositories\Persistence\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

final class UserRepository implements UserRepositoryInterface
{
    public function __construct(DB $persistence)
    {
        $this->persistence = $persistence;
    }

    /**
     * @return object|null
     */
    public function getUserById(int $userId)
    {
        return $this->persistence::table('users')->select('users.*', 'slug as type', 'balance')
            ->join('user_types', 'user_types.id', '=', 'users.user_type_id')
            ->join('wallets', 'users.id', '=', 'wallets.id')
            ->where('users.id', $userId)
            ->first();
    }
}
