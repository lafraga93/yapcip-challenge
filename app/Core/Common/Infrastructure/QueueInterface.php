<?php

declare(strict_types=1);

namespace App\Core\Common\Infrastructure\Queue;

interface QueueInterface
{
    public function push(): bool;
    public function pull(): bool;
}
