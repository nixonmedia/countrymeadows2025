<?php
/**
 * StreamlineHQ ACF Icon Picker (Theme Module)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ---------------------------------------------------------
// Define constants
// ---------------------------------------------------------
define('STREAMLINE_PLUGIN_PATH', get_template_directory() . '/inc/streamline-icon-picker/');
define('STREAMLINE_PLUGIN_URL', get_template_directory_uri() . '/inc/streamline-icon-picker/');

// ---------------------------------------------------------
// Load Streamline API Handler
// ---------------------------------------------------------
require_once STREAMLINE_PLUGIN_PATH . 'includes/class-streamline-api-handler.php';

add_action( 'init', function() {
    if ( class_exists( 'Streamline_API_Handler' ) ) {
        Streamline_API_Handler::init();
    }
});

// ---------------------------------------------------------
// Register custom ACF field type (after ACF is loaded)
// ---------------------------------------------------------
add_action( 'acf/include_field_types', function() {
    require_once STREAMLINE_PLUGIN_PATH . 'includes/acf-streamline-icon-picker-v5.php';
});
