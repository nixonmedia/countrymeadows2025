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
        add_theme_support('post-thumbnails');
        add_theme_support('title-tag');


        // Enqueue editor styles.
        add_editor_style('style.css');

        register_nav_menus(
            array(
                'primary'            => esc_html__('Primary Menu', 'country_meadows'),
                'secondary'          => esc_html__('Secondary Menu', 'country_meadows'),
                'footer'             => esc_html__('Footer Menu', 'country_meadows'),
                'footer_communities' => esc_html__('Footer Communities', 'country_meadows'),
                'mobile_menu' => esc_html__('Mobile Menu', 'country_meadows'),
            )
        );

        // Register custom thumbnail size
        add_image_size('footer-column', 225, 125, true);
        add_image_size('wysiwyg-event-image', 396, 554, true);
        add_image_size('wysiwyg-gallery-image', 300, 300, true);
        add_image_size('intro_photo', 550, 365, true);
        add_image_size('layered_photo', 760, 9999, false);
        add_image_size('allentown', 551, 367, true);
        add_image_size('cm-couple', 661, 728, true);
        add_image_size('two_col_wide_image', 575, 345, true);
        add_image_size('two_col_tall_image', 440, 525, true);
        add_image_size('two_col_top', 444, 263, true);
        add_image_size('blog_post_thumb', 930, 616, true);
        add_image_size('single_post_thumb', 1136, 744, true);

        add_image_size('split-col-image', 1110, 734, true);
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
        wp_enqueue_style('slick-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css', array(), $theme_version);

        // Enqueue slick JS
        wp_enqueue_script('slick-js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array(), $theme_version, true);
        //Enqueue LightBox CSS-JS
        wp_enqueue_style('lightbox2-css', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css');
        wp_enqueue_script('lightbox2-js', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js', array('jquery'), null, true);
        // Enqueue Custom JS
        wp_enqueue_script('country_meadows-custom-js', get_template_directory_uri() . '/assets/js/app.js', array('jquery'), $theme_version, true);

        wp_enqueue_script('country_meadows-resize-js', get_template_directory_uri() . '/assets/js/resize.js', array('jquery'), '', true);

        // Localize script for AJAX
        wp_localize_script('country_meadows-custom-js', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));

        // Enqueue Font Awesome
        wp_enqueue_script('font-awesome', 'https://kit.fontawesome.com/151a7a2238.js', array(), null, true);
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
require_once get_template_directory() . '/inc/streamline-icon-picker/streamline-icon-picker.php';

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
    array_push($buttons, 'add_video_btn', 'add_event_btn', 'image_gallery_btn', 'add_testimonial_btn');
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
                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/play-icon.svg'); ?>"
                        alt="Play Icon">
                </span>

                <div class="video-image"
                    style="background-image:url('<?php echo esc_url($thumb_image); ?>');">
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

    <?php
        return ob_get_clean();
    } else {
        return '<p style="color:red;">Invalid video URL or ID.</p>';
    }
}
add_shortcode('add_video', 'wysiwyg_video_shortcode');


/*
   This shortcode outputs an image gallery section.
   It also accepts a “name” attribute for customization.
*/

// add_shortcode('image_gallery', 'wysiwyg_image_gallery_shortcode');
function get_gallery_posts_ajax_handler()
{

    check_ajax_referer('wysiwyg_button_nonce', 'nonce');

    $args = array(
        'post_type'      => 'galleries',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'fields'         => 'ids',
    );

    $gallery_posts = new WP_Query($args);
    $posts_data = array();

    if ($gallery_posts->have_posts()) {
        foreach ($gallery_posts->posts as $post_id) {
            $posts_data[] = array(
                'id'    => (string) $post_id,
                'title' => get_the_title($post_id),
            );
        }
    }

    wp_send_json_success($posts_data);
    wp_die();
}
add_action('wp_ajax_get_gallery_posts', 'get_gallery_posts_ajax_handler');
add_action('wp_ajax_nopriv_get_gallery_posts', 'get_gallery_posts_ajax_handler');

