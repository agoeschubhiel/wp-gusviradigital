<?php
// inc/classes/core/class-gdp-assets.php

class GDP_Assets {
    public static function init() {
        add_action('wp_enqueue_scripts', [__CLASS__, 'register_assets']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'register_admin_assets']);
        add_action('wp_head', [__CLASS__, 'preload_assets'], 1);
    }

    public static function register_assets() {
        // Enqueue styles
        wp_enqueue_style(
            'gdp-styles',
            GDP_ASSETS_URI . '/css/dist/main.css',
            [],
            GDP_VERSION
        );

        // Enqueue scripts
        wp_enqueue_script(
            'gdp-scripts',
            GDP_ASSETS_URI . '/js/dist/main.js',
            ['jquery'],
            GDP_VERSION,
            true
        );

        // Localize script
        wp_localize_script('gdp-scripts', 'gdpData', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('gdp-nonce')
        ]);
    }

    public static function register_admin_assets($hook) {
        wp_enqueue_style(
            'gdp-admin-styles',
            GDP_ASSETS_URI . '/css/dist/admin.css',
            [],
            GDP_VERSION
        );

        wp_enqueue_script(
            'gdp-admin-scripts',
            GDP_ASSETS_URI . '/js/dist/admin.js',
            ['jquery'],
            GDP_VERSION,
            true
        );
    }

    public static function preload_assets() {
        echo '<link rel="preload" href="' . GDP_ASSETS_URI . '/css/dist/main.css" as="style">';
        echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
        echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    }
}