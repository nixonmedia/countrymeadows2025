<?php
/*
Template Name: Resources
*/
?>
<?php get_header(); ?>
<section class="stylized-heading-intro-zone resources-intro-zone bg-light-blue py-5">
    <div class="container-fluid">
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
      <div class="row">
        <div class="col-lg-6 pe-lg-5 mb-4 mb-lg-0">
            <span class="stylized-heading d-block text-pink font-gloss-bloom mb-4">Advice</span>
            <h1 class="font-medium fw-bold mb-2 pb-1">Resource Center</h1>
            <div class="wysiwyg-content font-regular mb-4">
              <p>We have created our Resource Center for you. This is a place where you will find answers to your questions or concerns about senior living and aging loved ones. We hope that these research-based resources will help you learn how best to care for loved ones, what to look for when it’s time to look for senior living options, and prepare you to make the decision that’s right for you and your family.</p>
            </div>
            <a href="#" class="site-button">Have a question?</a>
        </div>
        <div class="col-lg-6 align-self-end mb-lg-4 position-relative">
          <div class="search-box-block bg-blue">
            <h3 class="font-medium text-white mb-3 mb-lg-4">What can we help you find?</h3>
            <div class="d-md-flex">
                <!-- Search Facet Shortcode -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<section class="py-5 git">
    <div class="container-fluid">
        <div class="row justify-content-center mb-5">
            <div class="col-12 text-center mb-4">
                <h2 class="fw-bold font-xl">Helpful Topics</h2>
                <div class="underline mx-auto"></div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-5 px-4 px-4">
                        <div class="topic-card">
                            <div class="upper-content d-flex flex-column justify-content-center align-items-center">
                                <a href="">
                                    <h5 class="text-blue fw-bold text-capitalize has-arrow position-relative">Assisted Living</h5>
                                </a>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Disability-Sit-Cane-Streamline-Freehand-Duotone.png" class="">

                            </div>
                            <div class="below-content p-3">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/family.png  " class="">
                                <div>
                                    <p class="text-blue mb-0">Latest Resource</p>
                                    <p class="mb-0">Is Personal Care or Assisted Living right for me or my loved one?</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-5 px-4 px-4">
                        <div class="topic-card">
                            <div class="upper-content d-flex flex-column justify-content-center align-items-center">
                                <a href="">
                                    <h5 class="text-blue fw-bold text-capitalize has-arrow position-relative">Family & Caregivers</h5>
                                </a>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Disability-Sit-Cane-Streamline-Freehand-Duotone.png" class="" alt="">

                            </div>
                            <div class="below-content p-3">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/family.png" class="" alt="">
                                <div>
                                    <p class="text-blue mb-0">Family & Caregivers</p>
                                    <p class="mb-0">Is Personal Care or Assisted Living right for me or my loved one?</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-5 px-4 px-4">
                        <div class="topic-card">
                            <div class="upper-content d-flex flex-column justify-content-center align-items-center">
                                <a href="">
                                    <h5 class="text-blue fw-bold text-capitalize has-arrow position-relative">Health & Wellness</h5>
                                </a>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Disability-Sit-Cane-Streamline-Freehand-Duotone.png" class="">

                            </div>
                            <div class="below-content p-3">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/family.png" class="">
                                <div>
                                    <p class="text-blue mb-0">Latest Resource</p>
                                    <p class="mb-0">Is Personal Care or Assisted Living right for me or my loved one?</p>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-6 col-lg-4 mb-5 px-4 px-4">
                        <div class="topic-card">
                            <div class="upper-content d-flex flex-column justify-content-center align-items-center">
                                <a href="">
                                    <h5 class="text-blue fw-bold text-capitalize has-arrow position-relative">Finances</h5>
                                </a>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Adoptation_Family.png" class="">

                            </div>
                            <div class="below-content p-3">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/family.png" class="">
                                <div>
                                    <p class="text-blue mb-0">Latest Resource</p>
                                    <p class="mb-0">Is Personal Care or Assisted Living right for me or my loved one?</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-5 px-4 px-4">
                        <div class="topic-card">
                            <div class="upper-content d-flex flex-column justify-content-center align-items-center">
                                <a href="">
                                    <h5 class="text-blue fw-bold text-capitalize has-arrow position-relative">Finances</h5>
                                </a>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Disability-Sit-Cane-Streamline-Freehand-Duotone.png" class="">

                            </div>
                            <div class="below-content p-3">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/family.png" class="">
                                <div>
                                    <p class="text-blue mb-0">Latest Resource</p>
                                    <p class="mb-0">Is Personal Care or Assisted Living right for me or my loved one?</p>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-6 col-lg-4 mb-5 px-4 px-4">
                        <div class="topic-card">
                            <div class="upper-content d-flex flex-column justify-content-center align-items-center">
                                <a href="">
                                    <h5 class="text-blue fw-bold text-capitalize has-arrow position-relative">Finances</h5>
                                </a>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Disability-Sit-Cane-Streamline-Freehand-Duotone.png" class="">

                            </div>
                            <div class="below-content p-3">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/family.png" class="">
                                <div>
                                    <p class="text-blue mb-0">Independent Living</p>
                                    <p class="mb-0">Is Personal Care or Assisted Living right for me or my loved one?</p>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-6 col-lg-4 mb-5 px-4 px-4">
                        <div class="topic-card">
                            <div class="upper-content d-flex flex-column justify-content-center align-items-center">
                                <a href="">
                                    <h5 class="text-blue fw-bold text-capitalize has-arrow position-relative">Finances</h5>
                                </a>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Disability-Sit-Cane-Streamline-Freehand-Duotone.png" class="">

                            </div>
                            <div class="below-content p-3">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/family.png" class="">
                                <div>
                                    <p class="text-blue mb-0">Let’s Get Started...</p>
                                    <p class="mb-0">Is Personal Care or Assisted Living right for me or my loved one?</p>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-6 col-lg-4 mb-5 px-4 px-4">
                        <div class="topic-card">
                            <div class="upper-content d-flex flex-column justify-content-center align-items-center">
                                <a href="">
                                    <h5 class="text-blue fw-bold text-capitalize has-arrow position-relative">Finances</h5>
                                </a>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Disability-Sit-Cane-Streamline-Freehand-Duotone.png" class="">

                            </div>
                            <div class="below-content p-3">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/family.png" class="">
                                <div>
                                    <p class="text-blue mb-0">Lifestyle</p>
                                    <p class="mb-0">Is Personal Care or Assisted Living right for me or my loved one?</p>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-6 col-lg-4 mb-5 px-4 px-4">
                        <div class="topic-card">
                            <div class="upper-content d-flex flex-column justify-content-center align-items-center">
                                <a href="">
                                    <h5 class="text-blue fw-bold text-capitalize has-arrow position-relative">Finances</h5>
                                </a>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Disability-Sit-Cane-Streamline-Freehand-Duotone.png" class="">

                            </div>
                            <div class="below-content p-3">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/family.png" class="">
                                <div>
                                    <p class="text-blue mb-0">Memory Care</p>
                                    <p class="mb-0">Is Personal Care or Assisted Living right for me or my loved one?</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>
</section>



<?php get_footer(); ?>