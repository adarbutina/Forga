<?php

namespace Flynt\Components\ListIcons;

use Flynt\FieldVariables;
use Timber\URLHelper;

add_filter('Flynt/addComponentData?name=ListIcons', function (array $data): array {
    foreach ($data['items'] as $key => $item) {
        if (is_array($item['link'])) {
            $link = $item['link'];
            $data['items'][$key]['link'] = array_merge($link, [
                'is_target_blank' => $link['target'] === '_blank'
            ]);
        }
    }

    return $data;
});

function getACFLayout(): array
{
    return [
        'name' => 'listIcons',
        'label' => __('List Icons', 'flynt'),
        'sub_fields' => [
            [
                'name' => 'contentTab',
                'label' => __('Content', 'flynt'),
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'name' => 'preContentHtml',
                'label' => __('Text', 'flynt'),
                'instructions' => __('Want to add a headline? And a paragraph? Go ahead! Or just leave it empty and nothing will be shown.', 'flynt'),
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
                'media_upload' => 0,
                'delay' => 0
            ],
            [
                'name' => 'items',
                'label' => __('Items', 'flynt'),
                'type' => 'repeater',
                'min' => 1,
                'layout' => 'table',
                'button_label' => __('Add Item', 'flynt'),
                'sub_fields' => [
                    [
                        'name' => 'image',
                        'label' => __('Image', 'flynt'),
                        'instructions' => __('Image-Format: JPG, PNG, SVG, WebP.', 'flynt'),
                        'type' => 'image',
                        'preview_size' => 'thumbnail',
                        'mime_types' => 'jpg,jpeg,png,svg,webp',
                        'required' => 1,
                    ],
                    [
                        'name' => 'link',
                        'label' => __('Link', 'flynt'),
                        'type' => 'link',
                        'return_format' => 'array',
                    ],
                    [
                        'name' => 'contentHtml',
                        'label' => __('Text', 'flynt'),
                        'type' => 'wysiwyg',
                        'media_upload' => 0,
                        'required' => 1,
                    ],
                ],
            ],
            [
                'name' => 'optionsTab',
                'label' => __('Options', 'flynt'),
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    FieldVariables\getTheme(),
                    array_merge(
                        FieldVariables\getSize(),
                        [
                            'name' => 'contentSize',
                            'label' => __('Content Size', 'flynt'),
                        ],
                    ),
                    array_merge(
                        FieldVariables\getAlignment(),
                        [
                            'name' => 'contentAlign',
                            'label' => __('Content Alignment', 'flynt'),
                        ],
                    ),
                    [
                        'label' => __('Icon Size', 'flynt'),
                        'name' => 'iconSize',
                        'type' => 'radio',
                        'other_choice' => 0,
                        'save_other_choice' => 0,
                        'layout' => 'horizontal',
                        'choices' => [
                            '' => __('Small (Default)', 'flynt'),
                            'medium' => __('Medium', 'flynt)'),
                            'large' => __('Large', 'flynt)'),
                        ],
                        'default_value' => 'medium',
                        'wrapper' =>  [
                            'width' => '100',
                        ],
                    ],
                    [
                        'label' => __('Max Columns', 'flynt'),
                        'name' => 'maxColumns',
                        'type' => 'number',
                        'default_value' => 3,
                        'min' => 1,
                        'max' => 4,
                        'step' => 1
                    ],
                    [
                        'name' => 'showAsCard',
                        'label' => __('Show as Card?', 'flynt'),
                        'type' => 'true_false',
                        'ui' => 1,
                        'default_value' => 0,
                    ],
                ],
            ],
        ],
    ];
}
