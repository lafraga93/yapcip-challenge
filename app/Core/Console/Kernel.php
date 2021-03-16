<?php

namespace App\Core\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

final class Kernel extends ConsoleKernel
{
    /** @var array */
    protected $commands = [
        'App\Core\Console\Commands\DispatchTransactionNotifications',
    ];

    protected function schedule(Schedule $schedule): void
    {
        // ...
    }
}
