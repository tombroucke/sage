<?php

/**
 * Theme setup.
 */

namespace App;

use function Roots\bundle;

/**
 * Register the theme assets.
 *
 * @return void
 */
add_action('wp_enqueue_scripts', function () {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('global-styles');

    wp_dequeue_script('jquery');
    wp_deregister_script('jquery');


    bundle('app')->enqueue();
    app()->get('block-assets')->filterHasBlock()->enqueue();
}, 100);

/**
 * Register the theme assets with the block editor.
 *
 * @return void
 */
add_action('enqueue_block_editor_assets', function () {
    bundle('editor')->enqueue();

    app()->get('block-assets')->enqueue();
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
     * Enable features from the Soil plugin if activated.
     *
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil', [
        'clean-up',
        'nav-walker',
        'nice-search',
        'relative-urls',
    ]);

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
     * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#responsive-embedded-content
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
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
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

load_theme_textdomain('sage', get_template_directory() . '/resources/lang');

remove_filter('render_block', 'wp_render_layout_support_flag', 10, 2);
remove_filter('render_block', 'gutenberg_render_layout_support_flag', 10, 2);

add_filter('block_categories', function ($categories, $post) {
    return array_merge(
        $categories,
        array(
            array(
                'slug'  => 'custom',
                'title' => ucfirst('%themename%'),
            ),
        )
    );
}, 10, 2);

add_action('acf/init', function () {
    if (getenv('GOOGLE_MAPS_KEY')) {
        acf_update_setting('google_api_key', getenv('GOOGLE_MAPS_KEY'));
    }
});
