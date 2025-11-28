<?php get_header(); 

/**************************************
***** Stylized Heading Intro Zone *****
****************************************/
get_template_part('parts/layouts/stylized_heading_intro_zone'); ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <h2>Home Page Content</h2>
      <?php $icon = get_field('streamline_icon');
      var_dump($icon);
      echo "svg here ". $icon; ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>