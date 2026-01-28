<?php

namespace Flynt\Components\WooCommerce\GridProductsArchive;

use Flynt\FieldVariables;
use Flynt\Utils\Options;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=GridProductsArchive', function (array $data): array {
    $data['uuid'] ??= wp_generate_uuid4();

    if (is_shop()) {
        $data['isShop'] = true;
    } else {
        $data['description'] = term_description();
    }

    return $data;
});

Options::addGlobal('GridProductsArchive', [
    [
        'name' => 'optionsTab',
        'label' => __('Options', 'flynt'),
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    ],
    [
        'name' => 'options',
        'label' => '',
        'type' => 'group',
        'sub_fields' => [
            [
                'name' => 'maxColumns',
                'label' => __('Max Columns', 'flynt'),
                'type' => 'number',
                'default_value' => 3,
                'min' => 1,
                'max' => 4,
                'step' => 1,
            ],
            [
                'name' => 'card',
                'label' => __('Show as Card?', 'flynt'),
                'type' => 'true_false',
                'default_value' => 0,
                'ui' => 1,
            ],
        ],
    ],
]);

Options::addTranslatable('GridProductsArchive', [
    [
        'name' => 'contentTab',
        'label' => __('Content', 'flynt'),
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    ],
    [
        'name' => 'preContentHtml',
        'label' => __('Text', 'flynt'),
        'type' => 'wysiwyg',
        'media_upload' => 0,
        'delay' => 0,
    ],
    [
        'name' => 'labelsTab',
        'label' => __('Labels', 'flynt'),
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
                'name' => 'filterBy',
                'label' => __('Filter by', 'flynt'),
                'type' => 'text',
                'default_value' => __('Filter by', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'name' => 'previous',
                'label' => __('Previous', 'flynt'),
                'type' => 'text',
                'default_value' => __('Prev', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'name' => 'next',
                'label' => __('Next', 'flynt'),
                'type' => 'text',
                'default_value' => __('Next', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'name' => 'loadMore',
                'label' => __('Load More', 'flynt'),
                'type' => 'text',
                'default_value' => __('Load More', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'name' => 'noProductsFound',
                'label' => __('No Products Found Text', 'flynt'),
                'type' => 'text',
                'default_value' => __('No products found.', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
        ],
    ],
]);