// add_shortcode('image_gallery', 'wysiwyg_image_gallery_shortcode');
function wysiwyg_image_gallery_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'id'  => '',
        'max' => 3,
    ), $atts, 'image_gallery');

    $post_id = intval($atts['id']);
    $max     = intval($atts['max']);

    if (!$post_id || get_post_status($post_id) !== 'publish') {
        return 'Gallery not found';
    }

    $images = get_field('community_galleries', $post_id);
    if (empty($images)) {
        return 'No gallery images';
    }

    $total_images = count($images);
    $slidesToShow = ($total_images <= $max) ? 3 : $max;

    $slider_id = 'slickGallery_' . $post_id . '_' . rand(1000, 9999);
    $lightbox_group = 'gallery_' . $post_id;

    $output = '<div id="' . $slider_id . '" class="wysiwyg-gallery">';

    foreach ($images as $img) {

        $thumb = isset($img['sizes']['wysiwyg-gallery-image'])
            ? esc_url($img['sizes']['wysiwyg-gallery-image'])
            : esc_url($img['url']);

        $full = esc_url($img['url']);
        $alt  = esc_attr($img['alt']);

        $output .= '
            <div class="gallery-slide">
                <a href="' . $full . '" data-lightbox="' . $lightbox_group . '" data-title="' . $alt . '">
                    <img src="' . $thumb . '" alt="' . $alt . '" class="img-fluid">
                </a>
            </div>';
    }

    $output .= '</div>';

    // slick initialization script
    $output .= "
    <script>
        jQuery(document).ready(function($) {
            $('#{$slider_id}').slick({
                slidesToShow: {$slidesToShow},
                slidesToScroll: 1,
                arrows: true,
                infinite: true,
                dots: false,
                speed: 700,
                autoplay: false,
                responsive: [
                    {
                        breakpoint: 992,
                        settings: { slidesToShow: 3 }
                    },
                    {
                        breakpoint: 768,
                        settings: { slidesToShow: 2 }
                    }
                ]
            });
        });
    </script>";

    return $output;
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
            nonce: "<?php echo wp_create_nonce('wysiwyg_button_nonce'); ?>"
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
    check_ajax_referer('wysiwyg_button_nonce', 'nonce');

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
            $output  = '<div class="wysiwyg-testimonial font-lexend py-3">';

            if (!empty($testimonial_quote)) {
                $output .=  '<div class="wysiwyg-testimonial-block"><div class="wysiwyg-testimonial-content font-xm fw-bold mb-4 pb-lg-2">' . $testimonial_quote . '</div></div>';
            }

            if (!empty($testimonial_name)) {
                $output .= '<p class="mb-0 pt-lg-2 mt-4 font-xs-medium">' . esc_html($testimonial_name) . '</p>';
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

/**
 * Handle AJAX request to fetch Event Category.
 *
 * This function is triggered via AJAX from the WYSIWYG script.
 * It:
 * - Verifies the security nonce
 * - Returns a list of Event Category IDs and titles in JSON format
 *
 * Works for both logged-in and non-logged-in users (for flexibility).
 */

function get_event_categories_ajax_handler()
{

    check_ajax_referer('wysiwyg_button_nonce', 'nonce');

    $terms = get_terms(array(
        'taxonomy'   => 'tribe_events_cat',
        'hide_empty' => false,
    ));

    $cats = array();

    if (!is_wp_error($terms)) {
        foreach ($terms as $term) {
            $cats[] = array(
                'id'    => $term->slug,
                'title' => $term->name,
            );
        }
    }

    wp_send_json_success($cats);
}
add_action('wp_ajax_get_event_cats', 'get_event_categories_ajax_handler');
add_action('wp_ajax_nopriv_get_event_cats', 'get_event_categories_ajax_handler');



/**
 * Shortcode handler for displaying a Event.
 *
 * Usage: [add_event category="bethlehem"] and [add_event]
 *
 * The shortcode retrieves Event  data
 * and outputs it inside a formatted HTML container. If the ID is invalid
 * or there’s no content, it returns an HTML comment to keep the layout clean.
 */
function wysiwyg_event_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'id'       => '',
        'community' => '',
    ), $atts, 'add_event');


    /* ------------------------------------------
       1If NO Community provided show latest upcoming event
    ------------------------------------------*/
    if (empty($atts['community']) && empty($atts['id'])) {

        $args = array(
            'post_type'      => 'tribe_events',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'orderby'        => 'event_date',
            'order'          => 'ASC',
        );

        $latest = new WP_Query($args);

        if (!$latest->have_posts()) {
            return "<!-- No upcoming events found -->";
        }

        $output = '<div class="wysiwyg-event-list">';

        while ($latest->have_posts()) {
            $latest->the_post();
            $post_id = get_the_ID();

            // Event data
            $latest_link  = get_permalink($post_id);
            $latest_title = get_the_title($post_id);

            // Get start date and end date (with custom formatting)
            $latest_start_date = tribe_get_start_date($post_id, false, 'F j, Y'); // Get the full start date
            $latest_start_time = tribe_get_start_date($post_id, false, 'g:i A'); // Get the start time only
            $latest_end_time = tribe_get_end_date($post_id, false, 'g:i A'); // Get the end time only

            $latest_excerpt = get_the_excerpt($post_id);

            // Featured image
            $latest_img = get_the_post_thumbnail(
                $post_id,
                'wysiwyg-event-image',
                ['class' => 'img-fluid']
            );

            $output .= '<div class="wysiwyg-event py-4">';
            $output .= '  <div class="row">';

            // ---- COL 3 (Image) ----
            if (!empty($latest_img)) {

                $output .= '      <div class="col-md-4 mb-4 mb-md-0">';
                $output .= '          <a href="' . $latest_link . '">';
                $output .=                $latest_img;
                $output .= '          </a>';
                $output .= '      </div>';
            }


            // ---- COL 9 (Content) ----
            $output .= '      <div class="col-md-8 ps-lg-3 wysiwyg-event-content-col">';

            // Event title (as link)
            $output .= '          <h4 class="font-lexend event-title mb-2"><a href="' . esc_url($latest_link) . '">' . esc_html($latest_title) . '</a></h4>';

            // Event date/time (Start and End)
            $output .= '          <div class="event-metadata font-normal font-lexend mb-3 mb-lg-4">' . esc_html($latest_start_date) . ' - ' . esc_html($latest_start_time) . ' to ' . esc_html($latest_end_time) . '</div>';

            // Excerpt
            if (! empty($latest_excerpt)) {
                $output .= '<div class="wysiwyg-event-content font-lexend"><p>' . wp_kses_post($latest_excerpt) . '</p></div>';
            }

            $output .= '      </div>'; // end col-9
            $output .= '  </div>';     // end row
            $latest_archive_url = get_post_type_archive_link('tribe_events');

            $output .= '</div>';       // end event wrapper
        }

        $output .= '</div>';




        wp_reset_postdata();

        return $output;
    }


    /* ------------------------------------------
       Community PROVIDED  show Community events
    ------------------------------------------*/
    if (!empty($atts['community'])) {
        $args = array(
            'post_type'      => 'tribe_events',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'orderby'        => 'event_date',
            'order'          => 'ASC',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'tribe_events_cat',
                    'field'    => 'slug',
                    'terms'    => $atts['community'],
                )
            ),
        );

        $events = new WP_Query($args);

        if (!$events->have_posts()) {
            return "<!-- No events found in this community -->";
        }

        $output = '<div class="wysiwyg-event-list">';

        while ($events->have_posts()) {
            $events->the_post();
            $post_id = get_the_ID();


            // Retrieve the event data
            $event_link  = get_permalink($post_id);

            $event_title = get_the_title($post_id);

            // Get start and end date/times with custom formatting
            $event_start_date = tribe_get_start_date($post_id, false, 'F j, Y'); // Start date
            $event_start_time = tribe_get_start_date($post_id, false, 'g:i A'); // Start time only
            $event_end_time = tribe_get_end_date($post_id, false, 'g:i A'); // End time only
            $event_excerpt = get_the_excerpt($post_id);


            // Get the featured image (if available)
            $event_img = get_the_post_thumbnail(
                $post_id,
                'wysiwyg-event-image',
                ['class' => 'img-fluid']
            );

            $output .= '<div class="wysiwyg-event py-3">';
            $output .= '<div class="row">';

            // ---- COL 3 (Image) ----
            if (!empty($event_img)) {

                // Example link URL (replace with your own variable)
                $output .= '      <div class="col-lg-4 mb-4 mb-lg-0">';
                $output .= '          <a href="' . $event_link . '">';
                $output .=                $event_img;
                $output .= '          </a>';
                $output .= '      </div>';
            }

            // ---- COL 9 (Content) ----
            $output .= '    <div class="col-lg-8 ps-lg-3 wysiwyg-event-content-col">';

            // Event title (as link)
            $output .= '          <h4 class="font-lexend event-title mb-2"><a href="' . esc_url($event_link) . '">' . esc_html($event_title) . '</a></h4>';

            // Event date/time (Start and End)
            $output .= '        <div class="event-metadata font-normal font-lexend mb-3 mb-lg-4">' . esc_html($event_start_date) . ' - ' . esc_html($event_start_time) . ' to ' . esc_html($event_end_time) . '</div>';
            if (! empty($event_excerpt)) {
                $output .= '<div class="wysiwyg-content font-lexend font-normal"><p>' . wp_kses_post($event_excerpt) . '</p></div>';
            }


            $output .= '    </div>'; // end col-9
            $output .= '</div>';     // end row
            $events_archive_url = get_post_type_archive_link('tribe_events');


            $output .= '</div>';     // end event wrapper
        }
        // Dynamic button linking to the tribe_events archive page


        $output .= '</div>';



        wp_reset_postdata();

        return $output;
    }


    /* ------------------------------------------
        ID PROVIDED → output single event
    ------------------------------------------*/
    // $post_id = intval($atts['id']);

    // if (!$post_id) {
    //     return '<!-- Event not found -->';
    // }

    // $output = '<div class="wysiwyg-event py-3">';
    // $output .= '<h4>' . get_the_title($post_id) . '</h4>';

    // $date = get_field('event_date', $post_id);
    // if ($date) {
    //     $output .= '<p><strong>Date:</strong> ' . esc_html($date) . '</p>';
    // }

    // $details = get_field('event_details', $post_id);
    // if ($details) {
    //     $output .= '<p>' . $details . '</p>';
    // }

    // $output .= '</div>';

    // return $output;
}
add_shortcode('add_event', 'wysiwyg_event_shortcode');


