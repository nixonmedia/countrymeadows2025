</main>
<?php
$footer = get_field("footer", "option");
$ecumenical_text = $footer['ecumenical_text'];
$footer_logo = $footer['footer_logo'];
$button_1 = $footer['button_1'];
$button_2 = $footer['button_2'];

?>
<footer class="site-footer bg-dark-sky-blue">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 d-none d-lg-block">
        <div class="row">
          <div class="col-lg-6 footer-post-col">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/resource-img.jpg" class="img-fluid mb-3" alt="Resources Post Image">
            <h3 class="font-lexend fw-bold font-normal mb-3 footer-post-title text-white">Check out helpful tips and information for supporting your aging loved one.</a></h3>
            <a href="#" class="small-white-button">Resources</a>
          </div>
          <div class="col-lg-6 footer-post-col">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/careers-img.jpg" class="img-fluid mb-3" alt="Resources Post Image">
            <h3 class="font-lexend fw-bold font-normal mb-3 footer-post-title text-white">Explore the many career opportunities with Country Meadows.</a></h3>
            <a href="#" class="small-white-button">Careers</a>
          </div>
        </div>
      </div>
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
            'container'      => false,
          ));
        }
        ?>

      </div>
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
        <div class="footer-images-block pt-4 pt-lg-0 d-flex gap-5 gap-lg-2 gap-xl-4 flex-wrap justify-content-center justify-content-lg-end">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/equal-housing-opportunity.svg" class="img-fluid">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/great-place-to-work.svg" class="img-fluid">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/best-place-to-work.svg" class="img-fluid">
        </div>
      </div>
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
              'container'      => false, // removes the default <div> wrapper
            ));
          }
          ?>

          <div class="copyright-content text-white font-xsm mb-4 mb-lg-0">
            <p>© <?php echo date('Y'); ?> Country Meadows Retirement Communities</p>
          </div>
        </div>
        <div class="col-lg-3">
          <ul class="footer-social-icons d-flex align-items-center justify-content-center flex-wrap gap-3 list-unstyled mb-0">
            <li><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="22" viewBox="0 0 13 22" fill="none">
                  <path d="M2.87151 12.8585V21.9965H7.91841V12.8585H11.6818L12.465 8.65683H7.91841V7.17034C7.91841 4.94921 8.80162 4.09857 11.0814 4.09857C11.7906 4.09857 12.3606 4.11575 12.6912 4.15012V0.339399C12.0691 0.171848 10.5463 0 9.66742 0C5.01644 0 2.87151 2.16958 2.87151 6.84813V8.65683H0V12.8585H2.87151Z" fill="white" />
                </svg></a></li>
            <li><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="41" height="39" viewBox="0 0 41 39" fill="none">
                  <path d="M36.9124 11.2536C36.519 9.83572 35.3387 8.72291 33.8475 8.34599C31.1506 7.65796 20.3123 7.65796 20.3123 7.65796C20.3123 7.65796 9.47398 7.65796 6.77075 8.34599C5.27953 8.72291 4.10559 9.83572 3.70582 11.2536C2.98242 13.8203 2.98242 19.169 2.98242 19.169C2.98242 19.169 2.98242 24.5176 3.70582 27.0843C4.10559 28.4962 5.27953 29.5671 6.77075 29.9441C9.47398 30.6321 20.3123 30.6321 20.3123 30.6321C20.3123 30.6321 31.1506 30.6321 33.8538 29.9441C35.345 29.5671 36.519 28.4962 36.9187 27.0843C37.6421 24.5176 37.6421 19.169 37.6421 19.169C37.6421 19.169 37.6421 13.8203 36.9187 11.2536H36.9124ZM16.7651 24.027V14.3109L25.8203 19.169L16.7651 24.027Z" fill="white" />
                </svg></a></li>
            <li><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="33" height="32" viewBox="0 0 33 32" fill="none">
                  <g clip-path="url(#clip0_70_324)">
                    <path d="M10.2477 22.2409H5.45801V7.39212H10.2477V22.2409ZM7.8503 5.36661C6.31903 5.36661 5.07648 4.14535 5.07648 2.6709C5.07648 1.96097 5.37036 1.2858 5.89109 0.784389C6.41183 0.282976 7.11818 0 7.8503 0C8.58242 0 9.28877 0.282976 9.80951 0.784389C10.3302 1.2858 10.6241 1.96594 10.6241 2.6709C10.6241 4.14535 9.38157 5.36661 7.8503 5.36661ZM28.1693 22.2409H23.3899V15.0126C23.3899 13.2899 23.3538 11.0807 20.8996 11.0807C18.4094 11.0807 18.0279 12.9524 18.0279 14.8885V22.2409H13.2433V7.39212H17.8371V9.41763H17.9041C18.5434 8.25098 20.1056 7.01979 22.4361 7.01979C27.2825 7.01979 28.1745 10.0928 28.1745 14.0843V22.2409H28.1693Z" fill="white" />
                  </g>
                  <defs>
                    <clipPath id="clip0_70_324">
                      <rect width="32.9972" height="31.7727" fill="white" />
                    </clipPath>
                  </defs>
                </svg></a></li>
            <li><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="27" height="26" viewBox="0 0 27 26" fill="none">
                  <path d="M13.1172 6.1525C9.40159 6.14123 6.38232 9.03784 6.37062 12.6164C6.35891 16.1949 9.36649 19.1027 13.0821 19.114C16.7977 19.1253 19.8169 16.2287 19.8286 12.6502C19.8403 9.07166 16.8328 6.16377 13.1172 6.1525ZM13.0821 8.42922C15.4928 8.41794 17.453 10.2945 17.4647 12.6164C17.4764 14.9382 15.5279 16.826 13.1172 16.8373C10.7064 16.8486 8.74625 14.972 8.73454 12.6502C8.72284 10.3284 10.6713 8.44049 13.0821 8.42922ZM18.5472 5.88763C18.5472 5.05358 19.2494 4.37733 20.1153 4.37733C20.9813 4.37733 21.6835 5.05358 21.6835 5.88763C21.6835 6.72168 20.9813 7.39793 20.1153 7.39793C19.2494 7.39793 18.5472 6.72168 18.5472 5.88763ZM26.1363 7.42047C26.0369 5.39735 25.5571 3.60528 24.0182 2.12879C22.4851 0.652303 20.6244 0.190196 18.5238 0.0887582C16.3588 -0.0295861 9.8697 -0.0295861 7.70471 0.0887582C5.60995 0.184561 3.74923 0.646667 2.21033 2.12315C0.671438 3.59964 0.197482 5.39171 0.0921582 7.41484C-0.0307194 9.49995 -0.0307194 15.7497 0.0921582 17.8348C0.19163 19.8579 0.671438 21.65 2.21033 23.1265C3.74923 24.6029 5.60409 25.065 7.70471 25.1665C9.8697 25.2848 16.3588 25.2848 18.5238 25.1665C20.6244 25.0707 22.4851 24.6086 24.0182 23.1265C25.5512 21.65 26.031 19.8579 26.1363 17.8348C26.2592 15.7497 26.2592 9.50559 26.1363 7.42047ZM23.3394 20.072C22.883 21.1766 21.9995 22.0275 20.8468 22.4727C19.1206 23.1321 15.0247 22.9799 13.1172 22.9799C11.2097 22.9799 7.10788 23.1265 5.3876 22.4727C4.24074 22.0332 3.35719 21.1822 2.89494 20.072C2.21033 18.4096 2.36832 14.4648 2.36832 12.6276C2.36832 10.7905 2.21618 6.84002 2.89494 5.1832C3.35134 4.07865 4.23489 3.2277 5.3876 2.7825C7.11373 2.12315 11.2097 2.27531 13.1172 2.27531C15.0247 2.27531 19.1265 2.12879 20.8468 2.7825C21.9936 3.22207 22.8772 4.07302 23.3394 5.1832C24.024 6.84566 23.866 10.7905 23.866 12.6276C23.866 14.4648 24.024 18.4152 23.3394 20.072Z" fill="white" />
                </svg></a></li>
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