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
    $(document).ready(function(){
      $('.review-slider').slick({
        dots: false,
        arrows: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
         prevArrow:
      '<img src="/countrymeadows/wp-content/uploads/2025/11/slide-arrow-left.svg" alt="icon" class="icon-prev">',
    nextArrow:
      '<img src="/countrymeadows/wp-content/uploads/2025/11/slide-arrow-right.svg" alt="icon" class="icon-next">',
    responsive: [
      {
        breakpoint: 992,
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
    }); 

});