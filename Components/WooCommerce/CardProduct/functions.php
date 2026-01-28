<?php

namespace Flynt\Components\WooCommerce\CardProduct;

use Timber\Timber;

add_filter('Flynt/addComponentData?name=CardProduct', function (array $data): array {
    $post = $data['post'];
    $product = wc_get_product($post->ID);

    $data['title'] = get_the_title($post->ID);
    $data['link'] = $post->link;
    $data['thumbnail'] = $post->thumbnail;
    $data['priceHtml'] = $product->get_price_html();

    return $data;
});
