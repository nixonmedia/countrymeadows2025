<?php

/**
 * Twenty Twenty-Two functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Two
 * @since Twenty Twenty-Two 1.0
 */

if (! function_exists('country_meadows_support')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * @since Twenty Twenty-Two 1.0
     *
     * @return void
     */
    function country_meadows_support()
    {

        // Add support for block styles.
        add_theme_support('wp-block-styles');


        add_theme_support(
            'custom-logo',
            array(
                'height'               => "100px",
                'width'                => "100px",
                'flex-width'           => true,
                'flex-height'          => true,
                'unlink-homepage-logo' => false,
            )
        );

        // Enqueue editor styles.
        add_editor_style('style.css');

        register_nav_menus(
            array(
                'primary'            => esc_html__('Primary Menu', 'country_meadows'),
                'secondary'          => esc_html__('Secondary Menu', 'country_meadows'),
                'footer'             => esc_html__('Footer Menu', 'country_meadows'),
                'footer_communities' => esc_html__('Footer Communities', 'country_meadows'),
            )
        );

        // Register custom thumbnail size
        add_image_size('footer-column', 225, 125, true);
    }

endif;

add_action('after_setup_theme', 'country_meadows_support');

if (! function_exists('country_meadows_styles')) :

    /**
     * Enqueue styles.
     *
     * @since Twenty Twenty-Two 1.0
     *
     * @return void
     */
    function country_meadows_styles()
    {
        // Register theme stylesheet.
        $theme_version = wp_get_theme()->get('Version');

        $version_string = is_string($theme_version) ? $theme_version : false;
        wp_register_style(
            'country_meadows-style',
            get_template_directory_uri() . '/style.css',
            array(),
            $version_string
        );

        // Enqueue theme stylesheet.
        wp_enqueue_style('country_meadows-style');


        // Enqueue Bootstrap CSS
        wp_enqueue_style('country_meadows-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', array(), $theme_version);

        // Enqueue Custom Styles
        wp_enqueue_style('country_meadows-custom-style', get_stylesheet_directory_uri() . '/assets/css/app.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/app.css'));

        // Enqueue Bootstrap JS
        wp_enqueue_script('country_meadows-bootstrap-bundle', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js', array(), $theme_version, true);


        // Enqueue slick css
        wp_enqueue_style('country_meadows-slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css', array(), $theme_version);


        // Enqueue Custom JS
        wp_enqueue_script('country_meadows-custom-js', get_template_directory_uri() . '/assets/js/app.js', array('jquery'), '8.7', true);

        // Enqueue slick JS

        wp_enqueue_script('country_meadows-slick-js', 'https://cdn.jhttps://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array(), $theme_version, true);


        // Localize script for AJAX
        wp_localize_script('country_meadows-custom-js', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    }

endif;

add_action('wp_enqueue_scripts', 'country_meadows_styles');


/**
 * Save ACF JSON for field groups, post types, and taxonomies
 */
add_filter('acf/settings/save_json', function ($path) {
    $base_path = get_stylesheet_directory() . '/acf-json';
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;

    if ($screen && isset($screen->id)) {

        //  Field groups (default)
        if (strpos($screen->id, 'acf-field-group') !== false) {
            return $base_path;
        }

        //  Post Types (ACF > Post Types)
        if (strpos($screen->id, 'acf-post-type') !== false) {
            return $base_path . '/post-types';
        }

        // Taxonomies (ACF > Taxonomies)
        if (strpos($screen->id, 'acf-taxonomy') !== false) {
            return $base_path . '/taxonomy';
        }
    }

    // Default fallback
    return $base_path;
});


/**
 * Load ACF JSON from all subfolders
 */
add_filter('acf/settings/load_json', function ($paths) {
    unset($paths[0]); // Remove default ACF path

    $base_path = get_stylesheet_directory() . '/acf-json';

    $paths[] = $base_path;
    $paths[] = $base_path . '/post-types';
    $paths[] = $base_path . '/taxonomy';

    return $paths;
});

// Load Streamline Icon Picker for ACF
// require_once get_template_directory() . '/inc/streamline-icon-picker/streamline-icon-picker.php';

/*
   This function initializes and registers a TinyMCE button in the WordPress editor
   for inserting shortcodes. It ensures the user has editing privileges and that
   rich text editing is enabled in their profile before adding the necessary filters.
*/
function wysiwyg_shortcode_button()
{
    if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
        return;
    }

    if (get_user_option('rich_editing') == 'true') {
        add_filter('mce_external_plugins', 'add_wysiwyg_shortcode_plugin');
        // Add all button IDs here
        add_filter('mce_buttons', 'register_wysiwyg_shortcode_buttons');
    }
}
add_action('admin_init', 'wysiwyg_shortcode_button');

/*
   This function adds the custom TinyMCE buttons to the editor toolbar.
*/
function register_wysiwyg_shortcode_buttons($buttons)
{
    // List all unique button IDs you want to appear
    array_push($buttons, 'add_video_btn', 'add_event_btn', 'image_gallery_btn', 'add_testimonial_btn', 'font_size_btn');
    return $buttons;
}

/*
   This function declares the JavaScript file that handles the TinyMCE buttons’ behavior.
   The key 'wysiwyg_shortcode_btn' is the plugin handle used in the JS file's definition.
*/
function add_wysiwyg_shortcode_plugin($plugin_array)
{
    $plugin_array['wysiwyg_shortcode_btn'] = get_template_directory_uri() . '/assets/js/wysiwyg-shortcode-script.js';
    return $plugin_array;
}


/*
   UPDATED: This shortcode outputs content related to video posts.
   It accepts 'id', 'align', and 'size' attributes passed from the modal.
*/

function wysiwyg_video_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'id'    => '',     // Can be full URL or just ID
        'align' => 'none',
        'size'  => 'md',   // default medium
    ), $atts, 'add_video');

    $video_url = trim($atts['id']);
    $video_id = '';
    $embed_url = '';
    $thumb_image = '';

    // --- Set width/height based on size ---
    $size = strtolower($atts['size']);
    switch ($size) {
        case 'sm':
        case 'small':
            $width = 320;
            $height = 240;
            break;
        case 'lg':
        case 'large':
            $width = 854;
            $height = 480;
            break;
        default:
            $width = 560;
            $height = 315;
            break;
    }

    // --- Set alignment ---
    $align = 'none';
    if ($atts['align'] == 'left')  $align = 'left';
    if ($atts['align'] == 'right') $align = 'right';
    if ($atts['align'] == 'center') $align = 'center';

    // --- Detect YouTube ---
    if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false) {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_url, $match);
        if (!empty($match[1])) {
            $video_id = $match[1];
            $embed_url = 'https://www.youtube.com/embed/' . $video_id . '?rel=0&showinfo=0&controls=1';
            $thumb_image = 'https://i3.ytimg.com/vi/' . $video_id . '/hqdefault.jpg';
        }
    }
    // --- Detect Vimeo ---
    elseif (strpos($video_url, 'vimeo.com') !== false) {
        preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $video_url, $match);
        if (!empty($match[1])) {
            $video_id = $match[1];
            $embed_url = 'https://player.vimeo.com/video/' . $video_id . '?title=0&byline=0&portrait=0';

            // Secure and compatible Vimeo oEmbed request
            $context = stream_context_create([
                'http' => [
                    'header' => "User-Agent: PHP/" . PHP_VERSION . "\r\n"
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ]
            ]);

            $response = @file_get_contents("https://vimeo.com/api/oembed.json?url=https://vimeo.com/$video_id", false, $context);
            if ($response !== false) {
                $data = json_decode($response, true);
                if (!empty($data['thumbnail_url'])) {
                    $thumb_image = $data['thumbnail_url'];
                }
            }
        }
    }


    // --- Generate Output ---
    if ($embed_url) {
        $unique_key = uniqid('video_' . rand(1000, 9999) . '_');

        ob_start(); ?>
        <div class="video-box align-<?php echo esc_attr($align); ?> video-size-<?php echo esc_attr($size); ?>"
            style="max-width:<?php echo esc_attr($width); ?>px;">

            <div class="video-wrapper position-relative"
                style="width:<?php echo esc_attr($width); ?>px; height:<?php echo esc_attr($height); ?>px;">

                <span class="play-icon" id="play-<?php echo esc_attr($unique_key); ?>">
                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/images/play-icon.svg'); ?>"
                        alt="Play Icon">
                </span>

                <div class="video-image"
                    style="background-image:url('<?php echo esc_url($thumb_image); ?>'); 
                            background-size:cover; background-position:center; width:100%; height:100%;">
                    <div class="video-player vp-<?php echo esc_attr($unique_key); ?>"></div>
                </div>
            </div>
        </div>
        <script>
            jQuery(document).ready(function($) {
                // Store each thumbnail image for later restore
                $('.video-image').each(function() {
                    const bg = $(this).css('background-image');
                    if (bg) $(this).data('thumb', bg);
                });

                $('#play-<?php echo esc_attr($unique_key); ?>').on('click', function() {
                    const wrapper = $(this).closest('.video-box');
                    const player = wrapper.find('.vp-<?php echo esc_attr($unique_key); ?>');
                    const imageContainer = wrapper.find('.video-image');

                    // --- Stop other playing videos and restore thumbnails ---
                    $('.video-box').not(wrapper).each(function() {
                        const img = $(this).find('.video-image');
                        const thumb = img.data('thumb');
                        $(this).find('iframe').remove();
                        $(this).find('.play-icon').show();
                        if (thumb) {
                            img.css({
                                'background-image': thumb,
                                'background-size': 'cover',
                                'background-position': 'center'
                            });
                        }
                    });

                    // --- Hide play icon and clear current thumbnail ---
                    $(this).hide();
                    imageContainer.css('background-image', 'none');

                    // --- Play selected video ---
                    player.html(
                        '<iframe width="<?php echo $width; ?>" height="<?php echo $height; ?>" src="<?php echo esc_url($embed_url); ?>&autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
                    );
                });
            });
        </script>
        <style>
            .video-box {
                margin: 15px auto;
                display: inline-block;
                position: relative;
            }

            .video-box.align-left {
                float: left;
                margin-right: 15px;
            }

            .video-box.align-right {
                float: right;
                margin-left: 15px;
            }

            .video-box.align-center {
                display: block;
                margin: 0 auto;
            }

            .play-icon {
                position: absolute;
                z-index: 1;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
            }

            .play-icon img {
                width: 80px;
                opacity: 0.9;
                transition: transform 0.3s;
            }

            .play-icon:hover img {
                transform: scale(1.1);
            }
        </style>

    <?php
        return ob_get_clean();
    } else {
        return '<p style="color:red;">Invalid video URL or ID.</p>';
    }
}
add_shortcode('add_video', 'wysiwyg_video_shortcode');


