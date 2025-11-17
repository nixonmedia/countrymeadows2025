<?php
$main_heading = get_field('heading');

var_dump($main_heading);

$heading = $main_heading['heading']['heading'] ?? "";
$heading_style = $main_heading['heading']['heading_style'] ?? "";
$background_color = $section['background_color'];
// var_dump($heading);
// $headline_type = $section['headline_type'];
// $intro_content = $section['content'];
// $carousel = $section['carousel'];
$background_color_classes = [
    'white' => 'bg-white',
    'gray' => 'bg-dark-gray',
    'cyan' => 'bg-blue',
 
];
$bg_class = isset($color_classes[$background_color]) ? $color_classes[$background_color] : '';

?>
<section class="py-5" style="background:#4c47ee;">
    <div class="container-fluid text-center text-white">
        <div class="row">
            <div class="col">
      <h2 class="fw-bold mb-3 text-white">Let’s Get Started</h2>
         <div class="wyswing-content">
            Got a question about senior living? You’re not alone. That's why we created this series 
            of simple quizzes to help you get started. Each one takes just a few minutes and will 
            provide you with tips and resources for next steps based on where you are in the journey.
        </div>
          <!-- Quiz Boxes -->
        <div class="buttons d-flex justify-content-center g-4">

          
                <div class="p-4 bg-white text-dark shadow rounded single-button">
                    <strong>Burden Quiz</strong>
                </div>
           
                <div class="p-4 bg-white text-dark shadow rounded single-button">
                    <strong>Burden Quiz</strong>
                </div>
                
                <div class="p-4 bg-white text-dark shadow rounded single-button">
                    <strong>Burden Quiz</strong>
                    
                </div>
                
                <div class="p-4 bg-white text-dark shadow rounded single-button">
                    <strong>Burden Quiz</strong>
                </div>

     </div>
            </div>
        </div>

  <div class="wyswing-content">
            Still have questions? Be sure to explore all our Resources Center has to offer.
            Or reach out to We’re here to help every step of the way.
</div>

    </div>
</section>
