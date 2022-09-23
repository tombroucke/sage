<?php

namespace App;

use function Roots\bundle;

class CustomBlocks
{
    /**
     * blocks array blockname => bundlename
     *
     * @var array
     */
    private $blocks = [
        // 'acf/hero' => 'blockHero',
    ];

    /**
     * Enqueue bundle for custom blocks.
     *
     * @param boolean $editor Whether to enqueue for the block editor.
     * @return void
     */
    public function enqueue($editor = false)
    {
        foreach ($this->blocks as $blockName => $bundleName) {
            if (!$editor && !has_block($blockName)) {
                continue;
            }
            bundle($bundleName)->enqueue();
        }
    }
}
