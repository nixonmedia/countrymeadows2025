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
    prevArrow:
      `<button type="button" class="slick-prev custom-arrow" aria-label="Previous">
        <svg width="17" height="29" viewBox="0 0 17 29" xmlns="http://www.w3.org/2000/svg" fill="none">
          <path d="M0.00078 14.0156L1.01901 12.9974L12.9982 1.01825L14.0164 0L16.0469 2.03049L15.0286 3.04872L4.06771 14.0097L15.0286 24.9706L16.0469 25.9888L14.0164 28.0193L12.9982 27.0011L1.01901 15.0219L0.00078 14.0037L0.00078 14.0156Z" fill="currentColor"/>
        </svg>
      </button>`,
    nextArrow:
      `<button type="button" class="slick-next custom-arrow" aria-label="Next">
        <svg width="17" height="29" viewBox="0 0 17 29" xmlns="http://www.w3.org/2000/svg" fill="none">
          <path d="M16.0461 14.0036L15.0279 15.0219L3.0487 27.001L2.03047 28.0193L0 25.9888L1.01823 24.9706L11.9792 14.0096L1.01823 3.0487L0 2.03047L2.03047 0L3.0487 1.01823L15.0279 12.9974L16.0461 14.0156V14.0036Z" fill="currentColor"/>
        </svg>
      </button>`
  });

});