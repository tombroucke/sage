<?php

namespace App\View\Components\Nav;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tabs extends Component
{
    public $type = 'tabs';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $type = 'tabs')
    {
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return $this->view('components.nav.tabs');
    }
}
