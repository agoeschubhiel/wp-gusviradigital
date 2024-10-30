<?php

class AssetOptimizer {
    private $options;
    private $cache_dir;
    private $cache_url;
    private $excluded_css;
    private $excluded_js;
    private $inline_css; // Deklarasikan properti di sini
    private $inline_js;
    private $inline_styles = [];
    private $inline_scripts = [];

    public function __construct() {

        $this->inline_css = '';
        $this->inline_js = '';
        // Mengambil pengaturan dari Redux
        $this->options = [
            'minify_css' => GDP_Theme_Support::gdp_option('minify_css'),
            'minify_js' => GDP_Theme_Support::gdp_option('minify_js'),
            'combine_css' => GDP_Theme_Support::gdp_option('combine_css'),
            'combine_js' => GDP_Theme_Support::gdp_option('combine_js'),
            'minify_html' => GDP_Theme_Support::gdp_option('minify_html'),
            'defer_js' => GDP_Theme_Support::gdp_option('defer_js'),
            'cache_assets' => GDP_Theme_Support::gdp_option('cache_assets'),
        ];

        // Mengatur direktori cache
        $upload_dir = wp_upload_dir();
        $this->cache_dir = $upload_dir['basedir'] . '/asset-cache';
        $this->cache_url = $upload_dir['baseurl'] . '/asset-cache';

        // Memproses excluded files
        $this->excluded_css = array_filter(explode("\n", GDP_Theme_Support::gdp_option('exclude_css')));
        $this->excluded_js = array_filter(explode("\n", GDP_Theme_Support::gdp_option('exclude_js')));

        // Inisialisasi hooks
        $this->init();
    }

    private function init() {
        // Buat direktori cache jika belum ada
        if ($this->options['cache_assets'] && !file_exists($this->cache_dir)) {
            wp_mkdir_p($this->cache_dir);
        }

        // Hook untuk CSS
        if ($this->options['minify_css'] || $this->options['combine_css']) {
            add_action('wp_print_styles', [$this, 'process_styles'], 100);
        }

        // Hook untuk JavaScript
        if ($this->options['minify_js'] || $this->options['combine_js']) {
            add_action('wp_print_scripts', [$this, 'process_scripts'], 100);
        }

        // Hook untuk HTML Minification
        if ($this->options['minify_html']) {
            add_action('template_redirect', [$this, 'start_html_buffering']);
        }

        // Hook untuk Defer JavaScript
        if ($this->options['defer_js']) {
            add_filter('script_loader_tag', [$this, 'defer_js'], 10, 3);
        }

        add_action('wp_head', [$this, 'process_inline_styles'], 999);
        add_action('wp_footer', [$this, 'process_inline_scripts'], 999);
    }

    public function process_styles() {
        global $wp_styles;
        if (!is_object($wp_styles)) return;

        $styles = [];
        foreach ($wp_styles->queue as $handle) {
            if (in_array($handle, $this->excluded_css)) continue;

            $style = $wp_styles->registered[$handle];
            if (isset($style->src) && !empty($style->src)) {
                $styles[] = [
                    'handle' => $handle,
                    'src' => $style->src,
                    'deps' => $style->deps
                ];
            }

            // Tangkap inline styles
            if (isset($style->extra['after']) && is_array($style->extra['after'])) {
                foreach ($style->extra['after'] as $inline_style) {
                    $this->inline_styles[] = $inline_style;
                }
            }
        }

        if ($this->options['combine_css']) {
            $this->combine_css($styles);
        } elseif ($this->options['minify_css']) {
            $this->minify_css($styles);
        }
    }

    public function process_scripts() {
        global $wp_scripts;
        if (!is_object($wp_scripts)) return;

        $scripts = [];
        foreach ($wp_scripts->queue as $handle) {
            if (in_array($handle, $this->excluded_js)) continue;

            $script = $wp_scripts->registered[$handle];
            if (isset($script->src) && !empty($script->src)) {
                $scripts[] = [
                    'handle' => $handle,
                    'src' => $script->src,
                    'deps' => $script->deps
                ];
            }

            // Tangkap inline scripts
            if (isset($script->extra['data'])) {
                $this->inline_scripts[] = $script->extra['data'];
            }
        }

        if ($this->options['combine_js']) {
            $this->combine_js($scripts);
        } elseif ($this->options['minify_js']) {
            $this->minify_js($scripts);
        }
    }

