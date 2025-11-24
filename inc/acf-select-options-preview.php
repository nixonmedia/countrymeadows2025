<?php 
// ACF Load Embellishment Field
function acf_load_embellishment( $field ) {
    
    // Reset choices
    $field['choices'] = array();

    // Load image filenames from theme assets folder: assets/images/embellishments
    $images_dir = get_template_directory() . '/assets/images/embellishments';
    $images_uri = get_template_directory_uri() . '/assets/images/embellishments';

    $files = array();
    if ( is_dir( $images_dir ) ) {
        // Only SVG files expected in this folder
        $files = glob( $images_dir . '/*.svg' );
    }

    // Build an array of choices keyed by filename, with human-friendly labels
    $choices = array();
    foreach ( $files as $file ) {
        $basename = basename( $file );
        $name = pathinfo( $basename, PATHINFO_FILENAME );
        // Humanize: replace hyphens/underscores with spaces and capitalize words
        $label = ucwords( str_replace( array( '-', '_' ), ' ', $name ) );
        $choices[ $name ] = $label;
    }

    // Sort choices by label ascending (natural, case-insensitive)
    if ( ! empty( $choices ) ) {
        asort( $choices, SORT_NATURAL | SORT_FLAG_CASE );
        foreach ( $choices as $key => $label ) {
            $field['choices'][ $key ] = $label;
        }
    }



    // Return the field
    return $field;
    
}

add_action('acf/load_field/name=embellishment', 'acf_load_embellishment');

/**
 * Enqueue admin script to show a thumbnail preview next to the select field when an option is selected.
 */
function acf_embellishment_admin_preview_script() {
    // Build mapping of filename (no extension) => image URL from assets
    $mapping = array();
    // define images dir/uri inside this function
    $images_dir = get_template_directory() . '/assets/images/embellishments';
    $images_uri = get_template_directory_uri() . '/assets/images/embellishments';
    if ( is_dir( $images_dir ) ) {
        // Only SVGs
        $files = glob( $images_dir . '/*.svg' );
        foreach ( $files as $file ) {
            $basename = basename( $file );
            $name = pathinfo( $basename, PATHINFO_FILENAME );
            $mapping[ $name ] = $images_uri . '/' . $basename;
        }
    }

    $json = wp_json_encode( $mapping );
    $field_name = 'embellishment';

    // Inline script hooked into ACF admin enqueue point
    $script = <<<JS
    <script>
    (function(){
        var mapping = $json;

        function setPreview(previewEl, url){
            if(url){
                previewEl.innerHTML = '<img src="'+url+'" style="width:115px;height:115px;border:1px solid #ddd;background:#fff;border-radius:3px"/>';
            } else {
                previewEl.innerHTML = '';
            }
        }

        function initWrapper(wrapper){
            if(!wrapper) return;
            var select = wrapper.querySelector('select');
            if(!select){ return; }

            var preview = wrapper.querySelector('.acf-embellishment-preview');
            if(!preview){
                preview = document.createElement('div');
                preview.className = 'acf-embellishment-preview';
                preview.style.boxSizing = 'border-box';
                preview.style.marginLeft = '8px';
                preview.style.marginRight = '8px';

                var container = select.parentNode;
                container.style.display = 'flex';
                container.style.alignItems = 'center';
                select.style.boxSizing = 'border-box';
                select.style.flex = '0 0 80%';
                select.style.maxWidth = '80%';
                preview.style.flex = '0 0 20%';
                preview.style.maxWidth = '20%';

                select.parentNode.insertBefore(preview, select.nextSibling);
            }

            function update(val){ setPreview(preview, mapping[val] || null); }
            update(select.value);
            // per-select listener
                select.addEventListener('change', function(){ update(this.value); });
        }

        function process(container){
            container = container || document;
            var wrappers = container.querySelectorAll('.acf-field[data-name="{$field_name}"]');
            wrappers.forEach(function(w){ initWrapper(w); });
        }

        document.addEventListener('DOMContentLoaded', function(){ process(document); });

        // delegated change handler (capture) to catch selects added later
        document.addEventListener('change', function(e){
            var sel = e.target;
            if(!sel || sel.tagName !== 'SELECT') return;
            if(!sel.closest) return;
            var wrapper = sel.closest('.acf-field[data-name="{$field_name}"]');
            if(!wrapper) return;
            var preview = wrapper.querySelector('.acf-embellishment-preview');
            if(preview){ setPreview(preview, mapping[sel.value] || null); }
        }, true);

        // MutationObserver to log added nodes and auto-init wrappers
        if(window.MutationObserver){
            var initMO = function(){
                try{
                    var mo = new MutationObserver(function(records){
                        records.forEach(function(r){
                            r.addedNodes && r.addedNodes.forEach(function(node){
                                if(!node || node.nodeType !== 1) return;
                                if(node.matches && node.matches('.acf-field[data-name="{$field_name}"]')){
                                    // small delay to allow other scripts to initialize
                                    setTimeout(function(){ initWrapper(node); }, 50);
                                    setTimeout(function(){ initWrapper(node); }, 300);
                                } else if(node.querySelector){
                                    var found = node.querySelector('.acf-field[data-name="{$field_name}"]');
                                    if(found){ setTimeout(function(){ initWrapper(found); }, 50); setTimeout(function(){ initWrapper(found); }, 300); }
                                }
                            });
                        });
                    });
                            if(document && document.body){
                                mo.observe(document.body, { childList: true, subtree: true });
                            } else {
                                document.addEventListener('DOMContentLoaded', function(){
                                    try{ mo.observe(document.body, { childList: true, subtree: true }); }catch(e){}
                                });
                            }
                }catch(e){ console && console.log && console.log('[emb-debug] MutationObserver setup failed', e); }
            };

            if(document && document.body){
                initMO();
            } else {
                document.addEventListener('DOMContentLoaded', initMO);
            }
        }
    })();
    </script>
    JS;

    echo $script;
}

