jQuery(document).ready(function($){
  // Mobile Menu
  $(".navbar-toggler").click(function () {
    if ($("#main-content").hasClass("show")) {
      $(".navbar-toggler .open-btn").removeClass("open");
      $(".navbar-toggler .close-btn").removeClass("open");
      $("#main-content").removeClass("show");
      $("#navbarSupportedContent").removeClass("show");
    } else {
      $("#main-content").removeClass("show");
      $("#main-content").addClass("show");
      $(".navbar-toggler .open-btn").addClass("open");
      $(".navbar-toggler .close-btn").addClass("open");
      $("#navbarSupportedContent").addClass("show");
    }
  });

  if (window.matchMedia("(max-width: 991px)").matches) {
    $(".menu-item").removeClass("menu-open");

    $(".menu-item-has-children").click(function (e) {
      e.stopPropagation();
      var elem = $(this);
      if (elem.is(".menu-open")) {
        elem.children("ul").slideUp(200);
        elem.removeClass("menu-open");
      } else {
        $(".menu-item-has-children").removeClass(".menu-open");
        elem.addClass("menu-open").children("ul").slideDown(200);
      }
    });

    $(document).click(function () {
      $(".menu-open").removeClass("menu-open");
    });
  }
  
  // Meet Team Slider
  $('.meet-team-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    dots: false,
    infinite: true,
    autoplay: false,
    speed: 700,
  });

  // Floor plan slider

  $('.floorplan-slider').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    infinite: true,
    arrows: true,
    dots: false,
    centerMode: true,
  centerPadding: '0px',
responsive: [
  {
      breakpoint: 1600,  // below 1200px
      settings: {
        slidesToShow: 3,
      }
    },
    {
      breakpoint: 1200,  // below 1200px
      settings: {
        slidesToShow: 2,
        centerMode: false,
      }
    },
    {
      breakpoint: 768,   // below 768px
      settings: {
        slidesToShow: 1,
        centerMode: false,
      }
    }
  ]
});



  // Icons Slider
  $('.icons-slider, .image-gallery-slider').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    dots: false,
    infinite: true,
    autoplay: false,
    speed: 700,
    responsive: [
      {
          breakpoint: 768,
          settings: {
              slidesToShow: 2,
              slidesToScroll: 1
          }
      },
    ],
  });

  //prepend $ to financial form
   $('#gform_3 .ginput_container_text').prepend('<span class="money">$</span>');
});

jQuery(document).ready(function($){
    if (window.matchMedia('(min-width: 992px)').matches) {
        $.fn.equalHeights = function(){
            var selector = this;
            var heights = [];
            // Save the heights of every element into an array
            selector.each(function(){
                var height = $(this).height();
                heights.push(height);
            });

            // Get the biggest height
            var maxHeight = Math.max.apply(null, heights);

            // Set the maxHeight to every selected element
            selector.each(function(){
                $(this).height(maxHeight);
            }); 
        };                             
        $('.resources-section .resource-card').equalHeights();
        // $('.helpful-topics .topic-card').equalHeights();
        $('.floorplan-slider.floor-card-inner').equalHeights();
    }
  $('.review-slider').slick({
    dots: false,
    arrows: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 5000,
    prevArrow:
    `<img src="${themeDir}/assets/images/slide-arrow-left.svg" alt="icon" class="icon-prev">`,
    nextArrow:
    `<img src="${themeDir}/assets/images/slide-arrow-right.svg" alt="icon" class="icon-next">`,
    responsive: [
      {
        breakpoint: 1200,
        settings: {
          slidesToShow: 2,
          centerMode: false,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          centerMode: false
        },
      },
    ],
  });
  $(".content-buttons-slider .buttons").slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      arrows: true,
      dots: false,
      infinite: true,
      responsive: [
          {
              breakpoint: 992,
              settings: { slidesToShow: 3 }
          },
          {
              breakpoint: 768,
              settings: { slidesToShow: 2 }
          },
          {
              breakpoint: 480,
              settings: { slidesToShow: 1 }
          }
      ]
  });
});

jQuery(document).ready(function($){
    $.fn.equalHeights = function(){
        var selector = this;
        var heights = [];

        // Save the heights of every element into an array
        selector.each(function(){
            var height = $(this).height();
            heights.push(height);
        });

        // Get the biggest height
        var maxHeight = Math.max.apply(null, heights);

        // Set the maxHeight to every selected element
        selector.each(function(){
            $(this).height(maxHeight);
        }); 
    };                             
    $('.text-column-grid-content').equalHeights();
});

// Help Toolbars
document.addEventListener('DOMContentLoaded', function () {
  const helpToolbars = document.querySelector('.help-toolbars');
  const floatImg = document.querySelector('.help-tool-float');
  const toolbarContent = document.querySelector('.help-toolbars-content');
  const closeBtn = document.querySelector('.close-float');

  // Ensure all elements exist
  if (!helpToolbars || !floatImg || !toolbarContent || !closeBtn) return;

  const isMobile = () => window.innerWidth < 768; // Bootstrap md breakpoint

  floatImg.addEventListener('click', function () {
    toolbarContent.classList.add('is-open');
    floatImg.classList.add('d-md-none');
    helpToolbars.classList.add('is-expanded');

    if (isMobile()) {
      document.body.classList.add('no-scroll');
    }
  });

  // Close toolbar
  closeBtn.addEventListener('click', function () {
    toolbarContent.classList.remove('is-open');
    floatImg.classList.remove('d-md-none');
    helpToolbars.classList.remove('is-expanded');

    document.body.classList.remove('no-scroll');
  });
});


