<?php
$stylized_heading = get_field("stylized_heading");
$headline = get_field('headline');
$content = get_field('content');
$background_embellishment = get_field('background_embellishment');
$background_pattern = $background_embellishment['background_embellishment'] ?? '';
$bg_watercolor = get_field('background_watercolor');
$background_water_color = $bg_watercolor['background_watercolor'] ?? '';
$background_watercolor_position = $bg_watercolor['background_watercolor_position'] ?? '';
$media_column = get_field('media_column');
$media_type = get_field('media_type');
$image_type = get_field('image_type');
$standard_image = get_field('standard_image');
$layered_image_zone = get_field('layered_image_zone');
$layered_image = $layered_image_zone['image'] ?? "";
$embellishment =  $layered_image_zone['embellishment'] ?? "";
$video_url = get_field('video_url');

$disable_sidebar_submenu = get_field("disable_sidebar_submenu");
$hide = get_field('hide_sidebar_navigation');

global $post;
$pageids = array();
$nav_args = array(
    'post_type'   => 'page',
    'numberposts' => -1,
    'meta_key'    => 'hide_sidebar_navigation',
    'meta_compare'=> '=',
    'meta_value'  => 1
);
$pages = get_posts($nav_args);

if ($pages) {
    foreach ($pages as $p) {
        $pageids[] = $p->ID;
    }
}

// Always define exclude_list
$exclude_list = !empty($pageids) ? implode(",", $pageids) : '';
$children = wp_list_pages('exclude=' . $exclude_list . '&depth=2&title_li=&echo=0&child_of=' . $post->ID);


// Check if standard image should be shown
$show_layered_image = $media_column && $media_type == 'Image' && $image_type == 'Image with Embellishment' && $layered_image;


// Set background pattern class
if ($background_pattern == 'dots') {
  $background_pattern_class = 'with-background-pattern dots-background-pattern';
} elseif ($background_pattern == 'circles') {
  $background_pattern_class = 'with-background-pattern circles-background-pattern';
} elseif ($background_pattern == 'honeycomb') {
  $background_pattern_class = 'with-background-pattern honeycomb-background-pattern';
} elseif ($background_pattern == 'sprinkles') {
  $background_pattern_class = 'with-background-pattern sprinkles-background-pattern';
} else {
  $background_pattern_class = '';
}


if ($background_water_color == 'Blue') {
  $bg_water_color = 'bg-water-color bg-blue-water-color';
} elseif ($background_water_color == 'Yellow') {
  $bg_water_color = 'bg-water-color bg-yellow-water-color';
} elseif ($background_water_color == 'Pink') {
  $bg_water_color = 'bg-water-color bg-pink-water-color';
} else {
  $bg_water_color = '';
}
if ($background_watercolor_position == 'left') {
  $bg_water_color_position = 'bg-water-color-left';
} elseif ($background_watercolor_position == 'right') {
  $bg_water_color_position = 'bg-water-color-right';
} else {
  $bg_water_color_position = '';
}

if ($embellishment == 'circles') {
  $embellishment_class = 'with-embellishment circles-embellishment';
} elseif ($embellishment == 'seeds') {
  $embellishment_class = 'with-embellishment seeds-embellishment';
} elseif ($embellishment == 'seeds-open') {
  $embellishment_class = 'with-embellishment seeds-open-embellishment';
} elseif ($embellishment == 'seeds-open-large') {
  $embellishment_class = 'with-embellishment seeds-open-large-embellishment';
} elseif ($embellishment == 'squiggles') {
  $embellishment_class = 'with-embellishment squiggles-embellishment';
} elseif ($embellishment == 'Xs') {
  $embellishment_class = 'with-embellishment xs-embellishment';
} else {
  $embellishment_class = '';
}


$section_class = '';

