<?php
get_header();

if ( have_posts() ) : ?>
  <div class="post-featured-image pt-5">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <?php the_post_thumbnail('full'); ?>
        </div>
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
 endif;
get_footer();
?>
