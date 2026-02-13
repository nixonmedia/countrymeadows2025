<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_two
 * @since Twenty Twenty-two 1.0
 */

get_header();
if (have_posts()) { ?>
	<section class="search-section pt-5 pb-3">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 py-3">
					<h2 class="font-lexend font-xl fw-bold text-black">
						<?php printf(esc_html__('Results for "%s"', 'twentytwentyone'), esc_html(get_search_query())); ?>
					</h2>
					<h5 class="text-grey">
						<?php
						global $wp_query;
						printf(esc_html(_n('We found %d result for your search.', 'We found %d results for your search.', (int) $wp_query->found_posts, 'twentytwentytwo')), (int) $wp_query->found_posts); ?>
					</h5>
				</div>
			</div>
		</div>
	</section>
	<section class="search-results-section pb-5">
		<div class="container">
			<div class="row">
				<?php while (have_posts()) {
					the_post(); ?>
					<div class="col-12 mb-4 pb-3 mb-5 search-block">
						<div class="search-single-block bg-white h-100 d-lg-flex flex-lg-column">
							<h4 class="search-result-title font-lexend pb-3 text-start fw-bold  main-heading position-relative font-medium"><a href="<?php echo get_the_permalink(); ?>" class="text-decoration-none"><?php echo get_the_title(); ?></a></h4>
							<div class="search-content"><?php
									$excerpt = get_the_excerpt();
									if (get_the_excerpt()) {
										echo get_the_excerpt();
									} else {
										echo wp_trim_words(get_the_content(), 30, '...');
									}

									?>
								<a href="<?php echo get_the_permalink(); ?>" class="fw-bold font-lexend">Read More</a>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
			<div class="row pt-4 pb-5">
				<div class="col-lg-12 text-center">
					<div class="pagination-wrapper">
						<?php
						the_posts_pagination(array(
							'mid_size'  => 1,
							'end_size' => 1,
							'prev_text' => '<img src="' . get_template_directory_uri() . '/assets/images/left-chev.svg" alt="Previous">',
							'next_text' => '<img src="' . get_template_directory_uri() . '/assets/images/right-chev.svg" alt="Next">',
							'screen_reader_text' => '',
						));
						?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php
} else { ?>
	<section class="search-no-results-section py-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h2 class="font-medium pb-4">
						<?php printf(esc_html__('Results for "%s"', 'twentytwentyone'), esc_html(get_search_query())); ?>
					</h2>
					<p class="search-content font-regular">Sorry, but nothing matched your search terms. Please try again with some different keywords.</p>
					<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
						<input type="search" placeholder="search" id="search-form" class="search-field" value="<?php echo get_search_query(); ?>" name="s" />
						<button class="search-button" type="submit">
							<svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23" fill="#D62F74">
								<path d="M17.25 9.775C17.25 11.4245 16.7145 12.9483 15.8125 14.1845L20.3622 18.7378C20.8114 19.187 20.8114 19.9166 20.3622 20.3658C19.913 20.815 19.1834 20.815 18.7342 20.3658L14.1845 15.8125C12.9483 16.7145 11.4245 17.25 9.77499 17.25C5.64577 17.25 2.29999 13.9042 2.29999 9.775C2.29999 5.64578 5.64577 2.3 9.77499 2.3C13.9042 2.3 17.25 5.64578 17.25 9.775ZM9.77499 14.95C12.632 14.95 14.95 12.632 14.95 9.775C14.95 6.91797 12.632 4.6 9.77499 4.6C6.91796 4.6 4.59999 6.91797 4.59999 9.775C4.59999 12.632 6.91796 14.95 9.77499 14.95Z" fill="#D62F74" />
							</svg>
						</button>
					</form>
				</div>
			</div>
		</div>
	</section>
<?php }

get_footer();
?>