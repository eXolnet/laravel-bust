<?php

namespace Exolnet\Bust\Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;

abstract class UnitTest extends TestCase
{
    /**
     * @void
     */
    public function tearDown(): void
    {
        Mockery::close();
    }
}
