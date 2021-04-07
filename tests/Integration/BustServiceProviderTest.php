<?php

namespace Exolnet\Bust\Tests\Integration;

use Exolnet\Bust\Bust;
use Exolnet\Bust\BustServiceProvider;

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

    /**
     * @return void
     */
    public function testBustAliasShouldBeASingleton(): void
    {
        // By default, Bust should not be resolved
        $this->assertFalse(
            app()->resolved('bust')
        );

        // But it should be resolved on demand
        $bust = app('bust');

        $this->assertInstanceOf(Bust::class, $bust);

        $this->assertTrue(
            app()->resolved('bust')
        );

        $this->assertEquals($bust, app('bust'));
    }

    /**
     * @return void
     * @test
     */
    public function testProvides(): void
    {
        $bust = new BustServiceProvider($this->app);
        self::assertEquals(['bust'], $bust->provides());
    }
}
