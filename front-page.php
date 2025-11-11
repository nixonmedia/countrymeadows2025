<?php get_header(); ?>
<div class="container py-5">
  <div class="row">
    <div class="col-lg-12">
      <h2>Home Page Content</h2>
    <?php 
    $icon = get_field('streamline_icon');

if ( !empty($icon) && is_array($icon) ) {
    echo '<img src="' . esc_url($icon['preview']) . '" alt="' . esc_attr($icon['name']) . '" />';
}
?>







       
    </div>
  </div>
</div>
<?php get_footer(); ?>