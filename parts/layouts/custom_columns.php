<?php $video_url = $section['video'] ?? '';  
$background_color = $section['background_color'] ?? '';
$background_water_color = $section['background_watercolor']['background_watercolor'] ?? '';
$border = $section['border'] ?? '';
$background_pattern = $section['background_pattern'] ?? '';

$num_columns = $section['num_columns'] ?? '';
$alignment = $section['alignment'] ?? '';

$include_special_content = $section['include_special_content'] ?? false;
$special_content = $section['special_content'] ?? '';
$special_content_position = $special_content['special_content_position'] ?? '';
$choose_special_content = $special_content['choose_special_content'] ?? '';
$push = $special_content['push'] ?? '';
$media = $special_content['media'] ?? '';
$media_type = $media['media_type'] ?? '';
$landscapeportrait_image = $media['landscapeportrait_image'] ?? '';
$image_type = $landscapeportrait_image['image_type'] ?? '';
$landscape_image = $landscapeportrait_image['landscape_image'] ?? '';
$portrait_image = $landscapeportrait_image['portrait_image'] ?? '';
$media_video = $media['video'] ?? '';
$video_url = $media_video['video'] ?? '';
$meet_our_teams = $special_content['meet_our_teams'] ?? '';
$meet_heading = $meet_our_teams['heading'] ?? '';
$meet_our_team = $meet_our_teams['meet_our_team'] ?? '';
$meet_button = $meet_our_teams['button'] ?? '';
$meet_background_color = $meet_our_teams['background_color'] ?? '';
$media_accordions = $special_content['accordions'] ?? '';
$accordions_heading = $media_accordions['heading'] ?? '';
$accordions = $media_accordions['accordions'] ?? '';
$media_cta = $special_content['cta'] ?? '';
$call_to_action = $media_cta['call_to_action'] ?? '';
$bottom_overlap = $media_cta['bottom_overlap'] ?? '';
$media_embellishment = $special_content['embellishment'] ?? '';
$embellishment = $media_embellishment['embellishment'] ?? '';
$embellishment_position = $media_embellishment['embellishment_position'] ?? '';

$custom_columns_zone_heading = $section['custom_columns_zone_heading'] ?? '';
$custom_heading = $custom_columns_zone_heading['heading'] ?? '';
$include_image_headers_on_custom_content = $section['include_image_headers_on_custom_content'] ?? false;

$column_1 = $section['column_1'] ?? '';
$column_position = $column_1['column_position'] ?? '';
$column_1_image_header = $column_1['image_header'] ?? '';
$column_1_heading = $column_1['heading'] ?? '';
$heading_icon = $column_1['heading_icon'] ?? '';
$heading_icon_position = $column_1['heading_icon_position'] ?? '';
$column_1_content = $column_1['content'] ?? '';
$column_1_gallery = $column_1['gallery'] ?? false;
$icons_or_image = $column_1['icons_or_image'] ?? '';
$icons_group = $column_1['icons_group'] ?? '';
$icons_group_heading = $icons_group['heading'] ?? '';
$icons_group_icons = $icons_group['icons'] ?? '';
$image_group = $column_1['image_group'] ?? '';
$image_group_heading = $image_group['heading'] ?? '';
$image_gallery = $image_group['gallery'] ?? '';
$column_1_button = $column_1['button'] ?? '';

$column_2 = $section['column_2'] ?? '';
$column_2_image_header = $column_2['image_header'] ?? '';
$column_2_heading = $column_2['heading'] ?? '';
$column_2_content = $column_2['content'] ?? '';
$column_2_button = $column_2['button'] ?? '';

$column_3 = $section['column_3'] ?? '';
$column_3_image_header = $column_3['image_header'] ?? '';
$column_3_heading = $column_3['heading'] ?? '';
$column_3_content = $column_3['content'] ?? '';
$column_3_button = $column_3['button'] ?? '';
?>

<?php if ($background_color == 'Blue') {
  $bg_color = 'bg-blue';
  $text_color = 'text-white';
  $heading_color = 'text-white';
} elseif($background_color == 'Light Blue') {
  $bg_color = 'bg-light-blue';
  $text_color = 'text-black-100';
  $heading_color = 'text-black-100';
} elseif($background_color == 'Teal') {
  $bg_color = 'bg-teal';
  $text_color = 'text-black';
  $heading_color = 'text-black';
} elseif($background_color == 'Purple') {
  $bg_color = 'bg-purple';
  $text_color = 'text-white';
  $heading_color = 'text-white';
} elseif($background_color == 'Gradient Yellow') {
  $bg_color = 'bg-gradient-yellow';
  $text_color = 'text-black';
  $heading_color = 'text-black';
} else {
  $bg_color = 'bg-white';
  $text_color = 'text-black';
  $heading_color = 'text-black';
}

