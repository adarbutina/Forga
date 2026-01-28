<?php

namespace Flynt\Components\FeatureFlexibleContentExtension;

use Flynt\ComponentManager;

add_action('admin_enqueue_scripts', function (): void {
    $data = [
        'labels' => [
            'placeholder' => __('Search...', 'flynt'),
            'noResults' => __('No components found', 'flynt'),
        ],
    ];
    wp_localize_script('Flynt/assets/admin', 'FeatureFlexibleContentExtension', $data);
});
