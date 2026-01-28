# Developer Technical Assignment Migration Project

For 99.99% of the projects I do in WordPress, I use [Flynt](https://flyntwp.com/), an open-source WordPress Starter Theme for component-based development with ACF Pro. For a more detailed explanation of how the theme works, I suggest reading through their official [GitHub](https://github.com/flyntwp/flynt) repository. Reasons why I prefer using this theme instead of coding everything from scratch are the following:

1) Flynt is built with performance in mind, including automatic lazy-loading, JavaScript Islands architecture, and optimized build with Vite, therefore you get excellent PageSpeed scores right away.

2) The theme uses a reusable, component-based structure that helps you organize code cleanly and build pages from isolated pieces. This makes maintenance, reusability, and scaling of project code much easier.

3) Flynt integrates Vite for optimized builds, uses Timber + Twig for template rendering, and uses custom components with SCSS and vanilla JavaScript. This improves the developer experience significantly over traditional starter themes.

4) Through ACF Pro and Timber, you get rich content control in the WordPress admin while keeping templates clean. The ACF Flexible Content fields allow editors (and developers) to compose pages from components without writing code manually each time.

## Task 1 - Custom Theme Architecture

This theme includes the following folders:

1) `./assets` - this folder contains all global JavaScript, SCSS, images, and font files for the theme. Flynt uses Vite to watch for changes and compile them to `./dist`. The `main.scss` file is compiled to `./dist/assets/main.css` which is enqueued in the front-end. The `admin.scss` file is compiled to `./dist/assets/admin.css` which is enqueued in the administrator back-end of WordPress, so styles added to this file will take effect only in the back-end. Main and Admin SCSS and JS are enqueued globally, while component-specific JS is conditionally loaded via Flynt's JS Islands.

2) `./Components` - this folder is where all of the components are placed. Every component is a self-contained building-block that can have its own layout, ACF fields, PHP logic, scripts, and styles. This is the main folder of the theme where most of the frontend magic happens.

3) `./inc` - this folder is a more organised version of WordPress' `functions.php` and contains all custom theme logic. All files in the `./inc` folder are automatically required inside `functions.php`.

4) `./lib` - this folder includes helper functions and basic setup logic. Files inside this folder most likely won't need to be modified. All of the files inside are autoloaded via PSR-4.

5) `./templates` - Flynt uses Timber to combine PHP logic with Twig templates. Besides the main document structure (in `./templates/_document.twig`), everything else is a component.

6) `./woocommerce` (optional) - This folder is optional, and whether I use it or not depends on the project requirements. In this example, I've included it with two base templates, just for demonstration purposes. PHP files handle all the logic while Twig files handle the markup. Keep in mind, if you were to install this specific theme to any WooCommerce website, the `./woocommerce/single-product.php` and `./woocommerce/archive-product.php` would be ignored because `./woocommerce.php` has higher priority. I usually use only `./woocommerce.php` and load different templates conditionally. Generally, I avoid using WooCommerce template overrides as much as possible as it only adds more dependencies to the theme (and makes stuff harder to track). Instead, if I need to add/change/remove any of WooCommerce's behavious or templates, I add a new component and write the logic inside its `functions.php`.

## Task 2 - WooCommerce Single Product Page

As mentioned in the previous example, I generally avoid using WooCommerce template overrides as it makes maintenace more complex. Instead, I use hooks/filters inside components `functions.php`. For example, `./Components/WooCommerce/NavigationBreadcrumb` replaces default WooCommerce breadcrumb template with a custom one (in this case, it only wraps the default one inside the component wrapper, making it easier to style).

Another example is is `./Components/WooCommerce/BlockProductGallery`, where I replace default product image gallery and add a custom one that fixes the layout shift that happens when variation permalink is loaded. To see what I mean, simply comment out the action hooks inside the component's `function.php` and load the variation on the frontend directly through its permalink. Pay close attention to the brief "switch" between parent product and variation image.

```
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
add_action('woocommerce_before_single_product_summary', function (): void {
    Timber::render_string('{{ renderComponent("BlockProductGallery") }}');
}, 20);
```

Add-to-cart logic is handled via native WooCommerce templates and JS to preserve compatibility for simple and variable products.

## Task 3 - Headless Detachment & Data Safety

1) To start with, I'd make a full backup of the database (via phpMyAdmin or WP Migration plugin) and wp-content/uploads files, rather than relying solely on host backups.
2) After that, I'd create a staging version on a different domain/subdomain and import all the data there, so that I have an identical version of the production website.
3) On the staging version, I'd list all APIs, custom data, and plugins used for the headless frontend, and one-by-one, disable them and test the results. I'd make sure all product/order/user data remains unchanged.
4) I'd then implement a new theme and refactor all custom headless functionalities to classic ones.
5) I'd ensure all URLs remain unchanged.


## Task 4 - WooCommerce Custom Logic Scenario

In this example, I've hidden all of the products from the menus and archives if it has 'hidden' category assigned to it. I've modified both the main WooCommerce query and nav menu items. The condition I added is just an example, and can be modified based on different requirements.

```
/**
 * Hide products from catalog & menus if they have 'hidden' product category assigned to them.
 */

add_action('woocommerce_product_query', function ($query) {
    if (is_admin() || is_user_logged_in()) {
        return;
    }

    $taxQuery = (array) $query->get('tax_query');

    $taxQuery[] = [
        'taxonomy' => 'product_cat',
        'field'    => 'slug',
        'terms'    => ['hidden'],
        'operator' => 'NOT IN',
    ];

    $query->set('tax_query', $taxQuery);
});

add_filter('wp_nav_menu_objects', function ($items) {
    if (is_user_logged_in()) {
        return $items;
    }

    foreach ($items as $key => $item) {
        if ($item->object === 'product' && has_term('hidden', 'product_cat', $item->object_id)) {
            unset($items[$key]);
        }
    }

    return $items;
});
```

And just to point out, `woocommerce_product_query` only affects main WC loops - custom queries would need similar handling.

## Task 5

### Option A - QA & Production Readiness

#### QA

During QA, I'd make start with the following:

- Cart:
  - Ensure quantity updates for simple and variable products
  - Validate price calculations (taxes, discounts, coupons, shipping)
  - Validate data consistency on page reloads, sessions, and logins/logouts

- Checkout:
  - Validate all the checkout fields are working and behaving as expected
  - Test all payment gateways
  - Verify shipping methods, costs, and address-based rules
  - Confirm order creation, order status transitions, and stored metadata
  - Ensure checkout works on mobile

- Emails:
  - Test all core emails (new order, processing, completed, failed, refunds)
  - Check email formatting
  - Verify recipient addresses, subject lines, and dynamic content

#### Testing

Before going live, I'd test the following:

- I'd make sure the website loads quickly and works properly on both mobile and desktop devices (ensure optimised assets are being used, enable caching, ensure images are optimized)
- I'd make sure that the website is mobile responsivene and doesn't have any cross-browser compatibility issues
- I'd make sure that taxes and shipping are set up correctly
- I'd go through the entire order flow, make sure the shopping process works seamlessly, as expected
- I'd prepare a backup plan in case something goes wrong
- I'd make sure that currency and language are set up properly
