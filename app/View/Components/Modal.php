<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public $id = '';

    public $label = '';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(?string $id = null)
    {
        $uniqueId = uniqid();
        $this->id = $id ?: 'modal-'.$uniqueId;
        $this->label = $this->id.'-label';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return $this->view('components.modal');
    }
}
