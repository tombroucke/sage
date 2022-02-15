<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use Log1x\Navi\Navi;

class Navigation extends Composer
{

    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.navigation',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'navigation' => $this->navigation(),
        ];
    }

    /**
     * Returns the primary navigation.
     *
     * @return array
     */
    public function navigation()
    {
        $navMenu = $this->data->get('nav_menu') ?: 'primary_navigation';

        $navigation = (new Navi())->build($navMenu);

        if ($navigation->isEmpty()) {
            return;
        }

        return $navigation->toArray();
    }
}
