<?php

namespace App;

use Illuminate\Support\Collection;

class Post
{

    private ?Collection $blocks = null;

    private ?string $content = null;

    public function __construct(private int $postId)
    {
    }

    /**
     * Has block implementation counting with reusable blocks
     *
     * @param string $blockName Full Block type to look for.
     * @return bool
     */
    public function hasBlock($blockName)
    {
        if (has_block($blockName)) {
            return true;
        }

        if (empty($this->blocks())) {
            return false;
        }
        $hasBlock = $this->allBlocks()->contains('blockName', $blockName);
        return $hasBlock;
    }

    /**
     * Get all blocks in this page, including innerblocks
     *
     * @return Collection
     */
    public function postBlocks(Collection $blocks = null) : Collection
    {
        $blocks->each(function ($block) use (&$blocks) {
            if (empty($block['innerBlocks'])) {
                return;
            }
            $innerBlocks = collect($block['innerBlocks']);
            $blocks = $blocks->merge($this->postBlocks($innerBlocks));
        });

        return $blocks;
    }

    /**
     * Get all blocks, including reusable blocks
     *
     * @return Collection
     */
    public function allBlocks() : Collection
    {
        $topLevelBlocks = $this->blocks();
        $postBlocks = $this->postBlocks($topLevelBlocks);

        $postBlocks
            ->filter(function ($block) {
                return $block['blockName'] === 'core/block';
            })
            ->each(function ($block) use (&$postBlocks) {
                if (empty($block['attrs']['ref'])) {
                    return;
                }
                $reusablePost = new Post($block['attrs']['ref']);
                $postBlocks = $postBlocks->merge($reusablePost->allBlocks());
            });

        return $postBlocks->unique('blockName');
    }

    /**
     * Get the post content
     *
     * @return string
     */
    public function content() : string
    {
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = get_post_field('post_content', $this->postId);
        return $this->content;
    }

    /**
     * Get get blocks from the post content
     *
     * @return Collection
     */
    private function blocks() : Collection
    {
        if (!$this->blocks instanceof Collection) {
            return collect(parse_blocks($this->content()));
        }

        return $this->blocks;
    }
}
