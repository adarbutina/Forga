<?php

namespace Flynt\Components\NavigationBurger;

use Flynt\Utils\AssetLoader;
use Flynt\Utils\Options;
use Timber\Timber;

add_action('init', function () {
    register_nav_menus([
        'navigation_burger' => __('Navigation Burger', 'flynt'),
    ]);
});

add_filter('Flynt/addComponentData?name=NavigationBurger', function (array $data): array {
    $data['menu'] = Timber::get_menu('navigation_burger') ?? Timber::get_pages_menu();
    $data['logo'] = get_theme_mod('custom_logo') ? Timber::get_image(get_theme_mod('custom_logo')) : false;

    return $data;
});

Options::addTranslatable('NavigationBurger', [
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
                'name' => 'navigationAriaLabel',
                'label' => __('Navigation - Aria Label', 'flynt'),
                'type' => 'text',
                'default_value' => __('Navigation Burger', 'flynt')
            ],
            [
                'name' => 'toggleMenuAriaLabel',
                'label' => __('Toggle Menu - Aria Label', 'flynt'),
                'type' => 'text',
                'default_value' => __('Toggle Menu', 'flynt')
            ],
        ],
    ],
]);
