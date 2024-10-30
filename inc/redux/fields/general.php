<?php
Redux::setSection($opt_name, array(
    'title'  => 'Basic Settings',
    'id'     => 'basic_settings',
    'icon'   => 'el el-home',
    'fields' => array(
        
        // 1. Site Layout - Menentukan struktur dasar website
        array(
            'id'       => 'site_layout',
            'type'     => 'select',
            'title'    => 'Site Layout',
            'subtitle' => 'Pilih layout dasar website',
            'desc'     => 'Layout menentukan bagaimana konten ditampilkan',
            'options'  => array(
                'wide'      => 'Wide (Tampilan lebar)',
                'boxed'     => 'Boxed (Tampilan terbatas)',
                'fullwidth' => 'Full Width (Tampilan penuh)'
            ),
            'default'  => 'wide'
        ),

        // 2. Container Width - Mengatur lebar konten
        array(
            'id'       => 'container_width',
            'type'     => 'slider',
            'title'    => 'Container Width',
            'subtitle' => 'Atur lebar maksimum konten',
            'desc'     => 'Semakin besar nilai, semakin lebar area konten',
            'default'  => 1200,
            'min'      => 960,
            'max'      => 1920,
            'step'     => 10
        ),

        // 3. Site Logo - Identitas utama website
        array(
            'id'       => 'site_logo_dark',
            'type'     => 'media',
            'title'    => 'Site Logo Dark',
            'subtitle' => 'Upload logo website',
            'desc'     => 'Rekomendasi: PNG/SVG, max 200KB, ukuran 180x60px',
        ),

        array(
            'id'       => 'site_logo_light',
            'type'     => 'media',
            'title'    => 'Site Logo Light',
            'subtitle' => 'Upload logo website',
            'desc'     => 'Rekomendasi: PNG/SVG, max 200KB, ukuran 180x60px',
        ),

        // 4. Favicon - Ikon website di browser
        array(
            'id'       => 'favicon',
            'type'     => 'media',
            'title'    => 'Favicon',
            'subtitle' => 'Upload favicon website',
            'desc'     => 'Format: ICO/PNG, ukuran 16x16px atau 32x32px',
        ),

        array(
            'id'       => 'primary_color',
            'type'     => 'color',
            'title'    => __('Primary Color', 'gusviradigital'),
            'subtitle' => __('Pilih warna sekunder tema', 'gusviradigital'),
            'desc'     => __('Digunakan untuk elemen pendukung website', 'gusviradigital'),
            'default'  => '#2f5fdf',
            'validate' => 'color'
        ),

        // 5. Secondary Color - Warna pendukung tema
        array(
            'id'       => 'secondary_color',
            'type'     => 'color',
            'title'    => __('Secondary Color', 'gusviradigital'),
            'subtitle' => __('Pilih warna sekunder tema', 'gusviradigital'),
            'desc'     => __('Digunakan untuk elemen pendukung website', 'gusviradigital'),
            'default'  => '#f68d22',
            'validate' => 'color'
        ),

        array(
            'id'       => 'three_color',
            'type'     => 'color',
            'title'    => __('Three Color', 'gusviradigital'),
            'subtitle' => __('Pilih warna sekunder tema', 'gusviradigital'),
            'desc'     => __('Digunakan untuk elemen pendukung website', 'gusviradigital'),
            'default'  => '#91afff',
            'validate' => 'color'
        ),

        // 6. Preloader - Animasi loading
        array(
            'id'       => 'enable_preloader',
            'type'     => 'switch',
            'title'    => 'Enable Preloader',
            'subtitle' => 'Tampilkan animasi loading',
            'desc'     => 'Memberikan feedback visual saat website dimuat',
            'default'  => true,
        ),

        array(
            'id'       => 'dropdown_animation',
            'type'     => 'select',
            'title'    => __('Dropdown Animation', 'gusviradigital'),
            'subtitle' => __('Pilih animasi untuk dropdown menu', 'gusviradigital'),
            'options'  => array(
                'fade'     => 'Fade',
                'slide'    => 'Slide',
                'none'     => 'No Animation'
            ),
            'default'  => 'fade'
        ),

        array(
            'id'       => 'enable_dark_mode',
            'type'     => 'switch',
            'title'    => __('Enable Dark Mode Toggle', 'gusviradigital'),
            'subtitle' => __('Tampilkan tombol dark mode di header', 'gusviradigital'),
            'default'  => true
        ),

        array(
            'id'       => 'mobile_menu_style',
            'type'     => 'select',
            'title'    => __('Mobile Menu Style', 'gusviradigital'),
            'subtitle' => __('Pilih style untuk menu mobile', 'gusviradigital'),
            'options'  => array(
                'overlay'   => 'Full Screen Overlay',
                'dropdown'  => 'Dropdown',
                'side'      => 'Side Panel'
            ),
            'default'  => 'dropdown'
        ),

        array(
            'id'       => 'header_animation',
            'type'     => 'select',
            'title'    => __('Header Animation', 'gusviradigital'),
            'subtitle' => __('Pilih animasi untuk sticky header', 'gusviradigital'),
            'options'  => array(
                'slide'     => 'Slide',
                'fade'      => 'Fade',
                'none'      => 'No Animation'
            ),
            'default'  => 'slide'
        )
    )
));