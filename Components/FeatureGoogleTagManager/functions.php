<?php

namespace Flynt\Components\FeatureGoogleTagManager;

use Flynt\ComponentManager;
use Flynt\Utils\Options;

Options::addGlobal('GoogleTagManager', [
    [
        'name'  => 'containerId',
        'label' => __('Container ID', 'flynt'),
        'type'  => 'text',
    ],
]);

function getComponentPath(): string {
    $componentManager = ComponentManager::getInstance();
    $componentPathFull = $componentManager->getComponentDirPath('FeatureGoogleTagManager');
    return str_replace(trailingslashit(get_template_directory()), '', $componentPathFull);
}
