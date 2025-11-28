<?php
/**
 * Handles StreamlineHQ icon loading from local filesystem (no API).
 */

class Streamline_API_Handler {

    const OPTIONS_KEY   = 'streamline_icon_data';
    const ICONS_FOLDER  = 'inc/streamline-icon-picker/icons';

    public static function init() {
        // No ACF filters needed - icons are stored as plain text IDs
    }

    /**
     * Load icons from local filesystem (icons folder)
     */
    public static function get_icons() {
        $icons_dir = get_template_directory() . '/' . self::ICONS_FOLDER;
        $icons = [];

        if (!is_dir($icons_dir)) {
            return $icons;
        }

        $files = glob($icons_dir . '/*.svg');
        if (empty($files)) {
            return $icons;
        }

        $icons_uri = get_template_directory_uri() . '/' . self::ICONS_FOLDER;

        foreach ($files as $file) {
            $basename = basename($file, '.svg');
            $icons[] = [
                'id'      => $basename,
                'name'    => $basename,
                'path'    => $file,
                'preview' => $icons_uri . '/' . $basename . '.svg',
            ];
        }

        // Sort icons by name
        usort($icons, function($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        return $icons;
    }

    /**
     * ACF formatting - return SVG file path for use in templates
     */
    public static function get_icon_svg_path($icon_id) {
        if (is_array($icon_id)) $icon_id = $icon_id['id'] ?? '';
        if (empty($icon_id)) return '';

        $file_path = get_template_directory() . '/' . self::ICONS_FOLDER . '/' . sanitize_file_name($icon_id) . '.svg';

        // Verify file exists and is readable
        if (!file_exists($file_path) || !is_readable($file_path)) {
            return '';
        }

        return $file_path;
    }
}

Streamline_API_Handler::init();
