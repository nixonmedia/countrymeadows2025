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
        add_image_size('allentown', 551, 367, true);
		add_image_size('cm-couple', 661, 728, true);
        add_image_size('two_col_wide_image', 575, 345, true);
        add_image_size('two_col_wide_image', 440, 525, true);
        add_image_size('two_col_top', 444, 263, true);
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


        // Enqueue Custom JS
        wp_enqueue_script('country_meadows-custom-js', get_template_directory_uri() . '/assets/js/app.js', array('jquery'), '8.7', true);

        // Enqueue slick JS

        wp_enqueue_script('slick-js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array(), $theme_version, true);


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
    if ($total_images <= $max) {
        $slidesToShow    = 3;
        $slidesToScroll  = 3;
    } else {
        $slidesToShow    = $max;
        $slidesToScroll  = $max;
    }

    /* Slick Slider always used */
    $slider_id = 'slickGallery_' . $post_id . '_' . rand(1000, 9999);

    $output = '<div id="' . $slider_id . '" class="wysiwyg-gallery">';

    foreach ($images as $img) {
        $url = isset($img['sizes']['wysiwyg-gallery-image'])
            ? esc_url($img['sizes']['wysiwyg-gallery-image'])
            : esc_url($img['url']);

        $alt = esc_attr($img['alt']);

        $output .= '
            <div class="gallery-slide">
                <img src="' . $url . '" alt="' . $alt . '" class="img-fluid">
            </div>';
    }

    $output .= '</div>';

    /* Slick init script */
    $output .= "
    <script>
    jQuery(document).ready(function($) {
        $('#{$slider_id}').slick({
            slidesToShow: {$slidesToShow},
            slidesToScroll: 1,
            infinite: true,
            arrows: true,
            dots: false,
            speed: 700,
            autoplay: false,
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
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
                $output .=  '<div class="wysiwyg-testimonial-block"><div class="wysiwyg-testimonial-content font-xm fw-bold mb-4 pb-lg-2">'.$testimonial_quote.'</div></div>';
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
                $output .= '      <div class="col-md-4 mb-4 mb-md-0">';
                $output .= '          <a href="' . $event_link . '">';
                $output .=                $event_img;
                $output .= '          </a>';
                $output .= '      </div>';
            }

            // ---- COL 9 (Content) ----
            $output .= '    <div class="col-md-8 ps-lg-3 wysiwyg-event-content-col">';

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


// Allow Upload SVG File Tyoe
function cc_mime_types($mimes) {
 $mimes['svg'] = 'image/svg+xml';
 return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');