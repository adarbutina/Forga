<?php

namespace Flynt\Components\WooCommerce\FormCheckout;

function getACFLayout(): array {
    return [
        'name' => 'formCheckout',
        'label' => __('Form Checkout', 'flynt'),
    ];
}
