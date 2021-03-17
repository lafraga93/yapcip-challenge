<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Infrastructure\Repositories\Api;

use App\Modules\Transactions\Domain\Repositories\Api\TransactionAuthorizationRepositoryInterface;
use Exception;
use GuzzleHttp\Client;

final class TransactionAuthorizationRepository implements TransactionAuthorizationRepositoryInterface
{
    /** @var string */
    public const URI = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

    /** @var string */
    public const PASS_PHRASE = 'Autorizado';

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function check(): bool
    {
        /** this is a faker request */
        $response = $this->client->request('GET', self::URI);

        $responseStatusCode = $response->getStatusCode();
        $responseBody = json_decode((string) $response->getBody());

        if (!isset($responseBody->message)) {
            throw new Exception('Erro: Não foi possível consultar o serviço de autorização de transferências.', 500);
        }

        if ($responseBody->message !== self::PASS_PHRASE) {
            return false;
        }

        return true;
    }
}
