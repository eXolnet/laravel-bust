<?php

namespace Exolnet\Bust\Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;

abstract class UnitTestCase extends TestCase
{
    /**
     * @void
     */
    public function tearDown(): void
    {
        Mockery::close();
    }
}
