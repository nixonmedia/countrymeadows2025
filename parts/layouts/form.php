<?php
$heading        = $section['heading'];
$heading_style  = $section['heading']['heading_style']  ?? "";
$background     = $section['background_color']          ?? "";
$content        = $section['content']                   ?? "";
$form_position = $section['form_position'];
$form = $section['form'];
$icon = $section['icon'];
?>
<section class="form_zone py-5 bg-gradient-yellow">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div>
                    <?php $icon;?>
                </div>
                <img src="<?php echo 'get_template_directory_uri()';?>/assets/images/notepad-icon.svg" alt="">
                <h2 class="font-medium text-center"><?php echo $heading;?></h2>

            </div>
        </div>
        <!-- move form to left as its on right by default and add class to the row with name flex-row-reverse -->
        <div class="row <?php echo $form_position == "left" ? "flex-row-reverse" : ""; ?>">
            <div class="<?php echo $form_position == "center" ? "offset-lg-1 col-lg-10" : "col-lg-6"; ?>">
                <?php if($content){ ?>
                    <div class="wysiwyg-content">
                        <?php echo $content;?>
                    </div>
                <?php } ?>
                <!-- if form is center and form has value  -->
                <?php if ($form_position == "center" && $form) {?>

                    <div class="form-container">
                        <?php echo do_shortcode('[gravityform id="' . $form . '" title="true"]'); ?>
                    </div>
                <?php } ?>              
            </div>
            <!--if the form is right or not center this block will work -->
            <?php if ($form_position != "center") { ?>
                <div class="col-lg-6 ">
                    <?php if ($form) {?>
                        <div class="form-container">
                            <?php echo  do_shortcode('[gravityform id="' . $form . '" title="true"]'); ?>
                        </div>
                    <?php } ?>              
                </div>
            <?php } ?>

        </div>
    </div>
</section>