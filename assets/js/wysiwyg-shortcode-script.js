(function () {
  tinymce.PluginManager.add("wysiwyg_shortcode_btn", function (editor, url) {
    // --- Add Video Button (Uses a Modal Window) ---
    editor.addButton("add_video_btn", {
      // title: 'Add Video Shortcode',
      icon: false,
      text: " Add Video",
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

    // --- Add Event Button ---
    editor.addButton("add_event_btn", {
      title: "Add Event Shortcode",
      text: " Add Event",
      icon: false,
      image:
        "/countrymeadows2025/wp-content/themes/countrymeadows2025/assets/js/event.svg",

      onclick: function () {
        var editorInstance = editor;

        // Load categories instead of posts
        jQuery.ajax({
          url: WysiwygShortcodeVars.ajax_url,
          type: "POST",
          data: {
            action: "get_event_cats",
            nonce: WysiwygShortcodeVars.nonce,
          },

          success: function (response) {
            var items = [];

            if (response.success && response.data.length > 0) {
              items = response.data.map(function (cat) {
                return { text: cat.title, value: cat.id };
              });

              items.unshift({ text: "— Select a Community —", value: "" });
            } else {
              items = [{ text: "No Community found", value: "" }];
            }

            // Open modal
            editorInstance.windowManager.open({
              title: "Select Event Community",
              body: [
                {
                  type: "listbox",
                  name: "event_cat",
                  label: "Event Community",
                  values: items,
                },
              ],
              onsubmit: function (e) {
                var catSlug = e.data.event_cat;

                // If user selects community → insert with community
                if (catSlug) {
                  editorInstance.insertContent(
                    '[add_event community="' + catSlug + '"]'
                  );
                }
                // If user does NOT choose community → show latest upcoming event
                else {
                  editorInstance.insertContent("[add_event]");
                }
              },
            });
          },

          error: function () {
            alert("Error loading event Community.");
          },
        });
      },
    });

    // --- Add Image Gallery Button (Direct Insert) ---
    // editor.addButton("image_gallery_btn", {
    //   title: "Add Image Gallery Shortcode",
    //   text: "Add Gallery",
    //   onclick: function () {
    //     editor.insertContent("[image_gallery]");
    //   },
    // });
    // --- Add Image Gallery Button (Popup With Post Selection) ---
editor.addButton("image_gallery_btn", {
  title: "Add Image Gallery Shortcode",
  text: " Add Gallery",
  icon: false,
  image: "/countrymeadows2025/wp-content/themes/countrymeadows2025/assets/js/gallery.svg",

  onclick: function () {
    var editorInstance = editor;

    // Load gallery posts
    jQuery.ajax({
      url: WysiwygShortcodeVars.ajax_url,
      type: "POST",
      data: {
        action: "get_gallery_posts",
        nonce: WysiwygShortcodeVars.nonce,
      },

      success: function (response) {
        var items = [];

        if (response.success && response.data.length > 0) {
          items = response.data.map(function (post) {
            return { text: post.title, value: post.id };
          });

          items.unshift({ text: "— Select a Gallery —", value: "" });
        } else {
          items = [{ text: "No galleries found", value: "" }];
        }

        // Open modal
        editorInstance.windowManager.open({
          title: "Insert Image Gallery",
          body: [
            {
              type: "listbox",
              name: "gallery_id",
              label: "Gallery",
              values: items,
            },
            {
              type: "textbox",
              name: "max_thumbs",
              label: "Max Thumbnails",
              value: "3",
            },
          ],
          onsubmit: function (e) {
            var galleryID = e.data.gallery_id;
            var maxThumbs = e.data.max_thumbs || "3";

            if (!galleryID) {
              alert("Please select a gallery.");
              return false;
            }

            var shortcode =
              '[image_gallery id="' +
              galleryID +
              '" max="' +
              maxThumbs +
              '"]';

            editorInstance.insertContent(shortcode);
          },
        });
      },

      error: function () {
        alert("Error loading gallery posts.");
      },
    });
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
  });
})();
