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
        $blockContent = str_replace('wp-block-columns', 'row gx-4 wp-block-custom-columns', $blockContent);
        $blockContent = str_replace('wp-block-column" style="flex-basis:66.66%', 'col-md-8', $blockContent);
        $blockContent = str_replace('wp-block-column" style="flex-basis:33.33%', 'col-md-4', $blockContent);
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
        $blockContent = str_replace('href', 'data-fancybox="wp-gallery" href', $blockContent);
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

    // Remove container for separator or wide, non-acf blocks
    if ('core/separator' == $blockName || (!$isAcfBlock && $align && in_array($align, ['wide', 'full']))) {
        $blockContent = '</div>' . $blockContent . '<div class="container">';
    }

    // Bootstrap text-center
    $blockContent = str_replace('has-text-align-center', 'text-center', $blockContent);
    $blockContent = str_replace('has-text-align-right', 'text-right', $blockContent);
    $blockContent = str_replace('has-text-align-left', 'text-left', $blockContent);

    return $blockContent;
}, 10, 2);

add_filter('ninja_forms_admin_parent_menu_capabilities', '\\App\\returnEditPages');
add_filter('ninja_forms_admin_all_forms_capabilities', '\\App\\returnEditPages');
add_filter('ninja_forms_admin_parent_menu_capabilities', '\\App\\returnEditPages');
add_filter('ninja_forms_admin_add_new_capabilities', '\\App\\returnEditPages');
add_filter('ninja_forms_admin_submissions_capabilities', '\\App\\returnEditPosts');
add_filter('ninja_forms_admin_parent_menu_capabilities', '\\App\\returnEditPosts');
add_filter('ninja_forms_admin_menu_capabilities', '\\App\\returnEditPosts');
