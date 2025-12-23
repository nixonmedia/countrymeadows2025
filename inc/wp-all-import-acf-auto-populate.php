<?php
/**
 * Auto-populate ACF Flexible Content on WP All Import
 * 
 * This file automatically adds a "Custom Columns" flexible content layout
 * with default values when posts are imported via WP All Import.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Automatically add Custom Columns flexible content after import
 * 
 * @param int $post_id The ID of the post being imported
 * @param array $xml_node The XML data for this post
 * @param bool $is_update Whether this is an update or new post
 */
function cm_auto_add_flexible_content_on_import($post_id, $xml_node, $is_update) {
    
    // Only run for specific post types (adjust as needed)
    $allowed_post_types = array('post', 'page'); // Add your custom post types here
    
    if (!in_array(get_post_type($post_id), $allowed_post_types)) {
        return;
    }
    
    // Check if flexible content already exists (to avoid overwriting)
    $existing_flexible = get_field('flexible_content', $post_id);
    
    // Only add if flexible content is empty or doesn't exist
    if (empty($existing_flexible)) {
        
        // Get the post data
        $post = get_post($post_id);
        
        // Get post title and content
        $post_title = get_the_title($post_id);
        $post_content = $post->post_content; // This gets the WYSIWYG content
        
        // Prepare the flexible content data
        $flexible_content = array(
            array(
                'acf_fc_layout' => 'custom_columns', // Layout name from your ACF JSON
                'num_columns' => '1', // Default to 1 column
                'alignment' => 'Left', // Left or Centered
                'include_special_content' => false,
                'custom_columns_zone_heading' => array(
                    'heading' => $post_title, // Use post title as heading
                    'heading_type' => 'h2', // h1, h2, h3, or h4
                ),
                'include_image_headers_on_custom_content' => false,
                'column_1' => array(
                    'column_position' => 'Left', // Left or Centered
                    'heading' => array(
                        'heading' => '', // Column 1 heading (optional)
                        'heading_type' => 'h3',
                    ),
                    'content' => $post_content, // Use post content (WYSIWYG)
                ),
            ),
        );
        
        // Update the flexible content field
        update_field('flexible_content', $flexible_content, $post_id);
        
        // Optional: Clear the post content to avoid duplication (uncomment if needed)
        // wp_update_post(array(
        //     'ID' => $post_id,
        //     'post_content' => '', // Clear original content
        // ));
        
        // Optional: Log for debugging
        error_log("Auto-populated flexible content for post ID: {$post_id} with title: {$post_title}");
    }
}

// Hook into WP All Import after post is saved
add_action('pmxi_saved_post', 'cm_auto_add_flexible_content_on_import', 10, 3);


/**
 * Alternative: Add flexible content only for specific import IDs
 * Uncomment and modify if you want to target specific imports
 */
/*
function cm_auto_add_flexible_content_specific_import($post_id, $xml_node, $is_update, $import_id) {
    
    // Only run for specific import ID (find this in WP All Import > Manage Imports)
    $target_import_ids = array(1, 2, 3); // Replace with your import IDs
    
    if (!in_array($import_id, $target_import_ids)) {
        return;
    }
    
    // Same logic as above
    $existing_flexible = get_field('flexible_content', $post_id);
    
    if (empty($existing_flexible)) {
        // Get the post data
        $post = get_post($post_id);
        $post_title = get_the_title($post_id);
        $post_content = $post->post_content;
        
        $flexible_content = array(
            array(
                'acf_fc_layout' => 'custom_columns',
                'num_columns' => '1',
                'alignment' => 'Left', // Left or Centered
                'include_special_content' => false,
                'custom_columns_zone_heading' => array(
                    'heading' => $post_title, // Use post title
                    'heading_type' => 'h2',
                ),
                'include_image_headers_on_custom_content' => false,
                'column_1' => array(
                    'column_position' => 'Left', // Left or Centered
                    'heading' => array(
                        'heading' => '',
                        'heading_type' => 'h3',
                    ),
                    'content' => $post_content, // Use post content
                ),
            ),
        );
        
        update_field('flexible_content', $flexible_content, $post_id);
    }
}

add_action('pmxi_saved_post', 'cm_auto_add_flexible_content_specific_import', 10, 4);
*/
