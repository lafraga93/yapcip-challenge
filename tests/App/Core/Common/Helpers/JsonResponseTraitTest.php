<?php

declare(strict_types=1);

namespace Tests\App\Core\Common\Helpers;

use App\Core\Common\Helpers\JsonResponseTrait;
use Tests\TestCase;

final class JsonResponseTraitTest extends TestCase
{
    public function testResponseMountAValidResponsePayload(): void
    {
        $expectedPayload = [
            'message' => 'example message',
            'data' => [
                'foo' => 'bar',
            ],
        ];

        $response = JsonResponseTrait::response($expectedPayload['message'], $expectedPayload['data']);
        $this->assertEquals($expectedPayload, $response->original);
    }
}
