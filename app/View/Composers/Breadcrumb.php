<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Breadcrumb extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var string[]
     */
    protected static $views = [
        'partials.breadcrumb',
    ];

    /**
     * Breadcrumb items to be passed to view
     *
     * @return array
     */
    public function crumbs()
    {
        $items = [[
            'label' => __('Home', 'sage'),
            'url' => ! is_front_page() ? home_url('/') : false,
        ]];

        if (is_front_page()) {
            return $items;
        }

        if (is_singular()) {
            if (get_post_type() == 'post' && get_option('page_for_posts')) {
                $items[] = [
                    'label' => get_the_title(get_option('page_for_posts')),
                    'url' => get_permalink(get_option('page_for_posts')),
                ];
            } elseif (! in_array(get_post_type(), ['page', 'post'])) {
                $postTypeObject = get_post_type_object(get_post_type());
                $items[] = [
                    'label' => $postTypeObject->labels->name,
                    'url' => get_post_type_archive_link(get_post_type()),
                ];
            }

            foreach (get_post_ancestors(get_the_ID()) as $ancestorId) {
                $items[] = [
                    'label' => get_the_title($ancestorId),
                    'url' => get_permalink($ancestorId),
                ];
            }

            $items[] = [
                'label' => get_the_title(),
            ];
        } elseif (is_post_type_archive()) {
            $items[] = [
                'label' => post_type_archive_title('', false),
            ];
        } elseif (is_home()) {
            $items[] = [
                'label' => get_the_title(get_option('page_for_posts')),
            ];
        } elseif (is_category() || is_tag()) {
            $items[] = [
                'label' => get_the_title(get_option('page_for_posts')),
                'url' => get_permalink(get_option('page_for_posts')),
            ];
            $items[] = [
                'label' => single_cat_title('', false),
            ];
        } elseif (is_tax()) {
            $postTypeObject = get_post_type_object(get_post_type());
            $items[] = [
                'label' => $postTypeObject->labels->name,
                'url' => get_post_type_archive_link(get_post_type()),
            ];
            $items[] = [
                'label' => single_cat_title('', false),
            ];
        } elseif (is_search()) {
            $items[] = [
                'label' => __('Search'),
            ];
        }

        return $items;
    }
}
