<?php

$heading = $section['heading']['headline'] ?? "";
$heading_style = $section['heading']['heading_type'] ?? "";
$content = $section['content'] ?? "";
$link = $section['link'] ?? "";
$floor_plans = $section['floor_plans'] ?? "";
$include_side_content = $section['include_side_content'];
$side_content_gp = $section['side_content'];
$side_heading = $side_content_gp['heading']['headline'] ?? "";
$side_heading_style = $side_content_gp['heading']['heading_type'] ?? "";
$icon = $side_content_gp['icon'];
$gp_content = $side_content_gp['content'];
$button = $side_content_gp['button'];
$side_content_position = $side_content_gp['side_content_position'] ?? '';
$row_classes = 'row';

if ($include_side_content && $side_content_position === 'Right') {
    $row_classes .= ' flex-row-reverse px-3 px-lg-0';
} else {    
    $row_classes .= ' align-items-center';
}
?>

<section class="floorplan-zone allentown-section py-5 ">
    <div class="container-fluid px-3 px-lg-0">
        <div class="<?php echo $row_classes; ?>">
            <?php if (! empty($include_side_content)) : ?>
                <!-- LEFT COLUMN (Side Content) -->
                <div class="col-lg-4 mb-5 mb-lg-0 full-width-left-col">
                    <?php if (! empty($side_heading)) : ?>
                        <?php echo $icon; ?>
                        <<?php echo $side_heading_style; ?>> class="font-medium fw-bold mb-2 pb-1 font-poppins">
                            <?php echo $side_heading; ?>
                        </<?php echo $side_heading_style; ?>>

                    <?php endif; ?>

                    <?php if (! empty($gp_content)) : ?>
                        <div class="wysiwyg-content font-poppins">
                            <?php echo wp_kses_post($gp_content); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- RIGHT COLUMN (Full Floorplan Layout) -->
                <div class="col-lg-7 right-floorplan-col">
                    <div class="row mb-4">
                        <div class="col-lg-5 col-xl-4 left-floorplan-content">
                            <h3 class="fw-bold font-poppins heading"><?php echo $heading; ?> </h3>
                        </div>
                        <div class="col-lg-7 col-xl-6">
                            <div class="wysiwyg-content font-xs-medium font-poppins">
                                <?php echo $content; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="floorplan-slider my-4 font-poppins bg-water-color bg-blue-water-color bg-water-color-right">
                                <!-- Cards -->
                                <?php
                                $floor_plans = $section['floor_plans'] ?? [];
                                ?>

                                <?php if (! empty($floor_plans)) : ?>
                                    <?php foreach ($floor_plans as $post) : setup_postdata($post); ?>

                                        <?php
                                        $floor_plan_image = get_field('floor_plan_image', get_the_ID());
                                        ?>

                                        <div class="floor-card p-3 p-md-5 text-center">
                                            <div class="floor-card-inner">

                                                <?php if (! empty($floor_plan_image)) : ?>
                                                    <img src="<?php echo esc_url($floor_plan_image['url']); ?>"
                                                        class="img-fluid mb-2 mx-auto d-block"
                                                        alt="<?php echo esc_attr($floor_plan_image['alt'] ?? get_the_title()); ?>">
                                                <?php endif; ?>

                                                <p class="fw-semibold text-lg-start font-poppins">
                                                    <?php echo esc_html(get_the_title()); ?>
                                                </p>

                                            </div>
                                        </div>

                                    <?php endforeach; ?>
                                    <?php wp_reset_postdata(); ?>
                                <?php endif; ?>


                            </div>
                        </div>
                    </div>

                    <?php if (! empty($link)) : ?>
                        <div class="text-center">
                            <a href="<?php echo esc_url($link['url']); ?>"
                                class="font-xs-medium text-blue fw-bold"
                                <?php echo ! empty($link['target']) ? 'target="' . esc_attr($link['target']) . '"' : ''; ?>>
                                <?php echo esc_html($link['title']); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

            <?php else : ?>

                <!-- LEFT COLUMN (Intro Content) -->
                <div class="col-lg-5 my-auto">
                    <div class="row mb-4 px-0 px-lg-3">
                        <div class="col-xl-5 left-floorplan-content">
                            <h3 class="fw-bold font-poppins dotted-underline heading">
                                <?php echo $heading; ?>
                            </h3>
                        </div>
                        <div class="col-xl-7">
                            <div class="wysiwyg-content font-xs-medium font-poppins my-3 mb-lg-3">
                                <?php echo $content ?>
                            </div>
                            <!-- <div class="text-start">
                                <a href="#" class="font-xs-medium text-blue fw-bold">
                                    View all floor plans by community
                                </a>
                            </div> -->
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN (Small Slider Only) -->
                <div class="col-lg-7">
                    <div class="floorplan-slider floorplan-sm-slider my-4 font-poppins bg-water-color bg-blue-water-color bg-water-color-left">
                        <?php
                        $floor_plans = $section['floor_plans'] ?? [];
                        ?>

                        <?php if (! empty($floor_plans)) : ?>
                            <?php foreach ($floor_plans as $post) : setup_postdata($post); ?>

                                <?php
                                $floor_plan_image = get_field('floor_plan_image', get_the_ID());
                                ?>

                                <div class="floor-card p-3 p-md-5 text-center">
                                    <div class="floor-card-inner">

                                        <?php if (! empty($floor_plan_image)) : ?>
                                            <img src="<?php echo esc_url($floor_plan_image['url']); ?>"
                                                class="img-fluid mb-2 mx-auto d-block"
                                                alt="<?php echo esc_attr($floor_plan_image['alt'] ?? get_the_title()); ?>">
                                        <?php endif; ?>

                                        <p class="fw-semibold text-lg-start font-poppins">
                                            <?php echo esc_html(get_the_title()); ?>
                                        </p>

                                    </div>
                                </div>

                            <?php endforeach; ?>
                            <?php wp_reset_postdata(); ?>
                        <?php endif; ?>

                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>