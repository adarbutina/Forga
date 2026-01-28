<?php

namespace Flynt\Components\WooCommerce\BlockProductRelated;

use Flynt\Utils\Options;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=BlockProductRelated', function (array $data): array {
    $post = $data['post'] ?? Timber::get_post();
    $product = wc_get_product($post->ID);

    $productRelatedIds = wc_get_related_products($product->get_id(), 10);
    $data['posts'] = Timber::get_posts([
        'post__in' => $productRelatedIds,
        'post_type' => ['product', 'product_variation'],
        'post_status'  => is_user_logged_in() ? ['publish', 'private'] : ['publish'],
    ]);

    $data['preContentHtml'] = Options::getTranslatable('BlockProductRelated')['preContentHtml'];

    return $data;
});

remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
add_action('woocommerce_after_single_product', function (): void {
    Timber::render_string('{{ renderComponent("BlockProductRelated") }}');
}, 20);

Options::addTranslatable('BlockProductRelated', [
    [
        'name' => 'contentTab',
        'label' => __('Content', 'flynt'),
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    ],
    [
        'name' => 'preContentHtml',
        'label' => __('Text', 'flynt'),
        'type' => 'wysiwyg',
        'default_value' => sprintf('<h2>%s</h2>', __('Related products')),
        'media_upload' => 0,
        'delay' => 0,
    ],
]);
