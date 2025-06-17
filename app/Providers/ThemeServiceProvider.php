<?php

namespace App\Providers;

use App\Post;
use App\Services\Lcp;
use App\Helpers\BlockStyles;
use Illuminate\Support\Facades\Blade;
use App\Services\RichSnippets\FaqPage;
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
        $this->app->singleton(BlockStyles::class, function () {
            return new BlockStyles($this->app, $this->app->make('post'));
        });

        $this->app->singleton('post', function () {
            $postId = get_the_ID() ?: 0;
            if (is_home()) {
                $postId = get_option('page_for_posts');
            } elseif (function_exists('is_shop') && is_shop()) {
                $postId = wc_get_page_id('shop');
            } elseif (is_archive()) {
                $postId = 0;
            }

            return new Post($postId);
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
        add_action('wp_head', [new Lcp, 'preload']);
        add_action('wp_head', [new FaqPage, 'render']);

        $this->directives();

        parent::boot();
    }

    /**
     * Register custom Blade directives.
     *
     * @return void
     */
    private function directives()
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

        Blade::directive('year', function () {
            return '<?php echo date("Y") ?>';
        });

        Blade::if('preview', function ($block) {
            return $block->preview;
        });

        Blade::directive('echoWhen', function ($expression) {
            [$condition, $message] = explode(',', $expression, 2);

            return "<?php if($condition) { echo $message; } ?>";
        });
    }
}
