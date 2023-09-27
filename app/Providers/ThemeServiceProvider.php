<?php

namespace App\Providers;

use App\Post;
use ThemeJson;
use Illuminate\Support\Facades\Blade;
use Roots\Acorn\Sage\SageServiceProvider;

class ThemeServiceProvider extends SageServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('block-assets', function () {
            return new \App\Helpers\BlockAssets($this->app, $this->app->make('post'));
        });

        $this->app->singleton('post', function () {
            $postId = get_the_ID() ?: 0;
            if (is_home()) {
                $postId = get_option('page_for_posts');
            } elseif (is_archive()) {
                $postId = 0;
            };
            return new Post($postId);
        });

        $this->app->singleton('theme-json', function () {
            return new \App\Helpers\ThemeJson();
        });

        parent::register();
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
        parent::boot();
    }
}
