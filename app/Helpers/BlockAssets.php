<?php

namespace App\Helpers;

use App\Post;
use function Roots\bundle;
use Illuminate\Support\Str;
use Log1x\AcfComposer\Block;
use Roots\Acorn\Application;
use Illuminate\Support\Collection;

class BlockAssets
{
    /**
     * Blocks that will be enqueued
     *
     * @var Collection
     */
    private Collection $blocks;

    private Post $post;

    private Application $app;

    private ?Collection $acfBlocks = null;

    /**
     * Collect all assets filter out blocks
     */
    public function __construct(Application $app, Post $post)
    {
        $this->app = $app;
        $this->post = $post;
        $this->acfBlocks = $this->acfBlocks();

        $manifest = \config('assets.manifests.theme.assets');
        $this->blocks = collect(json_decode(file_get_contents($manifest), true))
            ->keys()
            ->filter(fn ($file) => Str::startsWith($file, 'blocks/'))
            ->map(fn ($file) => Str::before($file, '.'));
    }

    /**
     * Get all available acf blocks
     *
     * @return Collection
     */
    public function acfBlocks() : Collection
    {
        if (!$this->acfBlocks) {
            $acfComposer = $this->app->make('AcfComposer');
            $composers = collect($acfComposer->getComposers());
            $this->acfBlocks = $composers
                ->flatten()
                ->filter(function ($composer) {
                    return $composer instanceof Block;
                })
                ->map(function ($composer) {
                    return $composer->namespace;
                });
        }
        return $this->acfBlocks;
    }

    /**
     * Enqueue the assets for the blocks that are used on the page
     *
     * @return void
     */
    public function enqueueRelevantBundles(): void
    {
        $this->blocks->each(function (string $blockname) {
            bundle($blockname)->when(function () use ($blockname) {
                return $this->post->hasBlock($this->prependNamespace($blockname));
            })->enqueue();
        });
    }

    /**
     * Prepend the correct namespace to the blockname
     *
     * @param string $blockname
     * @return string
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

    /**
     * Enqueue all assets for all blocks
     *
     * @return void
     */
    public function enqueueAllBundles(): void
    {
        $this->blocks->each(function (string $blockname) {
            bundle($blockname)->enqueue();
        });
    }
}
