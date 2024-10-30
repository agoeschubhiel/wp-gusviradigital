<?php
Redux::setSection($opt_name, array(
    'title'      => '404 Settings',
    'id'         => '404_settings',
    'icon'       => 'el el-error',
    'desc'       => __('Pengaturan halaman 404 Not Found', 'gusviradigital'),
    'fields'     => array(

        // 1. Basic 404 Settings
        array(
            'id'       => '404_page_title',
            'type'     => 'text',
            'title'    => __('404 Page Title', 'gusviradigital'),
            'subtitle' => __('Judul halaman 404', 'gusviradigital'),
            'desc'     => __('Judul yang akan ditampilkan di halaman 404', 'gusviradigital'),
            'default'  => 'Page Not Found'
        ),

        array(
            'id'       => '404_message',
            'type'     => 'editor',
            'title'    => __('404 Message', 'gusviradigital'),
            'subtitle' => __('Pesan halaman 404', 'gusviradigital'),
            'desc'     => __('Pesan yang akan ditampilkan di halaman 404', 'gusviradigital'),
            'default'  => 'Sorry, the page you are looking for could not be found.'
        ),

        // 2. 404 Page Design
        array(
            'id'       => '404_design',
            'type'     => 'section',
            'title'    => __('404 Page Design', 'gusviradigital'),
            'subtitle' => __('Pengaturan desain halaman 404', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => '404_background',
            'type'     => 'background',
            'title'    => __('Background', 'gusviradigital'),
            'subtitle' => __('Background halaman 404', 'gusviradigital'),
            'default'  => array(
                'background-color' => '#ffffff'
            )
        ),

        array(
            'id'       => '404_image',
            'type'     => 'media',
            'title'    => __('404 Image', 'gusviradigital'),
            'subtitle' => __('Gambar untuk halaman 404', 'gusviradigital')
        ),

        // 3. Navigation Options
        array(
            'id'       => '404_navigation',
            'type'     => 'section',
            'title'    => __('Navigation Options', 'gusviradigital'),
            'subtitle' => __('Opsi navigasi halaman 404', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'show_home_button',
            'type'     => 'switch',
            'title'    => __('Show Home Button', 'gusviradigital'),
            'subtitle' => __('Tampilkan tombol kembali ke beranda', 'gusviradigital'),
            'default'  => true
        ),

        array(
            'id'       => 'home_button_text',
            'type'     => 'text',
            'title'    => __('Home Button Text', 'gusviradigital'),
            'default'  => 'Back to Home'
        ),

        // 4. Search Integration
        array(
            'id'       => '404_search',
            'type'     => 'section',
            'title'    => __('Search Integration', 'gusviradigital'),
            'subtitle' => __('Integrasi pencarian di halaman 404', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'show_search',
            'type'     => 'switch',
            'title'    => __('Show Search Box', 'gusviradigital'),
            'subtitle' => __('Tampilkan kotak pencarian', 'gusviradigital'),
            'default'  => true
        ),

        array(
            'id'       => 'search_placeholder',
            'type'     => 'text',
            'title'    => __('Search Placeholder', 'gusviradigital'),
            'default'  => 'Search...'
        ),

        // 5. Suggested Content
        array(
            'id'       => '404_suggestions',
            'type'     => 'section',
            'title'    => __('Suggested Content', 'gusviradigital'),
            'subtitle' => __('Konten yang disarankan', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'show_suggestions',
            'type'     => 'switch',
            'title'    => __('Show Suggested Posts', 'gusviradigital'),
            'subtitle' => __('Tampilkan artikel yang disarankan', 'gusviradigital'),
            'default'  => true
        ),

        array(
            'id'       => 'suggestion_count',
            'type'     => 'spinner',
            'title'    => __('Number of Suggestions', 'gusviradigital'),
            'default'  => '3',
            'min'      => '1',
            'max'      => '10',
            'step'     => '1'
        ),

        // 6. Analytics & Logging
        array(
            'id'       => '404_analytics',
            'type'     => 'section',
            'title'    => __('Analytics & Logging', 'gusviradigital'),
            'subtitle' => __('Pelacakan halaman 404', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'enable_404_logging',
            'type'     => 'switch',
            'title'    => __('Enable 404 Logging', 'gusviradigital'),
            'subtitle' => __('Catat semua akses ke halaman 404', 'gusviradigital'),
            'default'  => true
        ),

        array(
            'id'       => 'log_retention',
            'type'     => 'spinner',
            'title'    => __('Log Retention (days)', 'gusviradigital'),
            'default'  => '30',
            'min'      => '1',
            'max'      => '365'
        ),

        // 7. Redirect Settings
        array(
            'id'       => '404_redirects',
            'type'     => 'section',
            'title'    => __('Redirect Settings', 'gusviradigital'),
            'subtitle' => __('Pengaturan pengalihan 404', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'enable_auto_redirect',
            'type'     => 'switch',
            'title'    => __('Enable Auto Redirect', 'gusviradigital'),
            'subtitle' => __('Pengalihan otomatis untuk URL tertentu', 'gusviradigital'),
            'default'  => false
        ),

        array(
            'id'       => 'redirect_rules',
            'type'     => 'repeater',
            'title'    => __('Redirect Rules', 'gusviradigital'),
            'subtitle' => __('Aturan pengalihan URL', 'gusviradigital'),
            'fields'   => array(
                array(
                    'id'       => 'old_url',
                    'type'     => 'text',
                    'title'    => 'Old URL'
                ),
                array(
                    'id'       => 'new_url',
                    'type'     => 'text',
                    'title'    => 'New URL '
                )
            )
        )
    )
));