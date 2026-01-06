<?php

namespace App\Helpers;

use App\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Log1x\AcfComposer\Block;

class BlockStyles
{
    /**
     * Blocks that will be enqueued
     */
    private Collection $blockStyles;

    private string $blockStylesPath = 'styles/blocks/';

    private Post $post;

    private Application $app;

    private ?Collection $acfBlocks = null;

    /**
     * Collect all styles filter out blocks
     */
    public function __construct(Application $app, Post $post)
    {
        $this->app = $app;
        $this->post = $post;
        $this->acfBlocks = $this->acfBlocks();

        $this->blockStyles = collect(glob(resource_path($this->blockStylesPath . '/*.scss')))
            ->map(fn ($filePath) => basename($filePath))
            ->reject(fn ($fileName) => Str::startsWith($fileName, ['_', 'index']));
    }

    /**
     * Get all available acf blocks
     */
    public function acfBlocks(): Collection
    {
        if (! $this->acfBlocks) {
            $acfComposer = $this->app->make('AcfComposer');
            $composers = collect($acfComposer->composers());
            $this->acfBlocks = $composers
                ->flatten()
                ->filter(fn ($composer) => $composer instanceof Block)
                ->map(fn ($composer) => $composer->namespace);
        }

        return $this->acfBlocks;
    }

    /**
     * Return the styles for the blocks that are used on the page
     */
    public function relevantBlockStyles(): Collection
    {
        return $this->blockStyles
            ->map(fn ($blockStyle) => Str::of(resource_path($this->blockStylesPath . $blockStyle))
                ->replace(base_path(), '')
                ->chopStart('/')
                ->toString())
            ->filter(function (string $blockStyle) {
                $blockName = Str::of($blockStyle)
                    ->replaceFirst($this->blockStylesPath, '')
                    ->replace('.scss', '');

                return $this->post->hasBlock($this->prependNamespace($blockName));
            });
    }

    /**
     * Return all styles for all blocks
     */
    public function allBlockStyles(): Collection
    {
        return $this->blockStyles
            ->map(fn ($blockStyle) => Str::of(resource_path($this->blockStylesPath . $blockStyle))
                ->replace(base_path(), '')
                ->chopStart('/')
                ->toString());
    }

    /**
     * Prepend the correct namespace to the blockname
     */
    public function prependNamespace(string $blockname): string
    {
        $blockBaseName = basename($blockname);
        $namespace = 'core/';

        if ($this->acfBlocks()->contains('acf/' . $blockBaseName)) {
            $namespace = 'acf/';
        }

        return $namespace . $blockBaseName;
    }
}
