<?php get_header();
$blog_page_id = get_option('page_for_posts');
$stylized_heading = get_field("stylized_heading_text", $blog_page_id);
$headline = get_field("headline", $blog_page_id);
$content = get_field('content', $blog_page_id);
$button = get_field('button', $blog_page_id);
$hide_breadcrumb = get_field('hide_breadcrumb', $blog_page_id); 
?>
<section class="stylized-heading-intro-zone blog-intro-zone bg-light-blue pt-5">
  <div class="container-fluid">
    <?php if ($hide_breadcrumb == false): ?>
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
    <?php endif; ?>
    <div class="row">
      <div class="col-lg-6 pe-lg-5 mb-4 mb-lg-0">
        <?php if ($stylized_heading): ?>
          <span class="stylized-heading d-block text-pink font-gloss-bloom mb-4"><?php echo $stylized_heading; ?></span>
        <?php endif;
        if ($headline): ?>
          <h1 class="font-medium fw-bold mb-2 pb-1"><?php echo $headline; ?></h1>
        <?php endif;
        if ($content): ?>
          <div class="wysiwyg-content font-regular <?php if ($button): ?>mb-4<?php endif; ?>">
            <?php echo $content; ?>
          </div>
        <?php endif;
        if ($button): ?>
          <a href="<?php echo $button['url']; ?>" class="site-button" <?php if ($button['target']): ?>target="<?php echo $button['target']; ?>" <?php endif; ?>><?php echo $button['title']; ?></a>
        <?php endif; ?>
      </div>
      <div class="col-lg-6 align-self-end mb-lg-4 position-relative">
        <div class="search-box-block bg-blue with-background-pattern circles-background-pattern">
          <h3 class="font-medium text-white mb-3 mb-lg-4">What can we help you find?</h3>
          <div class="d-md-flex align-items-center">
            <?php echo do_shortcode('[facetwp facet="blog_search"]'); ?>
            <span class="text-white align-items-center fw-bold px-3">Or</span>
            <?php echo do_shortcode('[facetwp facet="browse_by_topic"]'); ?>
          </div>
           <button id="facetwp-apply" type="button" class="facet-search-btn fw-bold mt-4">
              Search
            </button>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="blog-posts-zone py-5">
  <div class="container-fluid">
    <?php echo do_shortcode('[facetwp template="blog_posts"]'); ?>
  </div>
</section>
<section class="blog-pagination text-center">
  <div class="container-fluid">
    <?php echo do_shortcode('[facetwp facet="blog_pagination"]'); ?>
  </div>
</section>
<!-- Hide Pagination section if page is equal to 1 -->
<script>
  document.addEventListener('facetwp-loaded', function() {
    const paginationSection = document.querySelector('.blog-pagination');
    const pager = paginationSection?.querySelector('.facetwp-pager');

    if (!pager || pager.children.length <= 1) {
      paginationSection.style.display = 'none';
    } else {
      paginationSection.style.display = '';
    }
  });


  (function() {

    // Hard-disable auto refresh
    function disableAutoRefresh() {
      if (typeof FWP !== 'undefined') {
        FWP.auto_refresh = false;
        console.log('FacetWP auto refresh disabled');
      }
    }

    document.addEventListener('facetwp-ready', disableAutoRefresh);
    document.addEventListener('facetwp-loaded', disableAutoRefresh);

  })();

  document.addEventListener('DOMContentLoaded', function() {

    var btn = document.getElementById('facetwp-apply');
    if (!btn) return;

    btn.addEventListener('click', function() {
      console.log('Apply button clicked – filtering now');
      FWP.refresh();
    });

  });
</script>

<?php get_footer(); ?>