<?php

declare(strict_types=1);

namespace App\Modules\Users\Domain\Repositories\Persistence;

interface UserRepositoryInterface
{
    public function getUserById(int $userId): object;
}
