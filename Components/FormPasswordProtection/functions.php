<?php

namespace Flynt\Components\FormPasswordProtection;

use Flynt\FieldVariables;
use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=FormPasswordProtection', function (array $data): array {
    $data['form'] = [
        'url' => site_url('/wp-login.php?action=postpass', 'login_post')
    ];
    return $data;
});

Options::addTranslatable('FormPasswordProtection', [
    [
        'label' => __('Content', 'flynt'),
        'name' => 'contentTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => __('Text', 'flynt'),
        'name' => 'preContentHtml',
        'type' => 'wysiwyg',
        'delay' => 0,
        'media_upload' => 0,
        'required' => 0,
        'default_value' => sprintf(
            '<h1 class="h2">%1$s</h1><p>%2$s</p>',
            __('This content is protected', 'flynt'),
            __('To view, please enter the password', 'flynt')
        )
    ],
    [
        'label' => __('Labels', 'flynt'),
        'name' => 'labelsTab',
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
                'label' => __('Input - Aria Label', 'flynt'),
                'name' => 'inputAriaLabel',
                'type' => 'text',
                'default_value' => __('Password', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50'
                ]
            ],
            [
                'label' => __('Input - Placeholder', 'flynt'),
                'name' => 'inputPlaceholder',
                'type' => 'text',
                'default_value' => __('Enter password', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50'
                ]
            ],
            [
                'label' => __('Button - Submit', 'flynt'),
                'name' => 'buttonSubmit',
                'type' => 'text',
                'default_value' => __('Enter', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50'
                ]
            ]
        ]
    ],
]);
