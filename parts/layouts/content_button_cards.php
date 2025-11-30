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
$border = $section['border']['border'] ?? '';
$angle = $section['border']['angle'] ?? '';

if($background_pattern == 'circles') {
  $bg_pattern_class = 'bg-pattern bg-circles-pattern';
  $bg_svg_pattern = file_get_contents(get_stylesheet_directory() . '/assets/images/bg-patterns/circles.svg');
} elseif($background_pattern == 'dots') {
  $bg_pattern_class = 'bg-pattern bg-dots-pattern';
  $bg_svg_pattern = file_get_contents(get_stylesheet_directory() . '/assets/images/bg-patterns/dots.svg');
} elseif($background_pattern == 'honeycomb') {
  $bg_pattern_class = 'bg-pattern bg-honeycomb-pattern';
  $bg_svg_pattern = file_get_contents(get_stylesheet_directory() . '/assets/images/bg-patterns/honeycomb.svg');
} elseif($background_pattern == 'sprinkles') {
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
} elseif($background_color == 'Light Blue') {
  $bg_color = 'bg-light-blue';
  $text_color = 'text-black-100';
  $heading_color = 'text-black-100';
  $svg_fill = 'rgba(43, 161, 198, 0.10)';
} elseif($background_color == 'Teal') {
  $bg_color = 'bg-teal';
  $text_color = 'text-black';
  $heading_color = 'text-black';
  $svg_fill = 'rgba(0, 0, 0, 0.05)';
} elseif($background_color == 'Purple') {
  $bg_color = 'bg-purple';
  $text_color = 'text-white';
  $heading_color = 'text-white';
  $svg_fill = 'rgba(0, 0, 0, 0.05)';
} elseif($background_color == 'Gradient Yellow') {
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
    #content-and-buttons-cards-<?php echo get_the_ID().'-'.$key; ?>.bg-pattern {
      --svg-bg: url('data:image/svg+xml,<?php echo $svg_encoded; ?>');
    }
  </style>
<?php endif; ?>
<?php

if($border == 'angle' && $angle == 'down_left') {
  $border_class = 'border-angle';
  $angle_class = 'angle_down_left';
  $margin_class = 'my-7 position-relative';
} elseif($border == 'angle' && $angle == 'down_right') {
  $border_class = 'border-angle';
  $angle_class = 'angle_down_right';
  $margin_class = 'my-7 position-relative';
} else {
  $border_class = '';
  $angle_class = '';
  $margin_class = '';
}

$valid_buttons = [];

if (!empty($button_cards)) {

    foreach ($button_cards as $button) {
        // var_dump($button);
        $text = trim($button['text'] ?? '');
        $link_title = $button['link']['title'] ?? '';
        $link_url = $button['link']['url'] ?? '';
        $button_icon = $button['streamline_icon'] ?? '';
        // var_dump($button_icon);

      if ($text !== '' && $link_url !== '' || $button_icon !== '') {
    $valid_buttons[] = $button;
}

    }
}

if ($heading || $content || !empty($valid_buttons) || $bottom_zone_content):
?>

    <section id="content-and-buttons-cards-<?php echo get_the_ID().'-'.$key; ?>" class="content-and-button-cards py-5 <?php echo $bg_color; ?> <?php echo $bg_pattern_class; ?> <?php echo $border_class; ?> <?php echo $angle_class; ?> <?php echo $margin_class; ?>">
        <div class="container-fluid text-center text-white">
            <div class="row justify-content-center">
                <div class="col-lg-10 d-flex flex-column justify-content-center align-items-center">
                    <<?php  echo $heading_style;  ?> class="fw-bold mb-3 font-medium mb-2 <?php echo esc_attr($text_color); ?>">
                        <?php echo $heading; ?>
                    </<?php  echo $heading_style;  ?>>

                    <?php if ($content): ?>
                        <div class="wyswing-content pt-3 pb-5 top-content <?php echo esc_attr($text_color); ?>">
                            <?php echo $content; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Buttons -->
                    <div class="buttons d-flex flex-wrap justify-content-center gap-4 pb-5">
                        <?php if (!empty($valid_buttons)): ?>
                            <?php foreach ($valid_buttons as $button):
                            // echo "<pre>";  
                            //      var_dump($button);
                             $button_icon = $button['streamline_icon'] ?? '';
                            //  var_dump($button_icon);
                              ?>
                          
                             <a href="<?php echo esc_url($button['link']['url']); ?>" class="p-4 bg-white shadow single-button text-black text-decoration-none">
                                  <?php echo   $button_icon; ?>
                                  <strong><?php echo $button["text"]; ?></strong>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <?php if ($bottom_zone_content): ?>
                        <div class="wyswing-content bottom-content <?php echo esc_attr($text_color); ?>">
                            <?php echo $bottom_zone_content; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>