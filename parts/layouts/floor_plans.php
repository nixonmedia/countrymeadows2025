<?php

$heading = $section['heading']['headline'] ?? "";
$heading_style = $section['heading']['heading_type'] ?? "";
$content = $section['content'] ?? "";
$link = $section['link'] ?? "";
$floor_plans = $section['floor_plans'] ?? [];
$include_side_content = $section['include_side_content'];
$side_content_gp = $section['side_content'] ?? '';
$side_heading = $side_content_gp['heading']['headline'] ?? "";
$side_heading_style = $side_content_gp['heading']['heading_type'] ?? "";
$icon = $side_content_gp['icon'] ?? '';
$gp_content = $side_content_gp['content'] ?? '';
$button = $side_content_gp['button'] ?? "";
$side_content_position = $side_content_gp['side_content_position'] ?? '';
$background_color = $side_content_gp['background_color'] ?? '';
// $background_watercolor = $section['background_watercolor'];
$background_water_color = $section['background_watercolor'] ?? '';
$background_watercolor_position = $section['background_watercolor_position'] ?? '';
// var_dump($background_watercolor);
$row_classes = 'row';

if ($include_side_content && $side_content_position === 'Right') {
    $row_classes .= ' flex-row-reverse';
} else {
    $row_classes .= ' align-items-center';
}


