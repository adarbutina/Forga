<?php

namespace Flynt\Components\WooCommerce\NavigationBreadcrumb;

use Flynt\Utils\Options;
use Timber\Timber;
use WC_Breadcrumb;

add_filter('Flynt/addComponentData?name=NavigationBreadcrumb', function (array $data): array {
    $breadcrumb = new WC_Breadcrumb();
    $breadcrumb->generate();
    $data['items'] = array_map(function ($crumb) {
        return [
            'title' => $crumb[0],
            'link' => $crumb[1],
        ];
    }, $breadcrumb->get_breadcrumb());

    return $data;
});

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
add_action('woocommerce_before_main_content', function (): void {
    Timber::render_string('{{ renderComponent("NavigationBreadcrumb") }}');
}, 20);

Options::addTranslatable('NavigationBreadcrumb', [
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
                'name' => 'navigationAriaLabel',
                'label' => __('Navigation - Aria Label', 'flynt'),
                'type' => 'text',
                'default_value' => __('Navigation Breadcrumb', 'flynt'),
                'wrapper' => [
                    'width' => '50',
                ],
            ],
        ],
    ],
]);
