<?php

namespace Flynt\Components\WooCommerce\BlockProductGallery;

use Flynt\ComponentManager;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=BlockProductGallery', function (array $data): array {
    $post = $data['post'] ?? Timber::get_post();
    $product = wc_get_product($post->ID);

    if ($product->is_type('variable')) {
        $attributes = array_filter(
            wc_clean(wp_unslash($_GET)),
            static fn($value, $key) => str_starts_with($key, 'attribute_') && $value !== '',
            ARRAY_FILTER_USE_BOTH
        );

        $defaults = [];
        foreach ($product->get_default_attributes() as $key => $value) {
            $defaults["attribute_{$key}"] = $value;
        }

        $attributes = array_merge(
            $defaults,
            $attributes
        );

        if ($attributes) {
            $variation_id = $product->get_matching_variation($attributes);

            if ($variation_id) {
                $product = wc_get_product($variation_id);
            }
        }
    }

    $data['images'] = getImages($product);

    return $data;
});

remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
add_action('woocommerce_before_single_product_summary', function (): void {
    Timber::render_string('{{ renderComponent("BlockProductGallery") }}');
}, 20);

add_filter('woocommerce_available_variation', function (array $variation_data, $product, $variation): array {
    $componentManager = ComponentManager::getInstance();
    $componentPathFull = $componentManager->getComponentDirPath('BlockProductGallery');
    $componentPath = str_replace(trailingslashit(get_template_directory()), '', $componentPathFull);

    $context = Timber::context();
    $context['images'] = getImages($variation);

    $variation_data['BlockProductGallery'] = Timber::compile("{$componentPath}/index.twig", $context);

    return $variation_data;
}, 10, 3);

function getImages($product): array
{
    $image_ids = array_filter(array_merge([$product->get_image_id()], $product->get_gallery_image_ids()));
    return array_map(function ($image_id) {
        return Timber::get_image($image_id);
    }, $image_ids);
}
