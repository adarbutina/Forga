<?php

namespace Flynt\Components\FeatureGoogleTagManager;

use Flynt\Utils\Options;
use Timber\Timber;

class GoogleTagManager
{
    public static function init()
    {
        add_action('wp_head', [self::class, 'renderScript'], PHP_INT_MIN);
        add_action('wp_body_open', [self::class, 'renderNoScript'], PHP_INT_MIN);
        add_action('wp_footer', [self::class, 'renderComponent'], PHP_INT_MIN);

        add_action('woocommerce_thankyou', [self::class, 'addPurchaseData']);

        self::registerOptions();
    }

    public static function renderComponent(): void
    {
        $containerID = self::getContainerID();
        if ($containerID) {
            Timber::render_string('{{ renderComponent("FeatureGoogleTagManager") }}');
        }
    }

    public static function renderScript(): void
    {
        $componentPath = __DIR__;
        print_r($componentPath);
        $data = Options::getGlobal('GoogleTagManager');
        Timber::render("{$componentPath}/Partials/_script.twig", $data);
    }

    public static function renderNoScript(): void
    {
        $containerID = self::getContainerID();
        if ($containerID) {
            printf(
                '<!-- Google Tag Manager (noscript) -->
                <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=%s"
                height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
                <!-- End Google Tag Manager (noscript) -->',
                esc_attr($containerID)
            );
        }
    }

    public static function addPurchaseData($order_id): void
    {
        $order = wc_get_order($order_id);
        wp_localize_script('Flynt/assets/main', 'PurchaseData', [
            'transaction_id' => $order->get_order_number(),
            'currency' => get_woocommerce_currency(),
            'value' => $order->get_total(),
            'tax' => $order->get_total_tax(),
            'payment_type' => $order->get_payment_method_title(),
            'items' => array_values(array_map(function ($item) {
                $product = $item->get_product();
                $data = [
                    'item_id' => $product->get_sku(),
                    'item_name' => $product->get_name(),
                    'item_type' => $product->get_type(),
                    'price' => $item->get_total(),
                    'quantity' => $item->get_quantity(),
                ];
                return $data;
            }, $order->get_items())),
        ]);
    }

    protected static function registerOptions(): void
    {
        Options::addGlobal('GoogleTagManager', [
            [
                'name'  => 'containerId',
                'label' => __('Container ID', 'flynt'),
                'type'  => 'text',
            ],
        ]);
    }

    protected static function getContainerID(): string|bool
    {
        $gtm = Options::getGlobal('GoogleTagManager');
        return $gtm['containerID'] ?? false;
    }
}