    public function process_inline_styles() {
        if (!empty($this->inline_styles) && $this->options['minify_css']) {
            echo "<style id='gdp-optimized-inline-css'>\n";
            foreach ($this->inline_styles as $inline_style) {
                echo $this->minify_css_content($inline_style) . "\n";
            }
            echo "</style>\n";
        }
    }

    public function process_inline_scripts() {
        if (!empty($this->inline_scripts) && $this->options['minify_js']) {
            echo "<script id='gdp-optimized-inline-js'>\n";
            foreach ($this->inline_scripts as $inline_script) {
                echo $this->minify_js_content($inline_script) . "\n";
            }
            echo "</script>\n";
        }
    }

    private function minify_css($styles) {
        foreach ($styles as $style) {
            $content = $this->get_file_content($style['src']);
            if ($content) {
                $minified = $this->minify_css_content($content);
                $cache_file = $this->cache_dir . '/' . md5($style['handle']) . '.css';
                
                if ($this->options['cache_assets']) {
                    file_put_contents($cache_file, $minified);
                    wp_deregister_style($style['handle']);
                    wp_register_style($style['handle'], $this->cache_url . '/' . basename($cache_file));
                } else {
                    wp_deregister_style($style['handle']);
                    wp_register_style($style['handle'], $style['src']);
                    wp_add_inline_style($style['handle'], $minified);
                }
            }
        }
    }

    private function minify_js($scripts) {
        foreach ($scripts as $script) {
            $content = $this->get_file_content($script['src']);
            if ($content) {
                $minified = $this->minify_js_content($content);
                $cache_file = $this->cache_dir . '/' . md5($script['handle']) . '.js';
                
                if ($this->options['cache_assets']) {
                    file_put_contents($cache_file, $minified);
                    wp_deregister_script($script['handle']);
                    wp_register_script($script['handle'], $this->cache_url . '/' . basename($cache_file));
                } else {
                    wp_deregister_script($script['handle']);
                    wp_register_script($script['handle'], $script['src']);
                    wp_add_inline_script($script['handle'], $minified);
                }
            }
        }
    }

    private function combine_css($styles) {
        $combined = '';
        foreach ($styles as $style) {
            $content = $this->get_file_content($style['src']);
            if ($content) {
                $combined .= "/* {$style['handle']} */\n" . $this->minify_css_content($content) . "\n";
            }
        }

        if ($combined) {
            $cache_file = $this->cache_dir . '/combined-' . md5($combined) . '.css';
            
            if ($this->options['cache_assets']) {
                file_put_contents($cache_file, $combined);
                
                // Deregister original styles and register combined
                foreach ($styles as $style) {
                    wp_deregister_style($style['handle']);
                }
                wp_register_style('combined-styles', $this->cache_url . '/' . basename($cache_file));
                wp_enqueue_style('combined-styles');
            }
        }
    }

    private function combine_js($scripts) {
        $combined = '';
        foreach ($scripts as $script) {
            $content = $this->get_file_content($script['src']);
            if ($content) {
                $combined .= "/* {$script['handle']} */\n" . $this->minify_js_content($content) . ";\n";
            }
        }

        if ($combined) {
            $cache_file = $this->cache_dir . '/combined-' . md5($combined) . '.js';
            
            if ($this->options['cache_assets']) {
                file_put_contents($cache_file, $combined);
                
                // Deregister original scripts and register combined
                foreach ($scripts as $script) {
                    wp_deregister_script($script['handle']);
                }
                wp_register_script('combined-scripts', $this->cache_url . '/' . basename($cache_file));
                wp_enqueue_script('combined-scripts');
            }
        }
    }

    public function defer_js($tag, $handle, $src) {
        if (in_array($handle, $this->excluded_js)) {
            return $tag;
        }
        return str_replace(' src', ' defer src', $tag);
    }

    public function start_html_buffering() {
        ob_start([$this, 'minify_html']);
    }

    public function minify_html($html) {
        return $this->minify_html_content($html);
    }

    public function start_html_buffer() {
        ob_start([$this, 'minify_html']);
    }

    private function minify_html_content($html) {
        // Menghapus komentar HTML (kecuali conditional comments)
        $html = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $html);
        
        // Menghapus whitespace yang tidak diperlukan
        $search = array(
            '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
            '/[^\S ]+\</s',     // strip whitespaces before tags, except space
            '/(\s)+/s',         // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/' // Remove HTML comments
        );
        
