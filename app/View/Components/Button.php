<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public $tag = '';

    public $theme = '';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($tag = 'a', $theme = 'primary')
    {
        $this->tag = $tag;
        $this->theme = $theme;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return $this->view('components.button');
    }

    /**
     * Element classes
     *
     * @return string
     */
    public function classes()
    {
        return 'btn btn-'.$this->theme;
    }
}
