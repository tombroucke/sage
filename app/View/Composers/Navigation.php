<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use Log1x\Navi\Navi;

class Navigation extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var string[]
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
            return [];
        }

        $navigationArray = $navigation->toArray();

        foreach ($navigationArray as &$navigationArrayItem) {
            $navigationArrayItem->icons = [];
            foreach (explode(' ', $navigationArrayItem->classes) as $key => $class) {
                preg_match('/^(fa[srldbc]?-)/', $class, $matches);
                if (! empty($matches)) {
                    $fa_prefix = rtrim($matches[0], '-');
                    $icon = ltrim(ltrim($class, $fa_prefix), '-');
                    $navigationArrayItem->label = \Roots\view('components/icon', [
                        'icon' => $fa_prefix . '-' . $icon
                    ]) . $navigationArrayItem->label;
                    $navigationArrayItem->classes = str_replace($icon, '', $navigationArrayItem->classes);
                }
            }
        }

        foreach ($navigationArray as $key => &$navItem) {
            if (preg_match('/btn btn-([a-z]+)/', $navItem->classes, $matches)) {
                $navItem->buttonTheme = $matches[1];
                $navItem->classes = str_replace($matches[0], '', $navItem->classes);
            } elseif (preg_match('/btn-([a-z]+) btn/', $navItem->classes, $matches)) {
                $navItem->buttonTheme = $matches[1];
                $navItem->classes = str_replace($matches[0], '', $navItem->classes);
            }
        }
        return $navigationArray;
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
