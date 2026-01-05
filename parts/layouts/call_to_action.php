<?php

$call_to_action = $section['call_to_action'] ?? '';
$background_color = $section['background_color'] ?? '';
$background_pattern = $section['background_embellishment'] ?? '';
$embellishment = $media_embellishment['embellishment'] ?? '';
$embellishment_position = $media_embellishment['embellishment_position'] ?? '';
$section_border = $section['border'] ?? [];
$border = $section_border['border'] ?? '';
$angle = $section_border['angle'] ?? '';



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
}elseif ($background_color == 'Light Yellow') {
    $bg_color = 'bg-light-yellow';
    $text_color = 'text-black';
    $heading_color = 'text-black';
    $svg_fill = 'rgba(214, 47, 116, 0.08)';
}
else {
    $bg_color = 'bg-white';
    $text_color = 'text-black';
    $heading_color = 'text-black';
    $svg_fill = '#F1F1F1';
}

if ($embellishment_position == 'Left') {
    $embellishment_position_class = 'left-align-embellishment';
} elseif ($embellishment_position == 'Right') {
    $embellishment_position_class = 'right-align-embellishment';
} else {
    $embellishment_position_class = '';
}

if ($embellishment == 'circles') {
    $embellishment_class = 'with-embellishment circles-embellishment';
} elseif ($embellishment == 'seeds') {
    $embellishment_class = 'with-embellishment seeds-embellishment';
} elseif ($embellishment == 'seeds-open') {
    $embellishment_class = 'with-embellishment seeds-open-embellishment';
} elseif ($embellishment == 'seeds-open-large') {
    $embellishment_class = 'with-embellishment seeds-open-large-embellishment';
} elseif ($embellishment == 'squiggles') {
    $embellishment_class = 'with-embellishment squiggles-embellishment';
} elseif ($embellishment == 'Xs') {
    $embellishment_class = 'with-embellishment xs-embellishment';
} else {
    $embellishment_class = '';
}

if ($border == 'angle' && $angle == 'down_left') {
    $border_class = 'border-angle';
    $angle_class = 'angle_down_left';
    $margin_class = 'position-relative';
} elseif ($border == 'angle' && $angle == 'down_right') {
    $border_class = 'border-angle';
    $angle_class = 'angle_down_right';
    $margin_class = 'position-relative';
}elseif ($border == 'straight') {
    $border_class = 'border-straight';
    $angle_class = '';
    $margin_class = 'position-relative';
}
 else {
    $border_class = '';
    $angle_class = '';
    $margin_class = '';
}

if ($background_pattern == 'circles') {
    $bg_pattern_class = 'bg-pattern bg-circles-pattern';
    $bg_svg_pattern = file_get_contents(get_stylesheet_directory() . '/assets/images/bg-patterns/circles.svg');
} elseif ($background_pattern == 'dots') {
    $bg_pattern_class = 'bg-pattern bg-dots-pattern';
    $bg_svg_pattern = file_get_contents(get_stylesheet_directory() . '/assets/images/bg-patterns/dots.svg');
} elseif ($background_pattern == 'honeycomb') {
    $bg_pattern_class = 'bg-pattern bg-honeycomb-pattern';
    $bg_svg_pattern = file_get_contents(get_stylesheet_directory() . '/assets/images/bg-patterns/honeycomb.svg');
} elseif ($background_pattern == 'sprinkles') {
    $bg_pattern_class = 'bg-pattern bg-sprinkles-pattern';
    $bg_svg_pattern = file_get_contents(get_stylesheet_directory() . '/assets/images/bg-patterns/sprinkles.svg');
} else {
    $bg_pattern_class = '';
    $bg_svg_pattern = '';
}

if (!empty($bg_svg_pattern)) {

    // replace any fill value in the SVG to your dynamic color
    $bg_svg_pattern = preg_replace(
        '/fill="[^"]*"/',
        'fill="' . $svg_fill . '"',
        $bg_svg_pattern
    );

    $svg_encoded = rawurlencode($bg_svg_pattern);
} else {
    $svg_encoded = '';
}

if (!empty($svg_encoded)): ?>
    <style>
        #call-to-action-<?php echo get_the_ID() . '-' . $key; ?>.bg-pattern {
            --svg-bg: url('data:image/svg+xml,<?php echo $svg_encoded; ?>');
        }
    </style>
<?php endif; ?>

<?php $fields = get_fields(get_the_ID());
$total_sections = isset($fields['flexible_content']) && is_array($fields['flexible_content'])
    ? count($fields['flexible_content'])
    : 0;
$spacing_class = ($key === $total_sections - 1) ? 'mt-7' : 'my-7';
?>

<?php if (!empty($section['call_to_action'])): ?>

<section id="call-to-action-<?php echo get_the_ID() . '-' . $key; ?>" class="call-to-action py-5 <?php echo $bg_color; ?> <?php echo $border_class ?> <?php echo $angle_class ?> <?php echo $margin_class; ?> <?php echo $bg_pattern_class; ?> <?php if($border == 'angle'): echo $spacing_class; endif; ?>">
    <div class="container-fluid py-2">
   
   <div class="row justify-content-center">
    <?php if($call_to_action):?>
    <?php foreach ($call_to_action as $cta) : 
$call_to_action_title = get_field("cta_headline", $cta);
        $call_to_action_content = get_field("cta_content", $cta);
        $call_to_action_button = get_field("cta_link", $cta);
        //  var_dump( $call_to_action_title);
    ?>
        <div class="col-md-10 col-lg-8 col-xxl-6 text-center text-capitalize">
            <?php if($call_to_action_title): ?>
                <h2 class="<?php echo $text_color; ?> fw-bold mb-2"><?php echo $call_to_action_title; ?></h2>
            <?php endif; ?>
            <?php if($call_to_action_content): ?>
                <div class="wysiwyg-content <?php echo $text_color; ?> <?php if($call_to_action_button): ?>mb-3<?php endif; ?>">
                    <?php echo $call_to_action_content; ?>
                </div>
            <?php endif; ?> 
            <?php if($call_to_action_button): ?>
                <a href="<?php echo $call_to_action_button['url']; ?>" class="site-button" <?php if($call_to_action_button['target']): ?>target="<?php echo $call_to_action_button['target']; ?>" <?php endif; ?>><?php echo $call_to_action_button['title']; ?></a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>
</div>
</section>
<?php endif; ?>