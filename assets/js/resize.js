(function ($) {

  $(document).ready(function () {

$("#small").on("click", function (e) {
  e.preventDefault();

  $("#small").addClass("active");
  $("#large").removeClass("active");

  $(".wysiwyg-content p, \
    .wysiwyg-content, \
    .elementor-text-editor p, \
    .entry-content p, \
    .post-description, \
    .job-card-description, \
    .post-content p, \
    .blog-content p, \
    .single-post p, \
    .job-description p, \
    .job-content p, \
    .job-body p")
    .animate({
      "font-size": "17px",
      "line-height": "27px"
    });

  $(".wysiwyg-content p.wp-caption-text, \
    .wysiwyg-content .wp-caption-text")
    .animate({
      "font-size": "14px",
      "line-height": "22px"
    });
});

$("#large").on("click", function (e) {
  e.preventDefault();

  $("#large").addClass("active");
  $("#small").removeClass("active");

  $(".wysiwyg-content p, \
    .wysiwyg-content, \
    .elementor-text-editor p, \
    .entry-content p, \
    .post-description, \
    .job-card-description, \
    .post-content p, \
    .blog-content p, \
    .single-post p, \
    .job-description p, \
    .job-content p, \
    .job-body p")
    .animate({
      "font-size": "22px",
      "line-height": "32px"
    });

  $(".wysiwyg-content p.wp-caption-text, \
    .wysiwyg-content .wp-caption-text")
    .animate({
      "font-size": "14px",
      "line-height": "22px"
    });
});



var $resizer = $('#resizer');
var $header  = $('header');
var $footer  = $('footer');
var $adminBar = $('#wpadminbar');

if ($resizer.length && $header.length && $footer.length) {

  var gap = 20;
  var footerStopPercent = 0.2;

  function updateResizer() {
    var scrollTop = $(window).scrollTop();

    var adminBarHeight = $adminBar.length ? $adminBar.outerHeight() : 0;
    var resizerHeight = $resizer.outerHeight();

    var headerBottom =
      $header.offset().top +
      $header.outerHeight() +
      gap -
      adminBarHeight;

    var footerTop    = $footer.offset().top;
    var footerHeight = $footer.outerHeight();

    var footerStopPoint =
      footerTop + (footerHeight * footerStopPercent) - resizerHeight;

    var top;

    if (scrollTop <= headerBottom) {
      top = Math.max(headerBottom - scrollTop, adminBarHeight + gap);
    }
    else if (scrollTop >= footerStopPoint) {
      top = footerStopPoint - scrollTop;
    }
    else {
      top = adminBarHeight + gap;
    }

    $resizer.css('top', top + 'px');
  }

  $(window).on('scroll resize', function () {
    requestAnimationFrame(updateResizer);
  });

  updateResizer();
}



  });

})(jQuery);
