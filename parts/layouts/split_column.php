<?php $split_column_position = $section['split_column_position'] ?? '';
$standard_column = $section['standard_column'] ?? '';
$image_headers = $standard_column['image_headers'] ?? '';
$image_header_content = $standard_column['image_header_content'] ?? '';
$image_header = $image_header_content['image_header'] ?? '';
$image_embellishment = $image_header_content['embellishment'] ?? '';
$image_embellishment_position = $image_header_content['embellishment_position'] ?? '';
$heading = $standard_column['heading'] ?? '';
$content = $standard_column['content'] ?? '';
$button = $standard_column['button'] ?? '';

$split_column = $section['split_column'] ?? '';
$top_content = $split_column['top_content'] ?? '';
$top_content_type = $top_content['content_type'] ?? '';
$standard_content = $top_content['standard'] ?? '';
$standard_heading = $standard_content['heading'] ?? '';
$standard_icon = $standard_content['icon'] ?? '';
$standard_copy_content = $standard_content['content'] ?? '';
$standard_button = $standard_content['button'] ?? '';
$top_accordions = $top_content['accordions'] ?? '';
$top_accordions_heading = $top_accordions['heading'] ?? '';
$top_accordion = $top_accordions['accordion'] ?? '';
$top_cta = $top_content['call_to_action'] ?? '';
$background_color = $top_content['background_color'] ?? '';

$bottom_content = $split_column['bottom_content'] ?? '';
$bottom_content_type = $bottom_content['content_type'] ?? '';
$bottom_standard_content = $bottom_standard_content['standard'] ?? '';
$bottom_standard_heading = $bottom_standard_content['heading'] ?? '';
$bottom_standard_icon = $bottom_standard_content['icon'] ?? '';
$bottom_standard_copy_content = $bottom_standard_content['content'] ?? '';
$standard_button = $bottom_standard_content['button'] ?? '';
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
?>

<section class="split-column-zone" id="split-column-zone-<?php echo get_the_ID().'-'.$key; ?>">
  <div class="container-fluid">
    <div class="row <?php if($split_column_position == 'Left'):?>flex-row-reverse<?php endif; ?>">
      <div class="col-lg-5 pe-lg-5">
        <h2>Advice for seniors and caregivers.</h2>
        <div class="image-box mb-2">
          <img src="" class="img-fluid" alt="" >
        </div>
        <div class="wysiwyg-content">
          <?php echo $content; ?>
        </div>
        <a href="#" class="site-button">Explore</a>
      </div>
      <div class="col-lg-6 offset-lg-1">
        <div class="cta-block"> 
          <?php foreach($call_to_action as $post_cta):
            $cta_heading = get_field('cta_headline', $post_cta->ID); 
            $cta_content = get_field('cta_content', $post_cta->ID);
            $cta_link = get_field('cta_link', $post_cta->ID); ?>
            <div class="cta-info text-center">
              <div class="cta-content">
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
          <?php endforeach; ?>
        </div>
        
        <div class="bottom-gallery-slider">
          <?php if (!empty($icons_group_icons) && is_array($icons_group_icons)): ?>
            <div class="icons-slider mb-3 pb-4 pt-3">
              <?php foreach($icons_group_icons as $icons_group_icon): 
                $icon = $icons_group_icon['icon'] ?? ' ';
                $text = $icons_group_icon['text'] ?? ' ';
                $link = $icons_group_icon['link'] ?? ' ';
                if($icon || $text ):
              ?>
                <div>
                  <div class="icon-slide-box <?php if($alignment == 'Centered'): ?>text-center<?php endif; ?> px-2 px-md-3">
                    <?php if($link): ?>
                      <a href="<?php echo $link['url']; ?>" class="d-block text-decoration-none" <?php if($link['target']): ?> target="<?php echo $link['target']; ?>" <?php endif; ?>>
                    <?php endif; ?>
                      <?php if($icon): ?>
                          <?php echo $icon; ?>
                      <?php endif; 
                      if($text): ?>
                          <p class="mt-3 mb-0 fw-semibold <?php echo $text_color; ?>"><?php echo $text; ?></p>
                      <?php endif; ?>
                    <?php if($link): ?></a><?php endif; ?>
                  </div>
                </div>
              <?php endif; endforeach; ?>
            </div>
          <?php endif; ?>
          
          <?php if($column_1_gallery == true && $icons_or_image == 'Image Gallery' ): ?>
            <?php if($image_group_heading['headline']): ?>
                <<?php echo $image_group_heading['heading_type']; ?> class="font-medium mb-4 pb-lg-3 <?php echo $heading_color; ?>"><?php echo $image_group_heading['headline']; ?></<?php echo $image_group_heading['heading_type']; ?>>
              <?php endif; ?>
            <?php if (!empty($image_gallery) && is_array($image_gallery)): ?>
              <div class="image-gallery-slider mb-3 pb-4 pt-3">
                <?php foreach ($image_gallery as $gallery_post):
                    $images = get_field('community_galleries', $gallery_post->ID);
                    if (!empty($images) && is_array($images)):
                      foreach ($images as $img):
                        $image_url = $img['sizes']['wysiwyg-gallery-image'] ?? '';
                        $alt       = $img['alt'] ?? '';
                        if ($image_url): ?>
                          <div>
                            <div class="icon-slide-box <?php if($alignment == 'Centered') echo 'text-center'; ?> px-2 px-md-3">
                              <img src="<?php echo esc_url($image_url); ?>" class="img-fluid" alt="<?php echo esc_attr($alt); ?>">
                            </div>
                          </div>
                <?php endif; endforeach; endif; endforeach; ?>
              </div>
            <?php endif; ?>
          <?php endif; ?>
        </div>
        
        <div class="bottom-standard-content">
          <div class="heading-with-above-icon text-center mb-2">
            
          </div>
          <h3 class="font-medium font-lexend text-black-100 mb-3 mb-lg-4 text-center">This is a long title meant to be wide</h3>
          <div class="wysiwyg-content text-black-100 font-lexend mb-4">
            
          </div>
          <a href="" class="site-button"></a>
        </div>
        
        <?php if($accordions_heading['headline']): ?>
          <<?php echo $accordions_heading['heading_type']; ?> class="font-medium mb-4 <?php echo $heading_color; ?>"><?php echo $accordions_heading['headline']; ?></<?php echo $accordions_heading['heading_type']; ?>>
        <?php endif; ?>
        <?php if (!empty($accordions) && is_array($accordions)): ?>
          <div class="accordion accordion-block mt-3 mt-lg-0" id="accordionExample-<?php echo $key; ?>">
            <?php $i = 1;
            foreach($accordions as $accordion): 
            $accordion_title = get_field('accordion_header', $accordion->ID); 
            $accordion_content = get_field('accordion_content', $accordion->ID);
            $accordion_image = get_field('accordion_image', $accordion->ID);
            $accordion_button = get_field('accordion_button', $accordion->ID); ?>
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
                          <div class="wysiwyg-content accordion-content <?php if($accordion_button): ?>pb-2<?php endif; ?> <?php echo $text_color; ?>">
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
      </div>
    </div>
  </div>
</section>