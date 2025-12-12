<?php
get_header();

if ( have_posts() ) : ?>
  <section class="stories-post-content py-5">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <?php while ( have_posts() ) : the_post(); ?>
            <h1><?php the_title(); ?></h1>
            <div class="post-content">
                <?php the_content(); ?>
            </div>
          <?php endwhile; ?>
        </div>
      </div>
    </div>
  </section>  
<?php endif;
get_footer();
?>
