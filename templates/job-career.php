<?php
/*
Template Name: Careers
*/

get_header();
get_template_part('parts/font-resize');

$hide_breadcrumb = get_field('hide_breadcrumb'); 
if($hide_breadcrumb == false): ?>
<section class="breadcrumb pt-4 d-none d-lg-block mb-0 z-2 position-relative">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<?php if(function_exists('bcn_display')) {
						bcn_display();
					}
				?>
			</div>
		</div>
	</div>
</section><!-- /.breadcrumb -->
<?php endif;
get_template_part('parts/layouts/stylized_heading_intro_zone'); ?>
<section class="job-career-section pb-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <h2 class="section-title font-medium fw-bold">Find the next career</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-xl-3">
                <div class="careers-filters">
                    <div class="d-flex justify-content-between"><h4 class="font-regular fw-bold">Search Careers</h4><a class="font-regular" href="javascript:;" onclick="FWP.reset()">Reset</a></div>
                    <?php echo do_shortcode('[facetwp facet="career_search"]');?>
                    <div class="align-items-center d-flex divider mb-4">OR</div>
                    <h4 class="font-regular fw-bold">Filter Careers <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.92812 0.00312501C5.41563 0.00312501 5 0.41875 5 0.93125C5 1.17813 5.09687 1.4125 5.27187 1.5875L9.5 5.8125V9.00313C9.5 9.20312 9.57812 9.39375 9.71875 9.53438L11.9156 11.7312C12.0906 11.9062 12.325 12.0031 12.5719 12.0031C13.0844 12.0031 13.5 11.5875 13.5 11.075V5.8125L17.7281 1.58437C17.9031 1.40937 18 1.175 18 0.928125C18 0.415625 17.5844 0 17.0719 0L5.92812 0.00312501ZM10.7812 4.97188L7.3125 1.50312H15.6906L12.2219 4.97188C12.0813 5.1125 12.0031 5.30313 12.0031 5.50313V9.69375L11.0031 8.69375V5.50313C11.0031 5.30313 10.925 5.1125 10.7844 4.97188H10.7812ZM4.56875 3.00312H0.928125C0.415625 3.00312 0 3.41875 0 3.93125C0 4.17812 0.096875 4.4125 0.271875 4.5875L4.5 8.8125V12.0031C4.5 12.2031 4.57812 12.3938 4.71875 12.5344L6.91563 14.7312C7.09063 14.9062 7.325 15.0031 7.57188 15.0031C8.08438 15.0031 8.5 14.5875 8.5 14.075V10.4156C8.17813 10.0188 8 9.51875 8 9V7.19063L7.21875 7.97188C7.07812 8.1125 7 8.30313 7 8.50313V12.6938L6 11.6938V8.50313C6 8.30313 5.92188 8.1125 5.78125 7.97188L2.3125 4.50313H6.06875L4.56875 3.00312Z" fill="#4D57E6"/>
                    </svg>
                    </h4>
                    <h6 class="font-normal fw-600">Company Location</h6>
                    <?php echo do_shortcode('[facetwp facet="job_campus"]'); ?>
                    <h6 class="font-normal fw-600">Job Category</h6>
                    <?php echo do_shortcode('[facetwp facet="job_family"]'); ?>
                </div>
                <div class="job-alert-cta mb-3 mb-md-0">
                    <h6 class="font-normal fw-600">Country Meadows Job Alerts</h6>
                    <p class="font-normal">Receive job alerts in your inbox!</p>
                    <a href="#" class="site-button">Subscribe  <svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.91875 0C0.859375 0 0 0.859375 0 1.91875C0 1.94688 0 1.97188 0.003125 2H0V10C0 11.1031 0.896875 12 2 12H14C15.1031 12 16 11.1031 16 10V2H15.9969C15.9969 1.97188 16 1.94688 16 1.91875C16 0.859375 15.1406 0 14.0813 0H1.91875ZM14.5 4.00938V10C14.5 10.275 14.275 10.5 14 10.5H2C1.725 10.5 1.5 10.275 1.5 10V4.00938L6.3375 7.67813C7.31875 8.425 8.67813 8.425 9.6625 7.67813L14.5 4.00938ZM1.5 1.91875C1.5 1.6875 1.6875 1.5 1.91875 1.5H14.0813C14.3125 1.5 14.5 1.6875 14.5 1.91875C14.5 2.05 14.4375 2.175 14.3344 2.25313L8.75625 6.48438C8.30938 6.82188 7.69063 6.82188 7.24375 6.48438L1.66562 2.25313C1.5625 2.175 1.5 2.05 1.5 1.91875Z" fill="white"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="col-md-8 col-xl-9">
                <?php echo do_shortcode('[facetwp template="job_career"]'); ?>
                <?php echo do_shortcode('[facetwp facet="job_pagination"]'); ?>
            </div>
        </div>
    </div>
</section>
<?php /*********  Flexible Content Start  ***********/
$fields = get_fields( get_the_ID() );
if ( isset( $fields['flexible_content'] ) && is_array( $fields['flexible_content'] ) ):
	foreach ( $fields['flexible_content'] as $key => $section ) :
		$template = 'parts/layouts/' . $section['acf_fc_layout'] . '.php';
		if ( $loc_template = locate_template( $template ) ) {
			include( $loc_template );
		}
	endforeach;
endif;

 get_footer(); ?>