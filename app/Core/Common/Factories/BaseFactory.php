<?php

declare(strict_types=1);

namespace App\Core\Common\Factories;

final class BaseFactory
{
    public static function create(string $className, $parameters = []): object
    {
        return new $className(...$parameters);
    }
}
