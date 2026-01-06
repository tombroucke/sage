<?php

namespace App\View\Composers;

use App\Exceptions\BlockAssetNotFound;
use App\Facades\Post;
use App\Helpers\BlockStyles;
use Illuminate\Support\Facades\Vite;
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
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'siteName' => $this->siteName(),
            'viteAssets' => $this->viteAssets(),
            'allowedTinyMceTags' => $this->allowedTinyMceTags(),
            'allowedInlineTags' => $this->allowedInlineTags(),
            'sageVars' => $this->sageVars(),
        ];
    }

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

        if (Post::hasBlock('gravityforms/form') || Post::hasShortcode('gravityform') || Post::hasBlock('html-forms/form') || Post::hasShortcode('hf_form') || (function_exists('WC') && (is_checkout() || is_product() || is_cart() || is_account_page())) || is_search() || is_404() || (is_home() || get_option('page_for_posts') === get_the_ID())) {
            $assets[] = 'resources/styles/forms.scss';
        }

        if (false) {
            $assets[] = 'resources/styles/modal.scss';
        }

        app()->make(BlockStyles::class)->relevantBlockStyles()
            ->each(function ($asset) use (&$assets) {

                try {
                    $url = Vite::asset($asset);
                } catch (\Exception $e) {
                    throw new BlockAssetNotFound($asset);
                }

                $assets[] = $asset;
            });

        return $assets;
    }

    /**
     * Returns the TinyMCE allowed tags to use in wp_kses.
     *
     * @return array
     */
    public function allowedTinyMceTags()
    {
        return [
            'a' => [
                'href' => [],
                'title' => [],
                'target' => [],
                'rel' => [],
            ],
            'img' => [
                'src' => [],
                'alt' => [],
                'width' => [],
                'height' => [],
            ],
            'p' => [],
            'h1' => [],
            'h2' => [],
            'h3' => [],
            'h4' => [],
            'h5' => [],
            'h6' => [],
            'strong' => [],
            'em' => [],
            'ul' => [],
            'ol' => [],
            'li' => [],
            'blockquote' => [],
            'br' => [],
            'hr' => [],
            'span' => [
                'style' => [],
                'class' => [],
            ],
            'div' => [
                'style' => [],
                'class' => [],
            ],
            'code' => [],
            'pre' => [],
            'table' => [
                'class' => [],
                'style' => [],
            ],
            'thead' => [
                'class' => [],
                'style' => [],
            ],
            'tbody' => [
                'class' => [],
                'style' => [],
            ],
            'tfoot' => [
                'class' => [],
                'style' => [],
            ],
            'th' => [
                'class' => [],
                'style' => [],
                'colspan' => [],
                'rowspan' => [],
            ],
            'td' => [
                'class' => [],
                'style' => [],
                'colspan' => [],
                'rowspan' => [],
            ],
        ];
    }

    /**
     * Returns the allowed inline tags to use in wp_kses.
     *
     * @return array
     */
    public function allowedInlineTags()
    {
        return [
            'strong' => [],
            'b' => [],
            'em' => [],
            'i' => [],
            'u' => [],
            'a' => [
                'href' => [],
                'title' => [],
                'target' => [],
                'rel' => [],
            ],
            'span' => [
                'style' => [],
                'class' => [],
            ],
        ];
    }

    /**
     * Variables available in js.
     *
     * @return void
     */
    public function sageVars()
    {
        $vars = [];

        if (env('GOOGLE_MAPS_KEY')) {
            $vars['googleMapsKey'] = env('GOOGLE_MAPS_KEY');
        }

        return $vars;
    }
}
