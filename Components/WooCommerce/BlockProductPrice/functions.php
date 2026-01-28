<?php

namespace Flynt\Components\WooCommerce\BlockProductPrice;

use Flynt\ComponentManager;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=BlockProductPrice', function (array $data): array {
    $post = $data['post'] ?? Timber::get_post();
    $product = wc_get_product($post->ID);

    if ($product->is_type('variable')) {
        $attributes = [];
        foreach ($_GET as $key => $value) {
            if ($value !== '' && str_starts_with($key, 'attribute_')) {
                $attributes[$key] = wc_clean(wp_unslash($value));
            }
        }

        $defaultAttributes = [];
        foreach ($product->get_default_attributes() as $key => $value) {
            $defaultAttributes["attribute_{$key}"] = $value;
        }

        $attributes = array_merge(
            $defaultAttributes,
            $attributes
        );

        if ($attributes) {
            $variation_id = $product->get_matching_variation($attributes);

            if ($variation_id) {
                $product = wc_get_product($variation_id);
            }
        }
    }

    $data['html'] = $product->get_price_html();

    return $data;
});

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
add_action('woocommerce_single_product_summary', function (): void {
    Timber::render_string('{{ renderComponent("BlockProductPrice") }}');
}, 10);

add_filter('woocommerce_available_variation', function (array $variation_data, $product, $variation): array {
    $componentManager = ComponentManager::getInstance();
    $componentPathFull = $componentManager->getComponentDirPath('BlockProductPrice');
    $componentPath = str_replace(trailingslashit(get_template_directory()), '', $componentPathFull);

    $context = Timber::context();
    $context['html'] = $variation->get_price_html();

    $variation_data['BlockProductPrice'] = Timber::compile("{$componentPath}/index.twig", $context);

    return $variation_data;
}, 10, 3);
