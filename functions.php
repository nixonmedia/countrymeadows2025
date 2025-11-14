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
				'mobile_menu' => esc_html__('Mobile Menu', 'country_meadows'),
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

/*
   This function initializes and registers a TinyMCE button in the WordPress editor
   for inserting shortcodes. It ensures the user has editing privileges and that
   rich text editing is enabled in their profile before adding the necessary filters.
*/
function wysiwyg_shortcode_button() {
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
        return;
    }

    if ( get_user_option('rich_editing') == 'true' ) {
        add_filter( 'mce_external_plugins', 'add_wysiwyg_shortcode_plugin' );
        add_filter( 'mce_buttons', 'register_wysiwyg_shortcode_button' );
    }
}
add_action( 'admin_init', 'wysiwyg_shortcode_button' );

/*
   This function adds the custom TinyMCE button to the editor toolbar.
   The button will be labeled and referenced by its custom handle name.
*/
function register_wysiwyg_shortcode_button( $buttons ) {
    array_push( $buttons, 'wysiwyg_shortcode_btn' ); 
    return $buttons;
}

/*
   This function declares the JavaScript file that handles the TinyMCE button’s behavior.
   The JavaScript file is located in the theme’s assets directory.
*/
function add_wysiwyg_shortcode_plugin( $plugin_array ) {
    $plugin_array['wysiwyg_shortcode_btn'] = get_template_directory_uri() . '/assets/js/wysiwyg-shortcode-script.js';
    return $plugin_array;
}

/*
   This shortcode outputs content related to video posts.
   It accepts an optional “id” attribute that can be used to identify specific content.
*/
function wysiwyg_video_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'id' => 'default_id_or_empty',
    ), $atts );

    return 'added Video Post data here';
}
add_shortcode( 'add_video', 'wysiwyg_video_shortcode' );

/*
   This shortcode outputs event-related content.
   It can be customized using the “name” attribute for dynamic rendering.
*/
function wysiwyg_event_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'name' => 'default_event_or_empty',
    ), $atts );

    return 'Added Event Post data here';
}
add_shortcode( 'add_event_shortcode', 'wysiwyg_event_shortcode' );

/*
   This shortcode outputs an image gallery section.
   It also accepts a “name” attribute for customization.
*/
function wysiwyg_image_gallery_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'name' => 'default_event_or_empty',
    ), $atts );

    return 'Added Image Gallery Post data here';
}
add_shortcode( 'image_gallery', 'wysiwyg_image_gallery_shortcode' );

/*
   This shortcode displays testimonials.
   The “name” attribute can be used to specify the testimonial or source.
*/
function wysiwyg_testimonial_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'name' => 'default_event_or_empty',
    ), $atts );

    return 'Added Image testimonial Post data here';
}
add_shortcode( 'add_testimonial', 'wysiwyg_testimonial_shortcode' );

/*
   This shortcode modifies or displays text with a specific font size.
   It uses a “name” attribute that can represent the chosen size or style.
*/
function wysiwyg_font_size_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'name' => 'default_event_or_empty',
    ), $atts );

    return 'Added font size Post data here';
}
add_shortcode( 'font_size', 'wysiwyg_font_size_shortcode' );


?>
