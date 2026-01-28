<?php

namespace Flynt\BlockEditor;

// Disable Full Site Editing
define('DISABLE_FSE', '__return_true');

// Disable Templates and Template Parts in Block Editor
add_filter('block_editor_settings_all', function (array $settings): array {
    $settings['supportsTemplateMode'] = false;
    return $settings;
}, 10);

// Disable Gutenberg editor
add_filter('use_block_editor_for_post', '__return_false');
add_filter('use_block_editor_for_post_type', '__return_false');

// Remove rich text editor from WordPress pages, since Flynt uses components
add_action('init', function (): void {
    remove_post_type_support('page', 'editor');
    remove_action('wp_enqueue_scripts', 'wp_enqueue_classic_theme_styles');
});

// Remove Gutenberg block related styles on front-end, when a post has no blocks
add_action('wp_enqueue_scripts', function (): void {
    if (has_blocks()) {
        return;
    }

    wp_dequeue_style('core-block-supports');
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wp-global-styles');
    wp_dequeue_style('block-style-variation-styles');
});

// This filter hook forces the Visual Editor to be the default when editing posts or pages
add_filter('wp_default_editor', function ($editor): string {
    return 'tinymce';
});
