<?php
/**
 * GDP Theme Functions
 *
 * @package GDP
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Constants Definition
 */
define('GDP_VERSION', '1.0.0');
define('GDP_DIR', get_template_directory());
define('GDP_URI', get_template_directory_uri());
define('GDP_ASSETS', GDP_URI . '/assets');
define('GDP_INC', GDP_DIR . '/inc');
define('GDP_DEBUG', true);

/**
 * Composer Autoloader
 */
if (file_exists(GDP_DIR . '/vendor/autoload.php')) {
    require_once GDP_DIR . '/vendor/autoload.php';
}

/**
 * Initialize Theme Class
 */
final class GDP_Theme {
    /**
     * Instance
     */
    private static $instance = null;

    /**
     * Get instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        $this->load_dependencies();
        $this->init_hooks();
    }

    /**
     * Load Dependencies
     */
    private function load_dependencies() {
        // Core
        require_once GDP_INC . '/theme-support.php';
        require_once GDP_INC . '/classes/features/class-maintenance.php';
        require_once GDP_INC . '/classes/features/class-translations.php';
        require_once GDP_INC . '/classes/features/class-general.php';
        require_once GDP_INC . '/classes/features/custom-code.php';
        require_once GDP_INC . '/classes/features/typography.php';
        
        // Classes
        require_once GDP_INC . '/classes/Security/Firewall.php';
        require_once GDP_INC . '/classes/Security/class-gdp-security.php';
        require_once GDP_INC . '/classes/Security/Scanner.php';
        require_once GDP_INC . '/classes/Authentication/User_Auth.php';

        // require_once GDP_INC . '/classes/Performance/traits/PerformanceHelper.php';
        require_once GDP_INC . '/classes/Performance/AssetOptimizer.php';
        require_once GDP_INC . '/classes/Performance/Cache.php';
        // require_once GDP_INC . '/classes/Performance/DatabaseOptimizer.php';
        require_once GDP_INC . '/classes/Performance/ImageOptimizer.php';
        // require_once GDP_INC . '/classes/Performance/Performance.php';
        // require_once GDP_INC . '/classes/Performance/PerformanceManager.php';

        // Custom Posts
        require_once GDP_INC . '/post-types/Services.php';
        require_once GDP_INC . '/post-types/Portfolio.php';

        // Elementor
        if (did_action('elementor/loaded')) {
            require_once GDP_INC . '/widgets/elementor/init.php';
        }

        // Redux
        require_once GDP_INC . '/redux/config.php';

        // Shortcodes
        require_once GDP_INC . '/shortcodes/service-grid.php';
        require_once GDP_INC . '/shortcodes/cta-button.php';

        // Widgets
        require_once GDP_INC . '/widgets/wordpress/Recent_Services.php';
        require_once GDP_INC . '/widgets/wordpress/Service_Categories.php';

        // Helpers & Utils
        require_once GDP_INC . '/helpers/general-helper.php';
        require_once GDP_INC . '/helpers/format-helper.php';
        require_once GDP_INC . '/utils/Optimizer.php';
        require_once GDP_INC . '/utils/Assets_Manager.php';
    }

    /**
     * Initialize Hooks
     */
    private function init_hooks() {
        // Theme Setup
        add_action('after_setup_theme', [$this, 'theme_setup']);
        
        // Assets
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('admin_enqueue_scripts', [$this, 'admin_scripts']);
        
    }

    /**
     * Theme Setup
     */
    public function theme_setup() {
        // Load theme support
        GDP_Theme_Support::init();
    }

    /**
     * Enqueue Frontend Scripts
     */
    public function enqueue_scripts() {
        // Styles
        wp_enqueue_style( 'gdp-animate.min', GDP_ASSETS . '/css/vendor/animate.min.css', [], GDP_VERSION );
        wp_enqueue_style( 'gdp-aos', GDP_ASSETS . '/css/vendor/aos.css', [], GDP_VERSION );
        wp_enqueue_style( 'gdp-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css', [], GDP_VERSION );

        // wp_enqueue_style(
        //     'gdp-style',
        //     GDP_ASSETS . '/css/custom.css',
        //     [],
        //     GDP_VERSION
        // );

        // // Scripts
        wp_enqueue_script( 'gdp-isotope', GDP_ASSETS . '/js/vendor/isotope.pkgd.min.js', ['jquery'], GDP_VERSION, true );
        wp_enqueue_script( 'gdp-gsap', GDP_ASSETS . '/js/vendor/gsap.min.js', ['jquery'], GDP_VERSION, true );
        wp_enqueue_script( 'gdp-scrollTrigger', GDP_ASSETS . '/js/vendor/ScrollTrigger.min.js', ['jquery'], GDP_VERSION, true );
        wp_enqueue_script( 'gdp-aos', GDP_ASSETS . '/js/vendor/aos.js', ['jquery'], GDP_VERSION, true );
        wp_enqueue_script('imagesloaded');
        wp_enqueue_script( 'gdp-main', GDP_ASSETS . '/js/main.js', ['jquery'], GDP_VERSION, true );

        wp_enqueue_style('gdp-styles', get_template_directory_uri() . '/dist/css/app.css', [], '1.0.0');
        wp_enqueue_script('gdp-scripts', get_template_directory_uri() . '/dist/js/app.js', [], '1.0.0', true);

        // Localize script
        wp_localize_script('gdp-main', 'gdpData', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('gdp-nonce')
        ]);
    }

    /**
     * Enqueue Admin Scripts
     */
    public function admin_scripts() {
        wp_enqueue_style(
            'gdp-admin',
            GDP_ASSETS . '/css/admin.css',
            [],
            GDP_VERSION
        );
    }

}

/**
 * Initialize Theme
 */
function gdp_init() {
    return GDP_Theme::get_instance();
}

// Start the theme
gdp_init();