<?php

declare(strict_types=1);

namespace Tests;

use Laravel\Lumen\Application;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;
use DG\BypassFinals;

abstract class TestCase extends BaseTestCase
{
    public function createApplication(): Application
    {
        BypassFinals::enable();
        return require __DIR__.'/../bootstrap/app.php';
    }
}
