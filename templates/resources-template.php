<?php
/*
Template Name: Resources
*/
?>
<?php get_header();
get_template_part('parts/font-resize'); 
$stylized_heading_text = get_field("stylized_heading_text");
$headline = get_field("headline");
$content = get_field("content");
$button = get_field("button");

?>
<section class="stylized-heading-intro-zone resources-intro-zone pt-5">
    <div class="container-fluid">
        <div class="breadcrumb d-none d-lg-block">
            <div class="row">
                <div class="col-lg-12">
                    <?php if (function_exists('bcn_display')) {
                        bcn_display();
                    }
                    ?>
                </div>
            </div>
        </div><!-- /.breadcrumb -->

        <div class="row">
            <?php if ($stylized_heading_text || $headline || $content || ! empty($button)): ?>
                <div class="col-lg-6 pe-lg-5 mb-4 mb-lg-0">
                    <?php if ($stylized_heading_text): ?>
                        <span class="stylized-heading d-block text-pink font-gloss-bloom mb-4"><?php echo $stylized_heading_text; ?></span>
                    <?php endif;
                    if ($headline): ?>
                        <h1 class="font-medium fw-bold mb-2 pb-1"><?php echo $headline; ?></h1>
                    <?php endif;
                    if ($content): ?>
                        <div class="wysiwyg-content font-regular mb-4">
                            <?php echo $content; ?>
                        </div>
                    <?php endif;
                    if (! empty($button)    ) : ?>
                        <a href="<?php echo esc_url($button['url']); ?>"
                            class="site-button"
                            <?php echo ! empty($button['target']) ? 'target="' . esc_attr($button['target']) . '"' : ''; ?>>
                            <?php echo esc_html($button['title']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="col-lg-5 align-self-end mb-lg-4 position-relative">
                <div class="facet-search-box search-box-block bg-blue">
                    <h3 class="font-medium text-white mb-3 mb-lg-4">What can we help you find?</h3>
                    <div class="location-filters align-items-center gap-2">

                        <?php echo do_shortcode('[facetwp facet="resources_search"]'); ?>

                        <button type="button" class="facet-search-btn fw-bold">
                            Search
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>
<section class="py-5 git">
    <div class="container-fluid">
        <div class="row justify-content-center mb-5">
            <div class="col-12 text-center mb-4">
                <h2 class="fw-bold font-xl">Helpful Topics</h2>
                <div class="underline mx-auto"></div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <?php echo do_shortcode('[facetwp template="resources"]'); ?>
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
endif;?>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        document.querySelector('.facet-search-btn')?.addEventListener('click', function() {
            FWP.setHash();
            FWP.refresh();
        });

    });
</script>


<?php get_footer(); ?>