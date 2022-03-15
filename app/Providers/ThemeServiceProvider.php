<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Roots\Acorn\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('background', function ($image) {
            return "style=\"background-image: url('<?= $image ?>')\"";
        });
    }
}
