<?php

namespace App\View\Components\Toast;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Item extends Component
{
    public $href;

    public $active;

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
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return $this->view('components.breadcrumb.item');
    }
}
