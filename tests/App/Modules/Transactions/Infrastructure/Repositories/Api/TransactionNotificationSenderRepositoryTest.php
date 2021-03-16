<?php

declare(strict_types=1);

namespace Tests\App\Modules\Transactions\Infrastructure\Repositories\Api;

use App\Modules\Transactions\Infrastructure\Repositories\Api\TransactionNotificationSenderRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use stdClass;
use Tests\BaseFactory;
use Tests\TestCase;

final class TransactionNotificationSenderRepositoryTest extends TestCase
{
    public function testCheckReturnsFalseWhenMessageIsNotDelivered(): void
    {
        $response = new Response(200, [], '{"message": "bar"}');
        $handlerStack = HandlerStack::create(new MockHandler([$response]));

        $repository = BaseFactory::create(
            TransactionNotificationSenderRepository::class,
            [new Client(['handler' => $handlerStack])]
        );

        $this->assertFalse($repository->fire(new stdClass()));
    }
}
