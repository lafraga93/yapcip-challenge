<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Infrastructure\Repositories\Queue;

use App\Core\Common\Infrastructure\QueueInterface;
use Illuminate\Support\Facades\DB;

final class TransactionNotificationRepository implements QueueInterface
{
    public function __construct(DB $persistence)
    {
        $this->persistence = $persistence;
    }

    public function push(object $payee, float $value): bool
    {
        $formattedValue = number_format($value, 2, ',', '');

        $payload = [
            'email' => $payee->email,
            'message' => 'Olá ' . $payee->name . ', você recebeu uma transferência no valor de R$' . $formattedValue,
        ];

        return (bool) $this->persistence::table('notifications')->insert([
            'payload' => json_encode($payload),
        ]);
    }

    /**
     * @return object|null
     */
    public function pull()
    {
        return $this->persistence::table('notifications')->get();
    }

    public function acknowledge(object $payload): bool
    {
        return (bool) $this->persistence::table('notifications')->where('id', $payload->id)->delete();
    }
}