if ($media_column && $media_type === 'Image' && $image_type === 'Image with Embellishment') {
  if($disable_sidebar_submenu == false && $children) {
     $section_class .= ' layered-image-zone with-sidebar-submenu';
  } else {
    $section_class .= ' layered-image-zone';
  }
} elseif ($media_column && $media_type === 'Image' && $image_type === 'Standard') {
  $section_class .= ' image-media-column';
  if (!$disable_sidebar_submenu && $children) {
    $section_class .= ' image-media-column with-sidebar-submenu';
  }
} elseif ($media_column && $media_type === 'Video') {
  $section_class .= ' video-media-column';
  if (!$disable_sidebar_submenu && $children) {
    $section_class .= ' image-media-column with-sidebar-submenu';
  }
} elseif ($disable_sidebar_submenu == false && $children) {
  $section_class .= ' with-sidebar-submenu';
}


if(!$media_column) {
    $content_col_class = 'col-md-8 intro-content-col';
    $outer_content_col_class = '';
    $media_col_class = '';
} elseif($media_column && $media_type == 'Image' && $image_type == 'Image with Embellishment') {
  if($disable_sidebar_submenu == true || !$children) {
    $content_col_class = 'col-md-7 intro-content-col pb-5';
    $outer_content_col_class = '';
    $media_col_class = 'col-md-5 col-xl-4 offset-xl-1 intro-img-col';
  } else {
    $content_col_class = 'col-md-6 mb-4 mb-md-0 z-1';
    $outer_content_col_class = 'col-md-8 intro-content-col';
    $media_col_class = 'col-md-6 intro-img-col';
  }
} elseif($media_column && $media_type == 'Image' && $image_type == 'Standard' || $media_column && $media_type == 'Video' && $video_url) {
  if($disable_sidebar_submenu == true || !$children) {
    $content_col_class = 'col-md-7 intro-content-col';
    $outer_content_col_class = '';
    $media_col_class = 'col-md-5 intro-media-col mb-4 mb-lg-0';
  } else {
    $content_col_class = 'col-lg-6 z-1 ';
    $outer_content_col_class = 'col-md-8 intro-content-col';
    $media_col_class = 'col-lg-6 intro-media-col mb-4 mb-lg-0';
  }
} else {
  $content_col_class = '';
  $media_col_class = '';
  $inner_content_col_class = '';
}

?>

