<?php
Redux::setSection($opt_name, array(
    'title'  => 'Typography Settings',
    'id'     => 'typography_settings',
    'icon'   => 'el el-font',
    'desc'   => __('Pengaturan detail untuk setiap level heading', 'gusviradigital'),
    'fields' => array(

        // 1. H1 Typography - Untuk judul utama
        array(
            'id'          => 'h1_typography',
            'type'        => 'typography',
            'title'       => 'H1 Heading',
            'subtitle'    => 'Pengaturan font untuk H1',
            'desc'        => 'Biasanya digunakan untuk judul utama halaman',
            'google'      => true,
            'all_styles'  => true,
            'font-backup' => true,
            'output'      => array('h1'),
            'units'       => 'px',
            'default'     => array(
                'color'       => '#222222',
                'font-size'   => '36px',
                'font-family' => 'Nunito',
                'font-weight' => '800', // Bold untuk H1
                'line-height' => '1.2',
                'letter-spacing' => '-0.5px'
            ),
        ),

        // 2. H2 Typography - Untuk sub judul utama
        array(
            'id'          => 'h2_typography',
            'type'        => 'typography',
            'title'       => 'H2 Heading',
            'subtitle'    => 'Pengaturan font untuk H2',
            'desc'        => 'Biasanya digunakan untuk sub judul utama',
            'google'      => true,
            'all_styles'  => true,
            'font-backup' => true,
            'output'      => array('h2'),
            'units'       => 'px',
            'default'     => array(
                'color'       => '#222222',
                'font-size'   => '30px',
                'font-family' => 'Nunito',
                'font-weight' => '700', // Semi Bold untuk H2
                'line-height' => '1.3',
                'letter-spacing' => '-0.3px'
            ),
        ),

        // 3. H3 Typography - Untuk judul seksi
        array(
            'id'          => 'h3_typography',
            'type'        => 'typography',
            'title'       => 'H3 Heading',
            'subtitle'    => 'Pengaturan font untuk H3',
            'desc'        => 'Biasanya digunakan untuk judul seksi',
            'google'      => true,
            'all_styles'  => true,
            'font-backup' => true,
            'output'      => array('h3'),
            'units'       => 'px',
            'default'     => array(
                'color'       => '#222222',
                'font-size'   => '24px',
                'font-family' => 'Nunito',
                'font-weight' => '700',
                'line-height' => '1.4',
                'letter-spacing' => '-0.2px'
            ),
        ),

        // 4. H4 Typography - Untuk sub judul seksi
        array(
            'id'          => 'h4_typography',
            'type'        => 'typography',
            'title'       => 'H4 Heading',
            'subtitle'    => 'Pengaturan font untuk H4',
            'desc'        => 'Biasanya digunakan untuk sub judul seksi',
            'google'      => true,
            'all_styles'  => true,
            'font-backup' => true,
            'output'      => array('h4'),
            'units'       => 'px',
            'default'     => array(
                'color'       => '#222222',
                'font-size'   => '20px',
                'font-family' => 'Nunito',
                'font-weight' => '600', // Medium untuk H4
                'line-height' => '1.4',
                'letter-spacing' => '-0.1px'
            ),
        ),

        // 5. H5 Typography - Untuk judul kecil
        array(
            'id'          => 'h5_typography',
            'type'        => 'typography',
            'title'       => 'H5 Heading',
            'subtitle'    => 'Pengaturan font untuk H5',
            'desc'        => 'Biasanya digunakan untuk judul kecil',
            'google'      => true,
            'all_styles'  => true,
            'font-backup' => true,
            'output'      => array('h5'),
            'units'       => 'px',
            'default'     => array(
                'color'       => '#222222',
                'font-size'   => '18px',
                'font-family' => 'Nunito',
                'font-weight' => '600',
                'line-height' => '1.5',
                'letter-spacing' => '0'
            ),
        ),

        // 6. H6 Typography - Untuk judul terkecil
        array(
            'id'          => 'h6_typography',
            'type'        => 'typography',
            'title'       => 'H6 Heading',
            'subtitle'    => 'Pengaturan font untuk H6',
            'desc'        => 'Biasanya digunakan untuk judul terkecil',
            'google'      => true,
            'all_styles'  => true,
            'font-backup' => true,
            'output'      => array('h6'),
            'units'       => 'px',
            'default'     => array(
                'color'       => '#222222',
                'font-size'   => '16px',
                'font-family' => 'Nunito',
                'font-weight' => '600',
                'line-height' => '1.5',
                'letter-spacing' => '0'
            ),
        ),

        // 7. Body Typography
        array(
            'id'          => 'body_typography',
            'type'        => 'typography',
            'title'       => 'Body Text',
            'subtitle'    => 'Pengaturan font untuk body text',
            'google'      => true,
            'all_styles'  => true,
            'font-backup' => true,
            'output'      => array('body, p'),
            'units'       => 'px',
            'default'     => array(
                'color'       => '#666666',
                'font-size'   => '16px',
                'font-family' => 'Nunito',
                'font-weight' => '400', // Regular untuk body text
                'line-height' => '1.6',
                'letter-spacing' => '0'
            ),
        ),
        array(
            'id'          => 'menu_typography',
            'type'        => 'typography',
            'title'       => __('Menu Font', 'gusviradigital'),
            'subtitle'    => __('Pengaturan font untuk menu navigasi', 'gusviradigital'),
            'desc'        => __('Font ini akan digunakan di menu utama dan sub-menu', 'gusviradigital'),
            'google'      => true,
            'all_styles'  => true,
            'font-backup' => true,
            'output'      => array('.main-navigation'),
            'units'       => 'px',
            'default'     => array(
                'color'       => '#444444',
                'font-size'   => '15px',
                'font-family' => 'Poppins',
                'font-weight' => '500',
                'letter-spacing' => '0.5px'
            ),
        ),

        // 8. Global Font Settings
        array(
            'id'       => 'font_smoothing',
            'type'     => 'switch',
            'title'    => __('Font Smoothing', 'gusviradigital'),
            'subtitle' => __('Aktifkan font smoothing untuk tampilan lebih halus', 'gusviradigital'),
            'default'  => true
        ),

        // 9. Font Preload
        array(
            'id'       => 'preload_fonts',
            'type'     => 'switch',
            'title'    => __('Preload Fonts', 'gusviradigital'),
            'subtitle' => __('Preload font Nunito untuk performa lebih baik', 'gusviradigital'),
            'default'  => true
        ),
        array(
            'id'       => 'use_system_fonts',
            'type'     => 'switch',
            'title'    => __('Use System Fonts', 'gusviradigital'),
            'subtitle' => __('Gunakan font sistem sebagai fallback', 'gusviradigital'),
            'desc'     => __('Menggunakan font lokal untuk performa lebih baik', 'gusviradigital'),
            'default'  => true
        )
    )
));