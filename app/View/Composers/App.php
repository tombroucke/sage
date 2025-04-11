<?php

namespace App\View\Composers;

use App\Facades\Post;
use App\Helpers\BlockStyles;
use Roots\Acorn\View\Composer;

class App extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        '*',
    ];

    /**
     * Returns the site name.
     *
     * @return string
     */
    public function siteName()
    {
        return get_bloginfo('name', 'display');
    }

    /**
     * Returns the Vite assets.
     *
     * @return array
     */
    public function viteAssets()
    {
        $assets = [
            'resources/styles/app.scss',
            'resources/styles/fonts.scss',
            'resources/scripts/app.js',
        ];

        if (Post::hasBlock('core/image') || Post::hasBlock('acf/gallery')) {
            $assets[] = 'resources/styles/fancybox.scss';
        }

        if (Post::hasBlock('acf/carousel') || Post::hasBlock('acf/logos')) {
            $assets[] = 'resources/styles/swiper.scss';
        }

        if (Post::hasBlock('core/table') || Post::hasShortcode('cookie-table') || (function_exists('WC') && (is_checkout() || is_cart() || is_account_page()))) {
            $assets[] = 'resources/styles/tables.scss';
        }

        if (Post::hasBlock('gravityforms/form') || Post::hasShortcode('gravityform') || Post::hasBlock('html-forms/form') || Post::hasShortcode('hf_form') || (function_exists('WC') && (is_checkout() || is_cart() || is_account_page())) || is_search() || is_404() || (is_home() || get_option('page_for_posts') === get_the_ID())) {
            $assets[] = 'resources/styles/forms.scss';
        }

        if (false) {
            $assets[] = 'resources/styles/modal.scss';
        }

        app()->make(BlockStyles::class)->relevantBlockStyles()
            ->each(function ($bundle) use (&$assets) {
                $assets[] = $bundle;
            });

        return $assets;
    }
}
