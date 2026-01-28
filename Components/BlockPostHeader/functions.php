<?php

namespace Flynt\Components\BlockPostHeader;

use Timber\Timber;

add_filter('Flynt/addComponentData?name=BlockPostHeader', function (array $data): array {
    $post = $data['post'] ?? Timber::get_post();
    $data['post']->title = get_the_title($post->ID);
    return $data;
});
