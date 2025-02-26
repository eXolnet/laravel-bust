<?php

namespace Exolnet\Bust\Tests\Integration;

use Exolnet\Bust\Bust;
use Exolnet\Bust\BustFacade;

class BustFacadeTest extends TestCase
{
    /**
     * @return void
     */
    public function testFacadeRootIsBustClass(): void
    {
        $root = BustFacade::getFacadeRoot();

        $this->assertInstanceOf(Bust::class, $root);
    }
}