// Allow Upload SVG File Type
function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


// Load WP All Import ACF Auto-populate
require_once get_template_directory() . '/inc/wp-all-import-acf-auto-populate.php';

// Load ACF Blog Author Single Select Dropdown
require_once get_template_directory() . '/inc/acf-blog-author-single-select-dropdown.php';

// Load ACF options preview (use filesystem path, not URI)
$acf_preview_file = get_template_directory() . '/inc/acf-select-options-preview.php';
if (file_exists($acf_preview_file)) {
    require_once $acf_preview_file;
} else {
    error_log("ACF preview file not found: " . $acf_preview_file);
}


/**
 * UKG Job Importer (Fixed & Production Ready)
 */

/* ----------------------------------------
   UKG Credentials
----------------------------------------- */
define('UKG_CLIENT_ID', 'GEO1014GMLFclientimport');
define('UKG_CLIENT_SECRET', 'TQnCUfKnJGCQ1GmCY1D0kP8dW8OyjZK0r7yXxgoDtv6mgJZKy5l_mftpuX8WEXantSTrL4SblTKXWynqYShI_11Zjk');

define('UKG_TOKEN_URL', 'https://signin.ultipro.com/signin/oauth2/t/GEO1014GMLF/access_token');
define('UKG_JOB_API', 'https://service2.ultipro.com/talent/recruiting/v2/GEO1014GMLF/api/opportunities');

define('UKG_ACCESS_TOKEN_TRANSIENT', 'ukg_access_token');

/* ----------------------------------------
   GET ACCESS TOKEN
----------------------------------------- */
function ukg_get_access_token()
{

    // Check cached token
    $token = get_transient(UKG_ACCESS_TOKEN_TRANSIENT);
    if ($token) {
        return $token;
    }

    // Request token
    $response = wp_remote_post(UKG_TOKEN_URL, [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ],
        'body' => http_build_query([
            'grant_type'    => 'client_credentials',
            'client_id'     => UKG_CLIENT_ID,
            'client_secret' => UKG_CLIENT_SECRET,
        ]),
    ]);

    if (is_wp_error($response)) {
        error_log("UKG TOKEN ERROR: " . $response->get_error_message());
        return false;
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);

    if (!isset($body['access_token'])) {
        error_log("UKG TOKEN MISSING: " . wp_remote_retrieve_body($response));
        return false;
    }

    $token = $body['access_token'];
    $expires = isset($body['expires_in']) ? (int)$body['expires_in'] : 600;

    // Cache token (subtract 30s)
    set_transient(UKG_ACCESS_TOKEN_TRANSIENT, $token, $expires - 30);

    return $token;
}


/* ----------------------------------------
   FETCH JOBS
----------------------------------------- */

function ukg_fetch_jobs()
{
    error_log('UKG Cron ran at: ' . current_time('mysql'));
    $token = ukg_get_access_token();
    if (!$token) return;

    $page     = 1;
    $per_page = 1000; // adjust if API allows higher
    $start_of_month = new DateTime('first day of this month 00:00:00', new DateTimeZone('UTC'));
    $iso_utc = $start_of_month->format('Y-m-d\TH:i:s\Z');
    $updated_after = (new DateTime('now', new DateTimeZone('UTC')))
        ->modify('-16 days')
        ->format('Y-m-d\TH:i:s\Z');
    $all_jobs = [];
    $today = new DateTime('today', new DateTimeZone('UTC'));
    $target_board_ids = [
        'e66070ad-299d-4c5e-ad6e-43f81eb083fd', // CM
        '44b07573-b66f-4efe-a89b-b35cfe1cc42b', // Ecumenical Retirement
    ];

    while (true) {

        $response = wp_remote_get(
            add_query_arg([
                'page'     => $page,
                'per_page' => $per_page,
                'updated_after' => $iso_utc,
            ], UKG_JOB_API),
            [
                'headers' => [
                    'Authorization' => "Bearer $token",
                    'Accept'        => 'application/json'
                ],
                'timeout' => 30
            ]
        );

        if (is_wp_error($response)) {
            error_log("UKG API ERROR: " . $response->get_error_message());
            break;
        }

        $json = wp_remote_retrieve_body($response);
        $data = json_decode($json, true);

        if (!is_array($data)) {
            error_log("UKG INVALID JSON");
            break;
        }

        // UKG sometimes wraps results in "items"
        $jobs = $data['items'] ?? $data;

        // ✅ Stop condition
        if (empty($jobs)) {
            error_log("UKG: No more records at page {$page}");
            break;
        }

        // ✅ Accumulate
        $all_jobs = array_merge($all_jobs, $jobs);

        $page++;
    }

    /**
     * ------------------------------------
     * ALL RECORDS FETCHED AT THIS POINT
     * ------------------------------------
     */
    if (empty($all_jobs)) {
        error_log("UKG: No jobs found overall");
        return;
    }

    /**
     * 🔧 FILTER / TRANSFORM / GROUP DATA HERE
     */

    // Example: remove inactive jobs
    $filtered_jobs = array_values(array_filter($all_jobs, function ($job) use ($target_board_ids, $today) {

        // 1. Must be Active
        if (empty($job['status']) || $job['status'] !== 'Published') {
            return false;
        }

        if ($job['company']['auto_feed_company_name'] !== 'Country Meadows Retirement Communities') {
            return false;
        }

        // 2. closed_date must be >= today (UTC)
        if (!empty($job['closed_date'])) {
            try {
                // ISO 8601 with Z is auto-detected as UTC
                $closed_date = new DateTime($job['closed_date']);
            } catch (Exception $e) {
                return false;
            }

            if ($closed_date < $today) {
                return false;
            }
        }

        // 3. job_boards must exist
        if (empty($job['job_boards']) || !is_array($job['job_boards'])) {
            return false;
        }

        /**
         * job_boards could be:
         * - single object
         * - OR array of boards
         */
        foreach (($job['job_boards'] ?? []) as $board) {
            if (
                isset($board['id']) &&
                in_array($board['id'], $target_board_ids, true)
            ) {
                return true;
            }
        }

        return false;
    }));

    // Example: re-index array
    $filtered_jobs = array_values($filtered_jobs);
    // echo "<pre>";
    // var_dump($filtered_jobs);

    $api_requisitions = [];


    /**
     * ------------------------------------
     * CREATE / UPDATE ONLY AFTER FILTERING
     * ------------------------------------
     */

    // foreach ($filtered_jobs as $job) {
    //     ukg_create_or_update_job($job);
    // }
    foreach ($filtered_jobs as $job) {

        if (!empty($job['requisition_number'])) {
            $api_requisitions[] = $job['requisition_number'];
        }

        ukg_create_or_update_job($job);
    }
    ukg_delete_old_careers($api_requisitions);
}



