<?php

    $heading =  $section['heading']['heading'] ?? "";
    //  var_dump($heading);
    $heading_style = $section['heading']['heading_style'] ?? "";
    // var_dump($heading_style);
    $background_color = $section['background_color'] ?? "";
    var_dump($background_color);
    $content        = $section['content'] ?? '';
    $button         = $section['button'] ?? '';
    $border         = $section['border'] ?? '';

?>
<section class="reviews-zone position-relative pt-5"
         style="background-color: <?php echo esc_attr($bg_color); ?>;">
    <div class="container-fluid pt-lg-4 pb-lg-5 pt-0 pb-5">
        <div class="row pb-5">
            <div class="offset-lg-1 col-lg-10 pb-4">
                <?php if ( $heading ): ?>
                    <h2 class="font-medium fw-bold mb-2 pb-1 text-center text-white">
                        <?php echo esc_html($heading); ?>
                    </h2>
                <?php endif; ?>
                <?php if ( $content ): ?>
                    <div class="review-content text-center text-white">
                        <?php echo wp_kses_post($content); ?>
                    </div>
                <?php endif; ?>
                <?php if ( $button ): ?>
                    <div class="text-center mt-4">
                        <a class="btn btn-light"
                           href="<?php echo esc_url($button['url']); ?>"
                           target="<?php echo esc_attr($button['target']); ?>">
                            <?php echo esc_html($button['title']); ?>
                        </a>
                    </div>
                <?php endif; ?>
                

                

            </div>
        </div>
    </div>
</section>

<?php 
// endif;
 ?>

<!-- <section class="reviews-zone position-relative pt-5 bg-purple">
  <div class="container-fluid pt-lg-4 pb-lg-5 pt-0 pb-5">
    <div class="row pb-5">
        <div class="offset-lg-1 col-lg-10 pb-4">
            <h2 class="font-medium fw-bold mb-2 pb-1 text-center text-white">Google Reviews about Country Meadows of Allentown</h2>
            <div class="review-slider ps-lg-4">
                <div class="bg-white p-4">
                   <div class="text-center d-flex justify-content-center pb-2">
                     <img src="<?php echo get_template_directory_uri();?>/assets/images/star.svg" alt="" class="img-fluid" alt="Star Icon">
                   </div>
                    <h3 class="text-black font-xm text-center mb-0 mb-0">Danielle Gnecco</h3>
                    <h4 class="font-xsm fw-light text-center mb-0">Posted a month ago</h4>
                    <div class="font-xs-medium pb-3">I can highly recommend Country Meadows Allentown to anyone seeking these types of services. My mother was only there for 4 months, but had to move through Independent Living...</div>
                    <a href="#" class="read-more-text text-pink fw-bold">Read More</a>
                </div>
                 <div class="bg-white p-4">
                    <div class="text-center d-flex justify-content-center pb-2">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/star.svg" alt="" class="img-fluid" alt="Star Icon">
                    </div>
                    <h3 class="text-black font-xm text-center mb-0">Kathy Matthews</h3>
                    <h4 class="font-xsm fw-light text-center mb-0">Posted 3 months ago</h4>
                    <div class="font-xs-medium pb-3">
                    I cannot recommend more highly the care, compassion and kindness of the staff and management at Country Meadows. My mother is 102 and one of the reasons she has thrived is the care she’s received....
                    </div>
                    <a href="#" class="read-more-text text-pink fw-bold">Read More</a>
                </div> 
                <div class="bg-white p-4">
                    <div class="text-center d-flex justify-content-center pb-2">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/star.svg" alt="" class="img-fluid" alt="Star Icon">
                    </div>
                    <h3 class="text-black font-xm text-center mb-0">Brian Strauss</h3>
                    <h4 class="font-xsm fw-light text-center mb-0">Posted 4 months ago</h4>
                    <div class="font-xs-medium pb-3">
                    My mom was diagnosed with the onsets of dementia about 5-6 years ago. She was living on her own but my wife and I saw her memory start to decline faster than what we used to seeing...
                    </div>
                    <a href="#" class="read-more-text text-pink fw-bold">Read More</a>
                </div> 
                <div class="bg-white p-4">
                    <div class="text-center d-flex justify-content-center pb-2">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/star.svg" alt="" class="img-fluid" alt="Star Icon">
                    </div>
                    <h3 class="text-black font-xm text-center mb-0"> Danielle Gnecco</h3>
                    <h4 class="font-xsm fw-light text-center mb-0">Posted a month ago</h4>
                    <div class="font-xs-medium pb-3">
                    I can highly recommend Country Meadows Allentown to anyone seeking these types of services. My mother was only there for 4 months, but had to move through Independent Living...
                    </div>
                    <a href="#" class="read-more-text text-pink fw-bold">Read More</a>
                </div>
            </div>
 
        </div>
    </div>
  </div>
</section> -->
