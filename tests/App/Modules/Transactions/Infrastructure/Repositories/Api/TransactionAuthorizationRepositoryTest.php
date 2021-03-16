<?php

declare(strict_types=1);

namespace Tests\App\Modules\Transactions\Infrastructure\Repositories\Api;

use App\Modules\Transactions\Infrastructure\Repositories\Api\TransactionAuthorizationRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\BaseFactory;
use Tests\TestCase;

final class TransactionAuthorizationRepositoryTest extends TestCase
{
    public function testCheckReturnsFalseWhenTransferIsNotAuthorized(): void
    {
        $response = new Response(200, [], '{"message": "foo"}');
        $handlerStack = HandlerStack::create(new MockHandler([$response]));

        $repository = BaseFactory::create(
            TransactionAuthorizationRepository::class, 
            [new Client(['handler' => $handlerStack])]
        );

        $this->assertFalse($repository->check());
    }
}
