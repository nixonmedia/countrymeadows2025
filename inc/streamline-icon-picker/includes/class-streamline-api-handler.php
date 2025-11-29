<?php
/**
 * Handles StreamlineHQ icon loading from local filesystem (no API).
 */

class Streamline_API_Handler {

    const OPTIONS_KEY   = 'streamline_icon_data';
    const ICONS_FOLDER  = 'inc/streamline-icon-picker/icons';

    public static function init() {
        // Register AJAX search handler for admin (used by Select2 AJAX)
        add_action( 'wp_ajax_streamline_icon_search', array( __CLASS__, 'ajax_search_icons' ) );
    }

    /**
     * AJAX: search icons by query (returns select2-compatible JSON)
     */
    public static function ajax_search_icons() {
        // only for logged-in admin users (field is used in WP admin)
        if ( ! current_user_can( 'edit_posts' ) ) {
            wp_send_json_error( 'unauthorized', 403 );
        }

        check_ajax_referer( 'streamline_icon_search', 'nonce' );

        $q = isset( $_REQUEST['q'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['q'] ) ) : '';
        $q = trim( $q );

        $icons_dir = get_template_directory() . '/' . self::ICONS_FOLDER;
        $icons_uri = get_template_directory_uri() . '/' . self::ICONS_FOLDER;

        $results = array();

        if ( $q !== '' && is_dir( $icons_dir ) ) {
            // Simple case-insensitive filename match
            foreach ( glob( $icons_dir . '/*.svg' ) as $file ) {
                $basename = basename( $file, '.svg' );
                if ( stripos( $basename, $q ) !== false ) {
                    $results[] = array(
                        'id'   => $basename,
                        'text' => self::humanize_label( $basename ),
                        'preview' => $icons_uri . '/' . $basename . '.svg',
                    );
                }
            }

            // sort alphabetically by text
            usort( $results, function( $a, $b ) {
                return strcasecmp( $a['text'], $b['text'] );
            } );
        }

        // Select2 expects { results: [ { id, text, ... } ] }
        wp_send_json( array( 'results' => $results ) );
    }

    /**
     * Humanize filename to label (replace hyphens/underscores and ucwords)
     */
    private static function humanize_label( $basename ) {
        $label = str_replace( array( '-', '_' ), ' ', $basename );
        $label = preg_replace( '/\s+/', ' ', trim( $label ) );
        return ucwords( $label );
    }

