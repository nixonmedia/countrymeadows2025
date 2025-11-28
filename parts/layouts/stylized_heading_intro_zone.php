<?php
$stylized_heading = get_field("stylized_heading");
$intro = get_field("intro");
$headline = $intro['headline'] ?? "";
$content = $intro['content'] ?? "";
$background_pattern = $intro['background_pattern'] ?? " ";
$background_watercolor = $intro['background_watercolor'] ?? " ";
$media_column = $intro['media_column'] ?? " ";
$media_type = $intro['media_type'] ?? " ";
$image_type = $intro['image_type'] ?? " ";
$standard_image = $intro['standard_image'] ?? " ";
$layered_image_zone = $intro['layered_image_zone'] ?? "";
$layered_image = $layered_image_zone['image'] ?? " ";
$embellishment =  $layered_image_zone['embellishment'] ?? " ";
$video_url = $intro['video_url'] ?? " ";
$hide_breadcrumb = get_field("hide_breadcrumb");
$hide_sidebar_navigation = get_field("hide_sidebar_navigation");
$disable_sidebar_submenu = get_field("disable_sidebar_submenu");
$help_tool = get_field("help_tool");
$disable_help_too = get_field("disable_help_too");


// Check if standard image should be shown
$show_layered_image = $media_column && $media_type == 'Image' && $image_type == 'Image with Embellishment' && $layered_image;


// Set background pattern class
if ($background_pattern == 'Dots') {
  $background_pattern_class = 'dots-background-pattern';
} if ($background_pattern == 'Circles') {
  $background_pattern_class = 'circles-background-pattern';
} if ($background_pattern == 'Honeycomb') {
  $background_pattern_class = 'honeycomb-background-pattern';
} if ($background_pattern == 'Sprinkles') {
  $background_pattern_class = 'sprinkles-background-pattern';
} else {
  $background_pattern_class = '';
}


$color = $intro['background_watercolor'] ?? '';

$background_watercolor = "bg-water-color"; // common class

if ($color === "Blue") {
    $background_watercolor .= " bg-blue-water-color";
} elseif ($color === "Pink") {
    $background_watercolor .= " bg-pink-water-color";
} elseif ($color === "Yellow") {
    $background_watercolor .= " bg-yellow-water-color";
}



$section_class = '';

if ($media_column && $media_type === 'Image' && $image_type === 'Image with Embellishment') {
  $section_class .= ' layered-image-zone';
} elseif($media_column && $media_type === 'Image' && $image_type === 'Standard' ) {
  $section_class .= ' image-media-column';
  if(!$disable_sidebar_submenu) {
    $section_class .= ' image-media-column with-sidebar-submenu';
  }
} elseif($media_column && $media_type === 'Video' ) {
  $section_class .= ' video-media-column';
  if(!$disable_sidebar_submenu) {
    $section_class .= ' image-media-column with-sidebar-submenu';
  }
} elseif($disable_sidebar_submenu == false) {
  $section_class .= ' with-sidebar-submenu';
}
?>


