<?php

namespace Flynt\Components\GridImages;

use Flynt\FieldVariables;

function getACFLayout(): array
{
    return [
        'name' => 'gridImages',
        'label' => __('Grid Images', 'flynt'),
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
                'label' => __('Text', 'flynt'),
                'instructions' => __('Want to add a headline? And a paragraph? Go ahead! Or just leave it empty and nothing will be shown.', 'flynt'),
                'type' => 'wysiwyg',
                'media_upload' => 0,
                'delay' => 0,
            ],
            [
                'name' => 'images',
                'label' => __('Images', 'flynt'),
                'instructions' => __('Image-Format: JPG, PNG, WebP.', 'flynt'),
                'type' => 'gallery',
                'min' => 2,
                'required' => 1,
                'preview_size' => 'medium',
                'mime_types' => 'jpg,jpeg,png,webp',
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
                'layout' => 'row',
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
                        'step' => 1,
                    ],
                ],
            ],
        ],
    ];
}
