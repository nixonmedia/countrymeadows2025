<?php 
$stylized_heading_text = get_field("stylized_heading_text");
$intro = get_field("intro");
$headline = $intro['headline'];
$content = $intro['content'];
// echo $content;
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
          <!-- <p>For over 40 years, Country Meadows has provided senior living at the highest standards and helped families find the right options for them. Our nine retirement communities throughout Pennsylvania and Maryland offer quality lifestyles and care with different levels of service such as <a href="#">Independent Living</a>, <a href="#">Personal Care and Assisted Living</a>, <a href="#">Memory Support</a>, <a href="#">Restorative Services</a> and <a href="#">Skilled Nursing</a>. We hope you will add Country Meadows to the senior living communities you are considering as we strive each and every day to be one of the best retirement communities.</p> -->
        </div>
      </div>
      <div class="col-lg-5 intro-img-col position-relative">
        <img src="<?php echo get_stylesheet_directory_uri( );?>/images/cm-couple.png" alt="Couple Image" class="img-fluid">
      </div>
    </div>
  </div>
</section>