<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Badge extends Component
{
    public $theme = '';

    public $pill;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($theme = 'primary', $pill = false)
    {
        $this->theme = $theme;
        $this->pill = $pill;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return $this->view('components.badge');
    }

    /**
     * Element classes
     *
     * @return string
     */
    public function classes()
    {
        $classes = [];
        $classes[] = 'badge';
        $classes[] = 'bg-'.$this->theme;
        if ($this->pill) {
            $classes[] = 'rounded-pill';
        }

        return implode(' ', $classes);
    }
}
