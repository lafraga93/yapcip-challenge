<?php

declare(strict_types=1);

namespace App\Core\Console\Commands;

use App\Modules\Transactions\Domain\Services\Notifications\TransactionNotificationService;
use Illuminate\Console\Command;

final class DispatchTransactionNotifications extends Command
{
    /** @string */
    protected $signature = 'notifications:transaction';
    /** @string */
    protected $description = 'Envia as notificações de transações realizadas';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function handle(TransactionNotificationService $service)
    {
        $service->dispatch();
    }
}