if($background_water_color == 'Blue' && $background_color == 'White') {
  $bg_water_color = 'bg-water-color bg-blue-water-color';
} elseif($background_water_color == 'Yellow' && $background_color == 'White') {
  $bg_water_color = 'bg-water-color bg-yellow-water-color';
} elseif($background_water_color == 'Pink' && $background_color == 'White') {
  $bg_water_color = 'bg-water-color bg-pink-water-color';
} else {
  $bg_water_color = '';
}

if($num_columns == '1') {
  $section_class = 'custom-column-one';
} elseif($num_columns == '2') {
  if($media_type == 'Image' && $include_special_content == true) {
    $section_class = 'custom-column-two with-media with-image-media';
  } elseif($media_type == 'Video' && $include_special_content == true) {
    $section_class = 'custom-column-two with-media with-video-media';
  } else {
    $section_class = 'custom-column-two';
  }
  $section_class = 'custom-column-two with-media with-video-media';
} else {
  $section_class = '';
}



if($num_columns == '2' && $include_special_content == false || $num_columns == '2' && $include_special_content == false && $include_image_headers_on_custom_content == true) {
  $heading_column_class = 'col-lg-8';
  $left_column_class = 'col-lg-4';
  $right_column_class = 'col-lg-4';
  $row_class = 'justify-content-center';
  $heading_fonts = 'font-lexend';
  $content_fonts = 'font-lexend';
} elseif($num_columns == '2' && $include_special_content == true) {
  $heading_column_class = 'col-lg-12';
  $left_column_class = 'col-lg-7 pt-4 custom-columns-content-col';
  $row_class = '';
  $heading_fonts = 'font-lexend';
  $content_fonts = 'font-lexend';
  if($special_content_position == 'Left') {
    $right_column_class = 'col-lg-5 pe-lg-5';
  } else {
    $right_column_class = 'col-lg-5 ps-lg-5';
  }
} else {
  $heading_column_class = '';
  $left_column_class = '';
  $right_column_class = '';
  $row_class = '';
  $heading_fonts = '';
  $content_fonts = '';
}
if($num_columns == '2' && $include_special_content == false && $include_image_headers_on_custom_content == true){
  $row_img_class = 'custom-col-with-top-header-image';
} else {
  $row_img_class = '';
}

if($num_columns == '2' && $include_special_content == true && $special_content_position == 'Left') {
  $special_content_row_class = 'flex-lg-row-reverse';
} else {
  $special_content_row_class = '';
}
if($embellishment_position == 'Left') {
  $embellishment_position_class = ' left-align-embellishment';
} else {
  $embellishment_position_class = '';
} 

if($embellishment == 'Circles' ) {
  $embellishment_class = 'with-embellishment circles-embellishment';
} elseif($embellishment == 'Seeds' ) {
  $embellishment_class = 'with-embellishment seeds-embellishment';
} elseif($embellishment == 'Seeds Open' ) {
  $embellishment_class = 'with-embellishment seeds-open-embellishment';
} elseif($embellishment == 'Seeds Open Large' ) {
  $embellishment_class = 'with-embellishment seeds-open-large-embellishment';
} elseif($embellishment == 'Squiggles' ) {
  $embellishment_class = 'with-embellishment squiggles-embellishment';
} elseif($embellishment == 'X’s' ) {
  $embellishment_class = 'with-embellishment xs-embellishment';
} else {
  $embellishment_class = '';
}

?>

