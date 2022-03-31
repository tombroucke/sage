<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Breadcrumb extends Composer
{
    /**
    * List of views served by this composer.
    *
    * @var array
    */
    protected static $views = [
        'partials.breadcrumb',
    ];

    /**
    * Data to be passed to view before rendering.
    *
    * @return array
    */
    public function with()
    {
        return [
            'breadcrumbItems' => $this->breadcrumbItems(),
        ];
    }

    public function breadcrumbItems() {
        $breadcrumbItems = [];
        $breadcrumbItems[] = [
            'label' => __('Home', 'sage'),
            'url' => !is_front_page() ? home_url('/') : false,
        ];

        if (is_singular()) {
            if (get_post_type() == 'post') {
                $breadcrumbItems[] = [
                    'label' => get_the_title(get_option('page_for_posts')),
                    'url' => get_permalink(get_option('page_for_posts')),
                ];
            } elseif(get_post_type() != 'page') {
                $postTypeObject = get_post_type_object(get_post_type());
                $breadcrumbItems[] = [
                    'label' => $postTypeObject->labels->name,
                    'url' => get_post_type_archive_link(get_post_type()),
                ];
            }

            foreach(get_post_ancestors(get_the_ID()) as $ancestorId) {
                $breadcrumbItems[] = [
                    'label' => get_the_title($ancestorId),
                    'url' => get_permalink($ancestorId),
                ];
            }

            $breadcrumbItems[] = [
                'label' => get_the_title(),
            ];
        } elseif (is_post_type_archive()) {
            $breadcrumbItems[] = [
                'label' => post_type_archive_title(null, false),
            ];
        } elseif (is_home()) {
            $breadcrumbItems[] = [
                'label' => get_the_title(get_option('page_for_posts')),
            ];
        } elseif (is_category()) {
            $breadcrumbItems[] = [
                'label' => get_the_title(get_option('page_for_posts')),
                'url' => get_permalink(get_option('page_for_posts')),
            ];
            $breadcrumbItems[] = [
                'label' => single_cat_title('', false),
            ];
        } elseif (is_tax()) {
            $postTypeObject = get_post_type_object(get_post_type());
            $breadcrumbItems[] = [
                'label' => $postTypeObject->labels->name,
                'url' => get_post_type_archive_link(get_post_type()),
            ];
            $breadcrumbItems[] = [
                'label' => single_cat_title('', false),
            ];
        }
        return $breadcrumbItems;
    }
}
