<?php

// $heading        = $section['heading']['heading']  ?? "";
$heading        = $section['heading'];
$headline = $heading['headline'];
// var_dump($headline);

$heading_type = $heading['heading_type'];
// var_dump($heading_type);
// $heading_style  = $section['heading']['heading_style']  ?? "";
$background_color = $section['background_color'] ?? '';
$content        = $section['content']                   ?? "";
$button         = $section['button']                    ?? "";
$review_feed    = $section['review_feed']               ?? "";
$border_data    = $section['border'] ;
// var_dump($border_data);
// $border_data    = $section['border_component']          ?? [];
$border         = $border_data['border']                ?? "";
$angle          = $border_data['angle']                 ?? "";

if ($background_color == 'Blue') {
  $bg_color = 'bg-blue';
  $text_color = 'text-white';
  $heading_color = 'text-white';
} elseif($background_color == 'Light Blue') {
  $bg_color = 'bg-light-blue';
  $text_color = 'text-black-100';
  $heading_color = 'text-black-100';
} elseif($background_color == 'Teal') {
  $bg_color = 'bg-teal';
  $text_color = 'text-black';
  $heading_color = 'text-black';

} elseif($background_color == 'Purple') {
  $bg_color = 'bg-purple';
  $text_color = 'text-white';
  $heading_color = 'text-white';

} elseif($background_color == 'Gradient Yellow') {
  $bg_color = 'bg-gradient-yellow';
  $text_color = 'text-black';
  $heading_color = 'text-black';

} else {
  $bg_color = 'bg-white';
  $text_color = 'text-black';
  $heading_color = 'text-black';
}
// --- Border classes ---
$border_class = ($border === "angle") ? "border-angle" : "";
$angle_class  = $border === "angle" ?
    ($angle === "down_right" ? "angle_down_right" : ($angle === "down_left" ? "angle_down_left" : "")) : "";

?>
<?php if ($heading || $content || $button || $review_feed) : ?>
    <section class="reviews-zone position-relative mt-5 <?php echo $bg_color; ?> <?= $border_class ?> <?= $angle_class ?>">
        <div class="container-fluid pt-lg-4 pb-lg-5 pt-0 pb-5 position-relative z-1">
            <div class="row pb-4">
                <div class="offset-lg-1 col-lg-10 pb-4">

                    <?php if ($headline): ?>
                        <<?php echo $heading_type; ?> class="font-medium fw-bold mb-2 pb-1 text-center <?php echo $heading_color;?>"><?php echo $headline; ?></<?php echo $heading_type; ?>>
                    <?php endif; ?>

                    <?php if ($content): ?>
                        <div class="review-content text-center <?= $text_color ?>"><?= wp_kses_post($content); ?></div>
                    <?php endif; ?>

                    <?php if ($button): ?>
                        <div class="text-center mt-4">
                            <a class="site-button" href="<?= esc_url($button['url']); ?>" target="<?= esc_attr($button['target']); ?>"><?= esc_html($button['title']); ?></a>
                        </div>
                    <?php endif; ?>
                    <!-- Review Slider -->
                    <div class="review-slider ps-lg-4 pt-4">

                        <?php
                        // --- Query Reviews ---
                        $args = [
                            'post_type'      => 'google_review',
                            'posts_per_page' => -1,
                            'post_status'    => 'publish',
                            'orderby'        => 'date',
                            'order'          => 'DESC',
                        ];

                        if (!empty($review_feed->term_id)) {
                            $args['tax_query'] = [[
                                'taxonomy' => 'location',
                                'field'    => 'term_id',
                                'terms'    => $review_feed->term_id,
                            ]];
                        }

                        $reviews = new WP_Query($args);

                        if ($reviews->have_posts()) :
                            while ($reviews->have_posts()) : $reviews->the_post();

                                $review_name    = get_field('google_review_name');
                                $review_date    = get_field('google_review_date');
                                $review_stars   = intval(get_field('google_review_stars') ?: 5);
                                $review_excerpt = get_field('google_review_excerpt');
                                $review_url     = get_field('google_review_url');

                                // --- Time Ago ---
                                $date_posted = "";
                                if ($review_date && $date_obj = DateTime::createFromFormat('Y-m-d', $review_date)) {
                                    $diff = (new DateTime())->diff($date_obj);
                                    $date_posted =
                                        $diff->y ? "Posted {$diff->y} year" . ($diff->y > 1 ? "s" : "") . " ago" : ($diff->m ? "Posted {$diff->m} month" . ($diff->m > 1 ? "s" : "") . " ago" : ($diff->d ? "Posted {$diff->d} day" . ($diff->d > 1 ? "s" : "") . " ago" :
                                                "Posted today"));
                                }
                        ?>

                                <div class="bg-white p-4">
                                    <div class="text-center d-flex justify-content-center pb-2 gap-1">
                                        <?php for ($i = 0; $i < $review_stars; $i++): ?>
                                            <img src="<?= get_template_directory_uri(); ?>/assets/images/star.svg"
                                                alt="Star Icon"
                                                class="img-fluid"
                                                style="width:20px;height:20px;">
                                        <?php endfor; ?>
                                    </div>

                                    <?php if ($review_name): ?>
                                        <<?php echo $heading_type; ?> class="text-black font-xm text-center mb-0"><?= esc_html($review_name) ?></<?php echo $heading_type; ?>>
                                    <?php endif; ?>

                                    <?php if ($date_posted): ?>
                                        <<?php echo $heading_type; ?> class="font-xsm fw-light text-center mb-0 post-date"><?= esc_html($date_posted) ?></<?php echo $heading_type; ?>>
                                    <?php endif; ?>

                                    <?php if ($review_excerpt): ?>
                                        <div class="font-xs-medium pb-3"><?= esc_html($review_excerpt); ?></div>
                                    <?php endif; ?>

                                    <a href="<?= $review_url ? esc_url($review_url) : '#'; ?>" <?= $review_url ? 'target="_blank"' : ''; ?> class="read-more-text text-pink fw-bold">Read More</a>
                                </div>

                            <?php
                            endwhile;
                            wp_reset_postdata();
                        else: ?>

                            <div class="bg-white p-4 text-center">
                                No reviews found for this location.
                            </div>

                        <?php endif; ?>

                    </div>

                </div>
            </div>
        </div>
    </section>
<?php endif; ?>