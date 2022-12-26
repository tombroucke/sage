<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class App extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var string[]
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
            'containerClass' => $this->containerClass(),
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
     * Get the container class
     *
     * @return string
     */
    public function containerClass(): string
    {
        $classes = ['container'];
        if (
            ( function_exists('is_woocommerce') && is_woocommerce() )
            || is_home()
            || is_post_type_archive()
            || is_category()
            || is_tag()
        ) {
            $classes[] = 'container--wide';
        }
        return implode(' ', $classes);
    }
}
