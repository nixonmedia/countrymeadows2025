<?php
/**
 * Handles StreamlineHQ API integration and ACF icon picker data sync.
 */

class Streamline_API_Handler {

    const OPTIONS_KEY = 'streamline_icon_data';
    const PUBLIC_API_URL = 'https://public-api.streamlinehq.com/v1/search/global';
    const INCLUDED_FAMILIES = ['streamline-freehand', 'streamline-freehand-duotone'];

    /**
     * Initialize hooks
     */
    public static function init() {
        add_action('admin_init', [__CLASS__, 'maybe_sync_icons']);
        add_filter('acf/format_value/type=streamline_icon_picker', [__CLASS__, 'format_icon_to_svg'], 10, 3);
        add_action('wp_ajax_streamline_fetch_svg', [__CLASS__, 'ajax_fetch_svg']);
        add_action('init', [__CLASS__, 'manual_sync_trigger']);
    }

    /**
     * Manual trigger: visit ?streamline_sync=1
     */
    public static function manual_sync_trigger() {
        if (isset($_GET['streamline_sync']) && current_user_can('manage_options')) {
            $count = self::sync_all_icon_metadata();

            if ($count > 0) {
                wp_die('✅ Streamline sync completed successfully. ' . $count . ' icons saved.');
            } else {
                wp_die('❌ Sync failed — check your API key, API response, or plan access.');
            }
        }
    }

    /**
     * Daily auto sync
     */
    public static function maybe_sync_icons() {
        if (get_transient('streamline_last_sync')) return;

        $count = self::sync_all_icon_metadata();
        if ($count > 0) {
            set_transient('streamline_last_sync', time(), DAY_IN_SECONDS);
        }
    }

    /**
     * Fetch ALL icons from both Freehand families in safe batches
     */
    public static function sync_all_icon_metadata() {
        if (!defined('STREAMLINE_API_KEY') || empty(STREAMLINE_API_KEY)) {
            error_log('[StreamlineHQ] Missing STREAMLINE_API_KEY constant.');
            return 0;
        }

        $existing_icons = get_option(self::OPTIONS_KEY, []);
        $all_icons = $existing_icons;
        $families = self::INCLUDED_FAMILIES;
        $limit = 100;               // icons per request
        $max_icons_per_run = 1000;  // safety batch limit to avoid timeout
        $total_fetched = 0;

        foreach ($families as $family) {
            $page = 1;

            while ($total_fetched < $max_icons_per_run) {
                $url = add_query_arg([
                    'productType' => 'icons',
                    'query'       => $family, // "freehand" and "freehand-duotone"
                    'page'        => $page,
                    'limit'       => $limit,
                ], self::PUBLIC_API_URL);

                $args = [
                    'headers' => [
                        'accept'    => 'application/json',
                        'x-api-key' => STREAMLINE_API_KEY,
                    ],
                    'timeout' => 20,
                    'sslverify' => false,
                ];

                $response = wp_remote_get($url, $args);

                if (is_wp_error($response)) {
                    error_log("[StreamlineHQ] API error for $family page $page: " . $response->get_error_message());
                    break;
                }

                $code = wp_remote_retrieve_response_code($response);
                $body = json_decode(wp_remote_retrieve_body($response), true);

                if ($code !== 200 || empty($body['results'])) {
                    error_log("[StreamlineHQ] Finished $family at page $page (no more results).");
                    break;
                }

                $icons = array_map(function ($icon) use ($family) {
                    return [
                        'id'      => $icon['hash'] ?? '',
                        'name'    => $icon['name'] ?? '',
                        'family'  => $family,
                        'preview' => $icon['imagePreviewUrl'] ?? '',
                    ];
                }, $body['results']);

                $fetched = count($icons);
                $total_fetched += $fetched;
                $all_icons = array_merge($all_icons, $icons);

                error_log("[StreamlineHQ] ✅ Page $page: $fetched icons from $family (total $total_fetched).");

                // stop if fewer than limit (last page) or reached run limit
                if ($fetched < $limit || $total_fetched >= $max_icons_per_run) {
                    break;
                }

                $page++;
            }

            error_log("[StreamlineHQ] ✅ Total fetched for $family this run: $total_fetched icons.");

            if ($total_fetched >= $max_icons_per_run) {
                error_log('[StreamlineHQ] ⚠️ Stopping early — reached batch limit of ' . $max_icons_per_run);
                break;
            }
        }

        if (!empty($all_icons)) {
            // remove duplicates by icon id
            $unique_icons = [];
            foreach ($all_icons as $icon) {
                $unique_icons[$icon['id']] = $icon;
            }
            $final_icons = array_values($unique_icons);

            update_option(self::OPTIONS_KEY, $final_icons, 'no');
            error_log('[StreamlineHQ] ✅ Total saved icons: ' . count($final_icons));
            return count($final_icons);
        }

        error_log('[StreamlineHQ] ❌ No icons saved.');
        return 0;
    }

    /**
     * Fetch SVG for given icon ID
     */
    public static function get_icon_svg($icon_id) {
        if (!$icon_id) return '';

        $cache_key = 'streamline_svg_' . sanitize_title($icon_id);
        if ($cached = get_transient($cache_key)) return $cached;

        $url = 'https://public-api.streamlinehq.com/v1/icons/' . $icon_id . '/svg';
        $args = [
            'headers' => [
                'x-api-key' => STREAMLINE_API_KEY,
                'accept'    => 'application/json',
            ],
            'timeout' => 15,
            'sslverify' => false,
        ];

        $response = wp_remote_get($url, $args);
        if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) return '';

        $svg = wp_remote_retrieve_body($response);
        set_transient($cache_key, $svg, 12 * HOUR_IN_SECONDS);
        return $svg;
    }

    /**
     * Display SVG instead of ID in ACF output
     */
    public static function format_icon_to_svg($value, $post_id, $field) {
        if (!$value) return '';
        return self::get_icon_svg($value);
    }

    /**
     * AJAX handler for live SVG fetch
     */
    public static function ajax_fetch_svg() {
        check_ajax_referer('streamline_icon_nonce', '_ajax_nonce');
        $icon_id = isset($_GET['icon_id']) ? sanitize_text_field($_GET['icon_id']) : '';
        $svg = self::get_icon_svg($icon_id);

        if (!$svg) {
            wp_send_json_error('Icon not found or invalid ID.');
        }

        wp_send_json_success($svg);
    }
}

Streamline_API_Handler::init();
