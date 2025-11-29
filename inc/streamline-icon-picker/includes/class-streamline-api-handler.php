<?php
/**
 * Handles StreamlineHQ API integration and ACF icon picker data sync.
 */

class Streamline_API_Handler {

    const OPTIONS_KEY       = 'streamline_icon_data';
    const QUEUE_KEY         = 'streamline_icon_queue';
    const PUBLIC_API_URL    = 'https://public-api.streamlinehq.com/v1/search/family/';
    const INCLUDED_FAMILIES = ['freehand-free', 'streamline-freehand', 'streamline-freehand-duotone'];
    const LIMIT             = 100; // icons per batch

    // ✅ Extended query set to cover all possible icon names
    const QUERY_SET = [
        'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
        '0','1','2','3','4','5','6','7','8','9','_','-'
    ];

    public static function init() {
        add_action('admin_init', [__CLASS__, 'maybe_sync_icons']);
        add_action('streamline_process_batch', [__CLASS__, 'process_batch']);
        add_action('wp_ajax_streamline_start_sync', [__CLASS__, 'ajax_start_sync']);
        add_action('wp_ajax_streamline_sync_progress', [__CLASS__, 'ajax_get_sync_progress']);
        add_filter('acf/format_value/type=streamline_icon_picker', [__CLASS__, 'format_icon_to_svg'], 10, 3);
        // add_action('wp_ajax_streamline_fetch_svg', [__CLASS__, 'ajax_fetch_svg']);
        add_action('admin_notices', [__CLASS__, 'render_progress_bar']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_admin_scripts']);
    }

    /** Manual trigger */
    public static function maybe_sync_icons() {
        if (isset($_GET['streamline_sync']) && current_user_can('manage_options')) {
            self::reset_sync();
            wp_die('Streamline sync started. Processing in background...');
        }
    }

    private static function reset_sync() {
        delete_transient(self::QUEUE_KEY);
        delete_option(self::OPTIONS_KEY);
        self::init_queue();
        do_action('streamline_process_batch');
    }

    /** Initialize full queue */
    private static function init_queue() {
        $queue = [];
        foreach (self::INCLUDED_FAMILIES as $family) {
            foreach (self::QUERY_SET as $query) {
                $queue[] = [
                    'family' => $family,
                    'query'  => $query,
                    'page'   => 1
                ];
            }
        }
        set_transient(self::QUEUE_KEY, $queue, DAY_IN_SECONDS); // last longer
    }

    /** Fetch and save icons batch-by-batch */
    public static function process_batch() {
        $queue = get_transient(self::QUEUE_KEY);
        if (empty($queue)) return;

        $current = array_shift($queue);
        $family  = $current['family'];
        $query   = $current['query'];
        $page    = $current['page'];

        $url = self::PUBLIC_API_URL . $family
             . '?productType=icons'
             . '&query=' . urlencode($query)
             . '&page=' . $page
             . '&limit=' . self::LIMIT;

        $args = [
            'headers' => [
                'accept'    => 'application/json',
                'x-api-key' => STREAMLINE_API_KEY,
            ],
            'timeout'   => 30,
            'sslverify' => false,
        ];

        $response = wp_remote_get($url, $args);
        $added_count = 0;

        if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
            $body = json_decode(wp_remote_retrieve_body($response), true);

            if (!empty($body['results'])) {
                $existing = get_option(self::OPTIONS_KEY, []);
                $icons = array_map(function($icon) use ($family) {
                    return [
                        'id'      => $icon['hash'] ?? '',
                        'name'    => $icon['name'] ?? '',
                        'family'  => $family,
                        'preview' => $icon['imagePreviewUrl'] ?? '',
                    ];
                }, $body['results']);

                $added_count = count($icons);
                $all_icons = array_merge($existing, $icons);
                $unique = [];
                foreach ($all_icons as $icon) {
                    if (!empty($icon['id'])) { // skip invalid entries
                        $unique[$icon['id']] = $icon;
                    }
                }
                update_option(self::OPTIONS_KEY, array_values($unique), 'no');

                // Continue pagination
                if (!empty($body['hasMore']) && $body['hasMore'] === true) {
                    $current['page'] += 1;
                    array_unshift($queue, $current);
                }
            }
        } else {
            $code = wp_remote_retrieve_response_code($response);
            $body = wp_remote_retrieve_body($response);
            error_log("[StreamlineHQ] API error for {$family} query '{$query}' page {$page} | Code: {$code} | Response: {$body}");
        }

        if ($added_count > 0) {
            error_log("[Streamline Sync] Family: {$family} | Query: {$query} | Page: {$page} | Added: {$added_count} icons");
        }

        if (!empty($queue)) {
            set_transient(self::QUEUE_KEY, $queue, DAY_IN_SECONDS);
            wp_schedule_single_event(time() + 5, 'streamline_process_batch'); // slower to prevent throttling
        } else {
            delete_transient(self::QUEUE_KEY);
            $count = count(get_option(self::OPTIONS_KEY, []));
            error_log("[Streamline Sync] Completed full sync. Total icons saved: {$count}");
        }
    }

