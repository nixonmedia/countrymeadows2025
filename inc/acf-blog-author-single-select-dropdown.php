<?php
/**
 * ACF Blog Author - Single Select Dropdown UI
 * 
 * Enqueues CSS and JS to transform the Blog Author relationship field
 * into a dropdown-like single-select interface while keeping it as a relationship field.
 * 
 * Features:
 * - Keeps field type as "relationship"
 * - Dropdown-like UI (collapsed/expanded)
 * - Single selection only
 * - No drag-and-drop
 * - Clean, native WordPress UI
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue CSS and JS for single-select dropdown
 */
function cm_blog_author_single_select_dropdown_assets($hook) {
    // Only on post edit screens
    if (!in_array($hook, array('post.php', 'post-new.php'))) {
        return;
    }
    
    // Only for 'post' post type
    global $post_type;
    if ($post_type !== 'post') {
        return;
    }
    
    // Enqueue CSS
    wp_enqueue_style(
        'acf-single-select',
        get_template_directory_uri() . '/assets/css/acf-single-select.css',
        array('acf-input'),
        filemtime(get_template_directory() . '/assets/css/acf-single-select.css')
    );
    
    // Enqueue JS
    wp_enqueue_script(
        'acf-single-select',
        get_template_directory_uri() . '/assets/js/acf-single-select.js',
        array('jquery', 'acf-input'),
        filemtime(get_template_directory() . '/assets/js/acf-single-select.js'),
        true
    );
}
add_action('admin_enqueue_scripts', 'cm_blog_author_single_select_dropdown_assets');

/**
 * Set max to 1 for single selection (backend validation)
 */
function cm_blog_author_set_max($field) {
    // Only modify the blog_author field
    if ($field['name'] !== 'blog_author') {
        return $field;
    }
    
    // Set max to 1 for single selection
    $field['max'] = 1;
    
    return $field;
}
add_filter('acf/load_field/name=blog_author', 'cm_blog_author_set_max');

/**
 * Validate single selection on save
 */
function cm_blog_author_validate_single($valid, $value, $field, $input) {
    // Only validate the blog_author field
    if ($field['name'] !== 'blog_author') {
        return $valid;
    }
    
    // Check if more than one author is selected
    if (is_array($value) && count($value) > 1) {
        $valid = 'Please select only one blog author.';
    }
    
    return $valid;
}
add_filter('acf/validate_value/name=blog_author', 'cm_blog_author_validate_single', 10, 4);

/**
 * Ensure only one blog author is saved (server-side enforcement)
 */
function cm_blog_author_enforce_single($value, $post_id, $field) {
    // Only enforce for blog_author field
    if ($field['name'] !== 'blog_author') {
        return $value;
    }
    
    // If multiple values, keep only the first one
    if (is_array($value) && count($value) > 1) {
        $value = array($value[0]);
    }
    
    return $value;
}
add_filter('acf/update_value/name=blog_author', 'cm_blog_author_enforce_single', 10, 3);

