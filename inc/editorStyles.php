<?php

namespace Flynt\EditorStyles;

use Flynt\Utils\AssetLoader;

add_action('after_setup_theme', function (): void {
    add_theme_support('editor-styles');

    $stylesheet = getEditorStylesheetUrl();
    add_editor_style($stylesheet);
});

function getEditorStylesheetUrl(): string {
    return str_replace(get_template_directory_uri(), '', AssetLoader::requireUrl('assets/editor-style.scss'));
}
