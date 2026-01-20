<?php
$heading = $section['heading'] ?? '';
$headline = $heading['headline'] ?? '';
$heading_type = $heading['heading_type'] ?? '';
$background_color  = $section['background_color'] ?? '';
$content        = $section['content'] ?? "";
$form_position = $section['form_position'] ?? '';
$form_heading_gp = $section['form_heading'] ?? [];
// Go one level deeper
$heading_group   = $form_heading_gp['heading'] ?? [];
$form_headline       = $heading_group['headline'] ?? '';
$form_heading_type   = $heading_group['heading_type'];


$form = $section['form'] ?? '';
$icon = $section['icon'] ?? '';
$background_embellishment = $section['background_embellishment'] ?? '';

if ($background_embellishment == 'circles') {
    $bg_pattern_class = 'bg-pattern bg-circles-pattern';
    $bg_svg_pattern = file_get_contents(get_stylesheet_directory() . '/assets/images/bg-patterns/circles.svg');
} elseif ($background_embellishment == 'dots') {
    $bg_pattern_class = 'bg-pattern bg-dots-pattern';
    $bg_svg_pattern = file_get_contents(get_stylesheet_directory() . '/assets/images/bg-patterns/dots.svg');
} elseif ($background_embellishment == 'honeycomb') {
    $bg_pattern_class = 'bg-pattern bg-honeycomb-pattern';
    $bg_svg_pattern = file_get_contents(get_stylesheet_directory() . '/assets/images/bg-patterns/honeycomb.svg');
} elseif ($background_embellishment == 'sprinkles') {
    $bg_pattern_class = 'bg-pattern bg-sprinkles-pattern';
    $bg_svg_pattern = file_get_contents(get_stylesheet_directory() . '/assets/images/bg-patterns/sprinkles.svg');
} else {
    $bg_pattern_class = '';
    $bg_svg_pattern = '';
}
if ($background_color == 'Blue') {
    $bg_color = 'bg-blue';
    $text_color = 'text-white';
    $heading_color = 'text-white';
    $svg_fill = '#0C689F';
} elseif ($background_color == 'Light Blue') {
    $bg_color = 'bg-light-blue';
    $text_color = 'text-black-100';
    $heading_color = 'text-black-100';
    $svg_fill = '#CAE7F4';
} elseif ($background_color == 'Teal') {
    $bg_color = 'bg-teal';
    $text_color = 'text-black';
    $heading_color = 'text-black';
    $svg_fill = '#00B4D3';
} elseif ($background_color == 'Purple') {
    $bg_color = 'bg-purple';
    $text_color = 'text-white';
    $heading_color = 'text-white';
    $svg_fill = '#4953DA';
} elseif ($background_color == 'Gradient Yellow') {
    $bg_color = 'bg-gradient-yellow';
    $text_color = 'text-black';
    $heading_color = 'text-black';
    $svg_fill = '#F2BD3E';
} else {
    $bg_color = 'bg-white';
    $text_color = 'text-black';
    $heading_color = 'text-black';
    $svg_fill = '#F1F1F1';
}
if (!empty($bg_svg_pattern)) {
    $bg_svg_pattern = preg_replace(
        '/fill="[^"]*"/',
        'fill="' . $svg_fill . '"',
        $bg_svg_pattern
    );
    $svg_encoded = rawurlencode($bg_svg_pattern);
} else {
    $svg_encoded = '';
}
?>
<?php if (!empty($svg_encoded)): ?>
    <style>
        #form-zone-<?php echo get_the_ID() . '-' . $key; ?>.bg-pattern {
            --svg-bg: url('data:image/svg+xml,<?php echo $svg_encoded; ?>');
        }
    </style>
<?php endif; ?>
<?php if($heading || $content || $form): ?>
    <section id="form-zone-<?php echo get_the_ID() . '-' . $key; ?>" class="form_zone py-5 <?php echo $bg_pattern_class; ?> <?php echo $bg_color; ?> <?php if($form_position == 'center'): echo 'form-center'; endif; ?>">
        <div class="container-fluid">
            <?php if($form_position == 'center'):
            if ($headline || $icon): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <?php if (!empty($icon)): ?>
                        <div class="text-center pt-1 pb-3 form-icon heading-with-icon">
                            <?php echo $icon; ?>
                        </div>
                        <?php endif; ?>
                        <?php if ($headline): ?>
                            <<?php echo $heading_type; ?> class="font-medium text-center <?php echo $text_color; ?>"><?php echo $headline; ?></<?php echo $heading_type; ?>>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; endif; ?>
            <?php if ($content || $form):
                $row_class = ($form_position !== "center")
                    ? "justify-content-center"
                    : "";
            ?>
                <div class="row <?php echo $form_position == "left" ? "flex-column-reverse flex-md-row-reverse" : ""; ?> <?php echo $row_class; ?>">
                    <?php if($form_position == 'center') {
                        $column_class = 'offset-lg-1 col-lg-10';
                    } elseif($form_position == 'right') {
                        $column_class = 'col-md-6 col-lg-5 offset-lg-1';
                    } else {
                        $column_class = 'col-md-6';
                    }
                    ?>
                    <?php if ($content || $form_position == "center" && $form): ?>
                        <div class="<?php echo $column_class; ?> <?php if($form_position == 'right' || $form_position == 'left'): echo 'pe-lg-5'; endif; ?>">
                        <?php if($form_position != 'center'):
                            if ($headline): ?>
                                <<?php echo $heading_type; ?> class="font-medium <?php echo $text_color; ?> <?php if (!empty($icon)): ?>heading-with-icon mb-3<?php endif; ?>"><?php echo $headline; ?> <?php if (!empty($icon)): echo $icon; endif; ?></<?php echo $heading_type; ?>>
                            <?php endif; ?>
                        <?php endif; ?>
                            <?php if ($content) { ?>
                                <div class="wysiwyg-content <?php echo $text_color; ?> <?php echo $form_position == "center" ? "text-center" : ""; ?>">
                                    <?php echo $content; ?>
                                </div>
                            <?php } ?>
                            <!-- if form is center and form has value  -->
                            <?php if ($form_position == "center" && $form) { ?>
                                <div class="wysiwyg-content py-4 <?php echo $text_color; ?>">
                                    <?php echo do_shortcode('[gravityform id="' . $form . '" title="false" description="false" ajax="true"]'); ?>
                                </div>
                            <?php } ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($form_position != "center") { ?>
                        <div class="<?php if($form_position == 'right'): ?>col-md-6 <?php else: ?>col-md-6 col-lg-5 offset-lg-1<?php endif; ?> py-md-0 py-4 <?php if($form_position == 'right' || $form_position == 'left'): echo 'pe-lg-5'; endif; ?>">
                            <?php if($form_headline): ?>
                            <<?php echo $form_heading_type ; ?> class=" font-lexend font-medium mb-3 text-pink pe-xxl-5"><?php echo $form_headline;?> </<?php echo $form_heading_type ; ?>>
                            <?php endif; ?>
                            <?php if ($form) { ?>
                                <div class="wysiwyg-content <?php echo $text_color; ?>">
                                    <?php echo  do_shortcode('[gravityform id="' . $form . '" title="false" description="false" ajax="true"]'); ?>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>

                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>