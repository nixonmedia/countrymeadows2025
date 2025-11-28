<?php
$heading        = $section['heading'];
$headline = $heading['headline'];
$heading_type = $heading['heading_type'];
$background_color  = $section['background_color'];
$content        = $section['content'] ?? "";
$form_position = $section['form_position'];
$form = $section['form'];
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
    $svg_fill = 'rgba(0, 0, 0, 0.10)';
} elseif ($background_color == 'Light Blue') {
    $bg_color = 'bg-light-blue';
    $text_color = 'text-black-100';
    $heading_color = 'text-black-100';
    $svg_fill = 'rgba(43, 161, 198, 0.10)';
} elseif ($background_color == 'Teal') {
    $bg_color = 'bg-teal';
    $text_color = 'text-black';
    $heading_color = 'text-black';
    $svg_fill = 'rgba(0, 0, 0, 0.05)';
} elseif ($background_color == 'Purple') {
    $bg_color = 'bg-purple';
    $text_color = 'text-white';
    $heading_color = 'text-white';
    $svg_fill = 'rgba(0, 0, 0, 0.05)';
} elseif ($background_color == 'Gradient Yellow') {
    $bg_color = 'bg-gradient-yellow';
    $text_color = 'text-black';
    $heading_color = 'text-black';
    $svg_fill = '#F1F1F1';
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
        #custom-columns-zone-<?php echo get_the_ID() . '-' . $key; ?>.bg-pattern {
            --svg-bg: url('data:image/svg+xml,<?php echo $svg_encoded; ?>');
        }
    </style>
<?php endif; ?>


<section id="custom-columns-zone-<?php echo get_the_ID() . '-' . $key; ?>" class="form_zone py-5 <?php echo $bg_pattern_class; ?> <?php echo $bg_color; ?>">
    <div class="container-fluid">
        <?php if ($headline || $icon): ?>
            <div class="row">
                <div class="col-lg-12">
                    <div>
                        <?php if (!empty($icon)): ?>
                            <img src="<?php echo get_template_directory_uri() . '/assets/images/icons/' . esc_attr($icon) . '.svg'; ?>" alt="<?php echo esc_attr($icon); ?>" class="section-icon">
                        <?php endif; ?>
                    </div>
                    <?php if ($headline): ?>
                        <<?php echo $heading_type; ?> class="font-medium text-center <?php echo $text_color; ?>"><?php echo $headline; ?></<?php echo $heading_type; ?>>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        <!-- move form to left as its on right by default and add class to the row with name flex-row-reverse -->
        <?php if ($content || $form):
            $row_class = ($form_position !== "center")
                ? "justify-content-center"
                : "";
        ?>
            <div class="row <?php echo $form_position == "left" ? "flex-row-reverse" : ""; ?> <?php echo $row_class; ?>">
                <?php
                $column_class = ($form_position === "center")
                    ? "offset-lg-1 col-lg-10"
                    : "col-lg-6 left-column";
                ?>
                <?php if ($content || $form_position == "center" && $form): ?>
                    <div class="<?php echo $column_class; ?>">
                        <?php if ($content) {

                        ?>
                            <div class="wysiwyg-content <?php echo $text_color; ?> <?php echo $form_position == "center" ? "text-center" : ""; ?>">
                                <?php echo $content; ?>
                            </div>
                        <?php } ?>
                        <!-- if form is center and form has value  -->
                        <?php if ($form_position == "center" && $form) { ?>
                            <div class="form-container submit-button <?php echo $text_color; ?>">
                                <?php echo do_shortcode('[gravityform id="' . $form . '" title="false" description="false"] '); ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php endif; ?>
                <!--if the form is right or not center this block will work -->
                <?php if ($form_position != "center") { ?>
                    <div class="col-lg-6 right-column">
                        <?php if ($form) { ?>
                            <div class="form-container <?php echo $text_color; ?>">
                                <?php echo  do_shortcode('[gravityform id="' . $form . '" title="true" description="false"]'); ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>

            </div>
        <?php endif; ?>
    </div>
</section>