/*
   This shortcode outputs event-related content.
   It can be customized using the “name” attribute for dynamic rendering.
*/
function wysiwyg_event_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'name' => 'default_event_or_empty',
    ), $atts);

    return 'Added Event Post data here';
}
add_shortcode('add_event_shortcode', 'wysiwyg_event_shortcode');


/*
   This shortcode outputs an image gallery section.
   It also accepts a “name” attribute for customization.
*/
function wysiwyg_image_gallery_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'name' => 'default_event_or_empty',
    ), $atts);

    return 'Added Image Gallery Post data here';
}
add_shortcode('image_gallery', 'wysiwyg_image_gallery_shortcode');



/**
 * Enqueue WYSIWYG-related JavaScript in the WordPress admin area.
 *
 * This script connects to TinyMCE and handles the logic for inserting
 * testimonials as shortcodes directly from the WYSIWYG editor.
 * It depends on jQuery and the TinyMCE API, and it’s loaded only in the admin.
 */
function enqueue_wysiwyg_scripts()
{
    wp_enqueue_script(
        'wysiwyg-shortcode-script',
        get_template_directory_uri() . '/assets/js/wysiwyg-shortcode-script.js',
        array('jquery', 'tinymce_api'),
        null,
        true
    );
}
// Use admin_enqueue_scripts to ensure it only loads in the admin area
add_action('admin_enqueue_scripts', 'enqueue_wysiwyg_scripts');


