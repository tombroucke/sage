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
        $this->app->bind('custom-blocks', function () {
            return new \App\CustomBlocks();
        });
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

        Blade::directive('shortcode', function ($expression) {
            return '<?php echo do_shortcode(' . $expression . ') ?>';
        });

        Blade::directive('ray', function ($expression) {
            return '<?php ray(' . $expression . ') ?>';
        });
    }
}