/* ----------------------------------------
   CREATE OR UPDATE JOB
----------------------------------------- */
function ukg_create_or_update_job($job)
{

    $req = $job['requisition_number'] ?? null;
    if (!$req) return;

    // Find existing post
    $existing = get_posts([
        'post_type'  => 'career',
        'meta_key'   => 'career_requisition_number',
        'meta_value' => $req,
        'post_status' => 'any',
        'numberposts' => 1,
    ]);

    $post_id = $existing ? $existing[0]->ID : 0;

    // TITLE
    $title = $job['title']['en_us'] ?? 'No Title';

    // CONTENT
    $content = $job['description']['brief']['external']['en_us'] ?? '';

    // Fix future date issues
    // $post_date = current_time('mysql');

    // Convert API updated_at → WordPress datetime
    $updated_at = $job['updated_at'] ?? null;

    if ($updated_at) {
        // Convert ISO8601 → mysql datetime
        $post_date = gmdate('Y-m-d H:i:s', strtotime($updated_at));
    } else {
        // Fallback if missing
        $post_date = current_time('mysql');
    }

    // Insert/update post
    $post_id = wp_insert_post([
        'ID'          => $post_id,
        'post_title'  => $title,
        // 'post_content' => $content,
        'post_type'   => 'career',
        'post_status' => 'publish',
        'post_date'   => $post_date,
    ]);

    if (!$post_id) return;

    /* ------------------------------------------------------
       UPDATE ACF FIELDS
    ------------------------------------------------------- */
    if (function_exists('update_field')) {
        update_field('career_description', $content, $post_id);
        update_field('career_requisition_number', $req, $post_id);
        update_field('career_job_listing_url', $job['links'][0]['href'] ?? '', $post_id);
        update_field('career_job_date', $post_date, $post_id);
    }

    /* ------------------------------------------------------
       NEW FIELD MAPPING
    ------------------------------------------------------- */

    // 1. CAMPUS → taxonomy "campus"
    $campus_name = $job['locations'][0]['name'] ?? '';

    if ($campus_name) {

        // Create or get term
        $campus_term = term_exists($campus_name, 'campus');
        if (!$campus_term) {
            $campus_term = wp_insert_term($campus_name, 'campus');
        }

        if (!is_wp_error($campus_term)) {

            // Assign taxonomy term
            wp_set_post_terms($post_id, [$campus_term['term_id']], 'campus', false);

            // ALSO update ACF taxonomy field so it auto-selects
            update_field('campus', $campus_term['term_id'], $post_id);
        }

        // Update careers_city
        if (function_exists('update_field')) {
            $city = $job['locations'][0]['city'] ?? $campus_name;
            update_field('careers_city', $city, $post_id);
        }
    }


    // 2. JOB CATEGORY → taxonomy + ACF auto-select
    $job_category_raw = $job['job_family']['name']['en_us'] ?? '';
    $job_category = preg_replace('/\s+\d+$/', '', $job_category_raw); // remove trailing numbers

    if ($job_category) {

        // Create or get term
        $category_term = term_exists($job_category, 'job_category');
        if (!$category_term) {
            $category_term = wp_insert_term($job_category, 'job_category');
        }

        if (!is_wp_error($category_term)) {

            // Assign taxonomy term
            wp_set_post_terms($post_id, [$category_term['term_id']], 'job_category', false);

            // Auto-select in ACF taxonomy field
            update_field('job_category', $category_term['term_id'], $post_id);
        }
    }

    // 3. SCHEDULE → ACF TEXT FIELD "schedule" (store is_fulltime)
    $is_fulltime = $job['compensation']['is_fulltime'] ?? null;

    if (!is_null($is_fulltime) && function_exists('update_field')) {

        $schedule_value = $is_fulltime ? 'Full Time' : 'Part Time';

        update_field('schedule', $schedule_value, $post_id);
    }

    error_log("UKG JOB SAVED: $title ($req)");
}

/* ----------------------------------------
   DELETE OLD CAREERS NOT IN API
----------------------------------------- */
function ukg_delete_old_careers(array $api_requisitions)
{

    if (empty($api_requisitions)) {
        return;
    }

    $existing_posts = get_posts([
        'post_type'      => 'career',
        'posts_per_page' => -1,
        'post_status'    => 'any',
        'fields'         => 'ids',
        'meta_query'     => [
            [
                'key'     => 'career_requisition_number',
                'compare' => 'EXISTS',
            ],
        ],
    ]);

    foreach ($existing_posts as $post_id) {

        $req = get_post_meta($post_id, 'career_requisition_number', true);

        // Not found in API → delete
        if (!in_array($req, $api_requisitions, true)) {

            wp_delete_post($post_id, true); // true = permanent delete
            error_log("UKG JOB DELETED: Post ID {$post_id} (Req {$req})");
        }
    }
}



/* ----------------------------------------
   CRON SCHEDULING
----------------------------------------- */
add_action('init', function () {

    if (!wp_next_scheduled('ukg_fetch_careers_cron_event')) {

        $timestamp = strtotime('tomorrow 00:00:00');

        wp_schedule_event(
            $timestamp,
            'daily',
            'ukg_fetch_careers_cron_event'
        );
    }
});

/* ----------------------------------------
   CRON JOB CALLBACK
----------------------------------------- */
add_action('ukg_fetch_careers_cron_event', 'ukg_fetch_careers_cron_callback');

function ukg_fetch_careers_cron_callback()
{

    // Debug log start
    error_log('UKG Careers Cron: Started at ' . current_time('mysql'));

    if (function_exists('ukg_fetch_jobs')) {
        ukg_fetch_jobs();
        error_log('UKG Careers Cron: Jobs fetched successfully');
    } else {
        error_log('UKG Careers Cron: ukg_fetch_jobs() function NOT FOUND');
    }

    // Debug log end
    error_log('UKG Careers Cron: Finished at ' . current_time('mysql'));
}


/* ----------------------------------------
   MANUAL RUN TRIGGER (OPTIONAL)
----------------------------------------- */
add_action('admin_menu', function () {

    add_submenu_page(
        'edit.php?post_type=career',     // Parent (Careers)
        'Fetch Careers',                 // Page title
        'Fetch Careers',                 // Menu title
        'manage_options',                // Capability
        'fetch-careers',                 // Slug
        'render_fetch_careers_page',     // Callback
        99                               // Position (after Schedule)
    );
});


/* ----------------------------------------
   FETCH CAREERS PAGE CALLBACK
----------------------------------------- */
function render_fetch_careers_page()
{

    if (!current_user_can('manage_options')) {
        return;
    }

    // Run fetch when button clicked
    if (isset($_POST['fetch_careers'])) {

        // Run your API function
        ukg_fetch_jobs();

        echo '<div class="notice notice-success is-dismissible">
                <p><strong>Careers fetched successfully!</strong></p>
              </div>';
    }
?>

    <div class="wrap">
        <h1>Fetch Careers</h1>
        <p>Click the button below to fetch the latest careers from the API.</p>

        <form method="post">
            <?php submit_button('Fetch Latest Careers', 'primary', 'fetch_careers'); ?>
        </form>
    </div>

<?php
}

/**
 * FacetWP Integration: Prevent filtering on home page main query
 */
