<?php get_header(); ?>
<style>
    /* Pagination Wrapper */
.navigation.pagination {
    margin-top: 30px;
}

/* Container */
.navigation.pagination .nav-links {
    display: inline-flex;
    gap: 10px;
    align-items: center;
}

/* Default Page Buttons */
.navigation.pagination .page-numbers {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    min-width: 45px;
    height: 45px;
    padding: 0 15px;
    background-color: #4c5bd4; /* Blue */
    color: #fff;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

/* Hover */
.navigation.pagination .page-numbers:hover {
    background-color: #f0b429;
    color: #fff;
}

/* Active Page */
.navigation.pagination .page-numbers.current {
    background-color: #f0b429; /* Yellow */
    color: #fff;
}

/* Prev & Next Buttons */
.navigation.pagination .prev,
.navigation.pagination .next {
    font-weight: bold;
}
</style>
<section class="blog-posts-zone py-5">
    <div class="container">
        <div class="row py-4">
            <div class="top col-lg-12">
                <h1><?php single_cat_title(); ?></h1>
            </div>
        </div>
        <div class="row g-5">

            <?php if (have_posts()) : ?>
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
                <div class="row">
                    <div class="col-lg-12 text-center mt-4">
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
            <?php else : ?>
                <p>No posts found.</p>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php get_footer(); ?>