<!-- Intro Zone With Layered Image Zone -->
<?php if ($stylized_heading || $headline || $content || $standard_image || $layered_image || $video_url): ?>
  <section class="stylized-heading-intro-zone <?php echo $section_class . ' ' . $bg_water_color; ?> <?php if ($background_water_color != 'None'): echo $bg_water_color_position; endif; ?>">
    <div class="container-fluid">
      <div class="row flex-column-reverse flex-md-row">
        <?php if(($disable_sidebar_submenu == false && $children) && $media_column): ?>
          <div class="<?php echo $outer_content_col_class; ?> <?php echo $background_pattern_class; ?> position-relative">
            <?php if ($stylized_heading): ?>
              <span class="stylized-heading d-block text-pink font-gloss-bloom mb-4"><?php echo $stylized_heading; ?></span>
            <?php endif; ?>
            <div class="row flex-column-reverse <?php if($disable_sidebar_submenu == false && $children): ?>flex-lg-row<?php else: ?>flex-md-row<?php endif; ?>">
        <?php endif;?>
        
              <?php if ( ($stylized_heading && $disable_sidebar_submenu == true) || ($disable_sidebar_submenu == false && !$media_column) || $headline || $content): ?>
                <div class="<?php echo $content_col_class; ?> <?php if($disable_sidebar_submenu == true || $media_column == false || !$children): echo $background_pattern_class; endif; ?> position-relative">
                  <?php if ( ($stylized_heading && $disable_sidebar_submenu == true) || ($disable_sidebar_submenu == false && !$media_column) || !$children): ?>
                    <span class="stylized-heading d-block text-pink font-gloss-bloom mb-4 <?php if(!is_page('home') && ($disable_sidebar_submenu == true || !$children)):?>d-none d-md-block<?php endif; ?>"><?php echo $stylized_heading; ?></span>
                  <?php endif;
                  if ($headline): ?>
                    <h1 class="font-medium fw-bold mb-2 pb-1"><?php echo $headline; ?></h1>
                  <?php endif;
                  if ($content): ?>
                    <div class="wysiwyg-content font-regular">
                      <?php echo $content; ?>
                    </div>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
              <!-- Media Column -->
               <?php if($media_column): ?>
                <div class="<?php echo $media_col_class; ?> position-relative">
                  <?php if ((!is_page('home') && $stylized_heading && $disable_sidebar_submenu == true) || (!is_page('home') && $stylized_heading && !$children)): ?>
                    <span class="stylized-heading d-block d-md-none text-pink font-gloss-bloom mb-4"><?php echo $stylized_heading; ?></span>
                  <?php endif; ?>
                  <?php if ($media_column && $media_type == 'Image' && $image_type == 'Image with Embellishment' && $layered_image): ?>
                    <div class="image-box <?php echo $embellishment_class; ?> left-align-embellishment">
                      <img src="<?php echo esc_url($layered_image['sizes']['layered_photo']); ?>"
                        <?php if (!empty($layered_image['alt'])): ?>alt="<?php echo esc_attr($layered_image['alt']); ?>" <?php endif; ?>
                        class="img-fluid">
                    </div>
                  <?php endif;
                  if ( $media_column && $media_type === 'Image' && $image_type === 'Standard' && !empty($standard_image)): ?>
                      <div class="intro-img-col position-relative standard-image">
                        <img src="<?php echo esc_url($standard_image['sizes']['intro_photo']); ?>"
                          alt="<?php echo esc_attr($standard_image['alt'] ?? ''); ?>"
                          class="img-fluid">
                      </div>
                    <?php endif; 
                    if ( $media_column && $media_type === 'Video' && !empty($video_url) ):
                      // Extract video info
                      $thumb_image = "";
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
                      <div class="intro-video-col position-relative">
                        <div class="video-box">
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
                                <iframe title="Video"
                                  src="<?php echo esc_url($embed_src); ?>"
                                  frameborder="0"
                                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                  allowfullscreen
                                  loading="lazy"
                                  allow="autoplay"></iframe>
                              `);
                            });
                          });
                        </script>
                      </div>
                    <?php endif; ?>
                </div>
              <?php endif; ?>
        <?php if(($disable_sidebar_submenu == false && $children) && $media_column): ?>
          </div>
          </div>
        <?php endif; ?>
        <?php if(!is_page('home')):
            if($post->post_parent || $children):
                $parentTitle = get_the_title($post->post_parent);
                $thispage = $post->ID;
                $parent_id =  wp_get_post_parent_id( $post->ID );
                $parent_link = get_permalink($parent_id);
                $pageTitle = $post->post_title;
                $pagekids = get_pages('exclude=' . $exclude_list . '&depth=1&sort_column=menu_order&child_of=' . $thispage);

          ?>
            <?php if ($disable_sidebar_submenu == false): ?>
            <!-- Intro Zone With Sidebar -->
            <div class="col-md-4 sidebar-submenu-col d-none d-md-block">
                <div class="sidebar-submenu-block">
                    <?php if($pagekids) { ?>
                        <h3 class="font-medium">
                            <a href="<?php echo get_permalink(get_the_id()); ?>" class="text-decoration-none"><?php echo $pageTitle; ?></a>
                        </h3>
                        <ul class="list-unstyled mb-0">
                            <?php wp_list_pages('exclude=' . $exclude_list . '&depth=1&title_li=&sort_column=menu_order&child_of=' . $thispage); ?>
                        </ul>
                    <?php } else { ?>
                        <h3 class="font-medium">
                            <a href="<?php echo $parent_link; ?>" class="text-decoration-none"><?php echo $parentTitle; ?></a>
                        </h3>
                        <ul class="list-unstyled mb-0">
                            <?php echo wp_list_pages('exclude=' . $exclude_list . '&depth=1&title_li=&child_of=' . $post->post_parent . '&echo=0&sort_order=ASC'); ?>
                        </ul>
                    <?php } ?>
                </div>
            </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>
<?php endif; ?>