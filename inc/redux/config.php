<?php
if (!class_exists('Redux')) {
    return;
}

$opt_name = 'gusviradigital_options';

$args = array(
    'opt_name'             => $opt_name,
    'display_name'         => 'GDP Options',
    'display_version'      => GDP_VERSION,
    'menu_type'           => 'menu',
    'allow_sub_menu'      => true,
    'menu_title'          => 'GDP Options',
    'page_title'          => 'GDP Options',
    'dev_mode'            => false,
    'menu_icon'           => 'dashicons-admin-generic',
    'page_priority'       => 58,
    'page_permissions'    => 'manage_options',
    'save_defaults'       => true,
    'show_import_export'  => true,
    'transient_time'      => 60 * MINUTE_IN_SECONDS,
    'output'              => true,
    'output_tag'          => true,
    'database'            => '',
    'use_cdn'             => true,
);

// 1. Core Settings
require_once 'fields/general.php';        // xPengaturan dasar tema
require_once 'fields/typography.php';      // xPengaturan tipografi

// 2. Layout Components
require_once 'fields/header.php';         // xPengaturan header
require_once 'fields/footer.php';         // xPengaturan footer

// 3. Main Features
require_once 'fields/blog.php';           // Pengaturan blog
require_once 'fields/woocommerce.php';    // Pengaturan toko online
require_once 'fields/seo.php';            // xPengaturan SEO

// 4. System & Performance
require_once 'fields/performance.php';     // Pengaturan performa
require_once 'fields/security.php';        // Pengaturan keamanan
require_once 'fields/custom-code.php';     // xKode kustom

// 5. Special Pages & Features
require_once 'fields/404.php';            // xHalaman 404
require_once 'fields/maintenance.php';     // xMode maintenance

// 6. Additional Settings
require_once 'fields/translations.php';    // xPengaturan terjemahan

Redux::setArgs($opt_name, $args);

// global $gdp_options;
// $gdp_options = GDP_Theme_Support::gdp_option();