add_filter('facetwp_is_main_query', function ($is_main_query, $query) {
    if ($query->is_home() && $query->is_main_query()) {
        $is_main_query = false;
    }
    return $is_main_query;
}, 10, 2);

/**
 * FacetWP Integration: Scroll to top on filter change
 */
add_action('wp_head', function () {
?>
    <script>
        (function($) {
            $(document).on('facetwp-loaded', function() {
                if (FWP.loaded) { // Run only after the initial page load
                    $('html, body').animate({
                        scrollTop: $('.facetwp-template').offset().top - 100 // Scroll to the top of the element with class "facetp-template"
                    }, 500);
                }
            });
        })(jQuery);
    </script>
<?php });
//Remove 'View' option from Blog Authors CPT
add_filter('post_row_actions', function ($actions, $post) {
    if ($post->post_type === 'blog-author') {
        unset($actions['view']);
    }
    return $actions;
}, 10, 2);
add_action('admin_bar_menu', function ($wp_admin_bar) {
    if (get_post_type() === 'blog-author') {
        $wp_admin_bar->remove_node('view');
    }
}, 999);


// ============================================
// 1. FETCH Google REVIEWS WITH PAGINATION
// ============================================
function cm_fetch_all_reputation_reviews()
{
    $api_key = '4b3526fd912_2f66114edde6c5ca36dc86c58f623259';

    // Resume support
    $url = get_option('cm_fetch_next_url');
    if (!$url) {
        $url = 'https://api.reputation.com/v3/reviews3';
    }

    $all_reviews = get_option('cm_fetch_reviews', []);
    $page_count  = 0;
    $max_pages   = 1000;
    $max_retries = 3;

    while ($url && $page_count < $max_pages) {

        $attempt = 0;
        $body    = null;

        while ($attempt < $max_retries) {

            $response = wp_remote_get($url, [
                'headers' => [
                    'X-API-Key' => $api_key,
                    'Accept'    => 'application/json',
                ],
                'timeout' => 120,
            ]);

            if (!is_wp_error($response)) {
                $body = json_decode(wp_remote_retrieve_body($response), true);

                if (!empty($body['reviews'])) {
                    break; // success
                }
            }

            $attempt++;
            sleep(2 * $attempt); // backoff
        }

        // ❌ If still empty → stop safely
        if (empty($body['reviews'])) {
            error_log('API failed after retries – stopping fetch safely');
            break;
        }

        // Merge reviews
        $all_reviews = array_merge($all_reviews, $body['reviews']);

        // Save progress (CRASH SAFE)
        $url = $body['paging']['next'] ?? null;
        update_option('cm_fetch_next_url', $url);
        update_option('cm_fetch_reviews', $all_reviews);

        $page_count++;
        error_log("Fetched page {$page_count}, total: " . count($all_reviews));
    }

    // ✅ Fetch completed → cleanup progress
    delete_option('cm_fetch_next_url');
    delete_option('cm_fetch_reviews');

    return $all_reviews;
}


// ============================================
// 2. FILTER GOOGLE REVIEWS
// ============================================
function cm_get_google_reviews()
{
    $reviews = cm_fetch_all_reputation_reviews();

    $google_reviews = array_filter($reviews, function ($review) {
        return isset($review['sourceID']) && $review['sourceID'] === 'GOOGLE_PLACES';
    });

    error_log("Filtered Google reviews: " . count($google_reviews) . " out of " . count($reviews) . " total reviews");

    return $google_reviews;
}


