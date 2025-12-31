<?php

$heading = $section['heading']['headline'] ?? "";
$heading_style = $section['heading']['heading_type'] ?? "";
$background_color = $section['background_color'] ?? "";
$button_cards = $section['button_cards'] ?? [];
$content = $section['content'] ?? "";
$bottom_zone_content = $section['bottom_zone_content'] ?? "";
$background_pattern = $section['background_embellishment'] ?? '';
$embellishment = $media_embellishment['embellishment'] ?? '';
$embellishment_position = $media_embellishment['embellishment_position'] ?? '';


?>

<section class="allentown-section py-5 ">
    <div class="container-fluid px-3 px-lg-0">

        <div class="row align-items-center">

            <!-- LEFT COLUMN -->
            <div class="col-lg-4 mb-5 mb-lg-0 full-width-left-col">

                <h2 class="font-medium fw-bold mb-2 pb-1 font-poppins">Our Apartments at Allentown</h2>
                <div class="wysiwyg-content font-poppins">
                    <p>Here, our residents enjoy a neighborly feeling of community living with the personalization and privacy of their own apartment in the heart of Allentown. Our apartment homes are rented on a month-to-month basis with one simple monthly bill and no large upfront fees. At our retirement community in Allentown, we offer a range of apartment styles in many configurations in each level of care.</p>


                    <p>Looking for pricing and floorplan samples? We offer customized plans tailored to the care you need. See our starting rates for our levels of care to help get a better understanding of what we offer and what’s included in our cost.</p>
                </div>

            </div>

            <!-- RIGHT COLUMN -->
            <div class="col-lg-7 right-floorplan-col">
                <div class="row mb-4 ">
                    <div class="col-lg-5 col-xl-4 left-floorplan-content">
                        <h3 class="fw-bold font-poppins heading">Explore our floor plans</h3>
                    </div>
                    <div class=" col-lg-7 col-xl-6">
                        <div class=" wysiwyg-content font-xs-medium font-poppins">
                            The all-rental, monthly starting rates for all of our campuses are based on your needs and preferences
                            and vary by campus, apartment style and level of care.
                            <a href="#">View all floor plans</a>
                        </div>
                    </div>
                </div>


                <!-- Slick Slider -->
                <div class="row">
                    <div class="col-12">
                        <div class="floorplan-slider my-4 font-poppins  bg-water-color bg-blue-water-color bg-water-color-right">

                            <!-- Card 1 -->
                            <div class="floor-card p-3 p-md-5  text-center">
                                <div class="floor-card-inner">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/floorplan_img.jpg" class="img-fluid mb-2 mx-auto d-block" alt="">
                                    <p class="fw-semibold text-lg-start font-poppins">Studio Apartment with Kitchen</p>
                                </div>
                            </div>

                            <!-- Card 2 -->
                            <div class="floor-card p-3 p-md-5  text-center">
                                <div class="floor-card-inner">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/floorplan_img.jpg" class="img-fluid mb-2 mx-auto d-block" alt="">
                                    <p class="fw-semibold text-lg-start">Alcove Apartment with Kitchen/Laundry Area</p>
                                </div>
                            </div>

                            <!-- Card 3 -->
                            <div class="floor-card p-3 p-md-5  text-center">
                                <div class="floor-card-inner">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/floorplan_img.jpg" class="img-fluid mb-2 mx-auto d-block" alt="">
                                    <p class="fw-semibold text-lg-start">One Bedroom Apartment with Kitchen/Laundry Area</p>
                                </div>
                            </div>

                            <!-- Card 4 -->
                            <div class="floor-card p-3 p-md-5  text-center">
                                <div class="floor-card-inner">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/floorplan_img.jpg" class="img-fluid mb-2 mx-auto d-block" alt="">
                                    <p class="fw-semibold text-lg-start">Premium One Bedroom</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <a href="#" class="font-xs-medium text-blue fw-bold">View our Allentown floor plans</a>
                </div>

            </div>

        </div>



        <div class="row py-5">

          <!-- RIGHT COLUMN -->
            <div class="col-lg-5 my-auto">
                <div class="row mb-4 px-0 px-lg-3">
                    <div class="col-xl-5 left-floorplan-content">
                        <h3 class="fw-bold font-poppins dotted-underline heading">Explore our floor plans</h3>
                    </div>
                    <div class=" col-xl-7">
                        <div class=" wysiwyg-content font-xs-medium font-poppins my-3 mb-lg-3">
                            <b>The all-rental, monthly </b>starting rates for all of our campuses are based on your needs and preferences and vary by campus, apartment style and level of care. 
                        </div>
                        
                <div class="text-start">
                    <a href="#" class="font-xs-medium text-blue fw-bold">View all floor plans by community</a>
                </div>
                    </div>
                </div>

            </div>


                <!-- Slick Slider -->
              
                    <div class="col-lg-7">
                        <div class="floorplan-slider floorplan-sm-slider my-4 font-poppins bg-water-color bg-blue-water-color bg-water-color-left">

                            <!-- Card 1 -->
                            <div class="floor-card p-3 p-md-5  text-center">
                                <div class="floor-card-inner">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/floorplan_img.jpg" class="img-fluid mb-2 mx-auto d-block" alt="">
                                    <p class="fw-semibold text-lg-start font-poppins">Studio Apartment with Kitchen</p>
                                </div>
                            </div>

                            <!-- Card 2 -->
                            <div class="floor-card p-3 p-md-5  text-center">
                                <div class="floor-card-inner">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/floorplan_img.jpg" class="img-fluid mb-2 mx-auto d-block" alt="">
                                    <p class="fw-semibold text-lg-start">Alcove Apartment with Kitchen/Laundry Area</p>
                                </div>
                            </div>

                            <!-- Card 3 -->
                            <div class="floor-card p-3 p-md-5  text-center">
                                <div class="floor-card-inner">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/floorplan_img.jpg" class="img-fluid mb-2 mx-auto d-block" alt="">
                                    <p class="fw-semibold text-lg-start">One Bedroom Apartment with Kitchen/Laundry Area</p>
                                </div>
                            </div>

                            <!-- Card 4 -->
                            <div class="floor-card p-3 p-md-5  text-center">
                                <div class="floor-card-inner">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/floorplan_img.jpg" class="img-fluid mb-2 mx-auto d-block" alt="">
                                    <p class="fw-semibold text-lg-start">Premium One Bedroom</p>
                                </div>
                            </div>
                        </div>
                  
             


            </div>

        </div>



    </div>
</section>