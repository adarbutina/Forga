<?php

namespace Flynt\Components\BlockNotFound;

use Flynt\Utils\Options;

Options::addTranslatable('BlockNotFound', [
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
        'instructions' => __('Content to be displayed on the 404 Not Found Page', 'flynt'),
        'type' => 'wysiwyg',
        'delay' => 0,
        'media_upload' => 0,
        'required' => 1,
        'default_value' => sprintf('<h1>%1$s</h1><p>%2$s</p>', __('404', 'flynt'), __('Sorry, the page you\'re looking for doesn\'t exist.', 'flynt')),
    ],
    [
        'name' => 'backLinkLabel',
        'label' => __('Back to Homepage', 'flynt'),
        'instructions' => __('Leave empty to remove back to home link below the content area.', 'flynt'),
        'type' => 'text',
        'default_value' => __('Back to Homepage', 'flynt')
    ]
]);
