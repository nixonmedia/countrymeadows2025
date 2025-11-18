<?php 
$stylized_heading = get_field("stylized_heading");
$intro = get_field("intro");
$headline = $intro['headline'] ?? '';
$content = $intro['content'] ?? '';
$layered_image_zone = $intro['layered_image_zone'] ?? [];
$layered_image = $layered_image_zone['image'] ?? null;
?>

<section class="stylized-heading-intro-zone image-with-embellishment">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-7 intro-content-col py-5">
        <?php if($stylized_heading): ?>
          <span class="stylized-heading d-block text-pink font-gloss-bloom mb-4 pb-2"><?php echo $stylized_heading; ?></span>
        <?php endif; ?>
        <?php if($headline): ?>
          <h1 class="font-medium fw-bold mb-2 pb-1"><?php echo $headline; ?></h1>
        <?php endif; ?>
        <div class="wysiwyg-content font-regular">
          <?php 
          echo $content;
          ?>
        </div>
      </div>
      <div class="col-lg-5 intro-img-col position-relative">
        <img src="<?php echo $layered_image['url']; ?>" alt="<?php echo $layered_image['alt']; ?>" class="img-fluid">
      </div>
    </div>
  </div>
</section>
