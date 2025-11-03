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

if ( ! function_exists( 'country_meadows_support' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function country_meadows_support() {

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );
		
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
		add_editor_style( 'style.css' );
		
		register_nav_menus(
			array(
					'primary' => esc_html__('Primary Menu', 'country_meadows'),
					'secondary' => esc_html__('Secondary Menu', 'country_meadows'),
					'footer' => esc_html__('Footer Menu', 'country_meadows'),
			)
	);
	}

endif;

add_action( 'after_setup_theme', 'country_meadows_support' );

if ( ! function_exists( 'country_meadows_styles' ) ) :

	/**
	 * Enqueue styles.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function country_meadows_styles() {
		// Register theme stylesheet.
		$theme_version = wp_get_theme()->get( 'Version' );

		$version_string = is_string( $theme_version ) ? $theme_version : false;
		wp_register_style(
			'country_meadows-style',
			get_template_directory_uri() . '/style.css',
			array(),
			$version_string
		);

		// Enqueue theme stylesheet.
		wp_enqueue_style( 'country_meadows-style' );
		

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

add_action( 'wp_enqueue_scripts', 'country_meadows_styles' );

