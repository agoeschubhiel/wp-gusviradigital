<?php

class Cache {
    private $lifetime;
    private $enabled;
    private $cache_dir;
    private $excluded_urls;
    private $excluded_cookies;
    private $enable_mobile_cache;
    private $cache_preload;
    private $cache_gzip;
    private $cache_debug;
    private $cache_hits = 0;
    private $cache_misses = 0;
    private $statistics_option_name = 'gdp_cache_statistics';
    
    public function __construct() {
        // Mengambil pengaturan dari Redux
        $this->enabled = GDP_Theme_Support::gdp_option('enable_cache', true);
        $this->lifetime = GDP_Theme_Support::gdp_option('cache_lifetime', 24);
        $this->enable_mobile_cache = GDP_Theme_Support::gdp_option('enable_mobile_cache', true);
        $this->cache_preload = GDP_Theme_Support::gdp_option('cache_preload', false);
        $this->cache_gzip = GDP_Theme_Support::gdp_option('cache_gzip', true);
        $this->cache_debug = GDP_Theme_Support::gdp_option('cache_debug', false);
        
        // Inisialisasi direktori cache
        $this->cache_dir = WP_CONTENT_DIR . '/cache/';
        
        // Mengambil dan memproses excluded URLs
        $excluded_urls_raw = GDP_Theme_Support::gdp_option('excluded_urls', '');
        $this->excluded_urls = array_filter(explode("\n", str_replace("\r", "", $excluded_urls_raw)));
        
        // Cookie yang mengindikasikan tidak perlu cache
        $this->excluded_cookies = [
            'wordpress_logged_in_',
            'woocommerce_cart_hash',
            'woocommerce_items_in_cart'
        ];
    }

    public function init() {
        if (!$this->enabled) {
            return;
        }

        add_action('template_redirect', [$this, 'setupCache']);
        add_action('save_post', [$this, 'clearCache']);
        add_action('comment_post', [$this, 'clearCache']);
        add_action('wp_update_nav_menu', [$this, 'clearCache']);
        add_action('wp_ajax_gdp_clear_cache', [$this, 'clearCache']);
        add_action('wp_ajax_nopriv_gdp_clear_cache', [$this, 'clearCache']);
        // Tambahkan widget dashboard
        add_action('wp_dashboard_setup', [$this, 'addDashboardWidget']);
        
        // Tambahkan endpoint AJAX untuk reset statistik
        add_action('wp_ajax_gdp_reset_cache_stats', [$this, 'resetStatistics']);

        add_action('wp_ajax_gdp_clear_cache', [$this, 'ajaxClearCache']);
        
        // Tambahkan tombol clear cache di admin bar
        add_action('admin_bar_menu', [$this, 'addClearCacheButton'], 100);
    }

    public function addDashboardWidget() {
        wp_add_dashboard_widget(
            'gdp_cache_stats_widget',
            'Cache Statistics',
            [$this, 'renderDashboardWidget']
        );
    }

    public function setupCache() {
        if ($this->shouldSkipCache()) {
            return;
        }

        $cache_file = $this->getCacheFile();
        
        if ($this->isCacheValid($cache_file)) {
            $this->updateStatistics('hit');
            $this->serveCachedFile($cache_file);
            exit;
        }

        $this->updateStatistics('miss');
        ob_start([$this, 'cacheCallback']);
    }

    public function getCacheStatistics() {
        return [
            'hits' => $this->cache_hits,
            'misses' => $this->cache_misses,
        ];
    }

    private function getCacheFile() {
        $url = $_SERVER['REQUEST_URI'];
        $mobile = ($this->enable_mobile_cache && wp_is_mobile()) ? 'mobile_' : '';
        $file = $this->cache_dir . $mobile . md5($url) . '.html';
        return $this->cache_gzip ? $file . '.gz' : $file;
    }

    private function shouldSkipCache() {
        // Skip jika user logged in
        if (is_user_logged_in()) {
            return true;
        }

        // Skip jika POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return true;
        }

