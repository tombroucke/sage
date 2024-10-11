<?php

namespace App\View\Components\Breadcrumb;

use Closure;
use Illuminate\Contracts\View\View;
use Roots\Acorn\View\Component;

class Item extends Component
{
    /**
     * Link URL
     *
     * @var string
     */
    public $href = '';

    /**
     * Whether item is active
     *
     * @var bool
     */
    public $active = false;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($href = false, $active = false)
    {
        $this->href = $href;
        $this->active = $active;
    }

    /**
     * Element classes
     *
     * @return string
     */
    public function classes()
    {
        $classes = ['breadcrumb-item'];
        if ($this->active) {
            $classes[] = 'active';
        }

        return implode(' ', $classes);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return $this->view('components.breadcrumb.item');
    }
}
