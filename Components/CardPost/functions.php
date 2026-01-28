<?php

namespace Flynt\Components\CardPost;

add_filter('Flynt/addComponentData?name=CardPost', function (array $data): array {
    $post = $data['post'];

    $data['title'] = get_the_title($post->ID);
    $data['link'] = $post->link;
    $data['thumbnail'] = $post->thumbnail;
    $data['excerpt'] = $post->post_excerpt;

    return $data;
});