    /** SVG fetcher */
    public static function get_icon_svg($icon_id) {
        if (is_array($icon_id)) $icon_id = $icon_id['id'] ?? '';
        if (empty($icon_id)) return '';

        // var_dump('id here '.$icon_id);
        $cache_key = 'streamline_svg_' . sanitize_title($icon_id);
        // var_dump("cache_key ". $cache_key);
        if ($cached = get_transient($cache_key)) return $cached;

        $url = 'https://public-api.streamlinehq.com/v1/icons/'.$icon_id.'/download/svg?size=48&responsive=false';
        // $url = 'https://public-api.streamlinehq.com/v1/icons/' . $icon_id . '/svg';
        $args = [
            'headers' => [
                'x-api-key' => STREAMLINE_API_KEY,
                'accept'    => 'image/svg+xml',
            ],
            'timeout'   => 15,
            'sslverify' => false,
            'decompress'  => true,
        ];

        $response = wp_remote_get($url, $args);
        if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) return '';

        $svg = wp_remote_retrieve_body($response);

        // Fallback if empty
        if (empty($svg) && isset($response['http_response'])) {
            $svg_obj = $response['http_response']->get_response_object();
            $svg = $svg_obj->body ?? '';
        }

        // Sanity check
        if (strpos($svg, '<svg') === false) {
            error_log('Invalid SVG response for icon ID: ' . $icon_id);
            return '';
        }

        // var_dump($svg);
        set_transient($cache_key, $svg, 12 * HOUR_IN_SECONDS);
        return $svg;
    }


    /** ACF formatting */
    public static function format_icon_to_svg($value, $post_id, $field) {
        if (!$value) return '';
        $icon_id = is_array($value) ? ($value['id'] ?? '') : $value;
        // return $icon_id ? self::get_icon_svg($icon_id) : '';
        $svg_icon = self::get_icon_svg($icon_id);
        // var_dump("ssss ".$svg_icon);
        return $svg_icon;
    }

    /** AJAX: Fetch SVG */
    public static function ajax_fetch_svg() {
        check_ajax_referer('streamline_icon_nonce', '_ajax_nonce');
        $icon_id = isset($_GET['icon_id']) ? sanitize_text_field($_GET['icon_id']) : '';
        $svg = self::get_icon_svg($icon_id);
        if (!$svg) wp_send_json_error('Icon not found or invalid ID.');
        wp_send_json_success($svg);
    }

    /** Progress bar */
    public static function render_progress_bar() {
        if (!current_user_can('manage_options')) return;
        $queue = get_transient(self::QUEUE_KEY);
        $sync_running = $queue ? true : false;

        echo '<div id="streamline-sync-progress" style="padding:10px; margin:10px 0; background:#f1f1f1; border:1px solid #ccc;">';
        echo '<strong>Streamline Icon Sync:</strong><br>';

        if ($sync_running) {
            echo '<div style="background:#ddd; width:100%; height:20px; border-radius:3px; overflow:hidden; margin:5px 0;">';
            echo '<div id="streamline-sync-bar" style="width:0%; height:100%; background:#0073aa;"></div>';
            echo '</div>';
            echo '<span id="streamline-sync-text">Loading...</span>';
        } else {
            echo '<button id="streamline-start-sync" class="button button-primary">Start Sync</button>';
            echo '<span id="streamline-sync-text" style="margin-left:10px;"></span>';
        }

        echo '</div>';
    }

    /** Admin JS */
    public static function enqueue_admin_scripts($hook) {
        if (!current_user_can('manage_options')) return;
        wp_enqueue_script('jquery');
        wp_add_inline_script('jquery', "
            function fetchStreamlineProgress(){
                jQuery.get(ajaxurl, { action: 'streamline_sync_progress' }, function(response){
                    if(response.success){
                        var percent = response.data.percent;
                        console.log('[Streamline Progress]', response.data.text);
                        jQuery('#streamline-sync-bar').css('width', percent + '%');
                        jQuery('#streamline-sync-text').text(response.data.text);
                        if(percent < 100){
                            setTimeout(fetchStreamlineProgress, 3000);
                        } else {
                            console.log('[Streamline Sync] Completed');
                            jQuery('#streamline-sync-text').text('Sync complete!');
                        }
                    }
                });
            }

            jQuery(document).on('click', '#streamline-start-sync', function(e){
                e.preventDefault();
                var btn = jQuery(this);
                btn.prop('disabled', true).text('Starting...');
                console.log('[Streamline Sync] Starting sync...');
                jQuery.get(ajaxurl, { action: 'streamline_start_sync' }, function(response){
                    if(response.success){
                        btn.hide();
                        fetchStreamlineProgress();
                    } else {
                        btn.prop('disabled', false).text('Start Sync');
                        alert('Failed to start sync: ' + response.data);
                    }
                });
            });

            if(jQuery('#streamline-sync-bar').length){
                fetchStreamlineProgress();
            }
        ");
    }

    /** AJAX: Start sync */
    public static function ajax_start_sync() {
        if (!current_user_can('manage_options')) wp_send_json_error('No permission');
        self::reset_sync();
        wp_send_json_success('Sync started');
    }

    /** AJAX: Progress updates */
    public static function ajax_get_sync_progress() {
        if (!current_user_can('manage_options')) wp_send_json_error('No permission');
        $total_icons = count(get_option(self::OPTIONS_KEY, []));
        $queue = get_transient(self::QUEUE_KEY);
        $remaining_batches = $queue ? count($queue) : 0;
        $initial_total = $total_icons + ($remaining_batches * self::LIMIT);
        $percent = $initial_total ? round(($total_icons / $initial_total) * 100) : 100;
        $text = $total_icons . ' icons saved';
        if ($remaining_batches) $text .= ', ' . $remaining_batches . ' batch(es) remaining';
        wp_send_json_success(['percent' => $percent, 'text' => $text]);
    }
}

Streamline_API_Handler::init();