if ($background_color == 'Blue') {
    $bg_color = 'bg-blue';
    $text_color = 'text-white';
    $heading_color = 'text-white';
} elseif ($background_color == 'Light Blue') {
    $bg_color = 'bg-light-blue';
    $text_color = 'text-black-100';
    $heading_color = 'text-black-100';
} elseif ($background_color == 'Teal') {
    $bg_color = 'bg-teal';
    $text_color = 'text-black';
    $heading_color = 'text-black';
} elseif ($background_color == 'Purple') {
    $bg_color = 'bg-purple';
    $text_color = 'text-white';
    $heading_color = 'text-white';
} elseif ($background_color == 'Gradient Yellow') {
    $bg_color = 'bg-gradient-yellow';
    $text_color = 'text-black';
    $heading_color = 'text-black';
} else {
    $bg_color = 'bg-white';
    $text_color = 'text-black';
    $heading_color = 'text-black';
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

?>
<?php if ($heading || $content || !empty($floor_plans) || ! empty($link)) :
?>
    <section id="floor-plans-zone-<?php echo get_the_ID() . '-' . $key; ?>" class="floorplan-zone allentown-section py-5  <?php if (! empty($include_side_content)) : ?>with-include-content px-0<?php endif; ?>">
        <div class="container-fluid">
            <div class="<?php echo $row_classes; ?>">
                <?php if (! empty($include_side_content)) : ?>
                    <!-- LEFT COLUMN (Side Content) -->
                    <?php if ($side_heading || $gp_content): ?>
                        <div class="col-lg-5 z-2 mb-5 mb-lg-0 full-width-left-col <?php echo $bg_color; ?>">
                            <?php if (! empty($side_heading)) : ?>
                                <?php echo $icon; ?>
                                <<?php echo $side_heading_style; ?> class="font-medium fw-bold mb-2 pb-1 font-poppins <?php echo $heading_color;  ?>">
                                    <?php echo $side_heading; ?>
                                </<?php echo $side_heading_style; ?>>
                            <?php endif; ?>

                            <?php if (! empty($gp_content)) : ?>
                                <div class="wysiwyg-content font-poppins <?php echo $text_color; ?> ">
                                    <?php echo $gp_content; ?>
                                </div>
                            <?php endif; ?>
                            <?php if (! empty($button)) : ?>
                                <div class="text-center">
                                    <a href="<?php echo esc_url($button['url']); ?>"
                                        class="font-xs-medium <?php echo $text_color; ?> fw-bold"
                                        <?php echo ! empty($button['target']) ? 'target="' . esc_attr($button['target']) . '"' : ''; ?>>
                                        <?php echo esc_html($button['title']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($heading || $content || !empty($floor_plans) || ! empty($link)): ?>
                        <div class="col-lg-7 right-floorplan-col z-2">
                            <?php if ($heading || $content): ?>
                                <div class="row mb-4">
                                    <?php if ($heading): ?>
                                        <div class="col-lg-5 col-xxl-4 left-floorplan-content mb-4 mb-lg-0">
                                            <<?php echo $heading_style; ?> class="fw-bold font-poppins dotted-underline heading"><?php echo $heading; ?> </<?php echo $heading_style; ?>>
                                        </div>
                                    <?php endif;
                                    if ($content): ?>
                                        <div class="col-lg-7 col-xxl-6">
                                            <div class="wysiwyg-content font-xs-medium font-poppins">
                                                <?php echo $content; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif;
                            if (!empty($floor_plans)): ?>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="floorplan-slider my-4 font-poppins <?php echo $bg_water_color; ?> <?php echo $bg_water_color_position; ?>">
                                            <?php foreach ($floor_plans as $post) : setup_postdata($post);
                                                $floor_plan_image = get_field('floor_plan_image', get_the_ID());
                                            ?>
                                                <div class="floor-card p-3 p-xxl-5 text-center">
                                                    <div class="floor-card-inner">

                                                        <?php if (! empty($floor_plan_image)) : ?>
                                                            <img src="<?php echo esc_url($floor_plan_image['url']); ?>"
                                                                class="img-fluid mb-2 mx-auto d-block"
                                                                alt="<?php echo esc_attr($floor_plan_image['alt'] ?? get_the_title()); ?>">
                                                        <?php endif; ?>

                                                        <p class="fw-semibold text-lg-start font-poppins mb-0 font-xs-medium">
                                                            <?php echo esc_html(get_the_title()); ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                            <?php wp_reset_postdata(); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (! empty($link)) : ?>
                                <div class="text-center z-2">
                                    <a href="<?php echo esc_url($link['url']); ?>"
                                        class="font-xs-medium text-blue fw-bold"
                                        <?php echo ! empty($link['target']) ? 'target="' . esc_attr($link['target']) . '"' : ''; ?>>
                                        <?php echo esc_html($link['title']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                <?php else : ?>
                    <?php if ($heading || $content): ?>
                        <div class="col-lg-5 my-auto">
                            <div class="row mb-4 px-0 px-lg-3">
                                <?php if ($heading): ?>
                                    <div class="col-xl-5 left-floorplan-content z-2 mb-3 mb-xl-0">
                                        <<?php echo $heading_style; ?> class="fw-bold font-poppins dotted-underline heading">
                                            <?php echo $heading; ?>
                                        </<?php echo $heading_style;  ?>>
                                    </div>
                                <?php endif;
                                if ($content || ! empty($link)): ?>
                                    <div class="col-xl-7 z-2">
                                        <div class="wysiwyg-content font-xs-medium font-poppins mb-3 mb-lg-3">
                                            <?php echo $content ?>
                                        </div>
                                        <?php if (! empty($link)) : ?>
                                            <div class="text-start">
                                                <a href="<?php echo esc_url($link['url']); ?>"
                                                    class="font-xs-medium text-blue fw-bold"
                                                    <?php echo ! empty($link['target']) ? 'target="' . esc_attr($link['target']) . '"' : ''; ?>>
                                                    <?php echo esc_html($link['title']); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (! empty($floor_plans)): ?>
                        <div class="col-lg-7">
                            <div class="floorplan-slider floorplan-sm-slider mt-4 my-md-4 font-poppins <?php echo $bg_water_color; ?>  <?php echo $bg_water_color_position; ?>">
                                <?php if (! empty($floor_plans)) : ?>
                                    <?php foreach ($floor_plans as $post) : setup_postdata($post); ?>

                                        <?php
                                        $floor_plan_image = get_field('floor_plan_image', get_the_ID());
                                        ?>

                                        <div class="floor-card p-3 p-xxl-5 text-center">
                                            <div class="floor-card-inner">

                                                <?php if (! empty($floor_plan_image)) : ?>
                                                    <img src="<?php echo esc_url($floor_plan_image['url']); ?>"
                                                        class="img-fluid mb-2 mx-auto d-block"
                                                        alt="<?php echo esc_attr($floor_plan_image['alt'] ?? get_the_title()); ?>">
                                                <?php endif; ?>

                                                <p class="fw-semibold text-lg-start font-poppins mb-0 font-xs-medium">
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
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>