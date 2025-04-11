<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Post extends Facade
{
    /**
     * Get the registered name of the component.
     */
    public static function getFacadeAccessor(): string
    {
        return 'post';
    }
}
