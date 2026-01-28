<?php

namespace Flynt\Components\GridImageText;

use Flynt\FieldVariables;

function getACFLayout(): array
{
    return [
        'name' => 'gridImageText',
        'label' => __('Grid Image Text', 'flynt'),
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
                'name' => 'items',
                'label' => __('Items', 'flynt'),
                'type' => 'repeater',
                'collapsed' => '',
                'layout' => 'block',
                'required' => 1,
                'min' => 1,
                'button_label' => __('Add Item', 'flynt'),
                'sub_fields' => [
                    [
                        'name' => 'itemAccordion',
                        'label' => __('Item', 'flynt'),
                        'type' => 'accordion',
                    ],
                    [
                        'name' => 'contentTab',
                        'label' => __('Content', 'flynt'),
                        'type' => 'tab',
                        'placement' => 'top',
                        'endpoint' => 0,
                    ],
                    [
                        'name' => 'image',
                        'label' => __('Image', 'flynt'),
                        'instructions' => __('Image-Format: JPG, PNG, SVG, WebP. Aspect Ratio: 3:2.', 'flynt'),
                        'type' => 'image',
                        'preview_size' => 'medium',
                        'mime_types' => 'jpg,jpeg,png,svg,webp',
                    ],
                    [
                        'name' => 'contentHtml',
                        'label' => __('Text', 'flynt'),
                        'type' => 'wysiwyg',
                        'delay' => 0,
                        'media_upload' => 0,
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
                        'layout' => 'row',
                        'sub_fields' => [
                            FieldVariables\getTheme(),
                        ],
                    ],
                ],
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
                        'min' => 1,
                        'max' => 4,
                        'step' => 1,
                    ],
                    [
                        'name' => 'card',
                        'label' => __('Show as Card', 'flynt'),
                        'type' => 'true_false',
                        'default_value' => 0,
                        'ui' => 1,
                    ],
                ],
            ],
        ],
    ];
}
