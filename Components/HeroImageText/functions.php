<?php

namespace Flynt\Components\HeroImageText;

use Flynt\FieldVariables;

function getACFLayout(): array
{
    return [
        'name' => 'heroImageText',
        'label' => __('Hero Image Text', 'flynt'),
        'sub_fields' => [
            [
                'name' => 'contentTab',
                'label' => __('Content', 'flynt'),
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'name' => 'images',
                'label' => __('Images', 'flynt'),
                'type' => 'group',
                'layout' => 'table',
                'sub_fields' => [
                    [
                        'name' => 'imageDesktop',
                        'label' => __('Desktop Image', 'flynt'),
                        'instructions' => __('Image-Format: JPG, PNG, SVG, WebP. Recommended resolution greater than 2560 × 800 px.', 'flynt'),
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'mime_types' => 'jpg,jpeg,png,svg,webp',
                        'required' => 1,
                    ],
                    [
                        'name' => 'imageMobile',
                        'label' => __('Mobile Image', 'flynt'),
                        'instructions' => __('Image-Format: JPG, PNG, SVG, WebP. Recommended resolution greater than 1440 × 800 px.', 'flynt'),
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'mime_types' => 'jpg,jpeg,png,svg,webp',
                    ]
                ]
            ],
            [
                'name' => 'contentHtml',
                'label' => __('Text', 'flynt'),
                'instructions' => __('The content overlaying the image. Character Recommendations: Title: 30-100, Content: 80-250.', 'flynt'),
                'type' => 'wysiwyg',
                'delay' => 0,
                'media_upload' => 0,
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
                    array_merge(
                        FieldVariables\getSize(),
                        [
                            'name' => 'contentSize',
                            'label' => __('Content Size', 'flynt'),
                            'instructions' => __('The size of the inner container.', 'flynt'),
                        ]
                    ),
                    array_merge(
                        FieldVariables\getAlignment(),
                        [
                            'name' => 'contentAlign',
                            'label' => __('Content Alignment', 'flynt'),
                            'instructions' => __('The alignment of the inner container.', 'flynt'),
                        ]
                    ),
                    [
                        'name' => 'imageAlign',
                        'label' => __('Image Alignment', 'flynt'),
                        'type' => 'group',
                        'layout' => 'table',
                        'sub_fields' => [
                            [
                                'name' => 'desktop',
                                'label' => __('Desktop', 'flynt'),
                                'type' => 'group',
                                'sub_fields' => [
                                    [
                                        'name' => 'horizontal',
                                        'label' => __('Horizontal', 'flynt'),
                                        'type' => 'select',
                                        'allow_null' => 0,
                                        'multiple' => 0,
                                        'ui' => 1,
                                        'ajax' => 0,
                                        'choices' => [
                                            'desktopHorizontalAlign--left' => __('Left', 'flynt'),
                                            'desktopHorizontalAlign--center' => __('Center', 'flynt'),
                                            'desktopHorizontalAlign--right' => __('Right', 'flynt'),
                                        ],
                                        'default_value' => 'desktopHorizontalAlign--center'
                                    ],
                                    [
                                        'name' => 'vertical',
                                        'label' => __('Vertical', 'flynt'),
                                        'type' => 'select',
                                        'allow_null' => 0,
                                        'multiple' => 0,
                                        'ui' => 1,
                                        'ajax' => 0,
                                        'choices' => [
                                            'desktopVerticalAlign--top' => __('Top', 'flynt'),
                                            'desktopVerticalAlign--center' => __('Center', 'flynt'),
                                            'desktopVerticalAlign--bottom' => __('Bottom', 'flynt'),
                                        ],
                                        'default_value' => 'desktopVerticalAlign--center'
                                    ],
                                ]
                            ],
                            [
                                'name' => 'mobile',
                                'label' => __('Mobile', 'flynt'),
                                'type' => 'group',
                                'sub_fields' => [
                                    [
                                        'name' => 'horizontal',
                                        'label' => __('Horizontal', 'flynt'),
                                        'type' => 'select',
                                        'allow_null' => 0,
                                        'multiple' => 0,
                                        'ui' => 1,
                                        'ajax' => 0,
                                        'choices' => [
                                            'mobileHorizontalAlign--left' => __('Left', 'flynt'),
                                            'mobileHorizontalAlign--center' => __('Center', 'flynt'),
                                            'mobileHorizontalAlign--right' => __('Right', 'flynt'),
                                        ],
                                        'default_value' => 'mobileHorizontalAlign--center'
                                    ],
                                    [
                                        'name' => 'vertical',
                                        'label' => __('Vertical', 'flynt'),
                                        'type' => 'select',
                                        'allow_null' => 0,
                                        'multiple' => 0,
                                        'ui' => 1,
                                        'ajax' => 0,
                                        'choices' => [
                                            'mobileVerticalAlign--top' => __('Top', 'flynt'),
                                            'mobileVerticalAlign--center' => __('Center', 'flynt'),
                                            'mobileVerticalAlign--bottom' => __('Bottom', 'flynt'),
                                        ],
                                        'default_value' => 'mobileVerticalAlign--center'
                                    ],
                                ]
                            ],
                        ]
                    ],
                    [
                        'name' => 'minHeight',
                        'label' => __('Minimum Height', 'flynt'),
                        'type' => 'group',
                        'layout' => 'table',
                        'sub_fields' => [
                            [
                                'name' => 'desktop',
                                'label' => __('Desktop', 'flynt'),
                                'type' => 'range',
                                'default_value' => 640,
                                'min' => 0,
                                'max' => 1024,
                                'append' => __('px', 'flynt'),
                            ],
                            [
                                'name' => 'mobile',
                                'label' => __('Mobile', 'flynt'),
                                'type' => 'range',
                                'default_value' => 480,
                                'min' => 0,
                                'max' => 1024,
                                'append' => __('px', 'flynt'),
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ];
}