<section class="custom-columns-zone <?php echo $section_class; ?> <?php echo $bg_color; ?> <?php echo $bg_water_color; ?> <?php if($num_columns == '1' && $alignment == 'Centered'): ?>text-center<?php endif; ?>">
  <div class="container-fluid">
    <?php if($num_columns == '1'): ?>
      <div class="row justify-content-center">
        <div class="col-lg-9">
          <?php if($custom_heading['headline']): ?>
            <<?php echo $custom_heading['heading_type']; ?> class="font-medium mb-3 <?php echo $heading_color; ?>"><?php echo $custom_heading['headline']; ?></<?php echo $custom_heading['heading_type']; ?>>
          <?php endif; ?>
          <?php if($column_1_heading['headline']): ?>
            <<?php echo $column_1_heading['heading_type']; ?> class="font-medium mb-3 <?php echo $heading_color; ?>"><?php echo $column_1_heading['headline']; ?></<?php echo $column_1_heading['heading_type']; ?>>
          <?php endif; 
          if($column_1_content): ?>
            <div class="wysiwyg-content fw-semibold mb-4 pb-4 <?php echo $text_color; ?>">
              <?php echo $column_1_content; ?>
            </div>
          <?php endif;
          if($column_1_gallery == true && $icons_or_image == 'Icons' ): ?>
              <?php if($icons_group_heading['headline']): ?>
                <<?php echo $icons_group_heading['heading_type']; ?> class="font-medium mb-4 pb-lg-3 <?php echo $heading_color; ?>"><?php echo $icons_group_heading['headline']; ?></<?php echo $icons_group_heading['heading_type']; ?>>
              <?php endif; ?>
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
          <?php endif; 
          if($column_1_gallery == true && $icons_or_image == 'Image Gallery' ): ?>
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
          <?php endif;
          if($column_1_button): ?>
            <a href="<?php echo $column_1_button['url']; ?>" class="site-button" <?php if($column_1_button['target']): ?>target="<?php echo $column_1_button['target']; ?>" <?php endif; ?>><?php echo $column_1_button['title']; ?></a>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
    
    <?php if($num_columns == '2'): ?>
      <?php if($custom_heading['headline']): ?>
        <div class="row <?php echo $row_class; ?> pb-3">
          <div class="<?php echo $heading_column_class; ?>">
            <<?php echo $custom_heading['heading_type']; ?> class="font-medium mb-3 <?php echo $heading_color; ?>"><?php echo $custom_heading['headline']; ?></<?php echo $custom_heading['heading_type']; ?>>
          </div>
        </div>
      <?php endif; ?>
      <div class="row <?php echo $row_class; ?> <?php echo $row_img_class; ?> <?php echo $special_content_row_class; ?>"> 
        <?php if( $column_1_heading['headline'] || $column_1_content || $column_1_button): ?>
          <div class="<?php echo $left_column_class; ?>">
            <?php if($include_image_headers_on_custom_content == true && $column_1_image_header): ?>
              <div class="mb-3">
                <img src="<?php echo esc_url($column_1_image_header['sizes']['two_col_top']); ?>" alt="<?php echo esc_attr($column_1_image_header['alt']); ?>" class="img-fluid">
              </div>
            <?php endif;
            if($column_1_heading['headline']): ?>
              <<?php echo $column_1_heading['heading_type']; ?> class="font-medium <?php echo $heading_fonts; ?> mb-3 <?php echo $heading_color; ?> <?php if($heading_icon): ?>heading-with-icon<?php endif; ?>"><?php echo $column_1_heading['headline']; ?> <?php echo $heading_icon; ?></<?php echo $column_1_heading['heading_type']; ?>>
            <?php endif; 
            if($column_1_content): ?>
              <div class="wysiwyg-content <?php echo $content_fonts; ?> mb-3 <?php echo $text_color; ?>">
                <?php echo $column_1_content; ?>
              </div>
            <?php endif; 
            if($column_1_button): ?>
              <a href="<?php echo $column_1_button['url']; ?>" class="site-button" <?php if($column_1_button['target']): ?>target="<?php echo $column_1_button['target']; ?>" <?php endif; ?>><?php echo $column_1_button['title']; ?></a>
            <?php endif; ?>
          </div>
        <?php endif; ?>
        <div class="<?php echo $right_column_class; ?>">
          <?php if( $column_2_heading['headline'] || $column_2_content || $column_2_button): ?>
            <?php if($include_image_headers_on_custom_content == true && $column_2_image_header): ?>
              <div class="mb-3">
                <img src="<?php echo esc_url($column_2_image_header['sizes']['two_col_top']); ?>" alt="<?php echo esc_attr($column_2_image_header['alt']); ?>" class="img-fluid">
              </div>
            <?php endif;
            if($column_2_heading['headline']): ?>
                <<?php echo $column_2_heading['heading_type']; ?> class="font-medium mb-3 <?php echo $heading_fonts; ?> <?php echo $heading_color; ?>"><?php echo $column_2_heading['headline']; ?></<?php echo $column_2_heading['heading_type']; ?>>
            <?php endif; 
            if($column_2_content): ?>
              <div class="wysiwyg-content <?php echo $content_fonts; ?> mb-3 <?php echo $text_color; ?>">
                <?php echo $column_2_content; ?>
              </div>
            <?php endif; 
            if($column_2_button): ?>
              <a href="<?php echo $column_2_button['url']; ?>" class="site-button" <?php if($column_2_button['target']): ?>target="<?php echo $column_2_button['target']; ?>" <?php endif; ?>><?php echo $column_2_button['title']; ?></a>
            <?php endif; ?>
          <?php endif; ?>
          
          <!------- Video Special Content ------>
          <?php if($include_special_content == true && $media_type == 'Video' && $video_url): ?>
            <?php $thumb_image = "";
                  $video_id = "";
                  $embed_src = "";
                  $src = "";
                  // If iframe embed
                  if (strpos($video_url, '<iframe') !== false) {
                    preg_match('/src="([^"]+)"/', $video_url, $matches);
                    $src = $matches[1] ?? '';
                  } else {
                    // Direct video URL
                    $src = trim($video_url);
                  } 
                  // YouTube
                  if (strpos($src, 'youtu') !== false) {
                    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $src, $match);
                    if (!empty($match[1])) {
                      $video_id = $match[1];
                      $thumb_image = "https://i3.ytimg.com/vi/{$video_id}/maxresdefault.jpg";
                      $embed_src = "https://www.youtube.com/embed/{$video_id}?autoplay=1";
                    }
                  }
                  // Vimeo
                  elseif (strpos($src, 'vimeo') !== false) {
                    preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $src, $vimeo_match);
                    if (!empty($vimeo_match[1])) {
                      $vid = $vimeo_match[1];
                      $hash = @unserialize(file_get_contents("http://vimeo.com/api/v2/video/$vid.php"));
                      $thumb_image = $hash[0]['thumbnail_large'] ?? '';
                      $embed_src = "https://player.vimeo.com/video/$vid?autoplay=1";
                    }
                  }
                  $unique_key = uniqid();
                ?>
                <div class="video-box <?php echo $embellishment_class; ?><?php echo $embellishment_position_class; ?>">
                  <div class="embed-responsive embed-responsive-16by9 video-wrapper position-relative">
                    <span class="play-icon" id="play-<?php echo $unique_key; ?>">
                      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/play-icon.svg" alt="Play Video">
                    </span>
                    <div class="video-image" style="background-image: url('<?php echo esc_url($thumb_image); ?>');">
                      <div class="video-player vp-<?php echo $unique_key; ?>"></div>
                    </div>
                  </div>
                </div>
                <script>
                  jQuery(document).ready(function() {
                    jQuery('#play-<?php echo $unique_key; ?>').on('click', function() {
                      jQuery(this).hide(); // Hide play icon
                      // Remove background
                      jQuery('.vp-<?php echo $unique_key; ?>')
                        .closest('.video-image')
                        .css('background-image', 'none');
                      // Add video iframe
                      jQuery('.vp-<?php echo $unique_key; ?>').html(`
                      <iframe title="Video" width="100%" height="360"
                        src="<?php echo esc_url($embed_src); ?>"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen
                        loading="lazy"
                        allow="autoplay"></iframe>
                    `);
                      // Adjust height
                      let videoHeight = jQuery('.video-image').outerHeight();
                      jQuery('.video-player iframe').css('height', videoHeight);
                    });
                  });
                </script>
          <?php endif; ?>
          <!------- End Here Video Special Content ------>
          
          <!------- Image Special Content ------>
          <?php if($include_special_content == true && $media_type == 'Image'): ?>
            <div class="image-box <?php echo $embellishment_class; ?><?php echo $embellishment_position_class; ?>">
              <?php if($image_type == 'Landscape' && $landscape_image): ?>
                <img src="<?php echo esc_url($landscape_image['sizes']['two_col_wide_image']); ?>" alt="<?php echo esc_attr($landscape_image['alt']); ?>" class="img-fluid">
              <?php elseif($image_type == 'Portrait' && $portrait_image): ?>
                <img src="<?php echo esc_url($portrait_image['sizes']['two_col_tall_image']); ?>" alt="<?php echo esc_attr($portrait_image['alt']); ?>" class="img-fluid">
              <?php endif; ?>
            </div>
          <?php endif; ?>
          <!------- End Here Image Special Content ------>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

