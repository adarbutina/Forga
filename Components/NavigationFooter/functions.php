<?php

namespace Flynt\Components\NavigationFooter;

use Flynt\FieldVariables;
use Flynt\Utils\AssetLoader;
use Flynt\Utils\Options;
use Timber\Timber;

add_action('init', function () {
    register_nav_menus([
        'navigation_footer' => __('Navigation: Footer', 'flynt'),
    ]);
});

add_filter('Flynt/addComponentData?name=NavigationFooter', function (array $data): array {
    $data['menu'] = Timber::get_menu('navigation_footer') ?? false;

    if (!empty($data['socialPlatforms'])) {
        $data['socialPlatforms'] = array_map(function (array $item) {
            $item['icon'] = AssetLoader::getContents("assets/images/{$item['platform']['value']}.svg");
            return $item;
        }, $data['socialPlatforms']);
    }

    return $data;
});

Options::addTranslatable('NavigationFooter', [
    [
        'label' => __('Content', 'flynt'),
        'name' => 'contentTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    ],
    [
        'label' => __('Text', 'flynt'),
        'name' => 'contentHtml',
        'type' => 'wysiwyg',
        'delay' => 0,
        'media_upload' => 0,
        'toolbar' => 'basic',
        'default_value' => sprintf('© %s %s', date_i18n('Y'), get_bloginfo('name')),
    ],
    [
        'name' => 'socialPlatforms',
        'label' => __('Social Platforms', 'flynt'),
        'type' => 'repeater',
        'layout' => 'table',
        'button_label' => __('Add Social Link', 'flynt'),
        'sub_fields' => [
            [
                'name' => 'platform',
                'label' => __('Platform', 'flynt'),
                'type' => 'select',
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 1,
                'ajax' => 0,
                'return_format' => 'array',
                'choices' => [
                    'instagram' => 'Instagram',
                    'facebook' => 'Facebook',
                    'tiktok' => 'TikTok',
                    'youtube' => 'YouTube',
                ]
            ],
            [
                'name' => 'url',
                'label' => __('Link', 'flynt'),
                'type' => 'url',
                'required' => 1
            ],
        ]
    ],
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
                'default_value' => __('Footer Navigation', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'name' => 'socialPlatformsAriaLabel',
                'label' => __('Social Platforms - Aria Label', 'flynt'),
                'type' => 'text',
                'default_value' => __('Social Platforms', 'flynt'),
                'wrapper' => [
                    'width' => '50',
                ],
            ],
        ],
    ],
]);


