<?php
/**
 * Advanced WP All Import ACF Auto-population
 * 
 * Multiple methods for auto-populating flexible content based on different scenarios
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * METHOD 1: Auto-populate based on post meta or custom field from import
 * 
 * This checks if a specific meta field exists in the import data
 * and populates flexible content accordingly
 */
function cm_conditional_flexible_content($post_id, $xml_node, $is_update) {
    
    // Check if a trigger field exists (you can set this in WP All Import)
    $should_add_flexible = get_post_meta($post_id, '_add_flexible_content', true);
    
    if ($should_add_flexible === '1' || $should_add_flexible === 'yes') {
        
        // Get custom values from post meta if they exist
        $custom_heading = get_post_meta($post_id, '_flexible_heading', true);
        $custom_content = get_post_meta($post_id, '_flexible_content', true);
        
        $flexible_content = array(
            array(
                'acf_fc_layout' => 'custom_columns',
                'num_columns' => '1',
                'alignment' => 'Centered',
                'column_1' => array(
                    'zone_heading' => array(
                        'heading' => !empty($custom_heading) ? $custom_heading : 'Custom Columns Zone Heading',
                    ),
                    'content' => !empty($custom_content) ? $custom_content : 'Column 1 -> Content',
                ),
            ),
        );
        
        update_field('flexible_content', $flexible_content, $post_id);
        
        // Clean up temporary meta fields
        delete_post_meta($post_id, '_add_flexible_content');
        delete_post_meta($post_id, '_flexible_heading');
        delete_post_meta($post_id, '_flexible_content');
    }
}
// Uncomment to activate:
// add_action('pmxi_saved_post', 'cm_conditional_flexible_content', 10, 3);


/**
 * METHOD 2: Auto-populate for posts without any flexible content
 * 
 * This adds default flexible content only if the field is completely empty
 */
function cm_add_default_flexible_if_empty($post_id, $xml_node, $is_update) {
    
    $flexible = get_field('flexible_content', $post_id);
    
    // Only add if completely empty
    if (empty($flexible)) {
        
        $default_flexible = array(
            array(
                'acf_fc_layout' => 'custom_columns',
                'num_columns' => '1',
                'alignment' => 'Centered',
                'include_special_content' => false,
                'column_1' => array(
                    'zone_heading' => array(
                        'heading' => 'Custom Columns Zone Heading',
                    ),
                    'content' => 'Column 1 -> Content',
                ),
            ),
        );
        
        update_field('flexible_content', $default_flexible, $post_id);
    }
}
// Uncomment to activate:
// add_action('pmxi_saved_post', 'cm_add_default_flexible_if_empty', 10, 3);


/**
 * METHOD 3: Append flexible content (don't replace existing)
 * 
 * This adds a new custom_columns layout to existing flexible content
 */
function cm_append_flexible_content($post_id, $xml_node, $is_update) {
    
    $flexible = get_field('flexible_content', $post_id);
    
    // Initialize if empty
    if (empty($flexible)) {
        $flexible = array();
    }
    
    // Check if custom_columns already exists
    $has_custom_columns = false;
    foreach ($flexible as $layout) {
        if (isset($layout['acf_fc_layout']) && $layout['acf_fc_layout'] === 'custom_columns') {
            $has_custom_columns = true;
            break;
        }
    }
    
    // Only add if it doesn't exist
    if (!$has_custom_columns) {
        $new_layout = array(
            'acf_fc_layout' => 'custom_columns',
            'num_columns' => '1',
            'alignment' => 'Centered',
            'column_1' => array(
                'zone_heading' => array(
                    'heading' => 'Custom Columns Zone Heading',
                ),
                'content' => 'Column 1 -> Content',
            ),
        );
        
        // Append to existing flexible content
        $flexible[] = $new_layout;
        
        update_field('flexible_content', $flexible, $post_id);
    }
}
// Uncomment to activate:
// add_action('pmxi_saved_post', 'cm_append_flexible_content', 10, 3);


/**
 * METHOD 4: Multiple columns with dynamic content
 * 
 * This creates a 2 or 3 column layout with content from the post
 */
function cm_multi_column_flexible($post_id, $xml_node, $is_update) {
    
    $flexible = get_field('flexible_content', $post_id);
    
    if (empty($flexible)) {
        
        // Get post content to split into columns
        $post = get_post($post_id);
        $content = $post->post_content;
        
        $flexible_content = array(
            array(
                'acf_fc_layout' => 'custom_columns',
                'num_columns' => '2', // 2 columns
                'include_special_content' => false,
                'column_1' => array(
                    'zone_heading' => array(
                        'heading' => get_the_title($post_id),
                    ),
                    'content' => wp_trim_words($content, 50), // First 50 words
                ),
                'column_2' => array(
                    'zone_heading' => array(
                        'heading' => 'Additional Information',
                    ),
                    'content' => 'Column 2 content here',
                ),
            ),
        );
        
        update_field('flexible_content', $flexible_content, $post_id);
    }
}
// Uncomment to activate:
// add_action('pmxi_saved_post', 'cm_multi_column_flexible', 10, 3);


/**
 * METHOD 5: Based on post category or taxonomy
 * 
 * Add different flexible content based on post category
 */
function cm_category_based_flexible($post_id, $xml_node, $is_update) {
    
    $categories = wp_get_post_categories($post_id);
    
    if (empty($categories)) {
        return;
    }
    
    $flexible = get_field('flexible_content', $post_id);
    
    if (empty($flexible)) {
        
        // Get first category name
        $category = get_category($categories[0]);
        
        $flexible_content = array(
            array(
                'acf_fc_layout' => 'custom_columns',
                'num_columns' => '1',
                'alignment' => 'Centered',
                'column_1' => array(
                    'zone_heading' => array(
                        'heading' => 'Category: ' . $category->name,
                    ),
                    'content' => 'Content for ' . $category->name . ' category',
                ),
            ),
        );
        
        update_field('flexible_content', $flexible_content, $post_id);
    }
}
// Uncomment to activate:
// add_action('pmxi_saved_post', 'cm_category_based_flexible', 10, 3);