/**
 * Output localized JavaScript variables for use in our custom JS file.
 *
 * This creates a global JS object (WysiwygShortcodeVars) containing:
 * - ajax_url: URL to WordPress’s admin-ajax.php
 * - nonce: A security token to validate AJAX requests
 *
 * These are printed inline in the admin footer for easy access.
 */
function wysiwyg_shortcode_localized_vars_inline()
{
    ?>
    <script type="text/javascript">
        window.WysiwygShortcodeVars = {
            ajax_url: "<?php echo admin_url('admin-ajax.php'); ?>",
            nonce: "<?php echo wp_create_nonce('testimonial_nonce'); ?>"
        };
    </script>
<?php
}
add_action('admin_footer', 'wysiwyg_shortcode_localized_vars_inline');


/**
 * Handle AJAX request to fetch testimonial posts.
 *
 * This function is triggered via AJAX from the WYSIWYG script.
 * It:
 * - Verifies the security nonce
 * - Queries all published 'testimonials' posts
 * - Returns a list of post IDs and titles in JSON format
 *
 * Works for both logged-in and non-logged-in users (for flexibility).
 */
function get_testimonial_posts_ajax_handler()
{
    // Security check: Verify the nonce passed from JS
    check_ajax_referer('testimonial_nonce', 'nonce');

    $args = array(
        'post_type'      => 'testimonials', 
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'fields'         => 'ids', // Optimization
    );

    $testimonial_posts = new WP_Query($args);
    $posts_data = array();

    if ($testimonial_posts->have_posts()) {
        foreach ($testimonial_posts->posts as $post_id) {
            $posts_data[] = array(
                'id'    => (string) $post_id,
                'title' => get_the_title($post_id),
            );
        }
    }

    // Return the results as JSON
    wp_send_json_success($posts_data);
    wp_die(); // Required for all WordPress AJAX handlers
}
add_action('wp_ajax_get_testimonial_posts', 'get_testimonial_posts_ajax_handler');
add_action('wp_ajax_nopriv_get_testimonial_posts', 'get_testimonial_posts_ajax_handler'); 


