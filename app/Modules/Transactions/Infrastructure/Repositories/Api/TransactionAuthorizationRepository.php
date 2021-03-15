<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Infrastructure\Repositories\Api;

use App\Modules\Transactions\Domain\Repositories\Api\TransactionAuthorizationRepositoryInterface;

final class TransactionAuthorizationRepository implements TransactionAuthorizationRepositoryInterface
{
    public function check(): bool
    {
        return true;
    }
}
