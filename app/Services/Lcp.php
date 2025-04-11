<?php

/**
 * Theme setup.
 */

namespace App\Services;

use Post;

class Lcp
{
    private $supposedLcpSrcSet;

    public function __construct()
    {
        $this->supposedLcpSrcSet = collect();
    }

    public function preload()
    {
        if (function_exists('is_product') && is_product()) {
            if ($imageId = wc_get_product()->get_image_id()) {
                $this->addFromImageId($imageId);
            }
        } else {
            collect(Post::allBlocks())
                ->each(function ($block) {
                    collect([
                        'acf/hero' => 'background_image',
                        'acf/hero-slider' => 'items_0_background_image',
                        'acf/banner' => 'background_image',
                    ])
                        ->each(function ($imageKey, $blockName) use ($block) {
                            if ($this->supposedLcpSrcSet->isNotEmpty()) {
                                return;
                            }

                            if ($block['blockName'] == $blockName && isset($block['attrs']['data'][$imageKey]) && ! empty($block['attrs']['data'][$imageKey])) {
                                $this->addFromImageId($block['attrs']['data'][$imageKey]);
                            }
                        });
                });
        }

        $this->supposedLcpSrcSet
            ->each(function (array $image, int $key) {
                $imageUrl = $image['url'];
                $imageWidth = $image['width'];
                $media = 'media="(max-width: ' . $imageWidth . 'px)"';
                if ($key == 0 && $this->supposedLcpSrcSet->count() > 1) {
                    $media = 'media="(min-width: ' . $this->supposedLcpSrcSet[1]['width'] . 'px)"';
                }
                echo '<link rel="preload" href="' . $imageUrl . '" as="image" ' . $media . '>' . PHP_EOL;
            });
    }

    private function addFromImageId(int $imageId)
    {
        $srcSet = wp_get_attachment_image_srcset($imageId, 'large');
        foreach (explode(',', $srcSet) as $src) {
            $trimmedSrc = trim($src);
            $imageArray = explode(' ', $trimmedSrc);
            $image = [
                'url' => $imageArray[0],
                'width' => rtrim($imageArray[1], 'w'),
            ];
            $this->supposedLcpSrcSet->push($image);
        }
    }
}
