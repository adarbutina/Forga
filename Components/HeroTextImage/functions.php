<?php

namespace Flynt\Components\HeroTextImage;

use Flynt\FieldVariables;

function getACFLayout(): array
{
    return [
        'name' => 'heroTextImage',
        'label' => __('Hero Text Image', 'flynt'),
        'sub_fields' => [
            [
                'name' => 'contentTab',
                'label' => __('Content', 'flynt'),
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'name' => 'contentHtml',
                'label' => __('Content', 'flynt'),
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
                'media_upload' => 0,
                'delay' => 0,
                'required' => 1
            ],
            [
                'name' => 'image',
                'label' => __('Image', 'flynt'),
                'instructions' => __('Image-Format: JPG, PNG, SVG, WebP. Recommended Height: 1200px. Minimum Height: 600px.', 'flynt'),
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                // 'min_height' => 600,
                'mime_types' => 'jpg,jpeg,png,svg,webp',
                'required' => 1
            ],
            [
                'name' => 'optionsTab',
                'label' => __('Options', 'flynt'),
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
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
                        'label' => __('No Component Spacing'),
                        'type' => 'true_false',
                        'default_value' => 0,
                        'ui' => 1
                    ],
                    [
                        'name' => 'imagePosition',
                        'label' => __('Image Position', 'flynt'),
                        'type' => 'button_group',
                        'choices' => [
                            'left' => sprintf('<i class=\'dashicons dashicons-align-left\' title=\'%1$s\'></i>', __('Image on the left', 'flynt')),
                            'right' => sprintf('<i class=\'dashicons dashicons-align-right\' title=\'%1$s\'></i>', __('Image on the right', 'flynt'))
                        ],
                        'default_value' => 'right'
                    ],
                ]
            ],
        ]
    ];
}
