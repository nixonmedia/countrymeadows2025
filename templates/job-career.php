<?php
/*
Template Name: Job Career
*/

get_header();
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3">
            <div class="location-filters">
                <p> <strong>Filter Careers</strong></p>
                <p>Company Location</p>
                <?php echo do_shortcode('[facetwp facet="job_campus"]'); ?>
                <p>Job Category</p>
                <?php echo do_shortcode('[facetwp facet="job_family"]'); ?>
            </div>
        </div>
        <div class="col-lg-9">
            <?php echo do_shortcode('[facetwp template="job_career"]'); ?>
            <?php echo do_shortcode('[facetwp facet="jobpagination"]'); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>