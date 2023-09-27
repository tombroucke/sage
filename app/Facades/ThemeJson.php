<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ThemeJson extends Facade
{

    /**
     * Get the registered name of theme-json.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'theme-json';
    }
}
