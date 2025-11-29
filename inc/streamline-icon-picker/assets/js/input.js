(function($){
    function initAjaxSelect($select){
        if ($select.data('streamline-inited')) return;
        $select.data('streamline-inited', true);

        var ajaxUrl = (typeof StreamlineIconPicker !== 'undefined' && StreamlineIconPicker.ajax_url) ? StreamlineIconPicker.ajax_url : ajaxurl;
        var nonce = (typeof StreamlineIconPicker !== 'undefined') ? StreamlineIconPicker.nonce : $select.data('nonce');
        var minChars = (typeof StreamlineIconPicker !== 'undefined') ? (StreamlineIconPicker.min_chars || 2) : 2;

        $select.select2({
            placeholder: 'Type 1-2 characters to search icons',
            minimumInputLength: minChars,
            ajax: {
                url: ajaxUrl,
                dataType: 'json',
                delay: 250,
                data: function(params){
                    return {
                        action: 'streamline_icon_search',
                        nonce: nonce,
                        q: params.term
                    };
                },
                processResults: function(data){
                    // data should be { results: [ { id, text, preview } ] }
                    if (!data || !data.results) return { results: [] };
                    return { results: data.results };
                }
            },
            escapeMarkup: function(m){ return m; },
            templateResult: function(item){
                if (!item.id) return item.text;
                var preview = item.preview || $(item.element).data('preview') || '';
                return (preview ? '<span class="streamline-option"><img src="'+ preview +'" class="streamline-option-img" alt="" /> ' : '') + '<span class="streamline-option-label">'+ item.text +'</span>' + (preview ? '</span>' : '');
            },
            templateSelection: function(item){
                if (!item.id) return item.text;
                var preview = item.preview || $(item.element).data('preview') || '';
                return (preview ? '<span class="streamline-selection"><img src="'+ preview +'" class="streamline-selection-img" alt="" /> <span class="streamline-selection-label">'+ item.text +'</span></span>' : item.text);
            },
            width: 'resolve',
            dropdownParent: $select.closest('.acf-field')
        });
    }

    function injectStyles(){
        if ($('#streamline-icon-style').length) return;
        $('<style id="streamline-icon-style"> \
            .streamline-option-img, .streamline-selection-img{ width:20px; height:20px; vertical-align:middle; margin-right:6px; } \
            .select2-container--default .select2-selection--single .streamline-selection { display:flex; align-items:center; } \
            .select2-container--default .select2-results__option .streamline-option { display:flex; align-items:center; } \
        </style>').appendTo('head');
    }

    $(document).ready(function(){
        injectStyles();

        // init existing selects
        $('.streamline-icon-select').each(function(){
            initAjaxSelect($(this));
        });

        // ACF dynamic events
        if (typeof acf !== 'undefined') {
            acf.add_action('ready append', function($el){
                $el.find('.streamline-icon-select').each(function(){
                    initAjaxSelect($(this));
                });
            });
            acf.add_action('render_field', function($el){
                $el.find('.streamline-icon-select').each(function(){
                    initAjaxSelect($(this));
                });
            });
        }

        // MutationObserver fallback
        if (window.MutationObserver) {
            var mo = new MutationObserver(function(mutations){
                mutations.forEach(function(m){
                    Array.prototype.forEach.call(m.addedNodes || [], function(node){
                        try {
                            var $node = $(node);
                            if ($node.find && $node.find('.streamline-icon-select').length) {
                                $node.find('.streamline-icon-select').each(function(){
                                    initAjaxSelect($(this));
                                });
                            }
                        } catch(e){}
                    });
                });
            });
            if (document.body) {
                mo.observe(document.body, { childList: true, subtree: true });
            } else {
                document.addEventListener('DOMContentLoaded', function(){
                    mo.observe(document.body, { childList: true, subtree: true });
                });
            }
        }

    });
})(jQuery);
