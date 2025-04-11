<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

add_filter('render_block', function ($blockContent, $block) {
    $blockName = $block['blockName'];

    // Bootstrap search
    if ($blockName == 'core/search') {
        $blockContent = str_replace(
            'wp-block-search__button-outside wp-block-search__text-button wp-block-search',
            'search-form',
            $blockContent
        );
        $blockContent = str_replace('wp-block-search__inside-wrapper', '', $blockContent);
        $blockContent = str_replace('wp-block-search__label', 'form-label', $blockContent);
        $blockContent = str_replace('wp-block-search__input', 'form-control', $blockContent);
        $blockContent = str_replace('wp-block-search__button ', 'btn btn-primary mt-3 ', $blockContent);
    }

    // Bootstrap tables
    if ($blockName == 'core/table') {
        $blockContent = str_replace('<table class="', '<table class="table ', $blockContent);
        $blockContent = str_replace('<table>', '<table class="table">', $blockContent);
    }

    // Add fancybox to gallery
    if ($blockName == 'core/image') {
        preg_match('/href="(.*?)"/', $blockContent, $matches);
        if (isset($matches[1])) {
            $url = $matches[1];
            $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));
            $imageExts = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];

            if (in_array($ext, $imageExts)) {
                $blockContent = str_replace('href', 'data-fancybox="wp-gallery" href', $blockContent);
            }
        }
    }

    return $blockContent;
}, 10, 2);
