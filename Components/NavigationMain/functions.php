<?php

namespace Flynt\Components\NavigationMain;

use Flynt\Utils\AssetLoader;
use Flynt\Utils\Options;
use Timber\Timber;

add_action('init', function () {
    register_nav_menus([
        'navigation_main' => __('Navigation: Main', 'flynt'),
    ]);
});

add_filter('Flynt/addComponentData?name=NavigationMain', function (array $data): array {
    $data['menu'] = Timber::get_menu('navigation_main') ?? Timber::get_pages_menu();
    $data['logo'] = get_theme_mod('custom_logo') ? Timber::get_image(get_theme_mod('custom_logo')) : false;

    return $data;
});

Options::addTranslatable('NavigationMain', [
    [
        'label' => __('Labels', 'flynt'),
        'name' => 'labelsTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => '',
        'name' => 'labels',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => __('Navigation - Aria Label', 'flynt'),
                'name' => 'navigationAriaLabel',
                'type' => 'text',
                'default_value' => __('Navigation Main', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('Toggle Menu', 'flynt'),
                'name' => 'toggleMenu',
                'type' => 'text',
                'default_value' => __('Toggle Menu', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'name' => 'socialPlatformsAriaLabel',
                'label' => __('Social Platform - Aria Label', 'flynt'),
                'type' => 'text',
                'default_value' => __('Social Platforms', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
        ],
    ],
]);
