<?php
Redux::setSection($opt_name, array(
    'title'      => 'Maintenance Settings',
    'id'         => 'maintenance_settings',
    'icon'       => 'el el-wrench',
    'desc'       => __('Pengaturan mode maintenance website', 'gusviradigital'),
    'fields'     => array(

        // 1. Basic Maintenance Settings
        array(
            'id'       => 'maintenance_mode',
            'type'     => 'switch',
            'title'    => __('Enable Maintenance Mode', 'gusviradigital'),
            'subtitle' => __('Aktifkan mode maintenance', 'gusviradigital'),
            'desc'     => __('Website akan menampilkan halaman maintenance', 'gusviradigital'),
            'default'  => false
        ),

        array(
            'id'       => 'maintenance_type',
            'type'     => 'select',
            'title'    => __('Maintenance Type', 'gusviradigital'),
            'subtitle' => __('Pilih tipe maintenance', 'gusviradigital'),
            'options'  => array(
                'maintenance' => 'Maintenance Mode',
                'coming_soon' => 'Coming Soon',
                'custom'      => 'Custom Message'
            ),
            'default'  => 'maintenance'
        ),

        // 2. Content Settings
        array(
            'id'       => 'maintenance_title',
            'type'     => 'text',
            'title'    => __('Maintenance Title', 'gusviradigital'),
            'subtitle' => __('Judul halaman maintenance', 'gusviradigital'),
            'default'  => 'Site Under Maintenance'
        ),

        array(
            'id'       => 'maintenance_message',
            'type'     => 'editor',
            'title'    => __('Maintenance Message', 'gusviradigital'),
            'subtitle' => __('Pesan yang ditampilkan', 'gusviradigital'),
            'default'  => 'We are currently performing scheduled maintenance. We will be back online shortly.'
        ),

        // 3. Design Settings
        array(
            'id'       => 'maintenance_design',
            'type'     => 'section',
            'title'    => __('Design Settings', 'gusviradigital'),
            'subtitle' => __('Pengaturan tampilan maintenance', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'maintenance_background',
            'type'     => 'background',
            'title'    => __('Background', 'gusviradigital'),
            'subtitle' => __('Background halaman maintenance', 'gusviradigital'),
            'default'  => array(
                'background-color' => '#ffffff'
            )
        ),

        array(
            'id'       => 'maintenance_logo',
            'type'     => 'media',
            'title'    => __('Logo', 'gusviradigital'),
            'subtitle' => __('Logo untuk halaman maintenance', 'gusviradigital')
        ),

        // 4. Timer Settings
        array(
            'id'       => 'maintenance_timer',
            'type'     => 'section',
            'title'    => __('Timer Settings', 'gusviradigital'),
            'subtitle' => __('Pengaturan countdown timer', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'show_timer',
            'type'     => 'switch',
            'title'    => __('Show Countdown Timer', 'gusviradigital'),
            'subtitle' => __('Tampilkan countdown timer', 'gusviradigital'),
            'default'  => true
        ),

        array(
            'id'       => 'maintenance_date',
            'type'     => 'date',
            'title'    => __('End Date', 'gusviradigital'),
            'subtitle' => __('Tanggal selesai maintenance', 'gusviradigital')
        ),

        // 5. Access Control
        array(
            'id'       => 'access_control',
            'type'     => 'section',
            'title'    => __('Access Control', 'gusviradigital'),
            'subtitle' => __('Pengaturan akses maintenance', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'whitelist_ips',
            'type'     => 'multi_text',
            'title'    => __('Whitelist IPs', 'gusviradigital'),
            'subtitle' => __('IP yang diizinkan akses', 'gusviradigital')
        ),

        array(
            'id'       => 'bypass_roles',
            'type'     => 'select',
            'multi'    => true,
            'title'    => __('Bypass User Roles', 'gusviradigital'),
            'subtitle' => __('Role yang dapat mengakses website', 'gusviradigital'),
            'options'  => array(
                'administrator' => 'Administrator',
                'editor'       => 'Editor',
                'author'       => 'Author'
            ),
            'default'  => array('administrator')
        ),

        // 6. Notification Settings
        array(
            'id'       => 'notification_settings',
            'type'     => 'section',
            'title'    => __('Notification Settings', 'gusviradigital'),
            'subtitle' => __('Pengaturan notifikasi', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'enable_notifications',
            'type'     => 'switch',
            'title'    => __('Enable Email Notifications', 'gusviradigital'),
            'subtitle' => __('Kirim notifikasi email', 'gusviradigital'),
            'default'  => true
        ),

        array(
            'id'       => 'notification_email',
            'type'     => 'text',
            'title'    => __('Notification Email', 'gusviradigital'),
            'subtitle' => __('Email untuk menerima notifikasi', 'gusviradigital'),
            'validate' => 'email'
        ),

        // 7. Social Media
        array(
            'id'       => 'maintenance_social',
            'type'     => 'section',
            'title'    => __('Social Media', 'gusviradigital'),
            'subtitle' => __('Link social media', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'show_social',
            'type'     => 'switch',
            'title'    => __('Show Social Media', 'gusviradigital'),
            'subtitle' => __('Tampilkan icon social media', 'gusviradigital'),
            'default'  => true
        ),

        array(
            'id'       => 'social_links',
            'type'     => 'repeater',
            'title'    => __('Social Links', 'gusviradigital'),
            'subtitle' => __('Tambah link social media', 'gusviradigital'),
            'group_values' => true,
            'fields'   => array(
                array(
                    'id'       => 'platform',
                    'type'     => 'select',
                    'title'    => 'Platform',
                    'options'  => array(
                        'facebook'  => 'Facebook',
                        'twitter'   => 'Twitter',
                        'instagram' => 'Instagram',
                        'linkedin'  => 'LinkedIn'
                    )
                ),
                array(
                    'id'       => 'url',
                    'type'     => 'text',
                    'title'     => 'URL',
                    'validate' => 'url'
                )
            )
        )

    )
));