add_action('acf/input/admin_enqueue_scripts', 'acf_embellishment_admin_preview_script');

/**
 * Load choices for background_embellishment from assets/images/bg-patterns
 */
function acf_load_background_embellishment( $field ) {
    $field['choices'] = array();

    $images_dir = get_template_directory() . '/assets/images/bg-patterns';
    $images_uri = get_template_directory_uri() . '/assets/images/bg-patterns';

    $files = array();
    if ( is_dir( $images_dir ) ) {
        $files = glob( $images_dir . '/*.svg' );
    }

    $choices = array();
    foreach ( $files as $file ) {
        $basename = basename( $file );
        $name = pathinfo( $basename, PATHINFO_FILENAME );
        $label = ucwords( str_replace( array( '-', '_' ), ' ', $name ) );
        $choices[ $name ] = $label;
    }

    if ( ! empty( $choices ) ) {
        asort( $choices, SORT_NATURAL | SORT_FLAG_CASE );
        foreach ( $choices as $key => $label ) {
            $field['choices'][ $key ] = $label;
        }
    }

    return $field;
}

add_action('acf/load_field/name=background_embellishment', 'acf_load_background_embellishment');

/**
 * Admin preview script for background_embellishment (similar to embellishment preview)
 */
function acf_background_embellishment_admin_preview_script() {
    $mapping = array();
    $images_dir = get_template_directory() . '/assets/images/bg-patterns';
    $images_uri = get_template_directory_uri() . '/assets/images/bg-patterns';
    if ( is_dir( $images_dir ) ) {
        $files = glob( $images_dir . '/*.svg' );
        foreach ( $files as $file ) {
            $basename = basename( $file );
            $name = pathinfo( $basename, PATHINFO_FILENAME );
            $mapping[ $name ] = $images_uri . '/' . $basename;
        }
    }

    $json = wp_json_encode( $mapping );
    $field_name = 'background_embellishment';

    $script = <<<JS
    <script>
    (function(){
        var mapping = $json;

        function setPreview(previewEl, url){
            if(url){
                previewEl.innerHTML = '<img src="'+url+'" style="width:115px;height:115px;border:1px solid #ddd;background:#fff;border-radius:3px"/>';
            } else {
                previewEl.innerHTML = '';
            }
        }

        function initWrapper(wrapper){
            if(!wrapper) return;
            var select = wrapper.querySelector('select');
            if(!select) return;

            var preview = wrapper.querySelector('.acf-embellishment-preview');
            if(!preview){
                preview = document.createElement('div');
                preview.className = 'acf-embellishment-preview';
                preview.style.boxSizing = 'border-box';
                preview.style.marginLeft = '8px';
                preview.style.marginRight = '8px';

                var container = select.parentNode;
                container.style.display = 'flex';
                container.style.alignItems = 'center';
                select.style.boxSizing = 'border-box';
                select.style.flex = '0 0 80%';
                select.style.maxWidth = '80%';
                preview.style.flex = '0 0 20%';
                preview.style.maxWidth = '20%';

                select.parentNode.insertBefore(preview, select.nextSibling);
            }

            function update(val){ setPreview(preview, mapping[val] || null); }
            update(select.value);
            select.addEventListener('change', function(){ update(this.value); });
        }

        function process(container){
            container = container || document;
            var wrappers = container.querySelectorAll('.acf-field[data-name="{$field_name}"]');
            wrappers.forEach(function(w){ initWrapper(w); });
        }

        document.addEventListener('DOMContentLoaded', function(){ process(document); });

        document.addEventListener('change', function(e){
            var sel = e.target;
            if(!sel || sel.tagName !== 'SELECT') return;
            if(!sel.closest) return;
            var wrapper = sel.closest('.acf-field[data-name="{$field_name}"]');
            if(!wrapper) return;
            var preview = wrapper.querySelector('.acf-embellishment-preview');
            if(preview){ setPreview(preview, mapping[sel.value] || null); }
        }, true);

        if(window.MutationObserver){
            var initMO = function(){
                try{
                    var mo = new MutationObserver(function(records){
                        records.forEach(function(r){
                            r.addedNodes && r.addedNodes.forEach(function(node){
                                if(!node || node.nodeType !== 1) return;
                                if(node.matches && node.matches('.acf-field[data-name="{$field_name}"]')){
                                    setTimeout(function(){ initWrapper(node); }, 50);
                                    setTimeout(function(){ initWrapper(node); }, 300);
                                } else if(node.querySelector){
                                    var found = node.querySelector('.acf-field[data-name="{$field_name}"]');
                                    if(found){ setTimeout(function(){ initWrapper(found); }, 50); setTimeout(function(){ initWrapper(found); }, 300); }
                                }
                            });
                        });
                    });
                    if(document && document.body){
                        mo.observe(document.body, { childList: true, subtree: true });
                    } else {
                        document.addEventListener('DOMContentLoaded', function(){ try{ mo.observe(document.body, { childList: true, subtree: true }); }catch(e){} });
                    }
                }catch(e){}
            };

            if(document && document.body){ initMO(); } else { document.addEventListener('DOMContentLoaded', initMO); }
        }
    })();
    </script>
    JS;

    echo $script;
}

add_action('acf/input/admin_enqueue_scripts', 'acf_background_embellishment_admin_preview_script');