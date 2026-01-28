<?php

namespace Flynt\Components\GridPostsLatest;

use Flynt\FieldVariables;
use Flynt\Utils\Options;
use Timber\Timber;

const POST_TYPE = 'post';

add_filter('Flynt/addComponentData?name=GridPostsLatest', function (array $data): array {
    $data['uuid'] ??= wp_generate_uuid4();
    $data['taxonomies'] = $data['taxonomies'] ?: [];
    $data['options']['maxColumns'] = $data['options']['maxColumns'] ?? 2;
    $postsPerPage = $data['options']['maxPosts'] ?? 10;

    $posts = Timber::get_posts([
        'post_status' => 'publish',
        'post_type' => POST_TYPE,
        'cat' => implode(',', array_map(function ($taxonomy) {
            return $taxonomy->term_id;
        }, $data['taxonomies'])),
        'posts_per_page' => $postsPerPage + 1,
        'ignore_sticky_posts' => 1,
    ]);

    $data['posts'] = array_slice(array_filter($posts->to_array(), function ($post): bool {
        return $post->ID !== get_the_ID();
    }), 0, $postsPerPage);

    $data['postTypeArchiveLink'] = get_permalink(get_option('page_for_posts')) ?? get_post_type_archive_link(POST_TYPE);

    return $data;
});

function getACFLayout(): array
{
    return [
        'name' => 'gridPostsLatest',
        'label' => __('Grid Posts Latest', 'flynt'),
        'sub_fields' => [
            [
                'name' => 'contentTab',
                'label' => __('Content', 'flynt'),
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'name' => 'preContentHtml',
                'label' => __('Title', 'flynt'),
                'instructions' => __('Want to add a headline? And a paragraph? Go ahead! Or just leave it empty and nothing will be shown.', 'flynt'),
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
                'media_upload' => 0,
                'delay' => 0,
            ],
            [
                'name' => 'taxonomies',
                'label' => __('Categories', 'flynt'),
                'instructions' => __('Select 1 or more categories or leave empty to show from all posts.', 'flynt'),
                'type' => 'taxonomy',
                'taxonomy' => 'category',
                'field_type' => 'multi_select',
                'allow_null' => 1,
                'multiple' => 1,
                'add_term' => 0,
                'save_terms' => 0,
                'load_terms' => 0,
                'return_format' => 'object',
            ],
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
                    FieldVariables\getTheme(),
                    [
                        'name' => 'maxPosts',
                        'label' => __('Max Posts', 'flynt'),
                        'type' => 'number',
                        'default_value' => 3,
                        'min' => 1,
                        'step' => 1,
                    ],
                    [
                        'name' => 'maxColumns',
                        'label' => __('Max Columns', 'flynt'),
                        'type' => 'number',
                        'default_value' => 3,
                        'min' => 1,
                        'max' => 4,
                        'step' => 1,
                    ],
                ],
            ],
        ],
    ];
}

Options::addTranslatable('GridPostsLatest', [
    [
        'name' => 'contentTab',
        'label' => __('Content', 'flynt'),
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'name' => 'preContentHtml',
        'label' => __('Title', 'flynt'),
        'type' => 'wysiwyg',
        'default_value' => '<h2>' . __('Related Posts', 'flynt') . '</h2>',
        'tabs' => 'visual,text',
        'media_upload' => 0,
        'delay' => 0,
    ],
    [
        'name' => 'labelsTab',
        'label' => __('Labels', 'flynt'),
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    ],
    [
        'name' => 'labels',
        'label' => '',
        'type' => 'group',
        'sub_fields' => [
            [
                'name' => 'allPosts',
                'label' => __('All Posts', 'flynt'),
                'type' => 'text',
                'default_value' => __('See More Posts', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => 50,
                ],
            ],
        ],
    ],
]);