        // Skip jika URL dikecualikan
        foreach ($this->excluded_urls as $url) {
            if (strpos($_SERVER['REQUEST_URI'], $url) !== false) {
                return true;
            }
        }

        // Skip jika ada cookie yang dikecualikan
        foreach ($this->excluded_cookies as $cookie) {
            foreach ($_COOKIE as $key => $value) {
                if (strpos($key, $cookie) !== false) {
                    return true;
                }
            }
        }

        return false;
    }

    public function cacheCallback($buffer) {
        if (http_response_code() !== 200) {
            return $buffer;
        }

        $cache_file = $this->getCacheFile();
        
        if (!is_dir($this->cache_dir)) {
            wp_mkdir_p($this->cache_dir);
        }

        if ($this->cache_debug) {
            $buffer .= "\n<!-- Cached by GDP Cache on " . date('Y-m-d H:i:s') . " -->";
        }
        
        if ($this->cache_gzip) {
            $buffer = gzencode($buffer, 9);
        }
        
        file_put_contents($cache_file, $buffer, LOCK_EX);
        return $buffer;
    }

    private function serveCachedFile($cache_file) {
        if ($this->cache_gzip) {
            header('Content-Encoding: gzip');
        }
        
        if ($this->cache_debug) {
            header('X-GDP-Cached: true');
            header('X-GDP-Cache-Time: ' . date('Y-m-d H:i:s', filemtime($cache_file)));
        }
        
        readfile($cache_file);
    }

    private function isCacheValid($cache_file) {
        return file_exists($cache_file) && 
               time() - filemtime($cache_file) < ($this->lifetime * 3600);
    }

    public function clearCache() {
        if (!is_dir($this->cache_dir)) {
            return;
        }

        $files = glob($this->cache_dir . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }

        // Update statistik saat cache dibersihkan
        $stats = get_option($this->statistics_option_name, []);
        $stats['last_cleared'] = current_time('timestamp');
        $stats['cache_size'] = 0;
        $stats['created_files'] = 0;
        update_option($this->statistics_option_name, $stats);

        // Hook untuk tindakan tambahan setelah cache dibersihkan
        do_action('gdp_cache_cleared');

        // Jika request dari AJAX
        if (wp_doing_ajax()) {
            wp_send_json_success([
                'message' => 'Cache cleared successfully',
                'timestamp' => human_time_diff($stats['last_cleared'], current_time('timestamp')) . ' ago'
            ]);
        }
    }

    public function ajaxClearCache() {
        // Verifikasi nonce dan capabilities
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized access');
        }

        $this->clearCache();
    }

    public function addClearCacheButton($wp_admin_bar) {
        if (!current_user_can('manage_options')) {
            return;
        }

        $wp_admin_bar->add_node([
            'id'    => 'gdp_clear_cache',
            'title' => 'Clear Cache',
            'href'  => '#',
            'meta'  => [
                'onclick' => 'gdpClearCache(); return false;'
            ]
        ]);

        add_action('admin_footer', [$this, 'addClearCacheScript']);
    }

    public function addClearCacheScript() {
        ?>
        <script>
        function gdpClearCache() {
            if (confirm('Are you sure you want to clear the cache?')) {
                jQuery.post(
                    ajaxurl,
                    { action: 'gdp_clear_cache' },
                    function(response) {
                        alert('Cache cleared successfully!');
                    }
                );
            }
        }
        </script>
        <?php
    }

    private function updateStatistics($type) {
        $stats = get_option($this->statistics_option_name, [
            'hits' => 0,
            'misses' => 0,
            'total_served' => 0,
            'cache_size' => 0,
            'last_cleared' => 0,
            'created_files' => 0
        ]);

        switch($type) {
            case 'hit':
                $stats['hits']++;
                break;
            case 'miss':
                $stats['misses']++;
                break;
        }

        $stats['total_served']++;
        $stats['cache_size'] = $this->calculateCacheSize();
        $stats['created_files'] = $this->countCacheFiles();

        update_option($this->statistics_option_name, $stats);
    }

    private function calculateCacheSize() {
        $size = 0;
        if (is_dir($this->cache_dir)) {
            $files = glob($this->cache_dir . '*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    $size += filesize($file);
                }
            }
        }
        return $size;
    }

    private function getCacheStats() {
        return get_option($this->statistics_option_name, [
            'hits' => 0,
            'misses' => 0,
            'total_served' => 0,
            'cache_size' => 0,
            'last_cleared' => 0,
            'created_files' => 0
        ]);
    }

    private function countCacheFiles() {
        if (!is_dir($this->cache_dir)) {
            return 0;
        }
        return count(glob($this->cache_dir . '*'));
    }

    // Method untuk reset statistik
    public function resetStatistics() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized access');
        }

        $default_stats = [
            'hits' => 0,
            'misses' => 0,
            'total_served' => 0,
            'cache_size' => $this->calculateCacheSize(),
            'last_cleared' => current_time('timestamp'),
            'created_files' => $this->countCacheFiles()
        ];

        update_option($this->statistics_option_name, $default_stats);

        if (wp_doing_ajax()) {
            wp_send_json_success([
                'message' => 'Statistics reset successfully',
                'stats' => $default_stats
            ]);
        }
    }

    public function renderDashboardWidget() {
        $stats = get_option($this->statistics_option_name, []);
        ?>
        <div class="dashboard-widget-content">
            <h4>Cache Overview</h4>
            <table>
                <tr>
                    <td>Cache Hits</td>
                    <td><?php echo number_format($stats['hits'] ?? 0); ?></td>
                </tr>
                <tr>
                    <td>Cache Misses</td>
                    <td><?php echo number_format($stats['misses'] ?? 0); ?></td>
                </tr>
                <tr>
                    <td>Hit Ratio</td>
                    <td>
                        <?php 
                        $total = ($stats['hits'] ?? 0) + ($stats['misses'] ?? 0);
                        echo $total > 0 ? round(($stats['hits'] / $total) * 100, 2) : 0;
                        ?>%
                    </td>
                </tr>
                <tr>
                    <td>Total Requests Served</td>
                    <td><?php echo number_format($stats['total_served'] ?? 0); ?></td>
                </tr>
                <tr>
                    <td>Cache Size</td>
                    <td><?php echo size_format($stats['cache_size'] ?? 0); ?></td>
                </tr>
                <tr>
                    <td>Cached Files</td>
                    <td><?php echo number_format($stats['created_files'] ?? 0); ?></td>
                </tr>
                <tr>
                    <td>Last Cache Clear</td>
                    <td>
                        <?php 
                        echo isset($stats['last_cleared']) ? 
                            human_time_diff($stats['last_cleared'], current_time('timestamp')) . ' ago' : 
                            'Never';
                        ?>
                    </td>
                </tr>
            </table>

            <div class="gdp-cache-actions">
                <button class="button button-primary" onclick="gdpClearCache()">Clear Cache</button>
                <button class="button" onclick="gdpResetStats()">Reset Statistics</button>
            </div>
        </div>

        <style>
        .gdp-cache-actions {
            margin-top: 20px;
        }
        .gdp-cache-actions button {
            margin-right: 10px;
        }
        </style>

        <script>
        function gdpClearCache() {
            if (confirm('Are you sure you want to clear the cache?')) {
                jQuery.post(ajaxurl, {
                    action: 'gdp_clear_cache'
                }, function(response) {
                    alert('Cache cleared successfully!');
                    location.reload();
                });
            }
        }

        function gdpResetStats() {
            if (confirm('Are you sure you want to reset statistics?')) {
                jQuery.post(ajaxurl, {
                    action: 'gdp_reset_cache_stats'
                }, function(response) {
                    alert('Statistics reset successfully!');
                    location.reload();
                });
            }
        }
        </script>
        <?php
    }
}

// Inisialisasi cache
$cache = new Cache();
$cache->init();