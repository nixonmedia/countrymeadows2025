<?php $split_column_position = $section['split_column_position'] ?? ''; 
$standard_column = $section['standard_column'] ?? '';
$image_headers = $standard_column['image_headers'] ?? '';
$image_header_content = $standard_column['image_header_content'] ?? '';
$image_header = $image_header_content['image_header'] ?? '';
$embellishment = $image_header_content['embellishment'] ?? '';
$embellishment_position = $image_header_content['embellishment_position'] ?? '';
$heading = $standard_column['heading'] ?? '';
$content = $standard_column['content'] ?? '';
$button = $standard_column['button'] ?? '';

$split_column = $section['split_column'] ?? '';
$top_content = $split_column['top_content'] ?? '';
$top_content_type = $top_content['content_type'] ?? '';
$top_standard_content = $top_content['standard'] ?? '';
$top_standard_heading = $top_standard_content['heading'] ?? '';
$top_standard_icon = $top_standard_content['icon'] ?? '';
$top_standard_copy_content = $top_standard_content['content'] ?? '';
$top_standard_button = $top_standard_content['button'] ?? '';
$top_accordions = $top_content['accordions'] ?? '';
$top_accordions_heading = $top_accordions['heading'] ?? '';
$top_accordion = $top_accordions['accordion'] ?? '';
$top_cta = $top_content['call_to_action'] ?? '';
$background_color = $top_content['background_color'] ?? '';

$bottom_content = $split_column['bottom_content'] ?? '';
$bottom_content_type = $bottom_content['content_type'] ?? '';
$bottom_standard_content = $bottom_content['standard'] ?? '';
$bottom_standard_heading = $bottom_standard_content['heading'] ?? '';
$bottom_standard_icon = $bottom_standard_content['icon'] ?? '';
$bottom_standard_copy_content = $bottom_standard_content['content'] ?? '';
$bottom_standard_button = $bottom_standard_content['button'] ?? '';
$bottom_accordions = $bottom_content['accordions'] ?? '';
$bottom_accordions_heading = $bottom_accordions['heading'] ?? '';
$bottom_accordion = $bottom_accordions['accordion'] ?? '';

$bottom_gallery = $bottom_content['gallery'] ?? '';
$bottom_gallery_type = $bottom_gallery['gallery_type'] ?? '';  
$bottom_icon_gallery = $bottom_gallery['icons'] ?? '';
$bottom_icon_heading = $bottom_icon_gallery['heading'] ?? '';
$bottom_add_icons = $bottom_icon_gallery['add_icons'] ?? '';
$bottom_icon = $bottom_add_icons['icon'] ?? '';
$bottom_icon_text = $bottom_add_icons['text'] ?? '';
$bottom_icon_link = $bottom_add_icons['link'] ?? '';
$bottom_image_gallery = $bottom_gallery['image_gallery'] ?? '';
$bottom_image_heading = $bottom_image_gallery['heading'] ?? '';
$bottom_images = $bottom_image_gallery['gallery'] ?? '';

if($background_color == 'Blue') {
  $bg_color = 'bg-blue';
} elseif($background_color == 'Light Blue') {
  $bg_color = 'bg-light-blue';
} elseif($background_color == 'Teal') {
  $bg_color = 'bg-teal';
} elseif($background_color == 'Purple') {
  $bg_color = 'bg-purple';
} elseif($background_color == 'Gradient Yellow') {
  $bg_color = 'bg-gradient-yellow';
} else {
  $bg_color = 'bg-white';
}

if($embellishment_position == 'Left') {
  $embellishment_position_class = 'left-align-embellishment';
} elseif($embellishment_position == 'Right') {
  $embellishment_position_class = 'right-align-embellishment';
} else {
  $embellishment_position_class = '';
} 

