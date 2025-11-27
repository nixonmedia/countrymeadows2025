<?php $split_column_position = $section['split_column_position'] ?? '';

?>

<section class="split-column-zone">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-5 pe-lg-5">
        <h2>Advice for seniors and caregivers.</h2>
        <div class="image-box mb-2">
          <img src="" class="img-fluid" alt="" >
        </div>
        <div class="wysiwyg-content">
          For over 50 years, the Leader family has cared for seniors and their families. During this time, we have gained much experience guiding residents and families in starting the conversation about moving to a retirement community or finding financial resources available. While you are searching, we have created our Resource Center we hope will be helpful. This is a place where you will find answers to your questions about senior living. Click the button below to learn more.
        </div>
        <a href="#" class="site-button">Explore</a>
      </div>
      <div class="col-lg-6 offset-lg-1">
        <div class="cta-block"> 
          <?php foreach($call_to_action as $post_cta):
            $cta_heading = get_field('cta_headline', $post_cta->ID); 
            $cta_content = get_field('cta_content', $post_cta->ID);
            $cta_link = get_field('cta_link', $post_cta->ID); ?>
            <div class="cta-info text-center">
              <div class="cta-content">
                <?php if($cta_heading): ?>
                  <h3 class="font-medium"><?php echo $cta_heading; ?></h3>
                <?php endif; 
                if($cta_content): ?>
                  <div class="wysiwyg-content <?php if($cta_link):?>mb-3<?php endif; ?> text-start"><?php echo $cta_content; ?></div>
                <?php endif; 
                if($cta_link): ?>
                  <a href="<?php echo $cta_link['url']; ?>" class="site-button" <?php if($cta_link['target']): ?>target="<?php echo $cta_link['target']; ?>"<?php endif; ?>><?php echo $cta_link['title']; ?></a>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>