<?php
/**
 * Register Custom Elementor Widgets
 */

namespace Elementor_Custom_Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Plugin {

    /**
     * Instance
     */
    private static $_instance = null;

    /**
     * Get instance
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Initialize widgets
     */
    public function init_widgets() {
        // Include widget files
        require_once(__DIR__ . '/widgets/gdp_hero1.php');
        require_once(__DIR__ . '/widgets/gdp_hero2.php');
        require_once(__DIR__ . '/widgets/gdp_hero3.php');
        require_once(__DIR__ . '/widgets/gdp_hero4.php');
        require_once(__DIR__ . '/widgets/gdp_hero5.php');
        require_once(__DIR__ . '/widgets/gdp_hero6.php');
        require_once(__DIR__ . '/widgets/gdp_about1.php');
        require_once(__DIR__ . '/widgets/gdp_about2.php');
        require_once(__DIR__ . '/widgets/gdp_about3.php');
        require_once(__DIR__ . '/widgets/gdp_about4.php');
        require_once(__DIR__ . '/widgets/gdp_about5.php');
        require_once(__DIR__ . '/widgets/gdp_service1.php');
        require_once(__DIR__ . '/widgets/gdp_service2.php');
        require_once(__DIR__ . '/widgets/gdp_service3.php');
        require_once(__DIR__ . '/widgets/gdp_service4.php');
        require_once(__DIR__ . '/widgets/gdp_service5.php');
        require_once(__DIR__ . '/widgets/gdp_portfolio1.php');
        require_once(__DIR__ . '/widgets/gdp_portfolio2.php');
        require_once(__DIR__ . '/widgets/gdp_portfolio3.php');
        require_once(__DIR__ . '/widgets/gdp_portfolio4.php');
        require_once(__DIR__ . '/widgets/gdp_portfolio5.php');
        require_once(__DIR__ . '/widgets/gdp_proses1.php');
        require_once(__DIR__ . '/widgets/gdp_proses2.php');
        require_once(__DIR__ . '/widgets/gdp_proses3.php');
        require_once(__DIR__ . '/widgets/gdp_faq1.php');
        require_once(__DIR__ . '/widgets/gdp_faq2.php');
        require_once(__DIR__ . '/widgets/gdp_faq3.php');
        require_once(__DIR__ . '/widgets/gdp_cta1.php');
        require_once(__DIR__ . '/widgets/gdp_cta2.php');
        require_once(__DIR__ . '/widgets/gdp_cta3.php');
        require_once(__DIR__ . '/widgets/gdp_testi1.php');
        require_once(__DIR__ . '/widgets/gdp_testi2.php');
        require_once(__DIR__ . '/widgets/gdp_testi3.php');
        require_once(__DIR__ . '/widgets/gdp_team1.php');
        require_once(__DIR__ . '/widgets/gdp_team2.php');
        require_once(__DIR__ . '/widgets/gdp_blog1.php');
        require_once(__DIR__ . '/widgets/gdp_pricing1.php');
        require_once(__DIR__ . '/widgets/gdp_pricing2.php');
        require_once(__DIR__ . '/widgets/gdp_pricing3.php');
        require_once(__DIR__ . '/widgets/gdp_pricing4.php');
        // Add more widget files as needed

        // Register widgets
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Gdp_hero1());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Gdp_hero2());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Gdp_hero3());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Gdp_hero4());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Gdp_hero5());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Gdp_hero6());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Gdp_about1());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Gdp_about2());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Gdp_about3());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Gdp_about4());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Gdp_about5());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Gdp_service1());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Gdp_service2());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Gdp_service3());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Gdp_service4());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Gdp_service5());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\GDP_Portfolio1());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\GDP_Portfolio2());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\GDP_Portfolio3());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\GDP_Portfolio4());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\GDP_Portfolio5());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\GDP_Proses1());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\GDP_Proses2());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\GDP_Proses3());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\GDP_Faq1());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\GDP_Faq2());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\GDP_Faq3());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\GDP_cta1());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\GDP_cta2());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\GDP_cta3());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\GDP_Testi1());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\GDP_Testi2());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\GDP_Testi3());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\GDP_Team1());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\GDP_Team2());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\GDP_Blog1());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\GDP_Pricing1());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\GDP_Pricing2());
        // Register more widgets as needed
    }

    /**
     * Register categories
     */
    public function add_elementor_widget_categories($elements_manager) {
        $elements_manager->add_category(
            'gdp_widget',
            [
                'title' => __('GDP Widgets', 'gdp'),
                'icon' => 'fa fa-plug',
            ]
        );
    }

    /**
     * Constructor
     */
    public function __construct() {
        // Register widgets
        add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets']);

        // Register widget categories
        add_action('elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories']);
    }
}

// Initialize Plugin
Plugin::instance();