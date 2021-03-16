<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Domain\Repositories\Api;

interface TransactionNotificationSenderRepositoryInterface
{
    public function fire(object $payload): bool;
}
