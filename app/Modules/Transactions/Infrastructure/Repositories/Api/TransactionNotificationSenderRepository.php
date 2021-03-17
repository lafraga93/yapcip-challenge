<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Infrastructure\Repositories\Api;

use App\Modules\Transactions\Domain\Repositories\Api\TransactionNotificationSenderRepositoryInterface;
use Exception;
use GuzzleHttp\Client;

final class TransactionNotificationSenderRepository implements TransactionNotificationSenderRepositoryInterface
{
    /** @var string */
    public const URI = 'https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04';

    /** @var string */
    public const PASS_PHRASE = 'Enviado';

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function fire(object $payload): bool
    {
        /** this is a faker request, should be a `POST` with `$payload` */
        $response = $this->client->request('GET', self::URI);

        $responseStatusCode = $response->getStatusCode();
        $responseBody = json_decode((string) $response->getBody());

        if ($responseStatusCode !== 200 || !isset($responseBody->message)) {
            throw new Exception('Erro: Não foi possível acessar o serviço de envio de notificações.', 500);
        }

        if ($responseBody->message !== self::PASS_PHRASE) {
            return false;
        }

        return true;
    }
}
