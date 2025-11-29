<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header(); 
// get_template_part('parts/layouts/stylized_heading_intro_zone'); ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <h2>Home Page Content</h2>
      <?php $icon = get_field('streamline_icon');
    //   var_dump($icon);
      echo "svg here ". $icon; ?>
    </div>
  </div>
</div>

<?php /*********  Flexible Content Start  ***********/
$fields = get_fields( get_the_ID() );
if ( isset( $fields['flexible_content'] ) && is_array( $fields['flexible_content'] ) ):
	foreach ( $fields['flexible_content'] as $key => $section ) :
		$template = 'parts/layouts/' . $section['acf_fc_layout'] . '.php';
		if ( $loc_template = locate_template( $template ) ) {
			include( $loc_template );
		}
	endforeach;
endif;


get_footer(); ?>