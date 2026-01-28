<?php

namespace Flynt\Components\WooCommerce\FeatureAdvancedProductVariation;

use Flynt\Utils\Options;
use Timber\Timber;

add_action('wp_footer', function () {
    if (is_singular('product')) {
        $product = wc_get_product(get_the_ID());
        if ($product->is_type('variable')) {
            Timber::render_string('{{ renderComponent("FeatureAdvancedProductVariation") }}');
        }
    }
}, 11);

// Remove 'clear' link from variation picker.
add_filter('woocommerce_reset_variations_link', '__return_empty_string');

Options::addGlobal('AdvancedProductVariation', [
    [
        'name' => 'generalTab',
        'label' => __('General', 'flynt'),
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    ],
    [
        'name' => 'enabled',
        'label' => __('Enabled?', 'flynt'),
        'type' => 'true_false',
        'default_value' => 0,
        'ui' => 1,
    ],
]);
