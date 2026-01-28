<?php

namespace Flynt\Theme;

use Flynt\FieldVariables;
use Flynt\Utils\Options;

add_action('after_setup_theme', function (): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('woocommerce');

    // Remove type attribute from link and script tags.
    add_theme_support('html5', ['script', 'style']);
});

add_filter('big_image_size_threshold', '__return_false');

add_filter('timber/context', function (array $context): array {
    $context['site']->labels = Options::getTranslatable('Theme')['labels'] ?? [];
    $context['site']->options = Options::getGlobal('Theme')['options'] ?? [];
    return $context;
});

Options::addTranslatable('Theme', [
    [
        'label' => __('Labels', 'flynt'),
        'name' => 'labels',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => __('Feed', 'flynt'),
                'instructions' => __('%s is placeholder for site title.', 'flynt'),
                'name' => 'feed',
                'type' => 'text',
                'default_value' => __('%s Feed', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('Skip to main content', 'flynt'),
                'name' => 'skipToMainContent',
                'type' => 'text',
                'default_value' => __('Skip to main content', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('Main Content – Aria Label', 'flynt'),
                'name' => 'mainContentAriaLabel',
                'type' => 'text',
                'default_value' => __('Main Content', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
        ],
    ],
]);

Options::addGlobal('Theme', [
    [
        'name' => 'optionsTab',
        'label' => __('Options', 'flynt'),
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    ],
    [
        'name' => 'options',
        'label' => __('Options', 'flynt'),
        'type' => 'group',
        'sub_fields' => [
            FieldVariables\getTheme(),
        ],
    ],
]);
