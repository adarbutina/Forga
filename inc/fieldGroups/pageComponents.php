<?php

namespace Flynt\FieldGroups;

use Flynt\ACFComposer;
use Flynt\Components;

add_action('Flynt/afterRegisterComponents', function (): void {
    ACFComposer::registerFieldGroup([
        'name' => 'pageComponents',
        'title' => __('Page Components', 'flynt'),
        'style' => 'seamless',
        'show_in_rest' => 1,
        'fields' => [
            [
                'name' => 'pageComponents',
                'label' => __('Page Components', 'flynt'),
                'type' => 'flexible_content',
                'button_label' => __('Add Component', 'flynt'),
                'layouts' => [
                    Components\BlockAnchor\getACFLayout(),
                    Components\BlockImageText\getACFLayout(),
                    Components\BlockSpacer\getACFLayout(),
                    Components\BlockWysiwyg\getACFLayout(),
                    Components\FormContactForm7\getACFLayout(),
                    Components\GridImages\getACFLayout(),
                    Components\GridPostsLatest\getACFLayout(),
                    Components\HeroImageText\getACFLayout(),
                    Components\HeroTextImage\getACFLayout(),
                    Components\ListIcons\getACFLayout(),
                    Components\ListLogos\getACFLayout(),
                    Components\ReusableComponent\getACFLayout(),
                    Components\SliderImageGallery\getACFLayout(),
                    Components\SliderPosts\getACFLayout(),
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ],
            ],
        ],
    ]);
});
