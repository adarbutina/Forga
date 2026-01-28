<?php

namespace Flynt\Components\WooCommerce\BlockStoreNotices;

use Timber\Timber;

remove_action('woocommerce_cart_is_empty', 'woocommerce_output_all_notices', 5);
remove_action('woocommerce_shortcode_before_product_cat_loop', 'woocommerce_output_all_notices', 10);
remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
remove_action('woocommerce_before_single_product', 'woocommerce_output_all_notices', 10);
remove_action('woocommerce_before_cart', 'woocommerce_output_all_notices', 10);
remove_action('woocommerce_before_checkout_form_cart_notices', 'woocommerce_output_all_notices', 10);
remove_action('woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10);
remove_action('woocommerce_account_content', 'woocommerce_output_all_notices', 5);
remove_action('woocommerce_before_customer_login_form', 'woocommerce_output_all_notices', 10);
remove_action('woocommerce_before_lost_password_form', 'woocommerce_output_all_notices', 10);
remove_action('before_woocommerce_pay', 'woocommerce_output_all_notices', 10);
remove_action('woocommerce_before_reset_password_form', 'woocommerce_output_all_notices', 10);

add_action('woocommerce_cart_is_empty', __NAMESPACE__ . '\\renderComponent', 5);
add_action('woocommerce_shortcode_before_product_cat_loop', __NAMESPACE__ . '\\renderComponent', 10);
add_action('woocommerce_before_shop_loop', __NAMESPACE__ . '\\renderComponent', 10);
add_action('woocommerce_before_single_product', __NAMESPACE__ . '\\renderComponent', 10);
add_action('woocommerce_before_cart', __NAMESPACE__ . '\\renderComponent', 10);
add_action('woocommerce_before_checkout_form_cart_notices', __NAMESPACE__ . '\\renderComponent', 10);
add_action('woocommerce_before_checkout_form', __NAMESPACE__ . '\\renderComponent', 10);
add_action('woocommerce_account_content', __NAMESPACE__ . '\\renderComponent', 5);
add_action('woocommerce_before_customer_login_form', __NAMESPACE__ . '\\renderComponent', 10);
add_action('woocommerce_before_lost_password_form', __NAMESPACE__ . '\\renderComponent', 10);
add_action('before_woocommerce_pay', __NAMESPACE__ . '\\renderComponent', 10);
add_action('woocommerce_before_reset_password_form', __NAMESPACE__ . '\\renderComponent', 10);

function renderComponent(): void {
    Timber::render_string('{{ renderComponent("BlockStoreNotices") }}');
}
