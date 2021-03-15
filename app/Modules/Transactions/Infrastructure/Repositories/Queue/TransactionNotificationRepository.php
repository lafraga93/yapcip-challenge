<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Infrastructure\Queue;

use App\Core\Common\Infrastructure\Queue\QueueInterface;

final class TransactionNotificationRepository implements QueueInterface
{
    public function push(): bool
    {
        return true;
    }

    public function pull(): bool
    {
        return true;
    }
}
