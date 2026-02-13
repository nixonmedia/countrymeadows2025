<?php
get_header();

if ( have_posts() ) : ?>
  <section class="resource-post-content py-5">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <?php while ( have_posts() ) : the_post(); ?>
           <div class="post-featured-image pb-5">
            <?php the_post_thumbnail('full'); ?>
           </div>
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
