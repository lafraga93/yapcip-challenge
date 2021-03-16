<?php

declare(strict_types=1);

namespace Tests;

final class BaseFactory
{
    public static function create(string $className, $parameters = []): object
    {
        return new $className(...$parameters);
    }
}
