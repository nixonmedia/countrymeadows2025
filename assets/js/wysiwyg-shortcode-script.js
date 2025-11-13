(function () {
  tinymce.PluginManager.add("wysiwyg_shortcode_btn", function (editor, url) {
    // --- Add Video Button (Uses a Modal Window) ---
    editor.addButton("add_video_btn", {
      // title: 'Add Video Shortcode',
      icon: false,
      text: "Add Video",
      image:
        "/countrymeadows2025/wp-content/themes/countrymeadows2025/assets/js/yt-icon.svg",
      onclick: function () {
        // Open the modal window definition
        editor.windowManager.open({
          title: "Video Embed Options",
          body: [
            {
              type: "container",
              label: "HTML",
              html: "Paste the youtube ID from the Youtube URL",
            },
            {
              type: "textbox",
              name: "youtube_id",
              label: "YouTube Video ID",
            },
            {
              type: "listbox",
              name: "video_alignment",
              label: "Video Alignment",
              values: [
                { text: "Left", value: "left" },
                { text: "Center", value: "center" },
                { text: "Right", value: "right" },
              ],
              value: "left", // Default selected value
            },
            {
              type: "listbox",
              name: "video_size",
              label: "Video Size",
              values: [
                { text: "Small", value: "small" },
                { text: "Medium", value: "medium" },
                { text: "Large", value: "large" },
              ],
              value: "small", // Default selected value
            },
          ],
          onsubmit: function (e) {
            // When the user clicks OK, construct the shortcode with attributes
            var videoID = e.data.youtube_id;
            if (videoID) {
              var shortcode =
                '[add_video id="' +
                videoID +
                '" align="' +
                e.data.video_alignment +
                '" size="' +
                e.data.video_size +
                '"]';
              editor.insertContent(shortcode);
            }
          },
        });
      },
    });

    // --- Add Event Button (Direct Insert) ---
    editor.addButton("add_event_btn", {
      title: "Add Event Shortcode",
      text: "Add Event",
      onclick: function () {
        editor.insertContent("[add_event_shortcode]");
      },
    });

    // --- Add Image Gallery Button (Direct Insert) ---
    editor.addButton("image_gallery_btn", {
      title: "Add Image Gallery Shortcode",
      text: "Add Gallery",
      onclick: function () {
        editor.insertContent("[image_gallery]");
      },
    });

    // --- Add Testimonial Button (Direct Insert) ---
    editor.addButton("add_testimonial_btn", {
      title: "Add Testimonial Shortcode",
      text: "Add Testimonial",
      icon: false,
      image:
        "/countrymeadows2025/wp-content/themes/countrymeadows2025/assets/js/testimonial.svg",
      onclick: function () {
        var editorInstance = editor;

        // 🔹 Step 1: Load testimonials BEFORE opening modal
        jQuery.ajax({
          url: WysiwygShortcodeVars.ajax_url,
          type: "POST",
          data: {
            action: "get_testimonial_posts",
            nonce: WysiwygShortcodeVars.nonce,
          },
          success: function (response) {
            var items = [];

            if (response.success && response.data.length > 0) {
              items = response.data.map(function (post) {
                return { text: post.title, value: post.id };
              });

              items.unshift({ text: "— Select a testimonial —", value: "" });
            } else {
              items = [{ text: "No testimonials found", value: "" }];
            }

            // 🔹 Step 2: Open TinyMCE modal with populated values
            editorInstance.windowManager.open({
              title: "Select Testimonial",
              body: [
                {
                  type: "listbox",
                  name: "testimonial_id",
                  label: "Choose Testimonial",
                  values: items,
                },
              ],
              onsubmit: function (e) {
                var testimonialID = e.data.testimonial_id;
                if (testimonialID) {
                  var shortcode =
                    '[add_testimonial id="' + testimonialID + '"]';
                  editorInstance.insertContent(shortcode);
                } else {
                  alert("Please select a testimonial.");
                  e.preventDefault();
                }
              },
            });
          },
          error: function (error) {
            console.error("AJAX Error:", error);
            alert("Error loading testimonials. Please try again.");
          },
        });
      },
    });

    // --- Add Font Size Button (Direct Insert) ---
    editor.addButton("font_size_btn", {
      title: "Add Font Size Shortcode",
      text: "Font Size",
      onclick: function () {
        editor.insertContent("[font_size]");
      },
    });
  });
})();