if($embellishment == 'circles' ) {
  $embellishment_class = 'with-embellishment circles-embellishment';
} elseif($embellishment == 'seeds' ) {
  $embellishment_class = 'with-embellishment seeds-embellishment';
} elseif($embellishment == 'seeds-open' ) {
  $embellishment_class = 'with-embellishment seeds-open-embellishment';
} elseif($embellishment == 'seeds-open-large' ) {
  $embellishment_class = 'with-embellishment seeds-open-large-embellishment';
} elseif($embellishment == 'squiggles' ) {
  $embellishment_class = 'with-embellishment squiggles-embellishment';
} elseif($embellishment == 'Xs' ) {
  $embellishment_class = 'with-embellishment xs-embellishment';
} else {
  $embellishment_class = '';
}

?>
  <section class="split-column-zone" id="split-column-zone-<?php echo get_the_ID().'-'.$key; ?>">
    <div class="container-fluid">
      <div class="row <?php if($split_column_position == 'left'):?>flex-row-reverse<?php endif; ?>">
        <?php if($heading['headline'] || $content || $button || $image_header): ?>
          <div class="col-lg-5 mb-4 mb-lg-0 <?php if($split_column_position == 'left'):?>ps-lg-5 <?php else: ?>pe-lg-5<?php endif; ?> <?php if($split_column_position == 'left'):?>offset-lg-1<?php endif; ?>">
            <?php if($heading['headline']): ?>
            <<?php echo $heading['heading_type']; ?> class="font-medium mb-3 pb-lg-1"><?php echo $heading['headline']; ?></<?php echo $heading['heading_type']; ?>>
            <?php endif;
            if($image_header && $image_headers == true): ?>
              <div class="image-box mb-3 <?php echo $embellishment_class; ?> <?php echo $embellishment_position_class; ?>">
                <img src="<?php echo $image_header['sizes']['split-col-image']; ?>" class="img-fluid" alt="<?php echo $image_header['alt']; ?>" >
              </div>
            <?php endif; 
            if($content): ?>
              <div class="wysiwyg-content <?php if($button): ?>mb-3<?php endif; ?>">
                <?php echo $content; ?>
              </div>
            <?php endif; 
            if($button): ?>
              <a href="<?php echo $button['url']; ?>" class="site-button" <?php if($button['target']):?>target="<?php echo $button['target']; ?><?php endif; ?>"><?php echo $button['title']; ?></a>
            <?php endif; ?>
          </div>
        <?php endif; ?>
        
        <div class="col-lg-6 <?php if($split_column_position == 'right'):?>offset-lg-1<?php endif; ?>">
          <?php if($top_content_type == 'Standard Content' || $top_content_type == 'Call-to-Action' || $top_content_type == 'Accordions'): ?>
            <div class="top-content-block mb-4 pb-3 pb-lg-4">
              <?php if($top_content_type == 'Standard Content'): ?>
                <!-- Top Standard Content -->
                <?php if($top_standard_copy_content || $top_standard_heading['headline'] || $top_standard_button): ?>
                  <div class="top-standard-content text-center <?php echo $bg_color; ?>">
                    <?php if($top_standard_icon): ?>
                      <div class="heading-with-above-icon mb-2">
                        <?php echo $top_standard_icon; ?>
                      </div>
                    <?php endif;
                    if($top_standard_heading['headline']): ?>
                      <<?php echo $top_standard_heading['heading_type']; ?> class="font-medium font-lexend text-black-100 mb-3 mb-lg-4"><?php echo $top_standard_heading['headline']; ?></<?php echo $top_standard_heading['heading_type']; ?>>
                    <?php endif; 
                    if($top_standard_copy_content): ?>
                      <div class="wysiwyg-content text-black-100 font-lexend mb-4">
                        <?php echo $top_standard_copy_content; ?>
                      </div>
                    <?php endif; 
                    if($top_standard_button): ?>
                      <a href="<?php echo $top_standard_button['url']; ?>" class="site-button" <?php if($top_standard_button['target']): ?>target="<?php echo $top_standard_button['target']; ?>"<?php endif; ?>><?php echo $top_standard_button['title']; ?></a>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
                <!-- End Here Top Standard Content -->
              <?php endif;
              if($top_content_type == 'Call-to-Action'): ?>
                <!-- Top CTA -->
                <div class="cta-block"> 
                  <?php foreach($top_cta as $post_cta):
                    $cta_heading = get_field('cta_headline', $post_cta->ID); 
                    $cta_content = get_field('cta_content', $post_cta->ID);
                    $cta_link = get_field('cta_link', $post_cta->ID); 
                    if($cta_heading || $cta_content || $cta_link): ?>
                      <div class="cta-info text-center <?php echo $bg_color; ?>">
                        <div class="cta-content">
                          <div class="mb-2">
                            <img src="<?php echo get_stylesheet_directory_uri( );?>/assets/images/call-icon.svg" class="img-fluid" alt="Call Icon">
                          </div>
                          <?php if($cta_heading): ?>
                            <h3 class="font-medium"><?php echo $cta_heading; ?></h3>
                          <?php endif; 
                          if($cta_content): ?>
                            <div class="wysiwyg-content <?php if($cta_link):?>mb-3<?php endif; ?> text-start"><?php echo $cta_content; ?></div>
                          <?php endif; 
                          if($cta_link): ?>
                            <a href="<?php echo $cta_link['url']; ?>" class="site-button" <?php if($cta_link['target']): ?>target="<?php echo $cta_link['target']; ?>"<?php endif; ?>><?php echo $cta_link['title']; ?></a>
                          <?php endif; ?>
                        </div>
                      </div>
                  <?php endif; endforeach; ?>
                </div>
                <!-- End Here Top CTA -->
              <?php endif;  
              if($top_content_type == 'Accordions'):?>
                <!-- Top Accordions Content -->
                <?php if($top_accordions_heading['headline']): ?>
                  <<?php echo $top_accordions_heading['heading_type']; ?> class="font-medium mb-4"><?php echo $top_accordions_heading['headline']; ?></<?php echo $top_accordions_heading['heading_type']; ?>>
                <?php endif; ?>
                <?php if (!empty($top_accordion) && is_array($top_accordion)): ?>
                  <div class="accordion accordion-block mt-3 mt-lg-0" id="TopAccordionExample-<?php echo $key; ?>">
                    <?php $i = 1;
                    foreach($top_accordion as $top_accordion_post): 
                    $accordion_title = get_field('accordion_header', $top_accordion_post->ID); 
                    $accordion_content = get_field('accordion_content', $top_accordion_post->ID);
                    $accordion_image = get_field('accordion_image', $top_accordion_post->ID);
                    $accordion_button = get_field('accordion_button', $top_accordion_post->ID); ?>
                      <div class="accordion-item">
                        <h3 class="accordion-header" id="heading-<?php echo $key.'-'.$i; ?>">
                          <button class="accordion-button font-lexend font-xs-medium fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $key.'-'.$i; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $key.'-'.$i; ?>">
                            <?php echo $accordion_title; ?>
                          </button>
                        </h3>
                        <div id="collapse-<?php echo $key.'-'.$i; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $key.'-'.$i; ?>" data-bs-parent="#TopAccordionExample-<?php echo $key; ?>">
                          <div class="accordion-body">
                            <div class="row">
                              <?php if($accordion_image): ?>
                                <div class="col-lg-4">
                                  <img src="<?php echo $accordion_image['url']; ?>" alt="<?php echo $accordion_image['alt']; ?>" class="img-fluid">
                                </div>
                              <?php endif; ?>
                              <div class="<?php if($accordion_image): ?>col-lg-8 ps-xxl-4 <?php else: ?>col-lg-12 pe-lg-5<?php endif; ?>">
                                <?php if($accordion_content): ?>
                                  <div class="wysiwyg-content accordion-content <?php if($accordion_button): ?>pb-2<?php endif; ?>">
                                    <?php echo wp_trim_words( $accordion_content, 42, '...' ); ?>
                                  </div>
                                <?php endif; ?>
                                <?php if($accordion_button): ?>
                                  <a href="<?php echo $accordion_button['url']; ?>" class="site-button" <?php if($accordion_button['target']): ?>target="<?php echo $accordion_button['target']; ?>"<?php endif; ?>><?php echo $accordion_button['title']; ?></a>
                                <?php endif; ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php $i++; endforeach; ?>
                  </div>
                <?php endif; ?>
                <!-- End Here Top Accordions Content -->
              <?php endif; ?>
            </div>
          <?php endif; ?>
          
          <?php if($bottom_content_type == 'Standard Content' || $bottom_content_type == 'Accordions' || $bottom_content_type == 'Gallery'): ?>
            <div class="bottom-content-block">
              <?php if($bottom_content_type == 'Standard Content'): ?>
                <!-- Bottom Standard Content -->
                <?php if($bottom_standard_copy_content || $bottom_standard_heading['headline'] || $bottom_standard_button): ?>
                  <div class="bottom-standard-content text-center">
                    <?php if($bottom_standard_icon): ?>
                      <div class="heading-with-above-icon mb-2">
                        <?php echo $bottom_standard_icon; ?>
                      </div>
                    <?php endif;
                    if($bottom_standard_heading['headline']): ?>
                      <<?php echo $bottom_standard_heading['heading_type']; ?> class="font-medium font-lexend text-black-100 mb-3 mb-lg-4"><?php echo $bottom_standard_heading['headline']; ?></<?php echo $bottom_standard_heading['heading_type']; ?>>
                    <?php endif; 
                    if($bottom_standard_copy_content): ?>
                      <div class="wysiwyg-content text-black-100 font-lexend mb-4">
                        <?php echo $bottom_standard_copy_content; ?>
                      </div>
                    <?php endif; 
                    if($bottom_standard_button): ?>
                      <a href="<?php echo $bottom_standard_button['url']; ?>" class="site-button" <?php if($bottom_standard_button['target']): ?>target="<?php echo $bottom_standard_button['target']; ?>"<?php endif; ?>><?php echo $bottom_standard_button['title']; ?></a>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
                <!-- End Here Bottom Standard Content -->
              <?php endif; 
              if($bottom_content_type == 'Accordions'):?>
                <!-- Bottom Accordions Content -->
                <?php if($bottom_accordions_heading['headline']): ?>
                  <<?php echo $bottom_accordions_heading['heading_type']; ?> class="font-medium mb-4"><?php echo $bottom_accordions_heading['headline']; ?></<?php echo $bottom_accordions_heading['heading_type']; ?>>
                <?php endif; ?>
                <?php if (!empty($bottom_accordion) && is_array($bottom_accordion)): ?>
                  <div class="accordion accordion-block mt-3 mt-lg-0" id="accordionExample-<?php echo $key; ?>">
                    <?php $i = 1;
                    foreach($bottom_accordion as $bottom_accordion_post): 
                    $accordion_title = get_field('accordion_header', $bottom_accordion_post->ID); 
                    $accordion_content = get_field('accordion_content', $bottom_accordion_post->ID);
                    $accordion_image = get_field('accordion_image', $bottom_accordion_post->ID);
                    $accordion_button = get_field('accordion_button', $bottom_accordion_post->ID); ?>
                      <div class="accordion-item">
                        <h3 class="accordion-header" id="heading-<?php echo $key.'-'.$i; ?>">
                          <button class="accordion-button font-lexend font-xs-medium fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $key.'-'.$i; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $key.'-'.$i; ?>">
                            <?php echo $accordion_title; ?>
                          </button>
                        </h3>
                        <div id="collapse-<?php echo $key.'-'.$i; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $key.'-'.$i; ?>" data-bs-parent="#accordionExample-<?php echo $key; ?>">
                          <div class="accordion-body">
                            <div class="row">
                              <?php if($accordion_image): ?>
                                <div class="col-lg-4">
                                  <img src="<?php echo $accordion_image['url']; ?>" alt="<?php echo $accordion_image['alt']; ?>" class="img-fluid">
                                </div>
                              <?php endif; ?>
                              <div class="<?php if($accordion_image): ?>col-lg-8 ps-xxl-4 <?php else: ?>col-lg-12 pe-lg-5<?php endif; ?>">
                                <?php if($accordion_content): ?>
                                  <div class="wysiwyg-content accordion-content <?php if($accordion_button): ?>pb-2<?php endif; ?>">
                                    <?php echo wp_trim_words( $accordion_content, 42, '...' ); ?>
                                  </div>
                                <?php endif; ?>
                                <?php if($accordion_button): ?>
                                  <a href="<?php echo $accordion_button['url']; ?>" class="site-button" <?php if($accordion_button['target']): ?>target="<?php echo $accordion_button['target']; ?>"<?php endif; ?>><?php echo $accordion_button['title']; ?></a>
                                <?php endif; ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php $i++; endforeach; ?>
                  </div>
                <?php endif; ?>
                <!-- End Here Bottom Accordions Content -->
              <?php endif; 
              if($bottom_content_type == 'Gallery'): ?>
                <div class="bottom-gallery-slider text-center">
                  <?php if($bottom_gallery_type == 'Icons' ): ?>
                      <?php if($bottom_icon_heading['headline']): ?>
                        <<?php echo $bottom_icon_heading['heading_type']; ?> class="font-medium mb-lg-4"><?php echo $bottom_icon_heading['headline']; ?></<?php echo $bottom_icon_heading['heading_type']; ?>>
                      <?php endif; ?>
                      <?php if (!empty($bottom_add_icons) && is_array($bottom_add_icons)): ?>
                        <div class="icons-slider mb-lg-3 pb-lg-4 pt-3">
                          <?php foreach($bottom_add_icons as $icons_group_icon): 
                            $icon = $icons_group_icon['icon'] ?? ' ';
                            $text = $icons_group_icon['text'] ?? ' ';
                            $link = $icons_group_icon['link'] ?? ' ';
                            if($icon || $text ):
                          ?>
                            <div>
                              <div class="icon-slide-box px-2 px-md-3 text-center">
                                <?php if($link): ?>
                                  <a href="<?php echo $link['url']; ?>" class="d-block text-decoration-none" <?php if($link['target']): ?> target="<?php echo $link['target']; ?>" <?php endif; ?>>
                                <?php endif; ?>
                                  <?php if($icon): ?>
                                      <?php echo $icon; ?>
                                  <?php endif; 
                                  if($text): ?>
                                      <p class="mt-3 mb-0 fw-semibold"><?php echo $text; ?></p>
                                  <?php endif; ?>
                                <?php if($link): ?></a><?php endif; ?>
                              </div>
                            </div>
                          <?php endif; endforeach; ?>
                        </div>
                      <?php endif; ?>
                  <?php endif; 
                  if($bottom_gallery_type == 'Image Gallery' ): ?>
                    <?php if($bottom_image_heading['headline']): ?>
                        <<?php echo $bottom_image_heading['heading_type']; ?> class="font-medium mb-4"><?php echo $bottom_image_heading['headline']; ?></<?php echo $bottom_image_heading['heading_type']; ?>>
                      <?php endif; ?>
                    <?php if (!empty($bottom_images) && is_array($bottom_images)): ?>
                      <div class="image-gallery-slider mb-lg-3 pb-lg-4 pt-lg-3">
                        <?php foreach ($bottom_images as $gallery_post):
                            $images = get_field('community_galleries', $gallery_post->ID);
                            if (!empty($images) && is_array($images)):
                              foreach ($images as $img):
                                $image_url = $img['sizes']['wysiwyg-gallery-image'] ?? '';
                                $alt       = $img['alt'] ?? '';
                                if ($image_url): ?>
                                  <div>
                                    <div class="icon-slide-box px-2 px-md-3">
                                      <img src="<?php echo esc_url($image_url); ?>" class="img-fluid" alt="<?php echo esc_attr($alt); ?>">
                                    </div>
                                  </div>
                        <?php endif; endforeach; endif; endforeach; ?>
                      </div>
                    <?php endif; ?>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>