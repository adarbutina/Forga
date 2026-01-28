<?php

namespace Flynt\Components\NavigationFooterColumns;

use Flynt\FieldVariables;
use Flynt\Utils\AssetLoader;
use Flynt\Utils\Options;
use Timber\Timber;

add_action('init', function () {
    register_nav_menus([
        'navigation_footer_columns' => __('Navigation: Footer Columns', 'flynt'),
    ]);
});

add_filter('Flynt/addComponentData?name=NavigationFooterColumns', function (array $data): array {
    $data['menu'] = Timber::get_menu('navigation_footer_columns') ?? Timber::get_pages_menu();
    $data['logo'] = [
        'src' => get_theme_mod('custom_logo')
            ? wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full')
            : AssetLoader::requireUrl('assets/images/logo.svg'),
        'alt' => get_bloginfo('name')
    ];

    return $data;
});

Options::addTranslatable('NavigationFooterColumns', [
    [
        'name' => 'contentTab',
        'label' => __('Content', 'flynt'),
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'name' => 'preContentHtml',
        'label' => __('Text', 'flynt'),
        'type' => 'wysiwyg',
        'delay' => 0,
        'media_upload' => 0,
        'toolbar' => 'basic',
    ],
    [
        'name' => 'labelsTab',
        'label' => __('Labels', 'flynt'),
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'name' => 'labels',
        'label' => '',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => __('Navigation - Aria Label', 'flynt'),
                'name' => 'navigationAriaLabel',
                'type' => 'text',
                'default_value' => __('Navigation Footer Columns', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
        ],
    ],
]);
