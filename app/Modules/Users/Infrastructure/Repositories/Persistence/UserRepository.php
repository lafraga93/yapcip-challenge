<?php

declare(strict_types=1);

namespace App\Modules\Users\Infrastructure\Repositories\Persistence;

use App\Modules\Users\Domain\Repositories\Persistence\UserRepositoryInterface;

final class UserRepository implements UserRepositoryInterface
{
    public function getUserById(int $userId): object
    {
        return (object) [];
    }
}