    /**
     * Load icons from local filesystem (icons folder)
     */
    public static function get_icons() {
        $icons_dir = get_template_directory() . '/' . self::ICONS_FOLDER;
        $icons = [];

        if (!is_dir($icons_dir)) {
            return $icons;
        }

        $files = glob($icons_dir . '/*.svg');
        if (empty($files)) {
            return $icons;
        }

        $icons_uri = get_template_directory_uri() . '/' . self::ICONS_FOLDER;

        foreach ($files as $file) {
            $basename = basename($file, '.svg');
            $icons[] = [
                'id'      => $basename,
                'name'    => $basename,
                'path'    => $file,
                'preview' => $icons_uri . '/' . $basename . '.svg',
            ];
        }

        // Sort icons by name
        usort($icons, function($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        return $icons;
    }

    /**
     * Try to resolve a usable icon basename (filename without extension)
     * from a stored value which may be a basename or a human label.
     */
    private static function resolve_icon_basename( $value ) {
        if ( empty( $value ) ) {
            return '';
        }

        $value = (string) $value;
        $icons_dir = get_template_directory() . '/' . self::ICONS_FOLDER;

        // candidate transformations
        $candidates = array();

        // 1) sanitize as-is
        $candidates[] = sanitize_file_name( $value );

        // 2) replace spaces/underscores with hyphens (common filename pattern)
        $candidates[] = str_replace( array( ' ', '_' ), '-', $value );

        // 3) lowercase variants
        $candidates[] = strtolower( str_replace( array( ' ', '_' ), '-', $value ) );

        // 4) remove .svg if accidentally included
        $candidates = array_map( function( $c ) {
            return preg_replace( '/\.svg$/i', '', $c );
        }, $candidates );

        // normalize and uniq
        $candidates = array_unique( array_filter( array_map( 'trim', $candidates ) ) );

        // check filesystem for candidates
        foreach ( $candidates as $cand ) {
            $path = $icons_dir . '/' . $cand . '.svg';
            if ( file_exists( $path ) ) {
                return $cand;
            }
        }

        // fallback: try to match by humanized label against filenames
        if ( is_dir( $icons_dir ) ) {
            foreach ( glob( $icons_dir . '/*.svg' ) as $file ) {
                $basename = basename( $file, '.svg' );
                // humanize both sides for comparison
                $labelA = self::humanize_label( $basename );
                $labelB = self::humanize_label( $value );
                if ( strcasecmp( $labelA, $labelB ) === 0 ) {
                    return $basename;
                }
                // also allow partial match if user typed part of label
                if ( stripos( $labelA, $labelB ) !== false || stripos( $labelB, $labelA ) !== false ) {
                    return $basename;
                }
            }
        }

        // last resort: return sanitized first candidate even if file missing
        return $candidates[0] ?? '';
    }

    /**
     * Get filesystem path to SVG file
     */
    public static function get_icon_svg_path( $icon_id ) {
        $basename = self::resolve_icon_basename( $icon_id );
        if ( empty( $basename ) ) {
            return '';
        }

        $file_path = get_template_directory() . '/' . self::ICONS_FOLDER . '/' . $basename . '.svg';

        if ( ! file_exists( $file_path ) || ! is_readable( $file_path ) ) {
            return '';
        }

        return $file_path;
    }

    /**
     * Return public URL to SVG
     */
    public static function get_icon_svg_url( $icon_id ) {
        $basename = self::resolve_icon_basename( $icon_id );
        if ( empty( $basename ) ) {
            return '';
        }

        $icons_uri = get_template_directory_uri() . '/' . self::ICONS_FOLDER . '/' . $basename . '.svg';

        return esc_url_raw( $icons_uri );
    }

    /**
     * Format value hook - return full SVG markup when get_field() is called
     * Supports stored value as array('icon' => 'name', 'size' => 'small') or legacy string.
     */
    public static function format_value( $value, $post_id, $field ) {
        if ( empty( $value ) ) {
            return '';
        }

        if ( is_array( $value ) ) {
            $icon_id  = $value['icon'] ?? '';
            $size_key = $value['size'] ?? '';
        } else {
            $icon_id  = $value;
            $size_key = '';
        }

        if ( empty( $icon_id ) ) {
            return '';
        }

        $file_path = self::get_icon_svg_path( $icon_id );
        if ( empty( $file_path ) ) {
            return '';
        }

        $svg_content = file_get_contents( $file_path );
        if ( empty( $svg_content ) ) {
            return '';
        }

        $size_map = array(
            'extra_small' => 24,
            'small'       => 40,
            'medium'      => 60,
            'large'       => 85,
        );

        $width = null;
        if ( ! empty( $size_key ) && isset( $size_map[ $size_key ] ) ) {
            $width = intval( $size_map[ $size_key ] );
        }

        if ( $width ) {
            if ( preg_match( '/<svg\b[^>]*>/i', $svg_content, $m ) ) {
                $svg_tag = $m[0];
                $new_svg_tag = preg_replace( '/\s(width|height)=("|\')[^"\']*("|\')/i', '', $svg_tag );
                $new_svg_tag = rtrim( $new_svg_tag, '>' ) . ' width="' . $width . '" height="' . $width . '">';
                $svg_content = preg_replace( '/<svg\b[^>]*>/i', $new_svg_tag, $svg_content, 1 );
            }
        }

        return $svg_content;
    }
}

// Register ACF format_value filter for this field type
add_filter( 'acf/format_value/type=streamline_icon_picker', array( 'Streamline_API_Handler', 'format_value' ), 10, 3 );

Streamline_API_Handler::init();