// ============================================
// 3. SYNC Google REVIEWS (OPTIMIZED)
// ============================================
function cm_sync_google_reviews_to_cpt()
{
    global $wpdb;

    // Lock to prevent overlap
    // if (get_transient('cm_review_sync_lock')) {
    //     return ['success' => false, 'message' => 'Sync already running'];
    // }
    if (get_transient('cm_review_sync_lock')) {
        return [
            'success' => true,
            'notice'  => true,
            'message' => 'Note: A sync is already running. Please wait a moment and try again.'
        ];
    }

    set_transient('cm_review_sync_lock', true, 10 * MINUTE_IN_SECONDS);

    // Existing posts
    $existing = $wpdb->get_results("
        SELECT p.ID, pm.meta_value AS external_id
        FROM {$wpdb->posts} p
        INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
        WHERE p.post_type = 'google_review'
        AND p.post_status = 'publish'
        AND pm.meta_key = 'external_review_id'
    ");

    $existing_ids = [];
    foreach ($existing as $post) {
        $existing_ids[$post->external_id] = (int) $post->ID;
    }

    // Fetch API
    $reviews = cm_get_google_reviews();

    if (empty($reviews)) {
        delete_transient('cm_review_sync_lock');
        return ['success' => false, 'message' => 'No API data'];
    }

    $created = 0;
    $updated = 0;
    $api_ids = [];

    foreach ($reviews as $review) {

        if (empty($review['id'])) continue;

        $external_id = sanitize_text_field($review['id']);
        $api_ids[]   = $external_id;

        if (isset($existing_ids[$external_id])) {
            $post_id = $existing_ids[$external_id];
            $updated++;
        } else {
            $post_id = wp_insert_post([
                'post_type'   => 'google_review',
                'post_status' => 'publish',
                'post_title'  => wp_strip_all_tags($review['reviewer']['name'] ?? 'Anonymous'),
            ]);

            if (is_wp_error($post_id)) continue;

            add_post_meta($post_id, 'external_review_id', $external_id, true);
            $created++;
        }
        // ================================
        // LOCATION TAXONOMY SYNC
        // ================================
        if (!empty($review['locationName'])) {

            $taxonomy  = 'location';
            $term_name = sanitize_text_field($review['locationName']);

            $term = term_exists($term_name, $taxonomy);

            if (!$term) {
                $term = wp_insert_term($term_name, $taxonomy);
            }

            if (!is_wp_error($term)) {
                $term_id = is_array($term) ? (int) $term['term_id'] : (int) $term;
                wp_set_object_terms($post_id, [$term_id], $taxonomy, false);
                //  Assign taxonomy to ACF field
                // IMPORTANT: use FIELD KEY if possible
                update_field('location', $term_id, $post_id);
            }
        }
        // ACF
        update_field('google_review_name', $review['reviewer']['name'] ?? '', $post_id);
        update_field('google_review_date', date('Y-m-d', strtotime($review['date'])), $post_id);
        update_field('google_review_stars', (int) $review['rating'], $post_id);
        update_field('google_review_excerpt', $review['comment'] ?? '', $post_id);
        update_field('google_review_url', $review['url'] ?? '', $post_id);
        update_field('source_id', $review['sourceID'] ?? '', $post_id);
    }

    // ✅ DELETE ONLY IF FULL FETCH SUCCESS
    foreach ($existing_ids as $external_id => $post_id) {
        if (!in_array($external_id, $api_ids, true)) {
            wp_delete_post($post_id, true);
        }
    }

    update_option('cm_last_review_sync', current_time('mysql'));
    delete_transient('cm_review_sync_lock');

    return [
        'success' => true,
        'created' => $created,
        'updated' => $updated,
        'deleted' => count($existing_ids) - count(array_intersect(array_keys($existing_ids), $api_ids)),
        'total'   => count($reviews),
    ];
}

// ============================================
// 4. ADD ADMIN MENU Google Review PAGE
// ============================================
add_action('admin_menu', 'cm_add_review_sync_page');

function cm_add_review_sync_page()
{
    add_submenu_page(
        'edit.php?post_type=google_review',
        'Sync Reviews',
        'Sync Reviews',
        'manage_options',
        'sync-reviews',
        'cm_render_sync_page'
    );
}


// ============================================
// 5. RENDER SYNC Google Page PAGE
// ============================================
function cm_render_sync_page()
{
    $last_sync = get_option('cm_last_review_sync', 'Never');
?>
    <div class="wrap">
        <h1> Sync Google Reviews</h1>

        <div class="card" style="max-width: 600px; margin-top: 20px;">
            <h2>Manual Sync</h2>
            <p>Click the button below to fetch the latest reviews from Google.</p>
            <p><strong>Last Sync:</strong> <?php echo esc_html($last_sync); ?></p>

            <button id="sync-reviews-btn" class="button button-primary button-hero">
                Fetch Latest Reviews
            </button>

            <div id="sync-result" style="margin-top: 20px;"></div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function($) {
            // Sync Reviews Handler
            $('#sync-reviews-btn').on('click', function() {
                var $btn = $(this);
                var $result = $('#sync-result');

                // Disable button
                $btn.prop('disabled', true).text('⏳ Syncing...');

                // Show loading
                $result.removeClass('success error').addClass('loading')
                    .html('<span class="spinner-sync"></span> Fetching reviews from API...');

                // AJAX request
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'cm_sync_reviews'
                    },
                    success: function(response) {

                        if (response.success) {

                            //  NOTICE (sync already running)
                            if (response.data.notice) {
                                $result.removeClass('loading error')
                                    .addClass('notice')
                                    .html('ℹ️ <strong>' + response.data.message + '</strong>');
                                return;
                            }

                            // NORMAL SUCCESS
                            $result.removeClass('loading error')
                                .addClass('success')
                                .html(
                                    '<strong>✅ Sync Complete!</strong><br>' +
                                    'Created: ' + response.data.created + ' | ' +
                                    'Updated: ' + response.data.updated + ' | ' +
                                    'Total: ' + response.data.total
                                );

                            // DEBUG (optional)
                            console.log('API Review Data:', response.data.debug_data);
                        }
                    },
                    error: function() {
                        $result.removeClass('loading').addClass('error')
                            .html(' <strong>Error:</strong> Failed to sync reviews');
                    },
                    complete: function() {
                        $btn.prop('disabled', false).text(' Fetch Latest Reviews');
                    }
                });
            });

            // Debug API Handler
            $('#debug-api-btn').on('click', function() {
                var $btn = $(this);
                var $debug = $('#debug-output');

                // Disable button
                $btn.prop('disabled', true).text(' Loading API Data...');

                // Show loading
                $debug.removeClass('success error').addClass('loading')
                    .html('<span class="spinner-sync"></span> Fetching data from API...');

                // AJAX request
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'cm_debug_api_data'
                    },
                    success: function(response) {
                        if (response.success) {
                            $debug.removeClass('loading').addClass('success')
                                .html(response.data.html);

                            // Add click handlers for toggle buttons
                            $('.toggle-json').on('click', function() {
                                $(this).next('.raw-json').slideToggle();
                            });
                        } else {
                            $debug.removeClass('loading').addClass('error')
                                .html(' <strong>Error:</strong> ' + response.data);
                        }
                    },
                    error: function() {
                        $debug.removeClass('loading').addClass('error')
                            .html(' <strong>Error:</strong> Failed to fetch API data');
                    },
                    complete: function() {
                        $btn.prop('disabled', false).text(' Debug API Data');
                    }
                });
            });
        });
    </script>
<?php
}

// ============================================
// 6. AJAX HANDLER Google review
// ============================================
add_action('wp_ajax_cm_sync_reviews', 'cm_handle_sync_ajax');
function cm_handle_sync_ajax()
{
    set_time_limit(0);
    wp_raise_memory_limit('admin');

    if (!current_user_can('manage_options')) {
        wp_send_json_error('Permission denied');
    }

    $result = cm_sync_google_reviews_to_cpt();

    if (!empty($result['success'])) {
        wp_send_json_success($result);
    } else {
        wp_send_json_error($result['message']);
    }
}



// ============================================
// ADD 10 MINUTE CRON INTERVAL
// ============================================
add_filter('cron_schedules', 'cm_add_ten_minute_cron');

function cm_add_ten_minute_cron($schedules)
{
    $schedules['ten_minutes'] = [
        'interval' => 600, // 10 minutes in seconds
        'display'  => __('Every 10 Minutes')
    ];
    return $schedules;
}

// // ============================================
// // SCHEDULE CRON EVENT
// // ============================================
add_action('init', 'cm_schedule_review_cron');

function cm_schedule_review_cron()
{
    if (!wp_next_scheduled('cm_cron_sync_reviews')) {
        wp_schedule_event(time(), 'ten_minutes', 'cm_cron_sync_reviews');
    }
}

// // ============================================
// // CRON HANDLER
// // ============================================
add_action('cm_cron_sync_reviews', 'cm_run_review_cron_sync');

function cm_run_review_cron_sync()
{
    // Optional: prevent running during admin manual sync
    if (defined('DOING_AJAX') && DOING_AJAX) {
        return;
    }

    $result = cm_sync_google_reviews_to_cpt();

    // Optional logging
    if (!empty($result['success'])) {
        error_log('CRON Review Sync Success: ' . print_r($result, true));
    } else {
        error_log('CRON Review Sync Failed');
    }
}


// Career Review Sync - 15 JAN 2026
// Optimized for handling large datasets with pagination
// ============================================
// 1. FETCH CAREER REVIEWS WITH PARALLEL REQUESTS
// ============================================

function cm_fetch_all_reputation_career_reviews()
{
    $api_key = '4b3526fd912_2f66114edde6c5ca36dc86c58f623259';
    $url     = 'https://api.reputation.com/v3/reviews3';

    $all_reviews = [];
    $page_count  = 0;

    //  Rolling 2-year cutoff (UTC-safe)
    $cutoff_timestamp = strtotime('-2 years');

    while ($url && $page_count < 1000) {

        $response = wp_remote_get($url, [
            'headers' => [
                'X-API-Key' => $api_key,
                'Accept'    => 'application/json',
            ],
            'timeout' => 60,
        ]);

        if (is_wp_error($response)) {
            error_log('Career Review API Error: ' . $response->get_error_message());
            break;
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);

        if (empty($body['reviews'])) {
            break;
        }

        foreach ($body['reviews'] as $review) {

            // SOURCE FILTER
            if (
                empty($review['sourceID']) ||
                !in_array($review['sourceID'], ['GLASSDOOR', 'INDEED'], true)
            ) {
                continue;
            }

            // DATE FILTER (last 2 years only)
            if (empty($review['date'])) {
                continue;
            }

            $review_timestamp = strtotime($review['date']);
            if ($review_timestamp < $cutoff_timestamp) {
                continue;
            }

            $all_reviews[] = $review;
        }

        $url = $body['paging']['next'] ?? null;
        $page_count++;
    }

    error_log('Total Career Reviews (last 2 years): ' . count($all_reviews));
    return $all_reviews;
}

