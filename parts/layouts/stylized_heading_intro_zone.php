<?php 
$stylized_heading_text = get_field("stylized_heading_text");
$intro = get_field("intro");
$headline = $intro['headline'];
$content = $intro['content'];
?>

<section class="stylized-heading-intro-zone image-with-embellishment">
  <div class="container">
    <div class="row">
      <div class="col-lg-7 intro-content-col py-5">
        <span class="stylized-heading d-block text-pink font-gloss-bloom mb-4 pb-2">Here to help</span>
        <h1 class="font-medium fw-bold mb-2 pb-1">Welcome to our retirement communities.</h1>
        <div class="wysiwyg-content font-regular">
          <?php 
          echo $content;
          ?>
        </div>
      </div>
      <div class="col-lg-5 intro-img-col position-relative">
        <img src="<?php echo get_stylesheet_directory_uri( );?>/images/cm-couple.png" alt="Couple Image" class="img-fluid">
      </div>
    </div>
  </div>
</section>
