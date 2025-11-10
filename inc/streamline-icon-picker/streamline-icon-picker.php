<?php
/**
 * StreamlineHQ ACF Icon Picker (Theme Module)
 */
if (!defined('ABSPATH')) exit;

define('STREAMLINE_PLUGIN_PATH', get_template_directory() . '/inc/streamline-icon-picker/');
define('STREAMLINE_PLUGIN_URL', get_template_directory_uri() . '/inc/streamline-icon-picker/');

require_once STREAMLINE_PLUGIN_PATH . 'includes/class-streamline-api-handler.php';
require_once STREAMLINE_PLUGIN_PATH . 'includes/acf-streamline-icon-picker-v5.php';

add_action('init', function() {
    if (class_exists('Streamline_API_Handler')) {
        Streamline_API_Handler::init();
    }
});
 