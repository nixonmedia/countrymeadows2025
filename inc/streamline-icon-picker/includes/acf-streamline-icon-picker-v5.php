<?php
/**
 * Custom ACF Field: Streamline Icon Picker
 * Works from inside your theme (no plugin).
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action('acf/include_field_types', function() {
    class ACF_Field_Streamline_Icon_Picker extends acf_field {

        public function initialize() {
            $this->name     = 'streamline_icon_picker';
            $this->label    = __('Streamline Icon Picker', 'acf');
            $this->category = 'choice';
        }

        public function render_field( $field ) {
            $icons = get_option( 'streamline_icon_data', [] );

            if ( empty( $icons ) ) {
                echo '<p style="color:red;">⚠️ No icons found. Visit <code>?streamline_sync=1</code> to fetch icons.</p>';
                return;
            }

            echo '<select name="' . esc_attr( $field['name'] ) . '" class="streamline-icon-select" style="width:100%;">';
            echo '<option value="">Select Icon</option>';

            foreach ( $icons as $icon ) {
                $selected = selected( $field['value'], $icon['id'], false );
                $preview  = esc_url( $icon['preview'] ?? '' );
                $label    = esc_html( $icon['name'] );

                printf(
                    '<option value="%1$s" %3$s data-preview="%4$s">%2$s</option>',
                    esc_attr( $icon['id'] ),
                    $label,
                    $selected,
                    $preview
                );
            }

            echo '</select>';
        }

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
         * Save the selected icon value
         */
        public function update_value( $value, $post_id, $field ) {
            // Just return the value as-is; ACF will handle DB save
            return sanitize_text_field( $value );
        }

        /**
         * Load saved value back into the field
         */
        public function load_value( $value, $post_id, $field ) {
            return $value;
        }
    }

    acf_register_field_type('ACF_Field_Streamline_Icon_Picker');
});
