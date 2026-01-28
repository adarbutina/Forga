<?php

namespace Flynt\SliderOptions;

use Flynt\Utils\Options;

Options::addTranslatable('SliderOptions', [
    [
        'name' => 'labelsTab',
        'label' => __('Labels', 'flynt'),
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    ],
    [
        'name' => 'labels',
        'label' => '',
        'type' => 'group',
        'sub_fields' => [
            [
                'name' => 'nextSlideMessage',
                'label' => __('Next Slide Button Text', 'flynt'),
                'type' => 'text',
                'default_value' => __('Next Slide', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'name' => 'prevSlideMessage',
                'label' => __('Previous Slide Button Text', 'flynt'),
                'type' => 'text',
                'default_value' => __('Previous Slide', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'name' => 'paginationBulletMessage',
                'label' => __('Pagination Bullet Message', 'flynt'),
                'instructions' => '`{{index}}` will be replaced for the slide number.',
                'type' => 'text',
                'default_value' => __('Go to slide {{index}}', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
        ]
    ],
]);
