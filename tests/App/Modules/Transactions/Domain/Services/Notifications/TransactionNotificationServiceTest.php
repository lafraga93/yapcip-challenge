<?php

declare(strict_types=1);

namespace Tests\App\Modules\Transactions\Domain\Services\Notifications;

use App\Modules\Transactions\Domain\Services\Notifications\TransactionNotificationService;
use App\Modules\Transactions\Infrastructure\Repositories\Api\TransactionNotificationSenderRepository;
use App\Modules\Transactions\Infrastructure\Repositories\Queue\TransactionNotificationRepository;
use Tests\BaseFactory;
use Tests\TestCase;

final class TransactionNotificationServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testDispatchMustReturnsFalseWhenNotificationsIsNotFound(): void
    {
        $notificationRepositoryMock = $this->createMock(
            TransactionNotificationRepository::class
        );

        $notificationSenderRepositoryMock = $this->createMock(
            TransactionNotificationSenderRepository::class
        );

        $notificationRepositoryMock->method('pull')->willReturn(null);

        $service = BaseFactory::create(TransactionNotificationService::class, [
            $notificationRepositoryMock,
            $notificationSenderRepositoryMock,
        ]);

        $this->assertFalse($service->dispatch());
    }
}
