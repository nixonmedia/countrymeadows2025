(function ($) {

  $(document).ready(function () {
    var textSelector = ".wysiwyg-content p, \
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
      .job-body p, \
      .below-content p, \
      .search-content";

    var captionSelector = ".wysiwyg-content p.wp-caption-text, \
      .wysiwyg-content .wp-caption-text";

    // STORE ORIGINAL SIZES ON PAGE LOAD
    $(textSelector).each(function () {
      var $this = $(this);
      $this.data("original-font-size", $this.css("font-size"));
      $this.data("original-line-height", $this.css("line-height"));
    });

    $(captionSelector).each(function () {
      var $this = $(this);
      $this.data("original-font-size", $this.css("font-size"));
      $this.data("original-line-height", $this.css("line-height"));
    });

    // DEFAULT (restore original font safely)
    $("#default").on("click", function (e) {
      e.preventDefault();

      $("#default").addClass("active");
      $("#large").removeClass("active");

      $(textSelector).each(function () {
        var $this = $(this);
        $this.stop(true, true).animate({
          "font-size": $this.data("original-font-size"),
          "line-height": $this.data("original-line-height")
        }, 200);
      });

      $(captionSelector).each(function () {
        var $this = $(this);
        $this.stop(true, true).animate({
          "font-size": $this.data("original-font-size"),
          "line-height": $this.data("original-line-height")
        }, 200);
      });
    });

    // LARGE (increase font)
    $("#large").on("click", function (e) {
      e.preventDefault();

      $("#large").addClass("active");
      $("#default").removeClass("active");

      $(textSelector).stop(true, true).animate({
        "font-size": "22px",
        "line-height": "32px"
      }, 200);

      $(captionSelector).stop(true, true).animate({
        "font-size": "16px",
        "line-height": "24px"
      }, 200);
    });

    // RESIZER LOGIC
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
