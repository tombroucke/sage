<?php

namespace App\View\Composers;

use Log1x\Navi\Navi;
use Roots\Acorn\View\Composer;

class Navigation extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var string[]
     */
    protected static $views = [
        'partials.navigation*',
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
        $navigation = (new Navi)->build($this->navMenu());

        if ($navigation->isEmpty()) {
            return [];
        }

        $navigationArray = $navigation->toArray();

        foreach ($navigationArray as &$navItem) {
            $navItem->icons = [];
            foreach (explode(' ', $navItem->classes) as $class) {
                preg_match('/^(fa[srldbc]?-)/', $class, $matches);
                if (empty($matches)) {
                    continue;
                }
                $faPrefix = rtrim($matches[0], '-');
                $icon = ltrim(ltrim($class, $faPrefix), '-');
                $navItem->label = svg($faPrefix.'-'.$icon, 'me-2', ['height' => '1em'])->toHtml().$navItem->label;
                $navItem->classes = str_replace($icon, '', $navItem->classes);
            }

            if (preg_match('/btn btn-([a-z]+)/', $navItem->classes, $matches)) {
                $navItem->buttonTheme = $matches[1];
                $navItem->classes = str_replace($matches[0], '', $navItem->classes);
            }
        }

        return $navigationArray;
    }

    private function navMenu()
    {
        $viewName = $this->view->name();

        return $this->data->get('nav_menu') ?: str_replace('partials.navigation-', '', $viewName).'_navigation';
    }
}
