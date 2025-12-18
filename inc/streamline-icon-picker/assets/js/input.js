(function($){
    function initAjaxSelect($select){
        if ($select.data('streamline-inited')) return;
        $select.data('streamline-inited', true);

        var ajaxUrl = (typeof StreamlineIconPicker !== 'undefined' && StreamlineIconPicker.ajax_url) ? StreamlineIconPicker.ajax_url : ajaxurl;
        var nonce = (typeof StreamlineIconPicker !== 'undefined') ? StreamlineIconPicker.nonce : $select.data('nonce');
        var minChars = (typeof StreamlineIconPicker !== 'undefined') ? (StreamlineIconPicker.min_chars || 2) : 2;
        var selectId = $select.attr('id') || ('streamline-icon-' + Math.random().toString(36).slice(2));
        var placeholderText = 'Type 1-2 characters to search icons';

        if (!$select.attr('id')) $select.attr('id', selectId);

        $select.select2({
            placeholder: placeholderText,
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

        // Try to attach clear button after Select2 creates its DOM. Retry a few times.
        (function tryAttach(retries){
            retries = retries || 8;
            // prefer Select2's internal $container
            var $s2container = ($select.data('select2') && $select.data('select2').$container) ? $select.data('select2').$container : $select.next('.select2-container');
            if ($s2container && $s2container.length) {
                // Always store the clean placeholder HTML as default (not the current rendered state)
                // This ensures newly cloned fields also have the correct default
                var defaultHtml = '<span class="select2-selection__placeholder">Type 1-2 characters to search icons</span>';
                $select.data('default-rendered-html', defaultHtml);
                
                // NOW attach the button
                attachClearButtonToContainer($select, $s2container);
                toggleClearButton($select);
                // wire change events
                $select.on('change', function(){ toggleClearButton($select); });
                $select.on('select2:select select2:unselect', function(){ toggleClearButton($select); });
            } else if (retries > 0) {
                setTimeout(function(){ tryAttach(retries - 1); }, 50);
            } else {
                // final attempt: still attach events so toggle runs if container appears later
                $select.on('change', function(){ toggleClearButton($select); });
            }
        })();
    }

    // attach button given a known Select2 container
    function attachClearButtonToContainer($select, $s2container){
        var $selection = $s2container.find('.select2-selection');
        if (!$selection.length) return;
        if ($selection.find('.streamline-icon-clear-btn').length) return;

        var $btn = $('<button type="button" class="streamline-icon-clear-btn" aria-label="Clear icon">×</button>');
        $btn.attr('data-target-id', $select.attr('id'));

        // insert before the arrow if available
        var $arrow = $selection.find('.select2-selection__arrow');
        if ($arrow.length) {
            $arrow.before($btn);
        } else {
            $selection.append($btn);
        }
    }

    // fallback wrapper used elsewhere in file
    function attachClearButton($select){
        var $s2container = $select.next('.select2-container');
        if ($s2container.length) attachClearButtonToContainer($select, $s2container);
    }

    function toggleClearButton($select){
        var $s2container = ($select.data('select2') && $select.data('select2').$container) ? $select.data('select2').$container : $select.next('.select2-container');
        var $btn = $s2container.find('.streamline-icon-clear-btn');
        if (!$btn.length) return;
        if ($select.val()) $btn.show(); else $btn.hide();
    }

    function injectStyles(){
        if ($('#streamline-icon-style').length) return;
        $('<style id="streamline-icon-style"> \
            .streamline-option-img, .streamline-selection-img{ width:20px; height:20px; vertical-align:middle; margin-right:6px; } \
            .select2-container--default .select2-selection--single .streamline-selection { display:flex; align-items:center; } \
            .select2-container--default .select2-results__option .streamline-option { display:flex; align-items:center; } \
            .streamline-icon-clear-btn { position:absolute; right:28px; top:50%; transform:translateY(-50%); background:transparent; border:none; color:#666; cursor:pointer; font-size:18px; padding:0 6px; line-height:1; z-index:9999; display:none; } \
            .streamline-icon-clear-btn:hover { color:#222; } \
            .select2-selection { position:relative; } \
        </style>').appendTo('head');
    }

    // helper: escape text for HTML insertion
    function escapeHtml(str){
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
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
                    var $select = $(this);
                    // remove the init flag so it re-initializes
                    $select.data('streamline-inited', false);
                    
                    // if Select2 already initialized on this element, destroy it first
                    if ($select.data('select2')) {
                        try {
                            $select.select2('destroy');
                        } catch(e) {}
                    }
                    
                    // now init fresh
                    initAjaxSelect($select);
                });
            });
            acf.add_action('render_field', function($el){
                $el.find('.streamline-icon-select').each(function(){
                    var $select = $(this);
                    $select.data('streamline-inited', false);
                    if ($select.data('select2')) {
                        try {
                            $select.select2('destroy');
                        } catch(e) {}
                    }
                    initAjaxSelect($select);
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
                            } else if ($(node).hasClass && $(node).hasClass('streamline-icon-select')) {
                                initAjaxSelect($(node));
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

        // delegated click for clear button
        $(document).on('click', '.streamline-icon-clear-btn', function(e){
            e.preventDefault();
            e.stopPropagation();

            var $btn = $(this);
            var targetId = $btn.attr('data-target-id');
            if (!targetId) return;
            var $select = $('#' + targetId);
            if (!$select.length) return;

            // ensure empty option exists
            if ($select.find('option[value=""]').length === 0) {
                $select.prepend('<option value=""></option>');
            }

            // remove any synthetic option that might have been injected server-side
            var prev = $select.find('option:selected').val() || '';
            if (prev) {
                $select.find('option').filter(function(){ return $(this).val() === prev; }).remove();
            }

            // clear value first
            $select.val(null);

            // get Select2 container and rendered area
            var s2 = $select.data('select2');
            var $s2container = (s2 && s2.$container) ? s2.$container : $select.next('.select2-container');
            
            if ($s2container && $s2container.length) {
                var $rendered = $s2container.find('.select2-selection__rendered');
                
                // restore the default HTML (with placeholder)
                var defaultHtml = $select.data('default-rendered-html');
                if (defaultHtml) {
                    $rendered.html(defaultHtml);
                } else {
                    // fallback if default not stored
                    $rendered.empty().append('<span class="select2-selection__placeholder">Type 1-2 characters to search icons</span>');
                }
            }

            // trigger change for ACF listeners
            $select.trigger('change');

            // also clear the per-field size select if present
            var $size = $select.closest('.streamline-icon-field').find('.streamline-icon-size');
            if ($size.length) {
                $size.val('').trigger('change');
            }

            // hide button
            $btn.hide();
        });

        // keep showing/hiding on manual change events
        $(document).on('change', '.streamline-icon-select', function(){
            toggleClearButton($(this));
        });
    });
})(jQuery);
