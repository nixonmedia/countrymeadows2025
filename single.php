<?php
get_header();

if ( have_posts() ) : ?>
<section class="breadcrumb pt-4 d-none d-md-block mb-0 z-2 position-relative">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<?php if(function_exists('bcn_display')) {
						bcn_display();
					}
				?>
			</div>
		</div>
	</div>
</section>
<section class="blog-post-content pt-5">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-7">
        <div class="post-image-wrapper position-relative with-embellishment seeds-embellishment right-align-embellishment">
          <?php the_post_thumbnail('single_post_thumb', ['class' => 'img-fluid post-featured-img', 'loading' => 'lazy', 'alt' => get_the_title(),]); ?>
        </div>
        <div class="single-post-meta">
          <span class="blog-post-date d-block mt-3">
              Published on <?php echo get_the_date( 'F j, Y' ); ?>
          </span>
          <h1 class="single-post-title"><?php echo get_the_title(); ?></h1>
          <?php $categories = get_the_category();
            if ( ! empty( $categories ) ) :
                $valid_cats = [];
                // Filter out Uncategorized
                foreach ( $categories as $cat ) {
                    if ( 'uncategorized' !== $cat->slug ) {
                        $valid_cats[] = $cat;
                    }
                }
                if ( ! empty( $valid_cats ) ) :
            ?>
                <span class="post-categories">
                    <i class="fa-regular fa-folder-open me-1"></i>
                    <?php foreach ( $valid_cats as $index => $cat ) : ?>
                        <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"
                          class="text-blue">
                            <?php echo esc_html( $cat->name ); ?>
                        </a><?php echo ( $index < count( $valid_cats ) - 1 ) ? ', ' : ''; ?>
                    <?php endforeach; ?>
                </span>
            <?php
                endif;
            endif;
            ?>
            <?php
              $author_post = get_field( 'blog_author' ); // ACF Post Object
              if ( $author_post ) :
                  // If multiple selection is enabled, use first item
                  if ( is_array( $author_post ) ) {
                      $author_post = $author_post[0];
                  }
                  $author_id = $author_post->ID;
                  // Fetch fields
                  $author_image_url = get_the_post_thumbnail_url( $author_id, 'medium' );
                  $author_name  = get_field('name', $author_id );
                  $job_title = get_field( 'job_title', $author_id );
                  $bio       = get_field( 'bio', $author_id );
              ?>
              <div class="blog-author row align-items-center mt-4">
                  <?php if ( $author_image_url ) : ?>
                    <div class="col-lg-2 author-image">
                        <img 
                            src="<?php echo esc_url( $author_image_url ); ?>"
                            alt="<?php echo esc_attr( $author_name ); ?>"
                            class="img-fluid author-img"
                            loading="lazy"
                        >
                    </div>
                <?php endif; ?>
                  <div class="col-lg-10 author-info">
                      <h6 class="author-name mb-1"><?php echo esc_html( $author_name ); ?>, 
                      <?php if ( $job_title ) : ?><?php echo esc_html( $job_title ); ?></h6>
                      <?php endif; ?>
                      <?php if ( $bio ) : ?>
                          <div class="wysiwyg-content author-bio font-normal">
                              <?php echo wp_kses_post( $bio ); ?>
                          </div>
                      <?php endif; ?>
                  </div>
              </div>
              <?php endif; ?>
        </div>
      </div>
      <div class="col-md-4 offset-md-1">
        <div class="related-posts-wrapper position-relative">
          <?php
            // Get categories of current post
            $categories = get_the_category();
            $first_cat = $categories[0];
            $cat_link  = get_category_link( $first_cat->term_id );
            if ( ! empty( $categories ) ) :
                // Use only the FIRST category
                $first_cat_id = $categories[0]->term_id;
                $related_args = [
                    'post_type'      => 'post',
                    'posts_per_page' => 3,
                    'post__not_in'   => [ get_the_ID() ],
                    'cat'            => $first_cat_id,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ];
                $related_query = new WP_Query( $related_args );
                if ( $related_query->have_posts() ) : ?>
                  <h4 class="font-xm mb-4 pb-lg-2">Related Posts</h4>
                  <?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
                      <div class="related-post mb-4 row">
                        <div class="col-md-5 ps-lg-0">
                            <?php if ( has_post_thumbnail() ) : ?>
                              <div class="related-thumb h-100">
                                <?php the_post_thumbnail( 'full' ); ?>
                              </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-7 py-3">
                          <h6 class="related-post-title mb-0"><a href="<?php the_permalink(); ?>" class="text-blue text-decoration-none">
                            <?php the_title(); ?>
                          </a></h6>
                        </div>
                      </div>
                  <?php endwhile; ?>
                  <a href="<?php echo esc_url( $cat_link ); ?>" class="text-blue fw-bold font-xs-medium">More posts about these topics</a>
            <?php
                    wp_reset_postdata();
                endif;
            endif;
            ?>
        </div>
      </div>
    </div>
  </div>
</section>
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
 endif; ?>
 
<?php $cta_heading = get_field('heading');
$cta_content = get_field('content');
$cta_buttons = get_field('buttons'); ?>
<section class="post-cta-zone bg-light-blue border-straight">
  <div class="container-fluid">
    <div class="row justify-content-center text-center">
      <div class="col-lg-7">
        <?php if($cta_heading): ?>
        <h2 class="text-pink fw-normal pt-3 post-stylized-heading font-gloss-bloom"><?php echo $cta_heading; ?></h2>
        <?php endif;
        if($cta_content): ?>
          <div class="wysiwyg-content">
            <?php echo $cta_content; ?>
          </div>
        <?php endif;  ?>
          <div class="post-cta-buttons d-flex align-items-center justify-content-center gap-4 flex-wrap mt-4">
            <?php foreach($cta_buttons as $button): ?>
              <a href="<?php echo $button['button']['url'];?>" class="site-button" <?php if($button['button']['target']): ?>target="<?php echo $button['button']['target']; ?>"<?php endif; ?>><?php echo $button['button']['title']; ?></a>
            <?php endforeach; ?>
          </div>
      </div>
    </div>
  </div>
</section>
<?php get_footer();
?>
