<?php

/**
 * Add Twig extensions.
 */

namespace Flynt\TwigExtensions;

use Flynt\Utils\TwigExtensionPlaceholderImage;
use Flynt\Utils\TwigExtensionReadingTime;
use Flynt\Utils\TwigExtensionRenderComponent;
use Twig\Environment;

add_filter('timber/twig', function (Environment $twig): Environment {
    $twig->addExtension(new TwigExtensionPlaceholderImage());
    $twig->addExtension(new TwigExtensionReadingTime());
    $twig->addExtension(new TwigExtensionRenderComponent());
    return $twig;
});
