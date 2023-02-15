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
    $isAcfBlock = strpos($blockName, 'acf/') !== false;
    $align = $block['attrs']['align'] ?? null;

    // Bootstrap columns
    if ('core/columns' == $blockName) {
        $blockContent = str_replace(
            'wp-block-column is-vertically-aligned-center',
            'is-vertically-aligned-center wp-block-column',
            $blockContent
        );
        $blockContent = str_replace('wp-block-columns', 'row gx-4 wp-block-custom-columns', $blockContent);
        $blockContent = str_replace('wp-block-column" style="flex-basis:66.66%', 'col-md-8', $blockContent);
        $blockContent = str_replace('wp-block-column" style="flex-basis:33.33%', 'col-md-4', $blockContent);
        $blockContent = str_replace('wp-block-column" style="flex-basis:60%', 'col-md-7', $blockContent);
        $blockContent = str_replace('wp-block-column" style="flex-basis:40%', 'col-md-5', $blockContent);
        $blockContent = str_replace('wp-block-column" style="flex-basis:50%', 'col-md-6', $blockContent);
        $blockContent = str_replace('wp-block-column" style="flex-basis:25%', 'col-md-3', $blockContent);
        $blockContent = str_replace('wp-block-column', 'col-md', $blockContent);
    }

    // Bootstrap tables
    if ('core/table' == $blockName) {
        $blockContent = str_replace('<table>', '<table class="table">', $blockContent);
    }

    // Add fancybox to gallery
    if ('core/image' == $blockName) {
        preg_match('/href="(.*?)"/', $blockContent, $matches);
        $url = $matches[1];
        $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));
        $imageExts = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];

        if (in_array($ext, $imageExts)) {
            $blockContent = str_replace('href', 'data-fancybox="wp-gallery" href', $blockContent);
        }
    }

    // Bootstrap search
    if ('core/search' == $blockName) {
        $blockContent = str_replace(
            'wp-block-search__button-outside wp-block-search__text-button wp-block-search',
            'search-form',
            $blockContent
        );
        $blockContent = str_replace('wp-block-search__inside-wrapper', '', $blockContent);
        $blockContent = str_replace('wp-block-search__label', 'form-label', $blockContent);
        $blockContent = str_replace('wp-block-search__input', 'form-control', $blockContent);
        $blockContent = str_replace('wp-block-search__button ', 'btn btn-primary mt-3', $blockContent);
    }

    // Bootstrap search block
    if ('core/media-text' == $blockName) {
        $blockContent = str_replace('wp-block-media-text ', 'wp-block-media-text-custom row ', $blockContent);
        $blockContent = str_replace('wp-block-media-text__media', 'col-lg-6', $blockContent);
        $blockContent = str_replace('wp-block-media-text__content', 'col-lg-6', $blockContent);
    }

    // Add/remove containers for default blocks
    if (!$isAcfBlock) {
        if ('wide' == $align) {
            $blockContent = '</div><div class="container container--wide">' . $blockContent . '</div><div class="container">'; // phpcs:ignore
        } elseif ('full' == $align) {
            $blockContent = '</div>' . $blockContent . '<div class="container">';
        }
    }

    // Bootstrap text-center
    if ($blockName == 'acf/buttons') {
        $blockContent = str_replace('align-text-center', 'justify-content-center', $blockContent);
        $blockContent = str_replace('align-text-right', 'justify-content-end', $blockContent);
        $blockContent = str_replace('align-text-left', 'justify-content-start', $blockContent);
    }

    $blockContent = str_replace(
        ['has-text-align-center', 'aligncenter', 'align-text-center'],
        'text-center',
        $blockContent
    );
    $blockContent = str_replace(['has-text-align-right', 'alignright', 'align-text-right'], 'text-end', $blockContent);
    $blockContent = str_replace(['has-text-align-left', 'alignleft', 'align-text-left'], 'text-start', $blockContent);

    $blockContent = str_replace('are-vertically-aligned-center', 'align-items-center', $blockContent);
    $blockContent = str_replace('are-vertically-aligned-top', 'align-items-start', $blockContent);
    $blockContent = str_replace('are-vertically-aligned-bottom', 'align-items-end', $blockContent);

    // Replace color
    $blockContent = preg_replace('/has-(\w+)-color/', 'text-$1', $blockContent);
    $blockContent = preg_replace('/has-(\w+)-color has-text-color/', 'text-$1', $blockContent);

    return $blockContent;
}, 10, 2);
