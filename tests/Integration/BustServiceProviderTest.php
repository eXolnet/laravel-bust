<?php

namespace Exolnet\Bust\Tests\Integration;

use Exolnet\Bust\Bust;

class BustServiceProviderTest extends TestCase
{
    /**
     * @return void
     */
    public function testBustInitializationIsDeferred(): void
    {
        // By default, Bust should not be resolved
        $this->assertFalse(
            app()->resolved(Bust::class)
        );

        // But it should be resolved on demand
        $bust = app(Bust::class);

        $this->assertInstanceOf(Bust::class, $bust);

        $this->assertTrue(
            app()->resolved(Bust::class)
        );
    }
}
