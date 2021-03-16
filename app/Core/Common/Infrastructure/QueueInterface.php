<?php

declare(strict_types=1);

namespace App\Core\Common\Infrastructure;

interface QueueInterface
{
    /** @return object|null */
    public function pull();
    public function acknowledge(object $payload): bool;
}
