<?php get_header(); ?>
<section class="blog-posts-zone pt-5">
    <div class="container">
        <div class="row py-4">
            <div class="top col-lg-12">
                <h1><?php single_cat_title(); ?></h1>
            </div>
        </div>
    </div>
        <?php if (have_posts()) : ?>
            <div class="container pb-5">
                <div class="row g-5">
                    <?php while (have_posts()) : the_post(); ?>

                        <div class="post-card col-sm-6 col-xl-4 pb-5">

                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('blog_post_thumb', array(
                                        'class' => 'post-img img-fluid',
                                        'alt'   => get_the_title()
                                    )); ?>
                                <?php endif; ?>
                            </a>

                            <h5>
                                <a href="<?php the_permalink(); ?>" class="post-title font-medium fw-bold text-decoration-none">
                                    <?php the_title(); ?>
                                </a>
                            </h5>

                            <div class="blog-post-date fw-bold small mb-3">
                                <?php echo get_the_date(); ?>
                            </div>

                            <!-- Description -->
                            <p class="post-description pt-3 font-xs-medium">
                                <?php echo wp_trim_words(get_the_excerpt(), 25); ?>
                            </p>

                            <!-- Link -->
                            <a class="site-button post-link fw-medium text-pink" href="<?php the_permalink(); ?>">
                                Read More
                            </a>

                        </div>

                    <?php endwhile; ?>
                </div>
            </div>
            <?php global $wp_query; ?>
            <?php if ( $wp_query->max_num_pages > 1 ) : ?>
                <div class="blog-pagination text-center default-pagination-wrapper">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <?php
                                the_posts_pagination(array(
                                    'mid_size'  => 2,
                                    'prev_text' => __('<'),
                                    'next_text' => __('>'),
                                    'base'      => trailingslashit(get_term_link(get_queried_object())) . '%_%',
                                    'format'    => 'page/%#%/',
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php else : ?>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <p>No posts found.</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
</section>

<?php get_footer(); ?>