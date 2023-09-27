<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class BlockAssets extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    public static function getFacadeAccessor() : string
    {
        return 'block-assets';
    }
}
