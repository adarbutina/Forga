<?php

namespace Flynt\Components\WooCommerce\BlockProductUpSells;

use Flynt\Utils\Options;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=BlockProductUpSells', function (array $data): array {
    $post = $data['post'] ?? Timber::get_post();
    $product = wc_get_product($post->ID);

    $upsellIds = $product->get_upsell_ids();
    $data['posts'] = Timber::get_posts([
        'post__in' => $upsellIds,
        'post_type' => ['product', 'product_variation'],
        'orderby' => 'post__in',
        'post_status'  => is_user_logged_in() ? ['publish', 'private'] : ['publish'],
    ]);

    $data['preContentHtml'] = Options::getTranslatable('BlockProductUpSells')['preContentHtml'];

    return $data;
});

remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
add_action('woocommerce_after_single_product', function (): void {
    Timber::render_string('{{ renderComponent("BlockProductUpSells") }}');
}, 15);

Options::addTranslatable('BlockProductUpSells', [
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
        'default_value' => sprintf('<h2>%s</h2>', __('Recommended products')),
        'media_upload' => 0,
        'delay' => 0,
    ],
]);
