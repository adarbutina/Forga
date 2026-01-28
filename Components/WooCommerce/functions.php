<?php

namespace Flynt\Components\WooCommerce;

use Flynt\ACFComposer;
use Flynt\Api;
use Flynt\Components;

if (!class_exists('WooCommerce')) {
    return;
}

call_user_func(function (): void {
    $basePath = __DIR__;
    Api::registerComponentsFromPath($basePath);
});

add_action('Flynt/afterRegisterComponents', function (): void {
    $acfData = acf_get_local_store('fields');
    $fieldGroups = ['pageComponents', 'reusableComponents'];
    $layouts = [
        Components\WooCommerce\FormCart\getACFLayout(),
        Components\WooCommerce\FormCheckout\getACFLayout(),
        Components\WooCommerce\SliderProducts\getACFLayout(),
    ];

    foreach ($fieldGroups as $fieldGroup) {
        $fields = $acfData->get($fieldGroup);
        foreach ($layouts as $layout) {
            $config = ACFComposer::forLayout($layout, [$fieldGroup . '_' . $fieldGroup]);
            $fields['layouts'][] = $config;
        }

        $acfData->set($fields['key'], $fields);
    }
}, 11);

// Disable default styles.
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Override default templates.
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
remove_action('woocommerce_single_variation', 'woocommerce_single_variation', 10);

// Remove "clear" link from variation picker.
add_filter('woocommerce_reset_variations_link', '__return_empty_string');