// ============================================
// OPTIMIZED SYNC WITH BATCH OPERATIONS
// ============================================

function cm_sync_career_reviews_to_cpt()
{
    global $wpdb;

    error_log('===== START CAREER REVIEW SYNC =====');

    // ================================
    // EXISTING POSTS (PUBLISH + TRASH)
    // ================================
    $existing_posts = $wpdb->get_results("
        SELECT p.ID, p.post_status, pm.meta_value AS external_id
        FROM {$wpdb->posts} p
        INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
        WHERE p.post_type = 'career_review'
        AND p.post_status IN ('publish', 'trash')
        AND pm.meta_key = 'external_career_review_id'
    ");

    $existing_ids = [];
    $trashed_ids  = [];

    foreach ($existing_posts as $post) {
        $existing_ids[$post->external_id] = (int) $post->ID;

        if ($post->post_status === 'trash') {
            $trashed_ids[$post->external_id] = (int) $post->ID;
        }
    }

    error_log('Existing posts found: ' . count($existing_ids));

    // ================================
    // API DATA
    // ================================
    $reviews = cm_fetch_all_reputation_career_reviews();

    if (empty($reviews)) {
        error_log('No career reviews returned from API');
        return [
            'success' => false,
            'message' => 'No career reviews found'
        ];
    }

    // ================================
    // DEBUG COUNTERS
    // ================================
    $total_api_reviews  = count($reviews);
    $skipped_no_id      = 0;
    $skipped_source     = 0;
    $skipped_date       = 0;
    $passed_date_filter = 0;

    $created  = 0;
    $updated  = 0;
    $restored = 0;
    $deleted  = 0;

    $api_ids = [];

    error_log('Total API reviews received: ' . $total_api_reviews);

    // ================================
    // PROCESS REVIEWS
    // ================================
    foreach ($reviews as $review) {

        // ----------------
        // ID CHECK
        // ----------------
        if (empty($review['id'])) {
            $skipped_no_id++;
            error_log('SKIPPED (NO ID)');
            continue;
        }

        // ----------------
        // SOURCE CHECK
        // ----------------
        if (
            empty($review['sourceID']) ||
            !in_array($review['sourceID'], ['GLASSDOOR', 'INDEED'], true)
        ) {
            $skipped_source++;
            error_log(
                'SKIPPED (SOURCE): ' . $review['id'] .
                    ' | Source: ' . ($review['sourceID'] ?? 'NULL')
            );
            continue;
        }

        // ----------------
        // DATE CHECK (LAST 2 YEARS)
        // ----------------
        $cutoff_timestamp = strtotime('-2 years');
        $review_timestamp = !empty($review['date']) ? strtotime($review['date']) : false;

        if (!$review_timestamp || $review_timestamp < $cutoff_timestamp) {
            $skipped_date++;
            error_log(
                'SKIPPED (DATE): ' . $review['id'] .
                    ' | Review Date: ' . ($review['date'] ?? 'NULL') .
                    ' | Cutoff Date: ' . date('Y-m-d', $cutoff_timestamp)
            );
            continue;
        }

        $passed_date_filter++;

        $external_id = sanitize_text_field($review['id']);
        $api_ids[]   = $external_id;

        // ================================
        // CREATE / UPDATE / RESTORE
        // ================================
        if (isset($existing_ids[$external_id])) {

            $post_id = $existing_ids[$external_id];

            // Restore from trash
            if (isset($trashed_ids[$external_id])) {
                wp_update_post([
                    'ID'          => $post_id,
                    'post_status' => 'publish'
                ]);

                $restored++;
                error_log('RESTORED: ' . $external_id);
            } else {
                $updated++;
                error_log('UPDATED: ' . $external_id);
            }
        } else {

            $post_id = wp_insert_post([
                'post_type'   => 'career_review',
                'post_status' => 'publish',
                'post_title'  => wp_strip_all_tags($review['reviewer']['name'] ?? 'Anonymous'),
            ]);

            if (is_wp_error($post_id)) {
                error_log('FAILED TO CREATE POST: ' . $external_id);
                continue;
            }

            add_post_meta($post_id, 'external_career_review_id', $external_id, true);

            $created++;
            error_log('CREATED: ' . $external_id);
        }

        // ================================
        // ACF / META FIELDS
        // ================================
        update_field('career_review_name', $review['reviewer']['name'] ?? '', $post_id);
        update_field('career_review_date', date('Y-m-d', strtotime($review['date'])), $post_id);
        update_field('career_review_stars', (int) $review['rating'], $post_id);
        update_field('career_review_excerpt', $review['comment'] ?? '', $post_id);
        update_field('career_review_url', $review['url'] ?? '', $post_id);
        update_field('source_id', $review['sourceID'], $post_id);

        // ================================
        // LOCATION TAXONOMY
        // ================================
        if (!empty($review['locationName'])) {

            $term = term_exists($review['locationName'], 'location');

            if (!$term) {
                $term = wp_insert_term($review['locationName'], 'location');
            }

            if (!is_wp_error($term)) {
                $term_id = is_array($term) ? (int) $term['term_id'] : (int) $term;
                wp_set_object_terms($post_id, [$term_id], 'location', false);
                update_field('location', $term_id, $post_id);
            }
        }
    }

    // ================================
    // DELETE MISSING POSTS (PERMANENT)
    // ================================
    foreach ($existing_ids as $external_id => $post_id) {
        if (!in_array($external_id, $api_ids, true)) {
            wp_delete_post($post_id, true);
            $deleted++;
            error_log('DELETED: ' . $external_id);
        }
    }

    // ================================
    // FINAL SUMMARY LOG
    // ================================
    error_log('===== CAREER REVIEW SYNC SUMMARY =====');
    error_log('Total API Reviews: ' . $total_api_reviews);
    error_log('Skipped (No ID): ' . $skipped_no_id);
    error_log('Skipped (Source): ' . $skipped_source);
    error_log('Skipped (Date < 2 Years): ' . $skipped_date);
    error_log('Passed Date Filter: ' . $passed_date_filter);
    error_log('Created: ' . $created);
    error_log('Updated: ' . $updated);
    error_log('Restored: ' . $restored);
    error_log('Deleted: ' . $deleted);
    error_log('=====================================');

    update_option('cm_last_career_review_sync', current_time('mysql'));

    return [
        'success'  => true,
        'created'  => $created,
        'updated'  => $updated,
        'restored' => $restored,
        'deleted'  => $deleted,
        'total'    => $total_api_reviews,
    ];
}

// ============================================
// BACKGROUND PROCESSING (RECOMMENDED)
// ============================================
// For very large datasets, consider WP-Cron
function cm_schedule_career_review_sync()
{
    if (!wp_next_scheduled('cm_career_review_sync_cron')) {
        wp_schedule_event(time(), 'hourly', 'cm_career_review_sync_cron');
    }
}
add_action('wp', 'cm_schedule_career_review_sync');

add_action('cm_career_review_sync_cron', 'cm_sync_career_reviews_to_cpt');

// ============================================
// ADMIN PAGES (SAME AS BEFORE)
// ============================================
add_action('admin_menu', 'cm_add_career_review_sync_page');
function cm_add_career_review_sync_page()
{
    add_submenu_page(
        'edit.php?post_type=career_review',
        'Sync Career Reviews',
        'Sync Career Reviews',
        'manage_options',
        'sync-career-reviews',
        'cm_render_career_sync_page'
    );
}

function cm_render_career_sync_page()
{
    $last_sync = get_option('cm_last_career_review_sync', 'Never');
?>
    <div class="wrap">
        <h1>Sync Career Reviews</h1>

        <div class="card" style="max-width: 600px; margin-top: 20px;">
            <h2>Manual Sync</h2>
            <p>Click the button below to fetch the latest reviews from Glassdoor & Indeed.</p>
            <p><strong>Last Sync:</strong> <?php echo esc_html($last_sync); ?></p>
            <p><em> Optimized for faster processing!</em></p>

            <button id="sync-career-reviews-btn" class="button button-primary button-hero">
                Fetch Latest Career Reviews
            </button>

            <div id="sync-result" style="margin-top: 20px;"></div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function($) {
            $('#sync-career-reviews-btn').on('click', function() {
                var $btn = $(this);
                var $result = $('#sync-result');

                $btn.prop('disabled', true).text('⏳ Syncing...');
                $result
                    .removeClass('success error')
                    .addClass('loading')
                    .html('<span class="spinner-sync"></span> Fetching career reviews from API... Please wait.');

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'cm_sync_career_reviews'
                    },
                    timeout: 600000,
                    success: function(response) {
                        if (response.success) {
                            $result
                                .removeClass('loading')
                                .addClass('success')
                                .html(
                                    ' <strong>Sync Complete!</strong><br>' +
                                    'Created: ' + response.data.created + ' | ' +
                                    'Updated: ' + response.data.updated + ' | ' +
                                    'Deleted: ' + response.data.deleted + ' | ' +
                                    (response.data.skipped ? 'Skipped: ' + response.data.skipped + ' | ' : '') +
                                    'Total: ' + response.data.total
                                );
                        } else {
                            $result
                                .removeClass('loading')
                                .addClass('error')
                                .html(' <strong>Error:</strong> ' + response.data);
                        }
                    },
                    error: function(xhr, status, error) {
                        var errorMsg = 'Failed to sync career reviews';
                        if (status === 'timeout') {
                            errorMsg = 'Request timed out. Please check error logs.';
                        }
                        $result
                            .removeClass('loading')
                            .addClass('error')
                            .html(' <strong>Error:</strong> ' + errorMsg);
                    },
                    complete: function() {
                        $btn.prop('disabled', false).text(' Fetch Latest Career Reviews');
                    }
                });
            });
        });
    </script>
