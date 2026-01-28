<?php

namespace Flynt\Components\WooCommerce\BlockProductDescription;

use Timber\Timber;

add_filter('Flynt/addComponentData?name=BlockProductDescription', function (array $data): array {
    $data['post'] = Timber::get_post();
    return $data;
});

add_action('woocommerce_after_single_product_summary', function (): void {
    Timber::render_string('{{ renderComponent("BlockProductDescription") }}');
});
