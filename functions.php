<?php

namespace Flynt;

use Flynt\Utils\FileLoader;

require_once __DIR__ . '/vendor/autoload.php';

if (!defined('WP_ENV')) {
    define('WP_ENV', function_exists('wp_get_environment_type') ? wp_get_environment_type() : 'production');
} elseif (!defined('WP_ENVIRONMENT_TYPE')) {
    define('WP_ENVIRONMENT_TYPE', WP_ENV);
}

if (Theme::checkRequiredPlugins()) {
    add_action('after_setup_theme', function (): void {
        FileLoader::loadPhpFiles('inc');
    }, PHP_INT_MIN);
    add_action('after_setup_theme', [Theme::class, 'init']);
    add_action('after_setup_theme', [Theme::class, 'loadComponents']);
}

// Remove the admin-bar inline-CSS as it isn't compatible with the sticky footer CSS.
// This prevents unintended scrolling on pages with few content, when logged in.
add_theme_support('admin-bar', ['callback' => '__return_false']);

add_action('after_setup_theme', function (): void {
    // Make theme available for translation.
    // Translations can be filed in the /languages/ directory.
    load_theme_textdomain('flynt', get_template_directory() . '/languages');
});
