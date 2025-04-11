<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Toast extends Component
{
    public $theme = '';

    public $color = '';

    /**
     * Create a new component instance.
     */
    public function __construct($theme = false, $color = false)
    {
        $this->theme = $theme;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return $this->view('components.toast');
    }

    /**
     * Element classes
     *
     * @return string
     */
    public function classes()
    {
        $classes = ['toast'];
        if ($this->theme) {
            $classes[] = 'bg-' . $this->theme;
        }
        if ($this->color) {
            $classes[] = 'text-' . $this->color;
        }

        return implode(' ', $classes);
    }
}
