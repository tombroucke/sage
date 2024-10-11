<?php

namespace App\View\Components\Nav\Tab;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Pane extends Component
{
    public $id = '';

    public $show = false;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $id, bool $show = false)
    {
        $this->id = $id;
        $this->show = $show;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return $this->view('components.nav.tab.pane');
    }
}
