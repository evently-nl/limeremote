<?php

namespace evently\LimeRemote\Facades;

use Illuminate\Support\Facades\Facade;

class LimeRemote extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'limeremote';
    }
}
