<?php

namespace Flynt\Components\ListLogos;

use Flynt\FieldVariables;
use Timber\URLHelper;

add_filter('Flynt/addComponentData?name=ListLogos', function (array $data): array {
    foreach ($data['items'] as $key => $item) {
        if (is_array($item['link'])) {
            $link = $item['link'];
            $data['items'][$key]['link'] = array_merge($link, [
                'is_external' => URLHelper::is_external($link['url']),
                'is_target_blank' => $link['target'] === '_blank'
            ]);
        }
    }

    return $data;
});

function getACFLayout(): array
{
    return [
        'name' => 'listLogos',
        'label' => __('List Logos', 'flynt'),
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
                'tabs' => 'visual,text',
                'media_upload' => 0,
                'delay' => 0,
            ],
            [
                'name' => 'items',
                'label' => __('Items', 'flynt'),
                'type' => 'repeater',
                'collapsed' => '',
                'min' => 1,
                'max' => 8,
                'layout' => 'block',
                'button_label' => __('Add Item', 'flynt'),
                'sub_fields' => [
                    [
                        'name' => 'link',
                        'label' => __('Link', 'flynt'),
                        'type' => 'link',
                        'return_format' => 'array',
                        'wrapper' =>  [
                            'width' => '60',
                        ]
                    ],
                    [
                        'name' => 'image',
                        'label' => __('Image', 'flynt'),
                        'instructions' => __('Image-Format: JPG, PNG, SVG, WebP. Recommended Minimum Width: 280px.', 'flynt'),
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'small',
                        'library' => 'all',
                        'mime_types' => 'jpg,jpeg,png,svg,webp',
                        'required' => 1,
                        'wrapper' =>  [
                            'width' => '40',
                        ]
                    ]
                ]
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
                    array_merge(
                        FieldVariables\getSize(),
                        [
                            'name' => 'contentSize',
                            'label' => __('Content Size', 'flynt'),
                            'wrapper' => [
                                'width' => '50',
                            ],
                        ],
                    ),
                    array_merge(
                        FieldVariables\getAlignment(),
                        [
                            'name' => 'contentAlign',
                            'label' => __('Content Alignment', 'flynt'),
                            'wrapper' => [
                                'width' => '50',
                            ],
                        ],
                    ),
                ],
            ],
        ],
    ];
}
