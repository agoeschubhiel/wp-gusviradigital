<?php
/**
 * GDP Theme Support
 *
 * @package GDP
 */

if (!defined('ABSPATH')) {
    exit;
}

class GDP_Theme_Support {
    /**
     * Initialize Theme Support
     */
    public static function init() {
        self::add_theme_support();
        self::register_nav_menus();
        self::register_sidebars();
        self::content_width();
        self::add_image_sizes();
        self::add_custom_header();
        self::register_meta();
        self::add_editor_styles();
    }

    /**
     * Add Theme Support
     */
    public static function add_theme_support() {
        // Basic Support
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('custom-logo', [
            'height'      => 100,
            'width'       => 400,
            'flex-height' => true,
            'flex-width'  => true,
        ]);
        
        // Gutenberg
        add_theme_support('align-wide');
        add_theme_support('responsive-embeds');
        add_theme_support('editor-styles');
        
        // HTML5
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'script',
            'style',
        ]);

        // Custom Background
        add_theme_support('custom-background', [
            'default-color' => 'ffffff',
        ]);

        // Post Formats
        add_theme_support('post-formats', [
            'aside',
            'gallery',
            'link',
            'image',
            'quote',
            'video',
            'audio',
        ]);

        // WooCommerce
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');

        // Elementor
        add_theme_support('elementor');

        // Automatic Feed Links
        add_theme_support('automatic-feed-links');

        // Custom Header
        add_theme_support('custom-header');

        // Block Styles
        add_theme_support('wp-block-styles');
    }

    /**
     * Register Navigation Menus
     */
    public static function register_nav_menus() {
        register_nav_menus([
            'primary'   => esc_html__('Primary Menu', 'gdp'),
            'footer'    => esc_html__('Footer Menu', 'gdp'),
            'social'    => esc_html__('Social Menu', 'gdp'),
            'services'  => esc_html__('Services Menu', 'gdp'),
        ]);
    }

    /**
     * Register Sidebars
     */
    public static function register_sidebars() {
        // Main Sidebar
        register_sidebar([
            'name'          => esc_html__('Main Sidebar', 'gdp'),
            'id'            => 'sidebar-main',
            'description'   => esc_html__('Add widgets here for main sidebar.', 'gdp'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]);

        // Footer Widgets
        for ($i = 1; $i <= 4; $i++) {
            register_sidebar([
                'name'          => sprintf(esc_html__('Footer Widget %d', 'gdp'), $i),
                'id'            => 'footer-' . $i,
                'description'   => sprintf(esc_html__('Add widgets here for footer column %d.', 'gdp'), $i),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h4 class="widget-title">',
                'after_title'   => '</h4>',
            ]);
        }

        // Services Sidebar
        register_sidebar([
            'name'          => esc_html__('Services Sidebar', 'gdp'),
            'id'            => 'sidebar-services',
            'description'   => esc_html__('Add widgets here for services sidebar.', 'gdp'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]);
    }

    /**
     * Set Content Width
     */
    public static function content_width() {
        if (!isset($content_width)) {
            $content_width = 1200;
        }
    }

    /**
     * Add Custom Image Sizes
     */
    public static function add_image_sizes() {
        add_image_size('gdp-featured', 1200, 628, true);
        add_image_size('gdp-service', 800, 600, true);
        add_image_size('gdp-portfolio', 600, 400, true);
        add_image_size('gdp-thumbnail', 350, 250, true);
    }

    /**
     * Add Custom Header Support
     */
    public static function add_custom_header() {
        add_theme_support('custom-header', [
            'default-image'          => '',
            'random-default'         => false,
            'width'                  => 1920,
            'height'                 => 400,
            'flex-height'            => true,
            'flex-width'             => true,
            'default-text-color'     => '000000',
            'header-text'            => true,
            'uploads'                => true,
            'wp-head-callback'       => '',
            'admin-head-callback'    => '',
            'admin-preview-callback' => '',
        ]);
    }

    /**
     * Register Custom Meta
     */
    public static function register_meta() {
        register_meta('post', 'gdp_service_icon', [
            'show_in_rest' => true,
            'single'       => true,
            'type'        => 'string',
        ]);

        register_meta('post', 'gdp_service_price', [
            'show_in_rest' => true,
            'single'       => true,
            'type'        => 'number',
        ]);
    }

    /**
     * Add Editor Styles
     */
    public static function add_editor_styles() {
        add_editor_style([
            'assets/css/editor-style.css',
            'assets/css/custom-editor.css'
        ]);
    }

    /**
     * Add Custom Body Classes
     */
    public static function body_classes($classes) {
        // Add browser detection class
        $classes[] = self::get_browser_class();

        // Add device detection class
        if (wp_is_mobile()) {
            $classes[] = 'is-mobile';
        }

        // Add page specific classes
        if (is_singular()) {
            $classes[] = 'singular';
        }

        if (is_single()) {
            $classes[] = 'single-post';
        }

        return $classes;
    }

        /**
     * Get Browser Class
     */
    private static function get_browser_class() {
        $browser = '';
        
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false) {
            $browser = 'chrome';
        } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== false) {
            $browser = 'firefox';
        } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) {
            $browser = 'ie';
        } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== false) {
            $browser = 'safari';
        }
        
        return $browser;
    }

    /**
     * Add Theme Color Meta Tag
     */
    public static function theme_color() {
        echo '<meta name="theme-color" content="#ffffff">';
    }

    /**
     * Add Custom Post Type Support
     */
    public static function custom_post_type_support() {
        add_post_type_support('page', 'excerpt');
    }

    /**
     * Add Custom Taxonomy Support
     */
    public static function register_taxonomies() {
        // Service Categories
        register_taxonomy('service_category', 'service', [
            'hierarchical'      => true,
            'labels'            => [
                'name'              => _x('Service Categories', 'taxonomy general name', 'gdp'),
                'singular_name'     => _x('Service Category', 'taxonomy singular name', 'gdp'),
                'menu_name'         => __('Categories', 'gdp'),
            ],
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'service-category'],
            'show_in_rest'      => true,
        ]);

        // Service Tags
        register_taxonomy('service_tag', 'service', [
            'hierarchical'      => false,
            'labels'            => [
                'name'              => _x('Service Tags', 'taxonomy general name', 'gdp'),
                'singular_name'     => _x('Service Tag', 'taxonomy singular name', 'gdp'),
                'menu_name'         => __('Tags', 'gdp'),
            ],
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'service-tag'],
            'show_in_rest'      => true,
        ]);
    }

    /**
     * Add Custom Roles and Capabilities
     */
    public static function add_custom_roles() {
        add_role('service_manager', __('Service Manager', 'gdp'), [
            'read'                   => true,
            'edit_posts'             => true,
            'edit_published_posts'   => true,
            'publish_posts'          => true,
            'edit_services'          => true,
            'edit_others_services'   => true,
            'publish_services'       => true,
            'read_private_services'  => true,
        ]);
    }

    /**
     * Add Custom Dashboard Widgets
     */
    public static function add_dashboard_widgets() {
        wp_add_dashboard_widget(
            'gdp_dashboard_widget',
            __('GDP Services Overview', 'gdp'),
            [__CLASS__, 'dashboard_widget_content']
        );
    }

    /**
     * Dashboard Widget Content
     */
    public static function dashboard_widget_content() {
        // Implementation for dashboard widget
    }

    /**
     * Add Custom Shortcodes
     */
    public static function register_shortcodes() {
        add_shortcode('gdp_services', [__CLASS__, 'services_shortcode']);
        add_shortcode('gdp_contact', [__CLASS__, 'contact_shortcode']);
    }

    /**
     * Add Custom Widgets
     */
    public static function register_widgets() {
        register_widget('GDP_Recent_Services_Widget');
        register_widget('GDP_Service_Categories_Widget');
    }

    /**
     * Get suggested posts for 404 page
     */
    public static function get_404_suggested_posts() {
        $count = self::gdp_option('suggestion_count');
        $count = $count ? intval($count) : 3;
        
        return get_posts(array(
            'numberposts' => $count,
            'post_status' => 'publish'
        ));
    }

    /**
     * Log 404 errors if enabled
     */
    public static function log_404_error() {
        if (self::gdp_option('enable_404_logging')) {
            $log_data = array(
                'timestamp' => current_time('mysql'),
                'url' => $_SERVER['REQUEST_URI'],
                'ip' => $_SERVER['REMOTE_ADDR'],
                'user_agent' => $_SERVER['HTTP_USER_AGENT']
            );
            
            // Implementasi logging sesuai kebutuhan
            // Contoh: bisa disimpan ke database atau file
        }
    }

    /**
     * Initialize All Hooks
     */
    public static function init_hooks() {
        // Theme Setup
        add_action('after_setup_theme', [__CLASS__, 'add_theme_support']);
        add_action('after_setup_theme', [__CLASS__, 'register_nav_menus']);
        add_action('after_setup_theme', [__CLASS__, 'content_width']);
        add_action('after_setup_theme', [__CLASS__, 'add_image_sizes']);
        add_action('after_setup_theme', [__CLASS__, 'add_custom_header']);
        add_action('after_setup_theme', [__CLASS__, 'custom_post_type_support']);

        // Widgets & Sidebars
        add_action('widgets_init', [__CLASS__, 'register_sidebars']);
        add_action('widgets_init', [__CLASS__, 'register_widgets']);

        // Admin Customization
        add_action('wp_dashboard_setup', [__CLASS__, 'add_dashboard_widgets']);

        // Custom Taxonomies & Post Types
        add_action('init', [__CLASS__, 'register_taxonomies']);
        add_action('init', [__CLASS__, 'add_custom_roles']);
        add_action('init', [__CLASS__, 'register_shortcodes']);

        // REST API
        // add_action('rest_api_init', [__CLASS__, 'register_rest_routes']);

        // Body Classes
        add_filter('body_class', [__CLASS__, 'body_classes']);

        // Admin Columns
        add_filter('manage_service_posts_columns', [__CLASS__, 'add_admin_columns']);
        add_action('manage_service_posts_custom_column', [__CLASS__, 'custom_column_content'], 10, 2);

        // Theme Color
        add_action('wp_head', [__CLASS__, 'theme_color']);

        // Custom Meta
        add_action('init', [__CLASS__, 'register_meta']);

        // Editor Styles
        add_action('admin_init', [__CLASS__, 'add_editor_styles']);
    }

    /**
     * Get Theme Options
     */
    public static function gdp_option($option_name, $default = '') {
        $options = get_option('gusviradigital_options');
        return isset($options[$option_name]) ? $options[$option_name] : $default;
    }

}

// Initialize hooks
GDP_Theme_Support::init_hooks();