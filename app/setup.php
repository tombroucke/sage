<?php

/**
 * Theme setup.
 */

namespace App;

use App\Helpers\BlockAssets;
use Log1x\AcfComposer\Contracts\Block;
use Post;

use function Roots\bundle;

/**
 * Register the theme assets.
 *
 * @return void
 */
add_action('wp_enqueue_scripts', function () {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('classic-theme-styles');

    wp_dequeue_script('jquery');
    wp_deregister_script('jquery');

    bundle('fonts')->enqueue();
    bundle('app')->enqueue()->localize('sageVars', [
        'googleMapsKey' => getenv('GOOGLE_MAPS_KEY'),
    ]);

    app()->make(BlockAssets::class)->enqueueRelevantBundles();

    bundle('fancybox')->when(function () {
        return Post::hasBlock('core/image') || Post::hasBlock('acf/gallery');
    })->enqueue();

    bundle('swiper')->when(function () {
        return Post::hasBlock('acf/carousel') || Post::hasBlock('acf/logos');
    })->enqueue();

    // bundle('modal')->when(function () {
    //     return true;
    // })->enqueue();

    bundle('tables')->when(function () {
        return Post::hasBlock('core/table')
        || (function_exists('WC') && (is_checkout() || is_cart() || is_account_page()));
    })->enqueue();

    bundle('forms')->when(function () {
        $result =
            Post::hasBlock('gravityforms/form') || Post::hasShortcode('gravityform')
            || Post::hasBlock('html-forms/form') || Post::hasShortcode('hf_form')
            || (function_exists('WC') && (is_checkout() || is_cart() || is_account_page()))
            || is_search()
            || is_404()
            || (is_home() || get_option('page_for_posts') === get_the_ID());

        return $result;
    })->enqueue();

}, 100);

/**
 * Register the theme assets with the block editor.
 *
 * @return void
 */
add_action('enqueue_block_editor_assets', function () {
    bundle('fonts')->enqueue();
    bundle('editor')->enqueue();

    app()->make(BlockAssets::class)->enqueueAllBundles();
}, 100);

add_action('after_setup_theme', function () {
    remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
    remove_action('wp_body_open', 'gutenberg_global_styles_render_svg_filters');
});

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    /**
     * Disable full-site editing support.
     *
     * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
     */
    remove_theme_support('block-templates');

    /**
     * Register the navigation menus.
     *
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'top_navigation' => __('Top Navigation', 'sage'),
        'primary_navigation' => __('Primary Navigation', 'sage'),
        'credits_navigation' => __('Credits Navigation', 'sage'),
    ]);

    /**
     * Disable the default block patterns.
     *
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support('core-block-patterns');

    /**
     * Enable plugins to manage the document title.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail support.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable responsive embed support.
     *
     * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#responsive-embedded-content
     */
    add_theme_support('responsive-embeds');

    /**
     * Enable HTML5 markup support.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style',
    ]);

    /**
     * Enable selective refresh for widgets in customizer.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#customize-selective-refresh-widgets
     */
    add_theme_support('customize-selective-refresh-widgets');
}, 20);

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id' => 'sidebar-primary',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
    ]);

    register_sidebar([
        'name' => __('Footer', 'sage'),
        'id' => 'sidebar-footer',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
        'before_widget' => '<section class="widget %1$s %2$s col-md">',
        'after_widget' => '</section>',
    ]);
});

load_theme_textdomain('sage', get_template_directory().'/resources/lang');

add_filter('block_categories', function ($categories, $post) {
    return array_merge(
        $categories,
        [
            [
                'slug' => 'custom',
                'title' => ucfirst('%themename%'),
            ],
        ]
    );
}, 10, 2);

add_action('acf/init', function () {
    if (! getenv('GOOGLE_MAPS_KEY')) {
        return;
    }
    acf_update_setting('google_api_key', getenv('GOOGLE_MAPS_KEY'));
});

add_filter('allowed_block_types_all', function ($allowedBlocks, $editorContext) {
    $acfComposer = app()->make('AcfComposer');
    $customBlockTypes = collect($acfComposer->composers())
        ->flatten()
        ->filter(fn ($composer) => $composer instanceof Block)
        ->map(fn ($composer) => $composer->namespace);

    return array_merge([
        'core/column',
        'core/columns',
        'core/embed',
        'core/group',
        'core/heading',
        'core/html',
        'core/image',
        'core/list-item',
        'core/list',
        'core/paragraph',
        'core/pullquote',
        'core/separator',
        'core/shortcode',
        'core/spacer',
        'core/table',
        'gravityforms/form',
        'html-forms/form',
    ], $customBlockTypes->toArray());
}, 25, 2);
