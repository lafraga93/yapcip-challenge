<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Domain\Services\Notifications;

use App\Modules\Transactions\Infrastructure\Repositories\Api\TransactionNotificationSenderRepository;
use App\Modules\Transactions\Infrastructure\Repositories\Queue\TransactionNotificationRepository;
use Exception;

final class TransactionNotificationService
{
    private TransactionNotificationRepository $notificationRepository;
    private TransactionNotificationSenderRepository $notificationSenderRepository;

    public function __construct(
        TransactionNotificationRepository $notificationRepository,
        TransactionNotificationSenderRepository $notificationSenderRepository
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->notificationSenderRepository = $notificationSenderRepository;
    }

    public function add(object $payee, float $value): bool
    {
        return $this->notificationRepository->push($payee, $value);
    }

    public function dispatch(): bool
    {
        $notifications = $this->notificationRepository->pull();

        if (!$notifications) {
            return false;
        }

        $notifications->each(function ($payload) {
            $status = $this->notificationSenderRepository->fire($payload);
            if ($status) {
                $this->notificationRepository->acknowledge($payload);
            }
        });

        return true;
    }
}
