<?php $video_url = $section['video'] ?? '';  ?>
<section class="custom-columns-zone with-media with-video-media bg-water-color bg-pink-water-color">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-5 d-none">
        <?php 
        if($video_url): 
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
      </div>
      <div class="col-lg-5 pe-lg-5">
        <div class="video-box with-embellishment seeds-embellishment left-align-embellishment">
          <div class="embed-responsive embed-responsive-16by9 video-wrapper position-relative">
            <span class="play-icon">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/play-icon.svg" alt="Play Video">
            </span>
            <div class="video-image" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/video-thumb.svg');">
              <div class="video-player"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-7 pt-4 custom-columns-content-col">
        <h2 class="font-medium font-lexend">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</h2>
        <div class="wysiwyg-content font-lexend">
          <p>Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing, commodo quis, gravida id, est. Sed lectus. Praesent elementum hendrerit tortor. Sed semper lorem at felis. Vestibulum volutpat, lacus a ultrices sagittis, mi neque euismod dui, eu pulvinar nunc sapien ornare nisl. Phasellus pede arcu, dapibus eu, fermentum et, dapibus sed, urna.</p>
          <a href="#" class="wysiwyg-button">Our Services</a>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="custom-columns-zone with-media with-video-media with-embellishment bg-teal">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-5 pe-lg-5">
        <div class="video-box with-embellishment seeds-embellishment left-align-embellishment">
          <div class="embed-responsive embed-responsive-16by9 video-wrapper position-relative">
            <span class="play-icon">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/play-icon.svg" alt="Play Video">
            </span>
            <div class="video-image" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/video-thumb.svg');">
              <div class="video-player"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-7 pt-4 custom-columns-content-col">
        <h2 class="font-medium font-lexend">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</h2>
        <div class="wysiwyg-content font-lexend">
          <p>Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing, commodo quis, gravida id, est. Sed lectus. Praesent elementum hendrerit tortor. Sed semper lorem at felis. Vestibulum volutpat, lacus a ultrices sagittis, mi neque euismod dui, eu pulvinar nunc sapien ornare nisl. Phasellus pede arcu, dapibus eu, fermentum et, dapibus sed, urna.</p>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="custom-columns-zone with-media with-image-media with-embellishment bg-water-color bg-yellow-water-color">
  <div class="container-fluid">
    <div class="row flex-lg-row-reverse">
      <div class="col-lg-5 ps-lg-5 text-end">
        <div class="with-embellishment circles-embellishment left-align-embellishment">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/video-thumb.svg" alt="Two col image" class="img-fluid">
        </div>
      </div>
      <div class="col-lg-7 pt-4 custom-columns-content-col">
        <h2 class="font-medium font-lexend">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</h2>
        <div class="wysiwyg-content font-lexend">
          <p>Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing, commodo quis, gravida id, est. Sed lectus. Praesent elementum hendrerit tortor. Sed semper lorem at felis. Vestibulum volutpat, lacus a ultrices sagittis, mi neque euismod dui, eu pulvinar nunc sapien ornare nisl. Phasellus pede arcu, dapibus eu, fermentum et, dapibus sed, urna.</p>
          <a href="#" class="wysiwyg-button">Our Services</a>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="custom-columns-zone with-media with-video-media with-embellishment bg-purple">
  <div class="container-fluid">
    <div class="row flex-lg-row-reverse">
      <div class="col-lg-5 ps-lg-5">
        <div class="video-box">
          <div class="embed-responsive embed-responsive-16by9 video-wrapper position-relative">
            <span class="play-icon">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/play-icon.svg" alt="Play Video">
            </span>
            <div class="video-image" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/video-thumb.svg');">
              <div class="video-player"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-7 pt-4">
        <h2 class="font-medium font-lexend text-white">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</h2>
        <div class="wysiwyg-content font-lexend text-white">
          <p>Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing, commodo quis, gravida id, est. Sed lectus. Praesent elementum hendrerit tortor. Sed semper lorem at felis. Vestibulum volutpat, lacus a ultrices sagittis, mi neque euismod dui, eu pulvinar nunc sapien ornare nisl. Phasellus pede arcu, dapibus eu, fermentum et, dapibus sed, urna.</p>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="custom-columns-zone with-meet-our-team">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-7 meet-team-info-col">
        <div class="meet-team-block with-emblishment bg-pink">
          <h2 class="font-medium font-lexend mb-lg-4">Meet our Advisors</h2>
          <div class="meet-team-slider">
            <div>
              <div class="row">
                <div class="col-lg-4 team-img-col">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/team-img.jpg" alt="Team Image" class="img-fluid">
                  <a href="#" class="meet-team-button">Speak to our Allentown Advisors</a>
                </div>
                <div class="col-lg-8 team-content-col">
                  <h3 class="text-pink font-xm">Martie Haller</h3>
                  <div class="wysiwyg-content">
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh viverra non semper suscipit posuere a pede.</p>
                    <p>Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet orci. Aenean dignissim pellentesque felis.</p>
                    <p>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi euismod in pharetra a ultricies in diam. Sed arcu. Cras consequat.</p>
                  </div>
                </div>
              </div>
            </div>
            <div>
              <div class="row">
                <div class="col-lg-4 team-img-col">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/team-img.jpg" alt="Team Image" class="img-fluid">
                  <a href="#" class="meet-team-button">Speak to our Allentown Advisors</a>
                </div>
                <div class="col-lg-8 team-content-col">
                  <h3 class="text-pink font-xm">Martie Haller</h3>
                  <div class="wysiwyg-content">
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh viverra non semper suscipit posuere a pede.</p>
                    <p>Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet orci. Aenean dignissim pellentesque felis.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-5 events-info-col">
        <h2 class="font-medium font-lexend heading-with-icon">Upcoming Allentown Events <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/calendar-icon.svg" class="img-fluid"></h2>
        <div class="wysiwyg-content font-lexend">
          <p>From open houses and wine and cheese tastings to art classes and educational series, we welcome anyone to join our community programs. Feel free to contact our Allentown team about any events or activities you are interested in at <Allentown@CountryMeadows.com. href="mailto:Allentown@CountryMeadows.com">Allentown@CountryMeadows.com</a>. Hope to see you soon!</p>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="custom-columns-zone with-media with-image-media with-embellishment bg-blue">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-lg-4 offset-lg-1 pe-lg-5">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/senior-lady-img.jpg" alt="Two col image" class="img-fluid">
      </div>
      <div class="col-lg-7">
        <h2 class="font-medium font-lexend text-white">Independent Living for Seniors</h2>
        <div class="wysiwyg-content font-lexend text-white">
          <p>Our independent senior living apartments let active older adults concentrate on living without the burdens of home ownership. With the ease of apartment living, available transportation to appointments and shopping, meals offered each day, weekly housekeeping and 24-hour access to staff, senior independent living communities are for seniors who want to make the most of retirement life on their own terms.</p>
          <a href="#" class="wysiwyg-button">More about Independent Living</a>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="custom-columns-zone with-media with-image-media with-embellishment bg-blue">
  <div class="container-fluid">
    <div class="row align-items-center flex-lg-row-reverse">
      <div class="col-lg-4 pe-lg-5">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/senior-living-communities-img.jpg" alt="Two col image" class="img-fluid">
      </div>
      <div class="col-lg-7 offset-lg-1 pe-lg-5">
        <div class="mb-2 text-center">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/alerts-stop-sign-icon.svg" class="img-fluid" alt="Alerts Stop Sign Icon">
        </div>
        <h2 class="font-medium font-lexend text-white">If you’re just starting to consider senior living communities or preparing to make a move soon, let us help.</h2>
        <div class="wysiwyg-content font-lexend text-white">
          <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.</p>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="custom-columns-zone with-media with-image-media with-embellishment bg-light-blue">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-4 pe-lg-4">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/video-thumb.svg" alt="Two col image" class="img-fluid">
      </div>
      <div class="col-lg-7 ps-lg-5 pt-4 mt-2">
        <h2 class="font-medium font-lexend text-black-100">Hospice & Aging in Place</h2>
        <div class="wysiwyg-content font-lexend text-black-100">
          <p>Suspendisse mauris. Fusce accumsan mollis eros. Pellentesque a diam sit amet mi ullamcorper vehicula. Integer adipiscing risus a sem. Nullam quis massa sit amet nibh viverra malesuada. Nunc sem lacus, accumsan quis, faucibus non, congue vel, arcu. Ut scelerisque hendrerit tellus. Integer sagittis. Vivamus a mauris eget arcu gravida tristique. Nunc iaculis mi in ante. Vivamus imperdiet nibh feugiat est.</p>
          <a href="#" class="wysiwyg-button">About Lifesong Hospice</a>
        </div>
      </div>
    </div>
  </div>
</section>
