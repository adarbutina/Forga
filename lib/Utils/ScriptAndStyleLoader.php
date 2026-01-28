<?php

namespace Flynt\Utils;

class ScriptAndStyleLoader
{
    // Filters the script loader tag.
    public function filterScriptLoaderTag(string $tag, string $handle, string $src): string
    {
        if (wp_scripts()->get_data($handle, 'module')) {
            $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
        }

        return $tag;
    }
}
