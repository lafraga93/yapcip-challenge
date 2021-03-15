<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Domain\Services\Notifications;

use App\Modules\Transactions\Infrastructure\Queue\TransactionNotificationRepository;

final class TransactionNotificationProcessor
{
    private TransactionNotificationRepository $repository;

    public function __construct(TransactionNotificationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function add(object $payee, float $value): bool
    {
        return $this->repository->push($payee, $value);
    }

    public function dispatch(): bool
    {
        return true;
    }
}
