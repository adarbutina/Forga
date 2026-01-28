<?php

namespace Flynt\Components\WooCommerce\SliderProducts;

use Flynt\FieldVariables;
use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=SliderProducts', function (array $data): array {
    $sliderOptions = Options::getTranslatable('SliderOptions');
    $data = array_merge($sliderOptions, $data);
    $data['options']['maxColumns'] = $data['options']['maxColumns'] ?? 3;
    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'sliderProducts',
        'label' => __('Slider Products'),
        'sub_fields' => [
            [
                'name' => 'contentTab',
                'label' => __('Content', 'flynt'),
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'name' => 'preContentHtml',
                'label' => __('Pre Content', 'flynt'),
                'type' => 'wysiwyg',
                'required' => 0,
                'delay' => 0,
            ],
            [
                'name' => 'posts',
                'label' => __('Products', 'flynt'),
                'type' => 'post_object',
                'post_type' => ['product', 'product_variation'],
                'multiple' => 1,
                'ui' => 1,
                'required' => 1,
            ],
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
                    FieldVariables\getTheme(),
                    [
                        'name' => 'noComponentSpacing',
                        'label' => __('No Component Spacing?', 'flynt'),
                        'type' => 'true_false',
                        'default_value' => 0,
                        'ui' => 1,
                    ],
                    [
                        'name' => 'maxColumns',
                        'label' => __('Max Columns', 'flynt'),
                        'type' => 'number',
                        'default_value' => 3,
                        'min' => 2,
                        'max' => 4,
                    ],
                ],
            ],
        ],
    ];
}
