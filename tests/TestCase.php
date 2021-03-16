<?php

declare(strict_types=1);

namespace Tests;

abstract class TestCase extends \Laravel\Lumen\Testing\TestCase
{
    /**
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        \DG\BypassFinals::enable();
        return require __DIR__ . '/../bootstrap/app.php';
    }
}