<!-- Intro Zone With Layered Image Zone -->
<?php if ($stylized_heading || $headline || $content): ?>
  <section class="stylized-heading-intro-zone <?php echo $section_class . ' ' . $background_watercolor; ?>" >
    <div class="container-fluid">
      <div class="row flex-column-reverse flex-lg-row">
        <!-- show if image type Image with Embellishment home page  -->
        <?php if ($media_column && $media_type == 'Image' && $image_type == 'Image with Embellishment'): ?>
          <div class="col-lg-7 intro-content-col pb-5 with-background-pattern <?php echo $background_pattern_class; ?> position-relative">
            <?php if ($stylized_heading): ?>
              <span class="stylized-heading d-block text-pink font-gloss-bloom mb-4"><?php echo $stylized_heading; ?></span>
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

        <!-- show if media type image or video allentown page  -->
        <?php

        // Determine the column class based on conditions
        $col_class = 'col-lg-7';

        $show_media_col = $media_column &&
          (
            ($media_type === 'Image' && $image_type === 'Standard') ||
            $media_type === 'Video'
          ) &&
          $image_type !== 'Image with Embellishment';

        if ($show_media_col && !$disable_sidebar_submenu) {
          $col_class = 'col-lg-8';
        }
        ?>

        <?php if ($show_media_col): ?>

          <?php if ($col_class === 'col-lg-7'): ?>
            <!-- Layout when col-lg-7, no row, 7 + 5 columns -->
            <div class=" <?php echo esc_attr($col_class); ?> intro-content-col position-relative with-background-pattern <?php echo esc_attr($background_pattern_class); ?>">
              <?php if ($stylized_heading): ?>
                <span class="stylized-heading d-block text-pink font-gloss-bloom mb-4"><?php echo $stylized_heading; ?></span>
              <?php endif; ?>

              <div>
                <?php if ($headline): ?>
                  <h1 class="font-medium fw-bold mb-2 pb-1"><?php echo $headline; ?></h1>
                <?php endif; ?>

                <?php if ($content): ?>
                  <div class="wysiwyg-content font-regular">
                    <?php echo $content; ?>
                  </div>
                <?php endif; ?>
              </div>
            </div> <!-- close col-lg-7 -->

            <div class="col-lg-5 intro-media-col position-relative with-background-pattern <?php echo esc_attr($background_pattern_class); ?>">
              <!-- MEDIA LOGIC HERE -->

              <?php
              // IMAGE BLOCK — SHOW ONLY IF Image Standard
              if (
                $media_column &&
                $media_type === 'Image' &&
                $image_type === 'Standard' &&
                !empty($standard_image)
              ): ?>
                <div class="intro-img-col position-relative standard-image">
                  <img src="<?php echo esc_url($standard_image['url']); ?>"
                    alt="<?php echo esc_attr($standard_image['alt'] ?? ''); ?>"
                    class="img-fluid">
                </div>
              <?php endif; ?>

              <?php
              // VIDEO BLOCK — SHOW ONLY IF VIDEO
              if (
                $media_column &&
                $media_type === 'Video' &&
                !empty($video_url)
              ):

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


                </div>

              <?php endif; ?>
            </div> <!-- close col-lg-5 -->

          <?php else: ?>
            <!-- Layout when col-lg-8 (or others), with row and 2x col-lg-6 columns -->
            <div class=" <?php echo esc_attr($col_class); ?> intro-content-col position-relative with-background-pattern <?php echo esc_attr($background_pattern_class); ?>">
              <?php if ($stylized_heading): ?>
                <span class="stylized-heading d-block text-pink font-gloss-bloom mb-4"><?php echo $stylized_heading; ?></span>
              <?php endif; ?>

              <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                  <?php if ($headline): ?>
                    <h1 class="font-medium fw-bold mb-2 pb-1"><?php echo $headline; ?></h1>
                  <?php endif; ?>

                  <?php if ($content): ?>
                    <div class="wysiwyg-content font-regular">
                      <?php echo $content; ?>
                    </div>
                  <?php endif; ?>
                </div>

                <div class="col-lg-6 intro-media-col position-relative with-background-pattern <?php echo esc_attr($background_pattern_class); ?>">
                  <!-- MEDIA LOGIC HERE -->

                  <?php
                  // IMAGE BLOCK — SHOW ONLY IF Image Standard
                  if (
                    $media_column &&
                    $media_type === 'Image' &&
                    $image_type === 'Standard' &&
                    !empty($standard_image)
                  ): ?>
                    <div class="intro-img-col position-relative standard-image">
                      <img src="<?php echo esc_url($standard_image['sizes']['intro_photo']); ?>"
                        alt="<?php echo esc_attr($standard_image['alt'] ?? ''); ?>"
                        class="img-fluid">

                    </div>
                  <?php endif; ?>

                  <?php
                  // VIDEO BLOCK — SHOW ONLY IF VIDEO
                  if (
                    $media_column &&
                    $media_type === 'Video' &&
                    !empty($video_url)
                  ):

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


                    </div>

                  <?php endif; ?>

                </div> <!-- close col-lg-6 intro-media-col -->

              </div> <!-- close row -->

            </div> <!-- close allentownpage -->

          <?php endif; ?>

        <?php endif; ?>


        <!-- Intro Zone No Media Column With Sidebar Community page  -->
        <?php if (!$media_column):
          $col_class = 'col-lg-12'; // default
          if (!$media_column && !$disable_sidebar_submenu) {
            $col_class = 'col-lg-8';
          }
        ?>
          <div class=" <?php echo esc_attr($col_class); ?> intro-content-col with-background-pattern <?php echo esc_attr($background_pattern_class); ?> position-relative">
            <?php if ($stylized_heading): ?>
              <span class="stylized-heading d-block text-pink font-gloss-bloom mb-4"><?php echo $stylized_heading; ?></span>
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

        <!-- Home page show if image type Image with Embellishment image home page  -->
        <?php if ($show_layered_image): ?>
          <div class="col-lg-5 col-xl-4 offset-xl-1 intro-img-col position-relative">
            <img src="<?php echo esc_url($layered_image['sizes']['layered_photo']); ?>"
              <?php if (!empty($layered_image['alt'])): ?>alt="<?php echo esc_attr($layered_image['alt']); ?>" <?php endif; ?>
              class="img-fluid">
          </div>
        <?php endif; ?>
        <!-- Intro Zone No Media Column With Sidebar -->
        <?php if (!$media_column && !$disable_sidebar_submenu): ?>
          <div class="col-lg-4 sidebar-submenu-col d-none d-lg-block">
            <div class="sidebar-submenu-block">
              <h3 class="font-medium">Communities</h3>
              <ul class="list-unstyled mb-0">
                <li><a href="#">Allentown</a></li>
                <li><a href="#">Bethlehem</a></li>
                <li><a href="#">Forks of Easton</a></li>
                <li><a href="#">Frederick</a></li>
                <li><a href="#">Hershey</a></li>
                <li><a href="#">Mechanicsburg</a></li>
                <li><a href="#">Wyomissing</a></li>
                <li><a href="#">York-South</a></li>
                <li><a href="#">York-West</a></li>
              </ul>
            </div>
          </div>
        <?php endif; ?>

        <!-- Intro Zone Media (Standard plus video) Column With Sidebar -->
        <?php
        if (
          $media_column &&
          !$disable_sidebar_submenu &&
          !($media_type === 'Image' && $image_type === 'Image with Embellishment')
        ):
        ?>

          <div class="col-lg-4 sidebar-submenu-col d-none d-lg-block video with iamge">
            <div class="sidebar-submenu-block">
              <h3 class="font-medium">Allentown</h3>
              <ul class="list-unstyled mb-0">
                <li><a href="#">Allentown Services</a></li>
                <li><a href="#">Pricing</a></li>
                <li><a href="#">Floor Plans</a></li>
                <li><a href="#">Community Gallery</a></li>
                <li><a href="#">Events</a></li>
                <li><a href="#">Download a Brochure</a></li>
                <li><a href="#">Speak to an Expert Advisor</a></li>
                <li><a href="#">Schedule a Personalized Visit</a></li>
                <li><a href="#">Contact and Directions</a></li>
              </ul>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
<?php endif; ?>
