<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Roots\Acorn\Assets\Asset\Asset;

use function Roots\bundle;

class BlockAssets
{
    /**
     * Blocks that will be enqueued
     *
     * @var Collection
     */
    private Collection $blocks;

    /**
     * Collect all assets filter out blocks
     */
    public function __construct()
    {
        $manifest = \config('assets.manifests.theme.assets');
        $this->blocks = collect(json_decode(file_get_contents($manifest), true))
            ->keys()
            ->filter(fn ($file) => Str::startsWith($file, 'blocks/'))
            ->map(fn ($file) => asset($file));
    }

    /**
     * Allow custom filter
     *
     * @param callable $function
     * @return BlockAssets
     */
    public function filter(callable $function): BlockAssets
    {
        $this->blocks = $this->blocks->filter($function);
        return $this;
    }

    /**
     * Filter out block bundles in case there's no block added
     *
     * @return BlockAssets
     */
    public function filterHasBlock(): BlockAssets
    {
        $this->blocks = $this->blocks->filter(function (Asset $asset) {
            $filename = pathinfo(basename($asset->path()), PATHINFO_FILENAME);
            $blockname = pathinfo($filename, PATHINFO_FILENAME);
            if (has_block("acf/$blockname") || has_block("core/$blockname")) {
                return true;
            }
            return false;
        });
        return $this;
    }

    /**
     * Enqueue bundles
     *
     * @return void
     */
    public function enqueue(): void
    {
        $this->blocks
            ->each(function (Asset $asset) {
                $filename = pathinfo(basename($asset->path()), PATHINFO_FILENAME);
                $blockname = pathinfo($filename, PATHINFO_FILENAME);
                bundle("blocks/$blockname")->enqueue();
            });
    }
}
