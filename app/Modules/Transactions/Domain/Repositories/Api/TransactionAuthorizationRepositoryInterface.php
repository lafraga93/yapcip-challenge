<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Domain\Repositories\Api;

interface TransactionAuthorizationRepositoryInterface
{
    public function check(): bool;
}
