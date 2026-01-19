(function ($) {
 
  $(document).ready(function () {
 
    $("#small").on("click", function (e) {
      e.preventDefault();

        // ACTIVE STATE
      $("#small").addClass("active");
      $("#large").removeClass("active");
 
      $(".wysiwyg-content p , .wysiwyg-content").animate({
        "font-size": "17px",
        "line-height": "27px"
      });
 
      $(".wysiwyg-content p.wp-caption-text, .wysiwyg-content .wp-caption-text").animate({
        "font-size": "14px",
        "line-height": "22px"
      });
 
      // $(".small").css("color", "#CEB367");
      // $(".large").css("color", "white");
    });
 
    $("#large").on("click", function (e) {
      e.preventDefault();

        // ACTIVE STATE
      $("#large").addClass("active");
      $("#small").removeClass("active");
 
      $(".wysiwyg-content p , .wysiwyg-content").animate({
        "font-size": "22px",
        "line-height": "32px"
      });
 
      $(".wysiwyg-content p.wp-caption-text , .wysiwyg-content .wp-caption-text").animate({
        "font-size": "14px",
        "line-height": "22px"
      });
 
      // $(".small").css("color", "white");
      // $(".large").css("color", "#CEB367");
    });
 
    // Sticky resizer
    var el = $('#resizer');
    if (el.length) {
      var elpos = el.offset().top;
 
      $(window).on("scroll", function () {
        var y = $(this).scrollTop();
        el.stop().animate({ 'top': y < elpos ? 0 : y - elpos }, 300);
      });
    }
 
  });
 
})(jQuery);