/**
 * Shortcode handler for displaying a testimonial by ID.
 *
 * Usage: [add_testimonial id="123"]
 *
 * The shortcode retrieves testimonial data (quote and name) using ACF fields
 * and outputs it inside a formatted HTML container. If the ID is invalid
 * or there’s no content, it returns an HTML comment to keep the layout clean.
 */
function wysiwyg_testimonial_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'id' => '', // Changed 'name' to 'id'
    ), $atts, 'add_testimonial');

    $post_id = intval($atts['id']);

    if ($post_id && get_post_status($post_id) === 'publish') {
        // Retrieve testimonial data
        $testimonial_quote = get_field('testimonial_quote', $post_id);
        $testimonial_name  = get_field('testimonial_name', $post_id);

        // Only show if at least one field has a value
        if (!empty($testimonial_quote) || !empty($testimonial_name)) {
            $output  = '<div class="wysiwyg-testimonial py-3">';

            if (!empty($testimonial_quote)) {
                $output .=  $testimonial_quote;
            }

            if (!empty($testimonial_name)) {
                $output .= '<h5>' . esc_html($testimonial_name) . '</h5>';
            }

            $output .= '</div>';

            return $output;
        } else {
            // Nothing to show
            return '<!-- No testimonial content available -->';
        }
    } else {
        return '<!-- Testimonial not found or ID missing -->';
    }
}
add_shortcode('add_testimonial', 'wysiwyg_testimonial_shortcode');

/*
   This shortcode modifies or displays text with a specific font size.
   It uses a “name” attribute that can represent the chosen size or style.
*/

function wysiwyg_font_size_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'name' => 'default_event_or_empty',
    ), $atts);

    return 'Added font size Post data here';
}
add_shortcode('font_size', 'wysiwyg_font_size_shortcode');





?>