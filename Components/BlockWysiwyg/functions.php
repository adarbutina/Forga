<?php

namespace Flynt\Components\BlockWysiwyg;

use Flynt\FieldVariables;

function getACFLayout(): array
{
    return [
        'name' => 'blockWysiwyg',
        'label' => __('Block WYSIWYG', 'flynt'),
        'sub_fields' => [
            [
                'name' => 'contentTab',
                'label' => __('Content', 'flynt'),
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'name' => 'contentHtml',
                'label' => __('Text', 'flynt'),
                'type' => 'wysiwyg',
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
                    [
                        'name' => 'noComponentSpacing',
                        'label' => __('No Component Spacing'),
                        'type' => 'true_false',
                        'default_value' => 0,
                        'ui' => 1,
                    ],
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
                            'label' => __('Content Align', 'flynt'),
                        ],
                    ),
                ],
            ],
        ],
    ];
}
