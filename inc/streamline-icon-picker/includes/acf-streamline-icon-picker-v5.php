<?php
/**
 * Custom ACF Field: Streamline Icon Picker
 * Fully working version with get_field() support
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'ACF_Field_Streamline_Icon_Picker' ) ) :

class ACF_Field_Streamline_Icon_Picker extends acf_field {

    public function initialize() {
        $this->name     = 'streamline_icon_picker';
        $this->label    = __( 'Streamline Icon Picker', 'acf' );
        $this->category = 'choice';
    }

    /**
     * Remove global icon size from field settings (no size while creating field)
     */
    public function render_field_settings( $field ) {
        // intentionally empty — size is chosen per-instance when selecting an icon
    }

    /**
     * Render field dropdown + inline size selector - load icons from local filesystem
     */
    public function render_field( $field ) {
        // keep field value normalization (array or legacy string)
        $raw_value = $field['value'] ?? '';
        $selected_icon = '';
        $selected_size = '';
        if ( is_array( $raw_value ) ) {
            $selected_icon = $raw_value['icon'] ?? '';
            $selected_size = $raw_value['size'] ?? '';
        } else {
            $selected_icon = is_string( $raw_value ) ? $raw_value : '';
        }

        // render select with no options; Select2 AJAX will populate based on input
        $nonce = wp_create_nonce( 'streamline_icon_search' );
        $field_name = esc_attr( $field['name'] );
        $field_id = 'streamline-icon-' . uniqid();

        echo '<div class="streamline-icon-field" style="display:flex;gap:8px;align-items:center;">';

        // icon select wrapper
        echo '<div style="flex:0 0 80%;position:relative;">';
        
        printf(
            '<select id="%1$s" name="%2$s[icon]" class="streamline-icon-select" data-ajax-action="streamline_icon_search" data-nonce="%3$s" style="width:100%%;">',
            esc_attr( $field_id ),
            $field_name,
            esc_attr( $nonce )
        );

        // if there's an existing selected icon, include it as a single option so Select2 can show it
        if ( $selected_icon ) {
            // get preview URL and label if possible
            $preview = Streamline_API_Handler::get_icon_svg_url( $selected_icon );
            $label = str_replace( array( '-', '_' ), ' ', $selected_icon );
            $label = ucwords( $label );
            printf(
                '<option value="%1$s" selected data-preview="%3$s">%2$s</option>',
                esc_attr( $selected_icon ),
                esc_html( $label ),
                esc_url( $preview )
            );
        }

        echo '</select>';
        echo '</div>';

        // size select (per selection)
        $size_choices = array(
            'extra_small' => 'Extra Small',
            'small'       => 'Small',
            'medium'      => 'Medium',
            'large'       => 'Large',
        );
        echo '<select name="' . $field_name . '[size]" class="streamline-icon-size" style="flex:0 0 20%;">';
        foreach ( $size_choices as $key => $label ) {
            $sel = selected( $selected_size, $key, false );
            printf( '<option value="%1$s" %2$s>%3$s</option>',
                esc_attr( $key ),
                $sel,
                esc_html( $label )
            );
        }
        echo '</select>';

        echo '</div>';
    }

    /**
     * Save the value (supports array or legacy string)
     */
    public function update_value( $value, $post_id, $field ) {
        if ( is_array( $value ) ) {
            $icon = sanitize_text_field( $value['icon'] ?? '' );
            $size = sanitize_text_field( $value['size'] ?? '' );
            $save = array( 'icon' => $icon, 'size' => $size );
            update_post_meta( $post_id, $field['name'], $save );
            return $save;
        }

        // legacy single string
        $value = sanitize_text_field( $value );
        update_post_meta( $post_id, $field['name'], $value );
        return $value;
    }

    /**
     * Load saved meta and normalize to array if needed
     */
    public function load_value( $value, $post_id, $field ) {
        if ( empty( $value ) ) {
            $meta_value = get_post_meta( $post_id, $field['name'], true );
            if ( ! empty( $meta_value ) ) {
                if ( is_array( $meta_value ) ) {
                    $value = $meta_value;
                } else {
                    $value = array( 'icon' => sanitize_text_field( $meta_value ), 'size' => '' );
                }
            }
        } else {
            if ( is_string( $value ) ) {
                $value = array( 'icon' => sanitize_text_field( $value ), 'size' => '' );
            }
        }
        return $value;
    }

    /**
     * Enqueue select2 and field JS
     */
    public function input_admin_enqueue_scripts() {
        $base_url = get_template_directory_uri() . '/inc/streamline-icon-picker/assets/';
        wp_enqueue_script('select2');
        wp_enqueue_style('select2');

        wp_enqueue_script(
            'streamline-icon-field',
            $base_url . 'js/input.js',
            array( 'jquery', 'select2' ),
            '1.0.0',
            true
        );

        // pass ajax URL + defaults to JS
        wp_localize_script( 'streamline-icon-field', 'StreamlineIconPicker', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'streamline_icon_search' ),
            'min_chars' => 2, // require 1 or 2 characters as needed
        ) );
    }

}

endif;

// Register field
add_action( 'acf/include_field_types', function() {
    acf_register_field_type( 'ACF_Field_Streamline_Icon_Picker' );
}, 99 );
