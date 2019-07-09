<?php

namespace Exolnet\Bust;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Exolnet\Bust\Bust
 */
class BustFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bust';
    }
}