<?php
}

add_action('wp_ajax_cm_sync_career_reviews', 'cm_handle_career_sync_ajax');
function cm_handle_career_sync_ajax()
{
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Permission denied');
    }

    // Increase time limit for large syncs
    set_time_limit(600); // 10 minutes

    $result = cm_sync_career_reviews_to_cpt();

    if ($result['success']) {
        wp_send_json_success($result);
    } else {
        wp_send_json_error($result['message']);
    }
}


/**
 * Populate ACF Select field with child pages of Communities page
 */
// function acf_load_community_choices( $field ) {
//     // Reset choices
//     $field['choices'] = array();
    
//     // Get all child pages of the Communities page (ID: 513)
//     $args = array(
//         'post_type'      => 'page',
//         'post_parent'    => 513,
//         'posts_per_page' => -1,
//         'orderby'        => 'title',
//         'order'          => 'ASC',
//         'post_status'    => 'publish'
//     );
    
//     $child_pages = get_posts( $args );
    
//     // Add an empty option (optional)
//     $field['choices'][''] = '-- Select Community --';
    
//     // Loop through child pages and add them as choices
//     if ( $child_pages ) {
//         foreach ( $child_pages as $page ) {
//             $field['choices'][ $page->ID ] = $page->post_title;
//         }
//     }
    
//     return $field;
// }

// // Apply filter to your specific field using its key
// add_filter('acf/load_field/key=field_690d7cb4a279c', 'acf_load_community_choices');


/**
 * Complete Communities Phone Number System
 * Add this code to your theme's functions.php
 */

// 1. Populate the communities_list select field with child pages of Communities (ID: 513)
function acf_load_community_choices_in_repeater( $field ) {
    // Reset choices
    $field['choices'] = array();
    
    // Get all child pages of the Communities page (ID: 513)
    $args = array(
        'post_type'      => 'page',
        'post_parent'    => 28,
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'post_status'    => 'publish'
    );
    
    $child_pages = get_posts( $args );
    
    // Add an empty option
    $field['choices'][''] = '-- Select Community --';
    
    // Loop through child pages and add them as choices
    if ( $child_pages ) {
        foreach ( $child_pages as $page ) {
            $field['choices'][ $page->ID ] = $page->post_title;
        }
    }
    
    return $field;
}

// Apply filter to the communities_list field inside repeater
add_filter('acf/load_field/name=communities_list', 'acf_load_community_choices_in_repeater');


function get_community_phone_by_page_id( $page_id = null ) {

    if ( ! $page_id ) {
        $page_id = get_queried_object_id();
    }

    if ( have_rows( 'field_communities_repeater', 'option' ) ) {
        while ( have_rows( 'field_communities_repeater', 'option' ) ) {
            the_row();

            $community_page = get_sub_field( 'communities_list' );
            $community_page_id = is_object( $community_page )
                ? (int) $community_page->ID
                : (int) $community_page;

            if ( $community_page_id === (int) $page_id ) {
                return (string) get_sub_field( 'comm_phone' );
            }
        }
    }

    return '';
}




// 3. Shortcode to display community phone header
function community_phone_header_shortcode() {

    if ( ! is_page() ) {
        return '';
    }

    $page_id        = get_queried_object_id();
    $community_name = get_the_title( $page_id );
    $community_phone = get_community_phone_by_page_id( $page_id );

    if ( empty( $community_phone ) ) {
        return '';
    }

    $phone_link = preg_replace( '/[^0-9]/', '', $community_phone );

    ob_start();
    ?>
    <div class="community-phone-header my-auto pe-lg-3 pe-xl-5">
        <h2 class="community-title text-blue fw-bold text-center my-auto mb-0">
            Call Our <?php echo esc_html( $community_name ); ?> Community <br>
            at <a href="tel:<?php echo esc_attr( $phone_link ); ?>"
                  class="community-phone-link text-blue text-decoration-none">
                <?php echo esc_html( $community_phone ); ?>
            </a>
        </h2>
    </div>
    <?php

    return ob_get_clean();
}
add_shortcode( 'community_phone_header', 'community_phone_header_shortcode' );





// Uncomment the line below if you want it to display automatically after opening body tag
// add_action('wp_body_open', 'auto_display_community_header');



