<?php get_header(); 
$blog_page_id = get_option('page_for_posts');
$stylized_heading = get_field("stylized_heading_text", $blog_page_id);
$headline = get_field("headline", $blog_page_id);
$content = get_field('content', $blog_page_id);
$button = get_field('button', $blog_page_id);
$hide_breadcrumb = get_field('hide_breadcrumb', $blog_page_id);  ?>
<section class="stylized-heading-intro-zone blog-intro-zone bg-light-blue pt-5">
    <div class="container-fluid">
      <?php if($hide_breadcrumb == false): ?>
        <div class="breadcrumb d-none d-lg-block">
          <div class="row">
            <div class="col-lg-12">
              <?php if(function_exists('bcn_display')) {
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
            <div class="wysiwyg-content font-regular <?php if($button): ?>mb-4<?php endif; ?>">
              <?php echo $content; ?>
            </div>
          <?php endif; 
          if($button): ?>
            <a href="<?php echo $button['url']; ?>" class="site-button" <?php if($button['target']): ?>target="<?php echo $button['target']; ?>"<?php endif; ?>><?php echo $button['title']; ?></a>
          <?php endif; ?>
        </div>
        <div class="col-lg-5 align-self-end mb-lg-4">
          <div class="search-box-block bg-blue">
            <h3 class="font-medium text-white mb-3 mb-lg-4">What can we help you find?</h3>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php get_footer(); ?>