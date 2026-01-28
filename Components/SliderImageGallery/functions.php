<?php

namespace Flynt\Components\SliderImageGallery;

use Flynt\FieldVariables;
use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=SliderImageGallery', function (array $data): array {
    $sliderOptions = Options::getTranslatable('SliderOptions');
    $data = array_merge($sliderOptions, $data);
    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'sliderImageGallery',
        'label' => __('Slider Image Gallery', 'flynt'),
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
                'name' => 'images',
                'label' => __('Images', 'flynt'),
                'instructions' => __('Image-Format: JPG, PNG, WebP.', 'flynt'),
                'type' => 'gallery',
                'min' => 1,
                'preview_size' => 'medium',
                'mime_types' => 'jpg,jpeg,png,webp',
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
                ],
            ],
        ],
    ];
}
