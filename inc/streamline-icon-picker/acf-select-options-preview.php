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
        document.addEventListener('DOMContentLoaded', function(){
            var wrappers = document.querySelectorAll('.acf-field[data-name="{$field_name}"]');
            wrappers.forEach(function(wrapper){
                var select = wrapper.querySelector('select');
                if(!select) return;
                var preview = document.createElement('div');
                preview.className = 'acf-embellishment-preview';
                preview.style.boxSizing = 'border-box';
                preview.style.marginLeft = '8px';

                // Make select and preview sit on one line: select 80%, preview 20%
                var container = select.parentNode;
                container.style.display = 'flex';
                container.style.alignItems = 'center';
                // Ensure select takes 80% and preview 20%
                select.style.boxSizing = 'border-box';
                select.style.flex = '0 0 80%';
                select.style.maxWidth = '80%';
                preview.style.flex = '0 0 20%';
                preview.style.maxWidth = '20%';

                select.parentNode.insertBefore(preview, select.nextSibling);
                function update(val){
                    if(mapping[val]){
                            // use a smaller fixed preview (60px) so it doesn't dominate the row
                            preview.innerHTML = '<img src="'+mapping[val]+'" style="width:115px;height:115px;border:1px solid #ddd;padding:4px;background:#fff;border-radius:3px"/>';
                        } else {
                            preview.innerHTML = '';
                        }
                }
                update(select.value);
                select.addEventListener('change', function(){ update(this.value); });
            });
        });
    })();
    </script>
    JS;

    echo $script;
}

add_action('acf/input/admin_enqueue_scripts', 'acf_embellishment_admin_preview_script');