        $replace = array(
            '>',
            '<',
            '\\1',
            ''
        );
        
        $html = preg_replace($search, $replace, $html);
        
        return trim($html);
    }

    private function minify_css_content($css) {
        // Menghapus komentar
        $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
        // Menghapus spasi
        $css = str_replace(["\r\n", "\r", "\n", "\t", '  ', '    ', '    '], '', $css);
        // Menghapus spasi yang tidak diperlukan
        $css = preg_replace(['(( )+{)', '({( )+)'], '{', $css);
        $css = preg_replace(['(( )+})', '(}( )+)', '(;( )*})'], '}', $css);
        $css = preg_replace(['(;( )+)', '(( )+;)'], ';', $css);
        return $css;
    }

    private function minify_js_content($js) {
        // Menghapus komentar
        $js = preg_replace('/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\'|\")\/\/.*))/', '', $js);
        // Menghapus spasi
        $js = preg_replace('/\s+/', ' ', $js);
        // Menghapus spasi sebelum dan sesudah operator
        $js = preg_replace('/\s*([!%&*\(\)\-=+\[\]\{\}|;:,.<>?\/])\s*/', '$1', $js);
        // Menghapus titik koma terakhir
        $js = preg_replace('/;+\}/', '}', $js);
        return $js;
    }

    private function get_file_content($url) {
        if (empty($url)) {
            error_log('AssetOptimizer Error: Empty URL provided');
            return false;
        }

        // Handle relative URLs
        if (strpos($url, '//') === 0) {
            $url = 'https:' . $url;
        } elseif (strpos($url, '/') === 0) {
            $url = get_site_url() . $url;
        }

        try {
            $response = wp_remote_get($url);
            if (is_wp_error($response)) {
                error_log('AssetOptimizer Error: ' . $response->get_error_message());
                return false;
            }
            $content = wp_remote_retrieve_body($response);
            if (empty($content)) {
                error_log('AssetOptimizer Error: Empty content retrieved from ' . $url);
                return false;
            }
            return $content;
        } catch (Exception $e) {
            error_log('AssetOptimizer Error: ' . $e->getMessage());
            return false;
        }
    }

    // Menambahkan metode untuk membersihkan cache
    public function clear_cache() {
        if (is_dir($this->cache_dir)) {
            $files = glob($this->cache_dir . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
        }
    }

    // Menambahkan metode untuk mengecek status cache
    public function get_cache_status() {
        if (!is_dir($this->cache_dir)) {
            return array(
                'status' => 'error',
                'message' => 'Cache directory does not exist',
                'size' => 0
            );
        }

        $size = 0;
        $files = glob($this->cache_dir . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                $size += filesize($file);
            }
        }

        return array(
            'status' => 'success',
            'message' => 'Cache is working',
            'size' => $size,
            'files' => count($files)
        );
    }

    // Menambahkan metode untuk menangani error
    private function handle_error($message, $context = array()) {
        error_log('AssetOptimizer Error: ' . $message . ' Context: ' . print_r($context, true));
        
        if (defined('WP_DEBUG') && WP_DEBUG) {
            echo "<!-- AssetOptimizer Error: {$message} -->\n";
        }
    }

    // Menambahkan metode untuk validasi file
    private function validate_file($file_path) {
        // Cek ekstensi file
        $allowed_extensions = array('css', 'js');
        $extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
        
        if (!in_array($extension, $allowed_extensions)) {
            return false;
        }

        // Cek ukuran file
        $max_size = 5 * 1024 * 1024; // 5MB
        if (filesize($file_path) > $max_size) {
            return false;
        }

        return true;
    }
}

// Penggunaan class
function init_asset_optimizer() {
    $optimizer = new AssetOptimizer();
    
    // Hook untuk membersihkan cache saat update theme atau plugin
    add_action('upgrader_process_complete', array($optimizer, 'clear_cache'));
    add_action('switch_theme', array($optimizer, 'clear_cache'));
    
    // Hook untuk membersihkan cache melalui admin
    add_action('admin_post_clear_asset_cache', function() use ($optimizer) {
        if (current_user_can('manage_options')) {
            $optimizer->clear_cache();
            wp_redirect(admin_url('admin.php?page=theme-options&cache-cleared=1'));
            exit;
        }
    });
}

// Inisialisasi

add_action('init', 'init_asset_optimizer');