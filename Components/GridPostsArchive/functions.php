<?php

namespace Flynt\Components\GridPostsArchive;

use Flynt\Utils\Options;
use Timber\Timber;

const POST_TYPE = 'post';
const FILTER_BY_TAXONOMY = 'category';

add_filter('Flynt/addComponentData?name=GridPostsArchive', function (array $data): array {
    $data['uuid'] ??= wp_generate_uuid4();
    $postType = POST_TYPE;
    $taxonomy = FILTER_BY_TAXONOMY;
    $terms = get_terms([
        'taxonomy' => $taxonomy,
        'hide_empty' => true,
    ]);
    $queriedObject = get_queried_object();
    if (count($terms) > 1) {
        $data['terms'] = array_map(function ($term) use ($queriedObject) {
            $timberTerm = Timber::get_term($term);
            if ($queriedObject->taxonomy ?? null) {
                $timberTerm->isActive = $queriedObject->taxonomy === $term->taxonomy && $queriedObject->term_id === $term->term_id;
            }
            return $timberTerm;
        }, $terms);

        // Add item for all posts
        array_unshift($data['terms'], [
            'link' => get_post_type_archive_link($postType),
            'title' => $data['labels']['allPosts'],
            'isActive' => is_home() || is_post_type_archive($postType),
        ]);
    }

    if (is_home()) {
        $data['isHome'] = true;
        $data['title'] = $queriedObject->post_title ?? get_bloginfo('name');
    } else {
        $data['title'] =  get_the_archive_title();
        $data['description'] = get_the_archive_description();
    }

    return $data;
});

Options::addGlobal('GridPostsArchive', [
    [
        'name' => 'optionsTab',
        'label' => __('Options', 'flynt'),
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    ],
    [
        'name' => 'options',
        'label' => '',
        'type' => 'group',
        'layout' => 'row',
        'sub_fields' => [
            [
                'name' => 'maxColumns',
                'label' => __('Max Columns', 'flynt'),
                'type' => 'number',
                'min' => 1,
                'max' => 4,
                'step' => 1,
                'default_value' => 2,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
        ],
    ],
]);

Options::addTranslatable('GridPostsArchive', [
    [
        'name' => 'contentTab',
        'label' => __('Content', 'flynt'),
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'name' => 'preContentHtml',
        'label' => __('Text', 'flynt'),
        'type' => 'wysiwyg',
        'delay' => 0,
        'media_upload' => 0,
    ]
]);
