<?php

namespace Exolnet\Bust\Tests\Integration;

use Exolnet\Bust\BustServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            BustServiceProvider::class,
        ];
    }
}
