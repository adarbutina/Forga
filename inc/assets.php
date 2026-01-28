<?php

namespace Flynt\Assets;

use Flynt\ComponentManager;
use Flynt\Utils\AssetLoader;
use Flynt\Utils\ScriptAndStyleLoader;

call_user_func(function (): void {
    $loader = new ScriptAndStyleLoader();
    add_filter('script_loader_tag', [$loader, 'filterScriptLoaderTag'], 10, 3);
});

add_action('wp_enqueue_scripts', function (): void {
    wp_enqueue_script('Flynt/assets/main', AssetLoader::requireUrl('assets/main.js'), [], null, true);
    wp_script_add_data('Flynt/assets/main', 'module', true);

    wp_localize_script('Flynt/assets/main', 'FlyntData', [
        'componentsWithScript' => ComponentManager::getInstance()->getComponentsWithScript(),
        'templateDirectoryUri' => get_template_directory_uri(),
    ]);

    wp_enqueue_style('Flynt/assets/main', AssetLoader::requireUrl('assets/main.scss'), [], null);
});

add_action('admin_enqueue_scripts', function (): void {
    wp_enqueue_script('Flynt/assets/admin', AssetLoader::requireUrl('assets/admin.js'), [], null, true);
    wp_script_add_data('Flynt/assets/admin', 'module', true);

    wp_localize_script('Flynt/assets/admin', 'FlyntData', [
        'componentsWithScript' => ComponentManager::getInstance()->getComponentsWithScript(),
        'templateDirectoryUri' => get_template_directory_uri(),
    ]);

    wp_enqueue_style('Flynt/assets/admin', AssetLoader::requireUrl('assets/admin.scss'), [], null);
}, 5);
