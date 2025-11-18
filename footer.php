</main>
<?php
$footer = get_field("footer", "option");
$ecumenical_text = $footer['ecumenical_text'];
$footer_logo = $footer['footer_logo'];
$button_1 = $footer['button_1'];
$button_2 = $footer['button_2'];
$badges = $footer['badges'];
$social_media = $footer['social_media'];
$content_column_1 = $footer['content_column_1'];
$column_1_image = $content_column_1['image'];
$column_1_text = $content_column_1['text'];
$column_1_link = $content_column_1['link'];
$content_column_2 = $footer['content_column_2'];
$column_2_image = $content_column_2['image'];
$column_2_text = $content_column_2['text'];
$column_2_link = $content_column_2['link'];

?>
<footer class="site-footer bg-blue">
  <div class="container-fluid">
    <div class="row">

      <?php
      // Check if columns have actual content
      $has_column_1 = !empty($column_1_image) || !empty($column_1_text) || !empty($column_1_link);
      $has_column_2 = !empty($column_2_image) || !empty($column_2_text) || !empty($column_2_link);

      if ($has_column_1 || $has_column_2): ?>
        <div class="col-lg-4 d-none d-lg-block">
          <div class="row">
            <?php if ($has_column_1): ?>
              <div class="col-lg-6 footer-post-col">
                <?php if ($column_1_image):
                  $image_url = isset($column_1_image['sizes']['footer-column']) ? $column_1_image['sizes']['footer-column'] : $column_1_image['url'];
                ?>
                  <img src="<?php echo esc_url($image_url); ?>" class="img-fluid mb-3" alt="<?php echo esc_attr($column_1_image['alt']); ?>">
                <?php endif; ?>
                <?php if ($column_1_text): ?>
                  <h3 class="font-lexend fw-bold font-normal mb-3 footer-post-title text-white"><?php echo $column_1_text; ?></h3>
                <?php endif; ?>
                <?php if ($column_1_link): ?>
                  <a href="<?php echo esc_url($column_1_link['url']); ?>" class="small-white-button" <?php if (!empty($column_1_link['target'])) echo 'target="' . esc_attr($column_1_link['target']) . '"'; ?>><?php echo esc_html($column_1_link['title']); ?></a>
                <?php endif; ?>
              </div>
            <?php endif; ?>
            <?php if ($has_column_2): ?>
              <div class="col-lg-6 footer-post-col">
                <?php if ($column_2_image):
                  $image_url = isset($column_2_image['sizes']['footer-column']) ? $column_2_image['sizes']['footer-column'] : $column_2_image['url'];
                ?>
                  <img src="<?php echo esc_url($image_url); ?>" class="img-fluid mb-3" alt="<?php echo esc_attr($column_2_image['alt']); ?>">
                <?php endif; ?>
                <?php if ($column_2_text): ?>
                  <h3 class="fobnt-lexend fw-bold font-normal mb-3 footer-post-title text-white"><?php echo $column_2_text; ?></h3>
                <?php endif; ?>
                <?php if ($column_2_link): ?>
                  <a href="<?php echo esc_url($column_2_link['url']); ?>" class="small-white-button" <?php if (!empty($column_2_link['target'])) echo 'target="' . esc_attr($column_2_link['target']) . '"'; ?>><?php echo esc_html($column_2_link['title']); ?></a>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>

      <div class="col-lg-5 px-lg-3">
        <?php if ($footer_logo): ?>
          <div class="text-center footer-logo">
            <img src="<?php echo $footer_logo['url']; ?>" class="img-fluid" <?php if ($footer_logo['alt']): ?> alt="<?php echo $footer_logo['alt']; ?>" <?php endif; ?>>
          </div>
        <?php
        endif;
        if (has_nav_menu('footer_communities')) {
          wp_nav_menu(array(
            'theme_location' => 'footer_communities',
            'menu_class'     => 'footer-menu list-unstyled mt-4',
            'container-fluid'      => false,
          ));
        }
        ?>

      </div>
      <?php if ($button_1 || $button_2 || $badges): ?>
        <div class="col-lg-3 pt-4 pt-lg-0">
          <?php if ($button_1): ?>
            <p class="pb-1 text-center text-lg-end">
              <a href="<?php echo $button_1['url']; ?>" class="footer-white-button" <?php if (!empty($button_1['target'])) echo 'target="_blank"'; ?>><?php echo $button_1['title']; ?></a>
            </p>
          <?php endif;
          if ($button_2): ?>
            <p class="mb-3 pb-3 text-center text-lg-end">
              <a href="<?php echo $button_2['url']; ?>" class="footer-white-button" <?php if (!empty($button_2['target'])) echo 'target="_blank"'; ?>><?php echo $button_2['title']; ?></a>
            </p>
          <?php endif; ?>
          <?php if ($badges): ?>
            <div class="footer-images-block pt-4 pt-lg-0 d-flex align-items-center gap-5 gap-lg-2 gap-xl-4 flex-wrap justify-content-center justify-content-lg-end">
              <?php foreach ($badges as $badge_item):
                $badge = $badge_item['badge'];
                if ($badge): ?>
                  <img src="<?php echo esc_url($badge['url']); ?>" class="img-fluid" alt="<?php echo esc_attr($badge['alt']); ?>">
              <?php endif;
              endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
    <div class="copyright-block">
      <div class="row">
        <?php if ($ecumenical_text): ?>
          <div class="col-lg-3 text-center text-lg-start pb-4 mb-2 pb-lg-0 mb-lg-0">
            <div class="wysiwyg-content text-white font-normal pb-1 pb-lg-0">
              <?php echo $ecumenical_text; ?>
            </div>
          </div>
        <?php endif; ?>
        <div class="col-lg-6 text-center footer-bottom-mid-col">
          <?php
          if (has_nav_menu('footer')) {
            wp_nav_menu(array(
              'theme_location' => 'footer',
              'menu_class'     => 'footer-copyright-menu d-lg-flex flex-wrap column-gap-3 row-gap-1 list-unstyled mb-4 pb-2 mb-lg-3 pb-lg-0 justify-content-center',
              'container-fluid'      => false, // removes the default <div> wrapper
            ));
          }
          ?>

          <div class="copyright-content text-white font-xsm mb-4 mb-lg-0">
            <p>© <?php echo date('Y'); ?> Country Meadows Retirement Communities</p>
          </div>
        </div>
        <div class="col-lg-3">
          <ul class="footer-social-icons d-flex align-items-center justify-content-center flex-wrap gap-3 list-unstyled mb-0">

            <?php if (!empty($social_media)) : ?>
              <?php foreach ($social_media as $item) :
                $icon = $item['icon'];   // fontawesome class
                $link = $item['link'];   // url
              ?>
                <?php if (!empty($link) && !empty($icon)) : ?>
                  <li>

                    <a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener">
                      <i class="<?php echo esc_attr($icon); ?>"></i>
                    </a>

                  </li>
                <?php endif; ?>
              <?php endforeach; ?>
            <?php endif; ?>

          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>
</div>
<?php wp_footer(); ?>
</body>

</html>