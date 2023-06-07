<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class Block extends Component
{
    /**
     * The ACF block
     *
     * @var mixed
     */
    public $acfBlock;

    /**
     * Option background for this block
     *
     * @var string|bool
     */
    public $background;

    /**
     * Create a new component instance.
     *
     * @param  mixed  $block
     * @param  bool|string  $background
     */
    public function __construct($block, $background = false)
    {
        $this->acfBlock = $block;
        $this->background = $background;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return $this->view('components.block');
    }

    /**
     * Check if container needs to be closed & reopened
     */
    public function extendsOutsideContainer(): bool
    {
        $alignmentsOutsideContainer = ['full', 'wide'];

        return in_array($this->acfBlock->block->align, $alignmentsOutsideContainer);
    }

    /**
     * Check if container should be wide
     */
    public function wide(): bool
    {
        return 'wide' == $this->acfBlock->block->align;
    }

    /**
     * Get default block attributes: class & optional ID
     */
    public function defaultAttributes(): array
    {
        $defaultClasses = ['block'];
        $acfBlockClasses = explode(' ', $this->acfBlock->classes);
        $extraClasses = $this->extraClasses();

        $classes = array_merge($defaultClasses, $acfBlockClasses, $extraClasses);

        $removeClasses = [];
        if (! is_admin()) {
            $removeClasses = ['alignwide', 'alignfull'];
        }

        $attributes = [
            'class' => implode(' ', array_diff($classes, $removeClasses)),
        ];

        if (isset($this->acfBlock->block->anchor)) {
            $attributes['id'] = $this->acfBlock->block->anchor;
        }

        return $attributes;
    }

    private function extraClasses(): array
    {
        $extraClasses = [];

        if (property_exists($this->acfBlock->block, 'backgroundColor')) {
            $extraClasses[] = 'has-background-color';
            $extraClasses[] = 'bg-'.$this->acfBlock->block->backgroundColor;
        }
        if (property_exists($this->acfBlock->block, 'textColor')) {
            $extraClasses[] = 'has-text-color';
            $extraClasses[] = 'text-'.$this->acfBlock->block->textColor;
        }

        return $extraClasses;
    }
}
