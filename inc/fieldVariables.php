<?php

namespace Flynt\FieldVariables;

function getTheme($default = ''): array
{
    return [
        'label' => __('Theme', 'flynt'),
        'name' => 'theme',
        'type' => 'select',
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'ajax' => 0,
        'choices' => [
            '' => __('None', 'flynt'),
            'reset' => __('Reset', 'flynt'),
            'light' => __('Light', 'flynt'),
            'dark' => __('Dark', 'flynt'),
        ],
        'default_value' => $default
    ];
}

function getNoComponentSpacing($default = 'large'): array
{
    return [
        'label' => __('No Component Spacing'),
        'name' => 'noComponentSpacing',
        'type' => 'true_false',
        'default_value' => 0,
        'ui' => 1
    ];
}

function getSize($default = 'full'): array
{
    return [
        'label' => __('Size', 'flynt'),
        'name' => 'size',
        'type' => 'select',
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'ajax' => 0,
        'choices' => [
            'narrow' => __('Narrow', 'flynt'),
            'wide' => __('Wide', 'flynt'),
            'full' => __('Full', 'flynt'),
        ],
        'default_value' => $default
    ];
}

function getAlignment($args = []): array
{
    $options = wp_parse_args($args, [
        'label' => __('Align', 'flynt'),
        'name' => 'align',
        'default' => 'left',
    ]);

    return [
        'label' => $options['label'],
        'name' => $options['name'],
        'type' => 'button_group',
        'choices' => [
            'left' => sprintf('<i class="dashicons dashicons-align-left" title="%s"></i>', __('Left', 'flynt')),
            'center' => sprintf('<i class="dashicons dashicons-align-center" title="%s"></i>', __('Center', 'flynt')),
            'right' => sprintf('<i class="dashicons dashicons-align-right" title="%s"></i>', __('Right', 'flynt'))
        ],
        'default_value' => $options['default']
    ];
}

function getTextAlignment($args = []): array
{
    $options = wp_parse_args($args, [
        'label' => __('Text Align', 'flynt'),
        'name' => 'textAlign',
        'default' => 'left',
    ]);

    return [
        'label' => $options['label'],
        'name' => $options['name'],
        'type' => 'button_group',
        'choices' => [
            'left' => sprintf('<i class="dashicons dashicons-editor-alignleft" title="%1$s"></i>', __('Align text left', 'flynt')),
            'center' => sprintf('<i class="dashicons dashicons-editor-aligncenter" title="%1$s"></i>', __('Align text center', 'flynt')),
            'right' => sprintf('<i class="dashicons dashicons-editor-alignright" title="%1$s"></i>', __('Align text right', 'flynt')),
        ],
        'default_value' => $options['default']
    ];
}
