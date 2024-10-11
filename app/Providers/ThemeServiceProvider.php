<?php

namespace App\Providers;

use App\Helpers\BlockAssets;
use App\Post;
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
        $this->app->singleton(BlockAssets::class, function () {
            return new BlockAssets($this->app, $this->app->make('post'));
        });

        $this->app->singleton('post', function () {
            $postId = get_the_ID() ?: 0;
            if (is_home()) {
                $postId = get_option('page_for_posts');
            } elseif (is_archive()) {
                $postId = 0;
            }

            return new Post($postId);
        });

        $this->app->singleton('theme-json', function () {
            return new \App\Helpers\ThemeJson;
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
            return '<?php echo do_shortcode('.$expression.') ?>';
        });

        Blade::directive('ray', function ($expression) {
            return '<?php ray('.$expression.') ?>';
        });

        Blade::directive('year', function () {
            return '<?php echo date("Y") ?>';
        });

        Blade::if('preview', function ($block) {
            return $block->preview;
        });

        Blade::if('home', function () {
            return get_option('page_on_front') == get_the_ID();
        });

        Blade::if('notHome', function () {
            return get_option('page_on_front') != get_the_ID();
        });

        Blade::directive('echoWhen', function ($expression) {
            [$condition, $message] = explode(',', $expression, 2);

            return "<?php if($condition) { echo $message; } ?>";
        });

        parent::boot();
    }
}
