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
    // Bootstrap columns
    if ($block['blockName'] == 'core/columns') {
        $blockContent = str_replace('wp-block-columns', 'row gx-4 wp-block-custom-columns', $blockContent);
        $blockContent = str_replace('wp-block-column" style="flex-basis:66.66%', 'col-md-7', $blockContent);
        $blockContent = str_replace('wp-block-column" style="flex-basis:33.33%', 'col-md-5', $blockContent);
        $blockContent = str_replace('wp-block-column" style="flex-basis:50%', 'col-md-6', $blockContent);
        $blockContent = str_replace('wp-block-column" style="flex-basis:25%', 'col-md-3', $blockContent);
        $blockContent = str_replace('wp-block-column', 'col-md', $blockContent);
    }

    // Separator in container
    if ($block['blockName'] == 'core/separator') {
        $blockContent = '</div>' . $blockContent . '<div class="container">';
    }

    // Bootstrap tables
    if ($block['blockName'] == 'core/table') {
        $blockContent = str_replace('<table>', '<table class="table">', $blockContent);
    }

    // Add fancybox to gallery
    if ($block['blockName'] == 'core/image') {
        $blockContent = str_replace('href', 'data-fancybox="wp-gallery" href', $blockContent);
    }

    // Bootstrap search
    if ($block['blockName'] == 'core/search') {
        $blockContent = str_replace('wp-block-search__button-outside wp-block-search__text-button wp-block-search', 'search-form', $blockContent);
        $blockContent = str_replace('wp-block-search__inside-wrapper', '', $blockContent);
        $blockContent = str_replace('wp-block-search__label', 'form-label', $blockContent);
        $blockContent = str_replace('wp-block-search__input', 'form-control', $blockContent);
        $blockContent = str_replace('wp-block-search__button ', 'btn btn-primary mt-3', $blockContent);
    }

    // Bootstrap search block
    if ($block['blockName'] == 'core/media-text') {
        $blockContent = str_replace('wp-block-media-text ', 'wp-block-media-text-custom row ', $blockContent);
        $blockContent = str_replace('wp-block-media-text__media', 'col-lg-6', $blockContent);
        $blockContent = str_replace('wp-block-media-text__content', 'col-lg-6', $blockContent);
    }

    // ACF blocks outside of container if align is full or wide
    if (strpos($block['blockName'], 'acf/') === false && isset($block['attrs']['align']) && ($block['attrs']['align'] == 'full' || $block['attrs']['align'] == 'wide')) {
        $blockContent = '</div>' . $blockContent . '<div class="container">';
    }

    // Bootstrap text-center
    $blockContent = str_replace(array('has-text-align-center', 'text-center'), 'text-center', $blockContent);
    $blockContent = str_replace(array('has-text-align-right', 'text-right'), 'text-right', $blockContent);
    $blockContent = str_replace(array('has-text-align-left', 'text-left'), 'text-left', $blockContent);

    return $blockContent;
}, 10, 2);

function ninjaFormsAdminCapabilities($capabilities)
{
    $capabilities = 'edit_pages';
    return $capabilities;
}
add_filter('ninja_forms_admin_parent_menu_capabilities', __NAMESPACE__ . '\\ninjaFormsAdminCapabilities');
add_filter('ninja_forms_admin_all_forms_capabilities', __NAMESPACE__ . '\\ninjaFormsAdminCapabilities');

function ninjaFormsNewFormCapabilities($capabilities)
{
    $capabilities = 'edit_pages';
    return $capabilities;
}
add_filter('ninja_forms_admin_parent_menu_capabilities', __NAMESPACE__ . '\\ninjaFormsNewFormCapabilities');
add_filter('ninja_forms_admin_add_new_capabilities', __NAMESPACE__ . '\\ninjaFormsNewFormCapabilities');

function ninjaFormsSubmissionCapabilities($cap)
{
    return 'edit_posts';
}
add_filter('ninja_forms_admin_submissions_capabilities', __NAMESPACE__ . '\\ninjaFormsSubmissionCapabilities');
add_filter('ninja_forms_admin_parent_menu_capabilities', __NAMESPACE__ . '\\ninjaFormsSubmissionCapabilities');
add_filter('ninja_forms_admin_menu_capabilities', __NAMESPACE__ . '\\ninjaFormsSubmissionCapabilities');
