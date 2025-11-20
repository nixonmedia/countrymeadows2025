<?php

$heading = $section['heading']['heading'] ?? "";
$heading_style = $section['heading']['heading_style'] ?? "";
$background_color = $section['background_color'] ?? "";
$button_cards = $section['button_cards'] ?? [];
$content = $section['content'] ?? "";
$bottom_zone_content = $section['bottom_zone_content'] ?? "";
$border = $section['border'] ?? "";
$background_embellishment = $section['background_embellishment'] ?? "";
$border = $border_angle["border"] ?? "";
$angle = $border_angle["angle"] ?? "";


$background_color_classes = [
    'White' => 'bg-white',
    'Blue' => 'bg-blue',
    'Light Blue' => 'bg-light-blue',
    'Teal' => 'bg-teal',
    'Purple' => 'bg-purple',
    'Gradient Yellow' => 'bg-gradient-yellow',
];

$heading_classes = [
    'White' => 'text-blue',
    'Blue' => 'text-white',
    'Light Blue' => 'text-blue',
    'Teal' => 'text-white',
    'Purple' => 'text-white',
    'Gradient Yellow' => 'text-black',
];


$bg_class = isset($background_color_classes[$background_color]) ? $background_color_classes[$background_color] : '';
$heading_class = isset($heading_classes[$background_color]) ? $heading_classes[$background_color] : '';

$valid_buttons = [];

if (!empty($button_cards)) {

    foreach ($button_cards as $button) {
        var_dump($button);
        $text = trim($button['text'] ?? '');
        $link_title = $button['link']['title'] ?? '';
        $link_url = $button['link']['url'] ?? '';
        $button_icon = trim($button['icon'] ?? '');

        if ($text !== '' || $link !== '' || $icon !== '') {
            $valid_buttons[] = $button;
        }
    }
}

if ($heading || $content || !empty($valid_buttons) || $bottom_zone_content):
?>

    <section class="content-and-button-cards py-5 <?php echo esc_attr($bg_class); ?>">
        <div class="container-fluid text-center text-white">
            <div class="row justify-content-center">
                <div class="col-lg-10 d-flex flex-column justify-content-center align-items-center">
                    <h2 class="fw-bold mb-3 font-medium mb-2 <?php echo esc_attr($heading_class); ?>">
                        <?php echo $heading; ?>
                    </h2>

                    <?php if ($content): ?>
                        <div class="wyswing-content pt-3 pb-5 top-content <?php echo esc_attr($heading_class); ?>">
                            <?php echo $content; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Buttons -->
                    <div class="buttons d-flex flex-wrap justify-content-center gap-5 pb-5">
                        <?php if (!empty($valid_buttons)): ?>
                            <?php foreach ($valid_buttons as $button): ?>
                                <div class="p-4 bg-white shadow single-button text-black <?php echo esc_attr($button_bg_class); ?> <?php echo esc_attr($button_text_class); ?>">
                                    <strong><?php echo $button["text"]; ?></strong>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <?php if ($bottom_zone_content): ?>
                        <div class="wyswing-content bottom-content <?php echo esc_attr($heading_class); ?>">
                            <?php echo $bottom_zone_content; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

<?php endif; ?>