<?php
/**
 * Typography Implementation
 * Mengimplementasikan pengaturan tipografi dari Redux
 */

class GDP_Typography {
    
    /**
     * Inisialisasi hooks dan filters
     */
    public static function init() {
        add_action('wp_enqueue_scripts', array(__CLASS__, 'enqueue_fonts'));
        add_action('wp_head', array(__CLASS__, 'output_custom_typography'), 10);
        add_filter('body_class', array(__CLASS__, 'add_typography_classes'));
        
        // Hook untuk font preloading
        if (GDP_Theme_Support::gdp_option('preload_fonts', true)) {
            add_action('wp_head', array(__CLASS__, 'preload_fonts'), 1);
        }
    }

    /**
     * Enqueue Google Fonts
     */
    public static function enqueue_fonts() {
        $google_fonts = self::get_google_fonts();
        
        if (!empty($google_fonts)) {
            $fonts_url = self::build_google_fonts_url($google_fonts);
            wp_enqueue_style('gdp-google-fonts', $fonts_url, array(), null);
        }
    }

    /**
     * Get semua font Google yang digunakan
     */
    private static function get_google_fonts() {
        $typography_options = array(
            'h1_typography',
            'h2_typography',
            'h3_typography',
            'h4_typography',
            'h5_typography',
            'h6_typography',
            'body_typography',
            'menu_typography'
        );

        $google_fonts = array();
        
        foreach ($typography_options as $option) {
            $typography = GDP_Theme_Support::gdp_option($option);
            
            if (!empty($typography['font-family']) && !empty($typography['google'])) {
                $font_family = $typography['font-family'];
                $font_weight = !empty($typography['font-weight']) ? $typography['font-weight'] : '400';
                
                if (!isset($google_fonts[$font_family])) {
                    $google_fonts[$font_family] = array();
                }
                
                if (!in_array($font_weight, $google_fonts[$font_family])) {
                    $google_fonts[$font_family][] = $font_weight;
                }
            }
        }

        return $google_fonts;
    }

    /**
     * Build Google Fonts URL
     */
    private static function build_google_fonts_url($fonts) {
        $font_families = array();
        
        foreach ($fonts as $family => $weights) {
            $font_families[] = $family . ':' . implode(',', $weights);
        }
        
        $query_args = array(
            'family' => urlencode(implode('|', $font_families)),
            'display' => 'swap',
        );
        
        return add_query_arg($query_args, 'https://fonts.googleapis.com/css2');
    }

    /**
     * Output Custom Typography CSS
     */
    public static function output_custom_typography() {
        $css = '<style id="gdp-custom-typography">';
        
        // Font Smoothing
        if (GDP_Theme_Support::gdp_option('font_smoothing', true)) {
            $css .= 'body {
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }';
        }

        // System Fonts Fallback
        if (GDP_Theme_Support::gdp_option('use_system_fonts', true)) {
            $system_fonts = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif';
            $css .= "body { font-family: var(--body-font, {$system_fonts}); }";
        }

        // Typography Styles
        $elements = array(
            'h1' => 'h1_typography',
            'h2' => 'h2_typography',
            'h3' => 'h3_typography',
            'h4' => 'h4_typography',
            'h5' => 'h5_typography',
            'h6' => 'h6_typography',
            'body, p' => 'body_typography',
            '.main-navigation' => 'menu_typography'
        );

        foreach ($elements as $selector => $option) {
            $typography = GDP_Theme_Support::gdp_option($option);
            if (!empty($typography)) {
                $css .= self::generate_typography_css($selector, $typography);
            }
        }

        $css .= '</style>';
        echo $css;
    }

    /**
     * Generate Typography CSS
     */
    private static function generate_typography_css($selector, $typography) {
        $css = $selector . ' {';
        
        if (!empty($typography['font-family'])) {
            $css .= "font-family: '{$typography['font-family']}', var(--system-font);";
        }
        if (!empty($typography['font-size'])) {
            $css .= "font-size: {$typography['font-size']};";
        }
        if (!empty($typography['font-weight'])) {
            $css .= "font-weight: {$typography['font-weight']};";
        }
        if (!empty($typography['color'])) {
            $css .= "color: {$typography['color']};";
        }
        if (!empty($typography['line-height'])) {
            $css .= "line-height: {$typography['line-height']};";
        }
        if (!empty($typography['letter-spacing'])) {
            $css .= "letter-spacing: {$typography['letter-spacing']};";
        }
        
        $css .= '}';
        
        // Responsive Typography
        if (!empty($typography['font-size'])) {
            $base_size = (int)$typography['font-size'];
            $css .= "@media (max-width: 768px) {
                {$selector} {
                    font-size: " . ($base_size * 0.9) . "px;
                }
            }";
            $css .= "@media (max-width: 480px) {
                {$selector} {
                    font-size: " . ($base_size * 0.8) . "px;
                }
            }";
        }
        
        return $css;
    }

    /**
     * Preload Fonts
     */
    public static function preload_fonts() {
        $fonts = self::get_google_fonts();
        foreach ($fonts as $family => $weights) {
            echo "<link rel='preload' href='https://fonts.gstatic.com' crossorigin>";
        }
    }

    /**
     * Add Typography Classes to Body
     */
    public static function add_typography_classes($classes) {
        if (GDP_Theme_Support::gdp_option('font_smoothing', true)) {
            $classes[] = 'has-smoothing';
        }
        if (GDP_Theme_Support::gdp_option('use_system_fonts', true)) {
            $classes[] = 'using-system-fonts';
        }
        return $classes;
    }
}

// Initialize Typography
GDP_Typography::init();

/**
 * Register theme features for typography
 */
function gdp_typography_theme_support() {
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');
}
add_action('after_setup_theme', 'gdp_typography_theme_support');