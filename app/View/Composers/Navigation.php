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
            'menuName' => $this->menuName(),
        ];
    }

    /**
     * Returns the primary navigation.
     *
     * @return array
     */
    public function navigation()
    {
        $navigation = (new Navi())->build($this->navMenu());

        if ($navigation->isEmpty()) {
            return;
        }

        $navArray = $navigation->toArray();

        foreach ($navArray as &$navArrayItem) {
            $navArrayItem->icons = [];
            foreach (explode(' ', $navArrayItem->classes) as $key => $class) {
                preg_match('/^(fa[srldbc]?-)/', $class, $matches);
                if (! empty($matches)) {
                    $fa_prefix = rtrim($matches[0], '-');
                    $icon = ltrim(ltrim($class, $fa_prefix), '-');
                    $navArrayItem->label = '<i class="' . $fa_prefix . ' fa-' . $icon . '"></i>' . $navArrayItem->label;
                    $navArrayItem->classes = str_replace($icon, '', $navArrayItem->classes);
                }
            }
        }

        return $navigation->toArray();
    }

    private function navMenu()
    {
        return $this->data->get('nav_menu') ?: 'primary_navigation';
    }

    public function menuName()
    {
        return $this->data->get('menu_name') ?: str_replace('_navigation', '', $this->navMenu());
    }
}
