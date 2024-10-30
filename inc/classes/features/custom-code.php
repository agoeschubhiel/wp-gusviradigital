<?php
/**
 * Custom Code Implementation
 * Mengimplementasikan kode kustom dari pengaturan Redux
 */

class GDP_Custom_Code {
    
    /**
     * Inisialisasi hooks dan filters
     */
    public static function init() {
        add_action('wp_head', array(__CLASS__, 'header_code'), 10);
        add_action('wp_body_open', array(__CLASS__, 'body_code'), 10);
        add_action('wp_footer', array(__CLASS__, 'footer_code'), 20);
        add_action('wp_enqueue_scripts', array(__CLASS__, 'enqueue_custom_js'), 99);
        add_action('wp_footer', array(__CLASS__, 'output_custom_html'), 10);
    }

    /**
     * Validasi dan minifikasi kode
     */
    private static function process_code($code, $type = 'html') {
        // Cek apakah validasi diaktifkan
        $validation_enabled = GDP_Theme_Support::gdp_option('code_validation', true);
        $minification_enabled = GDP_Theme_Support::gdp_option('code_minification', true);

        if (empty($code)) {
            return '';
        }

        // Validasi kode jika diaktifkan
        if ($validation_enabled) {
            $code = self::validate_code($code, $type);
        }

        // Minifikasi kode jika diaktifkan
        if ($minification_enabled) {
            $code = self::minify_code($code, $type);
        }

        return $code;
    }

    /**
     * Validasi kode berdasarkan tipe
     */
    private static function validate_code($code, $type) {
        switch ($type) {
            case 'js':
                // Validasi JavaScript menggunakan JShrink jika tersedia
                if (class_exists('JShrink\Minifier')) {
                    try {
                        \JShrink\Minifier::minify($code);
                        return $code;
                    } catch (Exception $e) {
                        error_log('JavaScript validation error: ' . $e->getMessage());
                        return ''; // Return empty jika invalid
                    }
                }
                break;

            case 'html':
                // Validasi HTML dasar
                if (strip_tags($code) !== $code) {
                    return $code;
                }
                break;
        }
        return $code;
    }

    /**
     * Minifikasi kode
     */
    private static function minify_code($code, $type) {
        switch ($type) {
            case 'js':
                // Minifikasi JavaScript
                $code = preg_replace('/\s+/', ' ', $code);
                $code = preg_replace('/\/\*.*?\*\//', '', $code);
                $code = preg_replace('/\/\/.*/', '', $code);
                break;

            case 'html':
                // Minifikasi HTML
                $code = preg_replace('/\s+/', ' ', $code);
                $code = preg_replace('/>\s+</', '><', $code);
                break;
        }
        return trim($code);
    }

    /**
     * Output kode header
     */
    public static function header_code() {
        $header_code = GDP_Theme_Support::gdp_option('custom_code_head');
        if (!empty($header_code)) {
            echo "<!-- Custom Header Code -->\n";
            echo self::process_code($header_code, 'html') . "\n";
        }
    }

    /**
     * Output kode body
     */
    public static function body_code() {
        $body_code = GDP_Theme_Support::gdp_option('custom_code_body');
        if (!empty($body_code)) {
            echo "<!-- Custom Body Code -->\n";
            echo self::process_code($body_code, 'html') . "\n";
        }
    }

    /**
     * Output kode footer
     */
    public static function footer_code() {
        $footer_code = GDP_Theme_Support::gdp_option('footer_scripts');
        if (!empty($footer_code)) {
            echo "<!-- Custom Footer Code -->\n";
            echo self::process_code($footer_code, 'html') . "\n";
        }
    }

    /**
     * Enqueue custom JavaScript
     */
    public static function enqueue_custom_js() {
        $custom_js = GDP_Theme_Support::gdp_option('custom_js');
        if (!empty($custom_js)) {
            $processed_js = self::process_code($custom_js, 'js');
            
            // Generate unique handle berdasarkan konten
            $handle = 'gdp-custom-js-' . substr(md5($processed_js), 0, 8);
            
            // Buat file temporary jika perlu
            $upload_dir = wp_upload_dir();
            $js_file = $upload_dir['basedir'] . '/custom-js/' . $handle . '.js';
            
            if (!file_exists($js_file) || md5_file($js_file) !== md5($processed_js)) {
                wp_mkdir_p(dirname($js_file));
                file_put_contents($js_file, $processed_js);
            }
            
            // Enqueue script
            wp_enqueue_script(
                $handle,
                $upload_dir['baseurl'] . '/custom-js/' . basename($js_file),
                array('jquery'),
                filemtime($js_file),
                true
            );
        }
    }

    /**
     * Output custom HTML
     */
    public static function output_custom_html() {
        $custom_html = GDP_Theme_Support::gdp_option('custom_html');
        if (!empty($custom_html)) {
            echo "<!-- Custom HTML -->\n";
            echo '<div class="gdp-custom-html">';
            echo self::process_code($custom_html, 'html');
            echo '</div>' . "\n";
        }
    }
}

// Inisialisasi class
GDP_Custom_Code::init();

/**
 * Tambahkan cleanup saat tema dinonaktifkan
 */
function gdp_cleanup_custom_code() {
    // Hapus file JavaScript temporary
    $upload_dir = wp_upload_dir();
    $custom_js_dir = $upload_dir['basedir'] . '/custom-js';
    
    if (is_dir($custom_js_dir)) {
        $files = glob($custom_js_dir . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        rmdir($custom_js_dir);
    }
}
register_deactivation_hook(__FILE__, 'gdp_cleanup_custom_code');