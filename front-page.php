<?php get_header(); ?>
<div class="container py-5">
  <div class="row">
    <div class="col-lg-12">
      <h2>Home Page Content</h2>
    <?php 
    $icon = get_field('streamline_icon');
    // var_dump($icon);
    echo "svg here ". $icon;
?>







       
    </div>
  </div>
</div>
<?php get_footer(); ?>