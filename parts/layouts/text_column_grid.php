<?php $content_blocks = $section['content_blocks'] ?? ''; ?>
<?php if (!empty($content_blocks) && is_array($content_blocks)): ?>
  <section class="text-column-grid-zone bg-water-color bg-yellow-water-color" id="text-column-grid-zone-<?php echo get_the_ID().'-'.$key; ?>">
    <div class="container-fluid">
      <div class="row justify-content-center text-center">
        <?php foreach($content_blocks as $content_block): 
          $icon = $content_block['icon'] ?? '';
          $heading = $content_block['heading'] ?? ''; 
          $content = $content_block['content'] ?? ''; 
          $button = $content_block['button'] ?? ''; ?>
          <div class="col-lg-6 position-relative text-column-grid-block">
            <?php if($heading): ?>
              <h2><?php echo $heading; ?></h2>
            <?php endif; 
            if($content): ?>
              <div class="wysiwyg-content <?php if($button):?>mb-3<?php endif; ?>">
                <?php echo $content; ?>
              </div>
            <?php endif; 
            if($button): ?>
              <a href="<?php echo $button['url']; ?>" class="site-button" <?php if($button['target']): ?>target="<?php echo $button['target']; ?>"<?php endif; ?>><?php echo $button['title']; ?></a>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>