<?php

namespace App;

use Illuminate\Support\Collection;

class Post
{
    private ?Collection $blocks = null;

    private ?string $content = null;

    private Collection $checkedBlocks;

    public function __construct(private int $postId)
    {
        $this->checkedBlocks = collect();
    }

    /**
     * Has block implementation counting with reusable blocks
     *
     * @param  string  $blockName  Full Block type to look for.
     */
    public function hasBlock($blockName): bool
    {
        if ($this->checkedBlocks->has($blockName)) {
            return $this->checkedBlocks->get($blockName);
        }

        $hasBlock = false;

        if (has_block($blockName)) {
            $hasBlock = true;
        } elseif (empty($this->blocks())) {
            $hasBlock = false;
        } else {
            $hasBlock = $this->allBlocks()->contains('blockName', $blockName);
        }

        $this->checkedBlocks->put($blockName, $hasBlock);

        return $hasBlock;
    }

    /**
     * Has shortcode implementation
     *
     * @param  string  $shortcode  Shortcode to look for.
     */
    public function hasShortcode($shortcode): bool
    {
        return has_shortcode($this->content(), $shortcode);
    }

    /**
     * Get all blocks in this page, including innerblocks
     */
    public function postBlocks(?Collection $blocks = null): Collection
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
     */
    public function allBlocks(): Collection
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
     */
    public function content(): string
    {
        if ($this->content === null) {
            $this->content = get_post_field('post_content', $this->postId);
        }

        return $this->content;
    }

    /**
     * Get get blocks from the post content
     */
    private function blocks(): Collection
    {
        if (! $this->blocks instanceof Collection) {
            $this->blocks = collect(parse_blocks($this->content()));
        }

        return $this->blocks;
    }
}
