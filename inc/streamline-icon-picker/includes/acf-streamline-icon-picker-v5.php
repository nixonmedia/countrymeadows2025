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
     * Render field dropdown
     */
    public function render_field( $field ) {
        $icons = get_option( 'streamline_icon_data', [] );
        $value = esc_attr( $field['value'] ?? '' );

        echo '<select name="' . esc_attr( $field['name'] ) . '" class="streamline-icon-select" style="width:100%;">';
        echo '<option value="">Select Icon</option>';

        if ( ! empty( $icons ) && is_array( $icons ) ) {
            foreach ( $icons as $icon ) {
                $selected = selected( $value, $icon['id'], false );
                printf(
                    '<option value="%1$s" %3$s data-preview="%4$s">%2$s</option>',
                    esc_attr( $icon['id'] ),
                    esc_html( $icon['name'] ),
                    $selected,
                    esc_url( $icon['preview'] )
                );
            }
        } else {
            echo '<option disabled>No icons found. Run ?streamline_sync=1</option>';
        }

        echo '</select>';
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
            ['jquery', 'select2'],
            '1.0.3',
            true
        );
    }

    /**
     * ✅ Save the value as plain meta
     */
    public function update_value( $value, $post_id, $field ) {
        // var_dump($value);
        // $icons = get_option('streamline_icon_data', []);
    
        // // If the value is not an actual ID (doesn't start with ico_), try to map it by name
        // if (strpos($value, 'ico_') !== 0) {
        //     foreach ($icons as $icon) {
        //         if ($icon['name'] === $value) {
        //             $value = $icon['id'];
        //             break;
        //         }
        //     }
        // }

        $value = sanitize_text_field( $value );
        update_post_meta( $post_id, $field['name'], $value );
        return $value;
    }

    /**
     * ✅ Load the saved meta so get_field() works
     */
    public function load_value( $value, $post_id, $field ) {
        if ( empty( $value ) ) {
            $meta_value = get_post_meta( $post_id, $field['name'], true );
            if ( ! empty( $meta_value ) ) {
                $value = $meta_value;
            }
        }
        return $value;
    }

    /**
     * ✅ Ensure formatted value returns the icon ID
     */
    // public function format_value( $value, $post_id, $field ) {
    //     if ( empty( $value ) ) {
    //         $value = get_post_meta( $post_id, $field['name'], true );
    //     }

    //     $value = sanitize_text_field( $value );
    //     if ( empty( $value ) ) {
    //         return null;
    //     }

    //     // Fetch full icon info from stored data
    //     $icons = get_option( 'streamline_icon_data', [] );

    //     if ( ! empty( $icons ) && is_array( $icons ) ) {
    //         foreach ( $icons as $icon ) {
    //             if ( isset( $icon['id'] ) && $icon['id'] === $value ) {
    //                 return $icon;
    //             }
    //         }
    //     }

    //     // Fallback: just return ID if no match found
    //     return [
    //         'id'      => $value,
    //         'name'    => '',
    //         'family'  => '',
    //         'preview' => '',
    //     ];
    // }

}

endif;

// Register field
add_action( 'acf/include_field_types', function() {
    acf_register_field_type( 'ACF_Field_Streamline_Icon_Picker' );
}, 99 );
