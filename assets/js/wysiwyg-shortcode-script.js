(function () {
    tinymce.PluginManager.add('wysiwyg_shortcode_btn', function (editor, url) {
        editor.addButton('wysiwyg_shortcode_btn', {
            title: 'Insert Wysiwyg Shortcode Options',
            text: 'Add Wysiwyg Shortcode',
            classes: 'btn wysiwyg_shortcode_btn',
            // icon: 'dashicons-admin-generic',
            onclick: function () {
                editor.windowManager.open({
                    title: 'Insert Wysiwyg Shortcode Options',
                    body: [
                        {
                            type: 'container',
                            layout: 'flex',
                            direction: 'column',
                            spacing: 10,
                            items: [

                                // ---- ROW 1 ----
                                {
                                    type: 'container',
                                    layout: 'flex',
                                    direction: 'row',
                                    align: 'center',
                                    spacing: 10,
                                    items: [
                                        { type: 'checkbox', name: 'add_video' },
                                        { type: 'label', text: 'Add Video Shortcode' },
                                        { type: 'checkbox', name: 'add_event' },
                                        { type: 'label', text: 'Add Event Shortcode' },
                                        { type: 'checkbox', name: 'image_gallery' },
                                        { type: 'label', text: 'Add Image Gallery Shortcode' }
                                    ]
                                },

                                // ---- ROW 2 ----
                                {
                                    type: 'container',
                                    layout: 'flex',
                                    direction: 'row',
                                    align: 'center',
                                    spacing: 10,
                                    items: [
                                        { type: 'checkbox', name: 'add_testimonial' },
                                        { type: 'label', text: 'Add Testimonial Shortcode' },
                                        { type: 'checkbox', name: 'add_fontsize' },
                                        { type: 'label', text: 'Add Font Size Shortcode' },

                                    ]
                                },
                            ]
                        }
                    ],

                    onsubmit: function (e) {
                        var output = '';
                        if (e.data.add_video) output += '[add_video]<br>';
                        if (e.data.add_event) output += '[add_event_shortcode]<br>';
                        if (e.data.image_gallery) output += '[image_gallery]<br>';
                        if (e.data.add_testimonial) output += '[add_testimonial]<br>';
                        if (e.data.add_fontsize) output += '[font_size]<br>';
                        editor.insertContent(output || "No shortcodes selected.");
                    }
                });
            }
        });
        const style = document.createElement('style');
        style.innerHTML = `
            .mce-wysiwyg_shortcode_btn button  {
                background: #f6f7f7;
                border: 1px solid #ccc;
                border-radius: 3px;
                color: #23282d;
                padding: 3px 8px !important;
                height: 30px;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 5px;
            }
                
            .mce-wysiwyg_shortcode_btn button:hover {
                border: unset;
                border-radius:unset;
            }
        `;
        document.head.appendChild(style);
    });
})();
