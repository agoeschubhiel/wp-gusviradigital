<?php
Redux::setSection($opt_name, array(
    'title'  => 'Header Settings',
    'id'     => 'header_settings',
    'icon'   => 'el el-website',
    'fields' => array(
        
        // 1. Header Layout - Paling penting karena menentukan struktur dasar header
        array(
            'id'       => 'header_layout',
            'type'     => 'image_select',
            'title'    => 'Header Layout',
            'subtitle' => 'Pilih layout dasar header website',
            'desc'     => 'Layout akan mempengaruhi susunan elemen dalam header',
            'options'  => array(
                'layout1' => array(
                    'alt' => 'Layout 1',
                    'img' => get_template_directory_uri() . '/assets/images/header-1.png'
                ),
                'layout2' => array(
                    'alt' => 'Layout 2',
                    'img' => get_template_directory_uri() . '/assets/images/header-2.png'
                ),
            ),
            'default'  => 'layout1'
        ),

        // 2. Header Style - Menentukan tampilan visual header
        array(
            'id'       => 'header_style',
            'type'     => 'select',
            'title'    => __('Header Style', 'gusviradigital'),
            'subtitle' => __('Pilih style visual header', 'gusviradigital'),
            'desc'     => __('Style mempengaruhi tampilan dan nuansa header', 'gusviradigital'),
            'options'  => array(
                'style1' => 'Style 1',
                'style2' => 'Style 2',
                'style3' => 'Style 3'
            ),
            'default'  => 'style1'
        ),

        // 3. Logo Height - Ukuran logo yang tepat penting untuk branding
        array(
            'id'       => 'logo_height',
            'type'     => 'text',
            'title'    => __('Logo Height (px)', 'gusviradigital'),
            'subtitle' => __('Atur tinggi logo header', 'gusviradigital'),
            'desc'     => __('Rekomendasi: 40-60px untuk tampilan optimal', 'gusviradigital'),
            'default'  => '50',
        ),

        // 4. Header Background - Warna latar penting untuk keseluruhan tampilan
        array(
            'id'       => 'header_background',
            'type'     => 'color',
            'title'    => __('Header Background Color', 'gusviradigital'),
            'subtitle' => __('Pilih warna latar header', 'gusviradigital'),
            'desc'     => __('Pastikan kontras dengan warna teks', 'gusviradigital'),
            'default'  => '#ffffff',
        ),

        // 5. Header Text Color - Warna teks untuk keterbacaan
        array(
            'id'       => 'header_text_color',
            'type'     => 'color',
            'title'    => __('Header Text Color', 'gusviradigital'),
            'subtitle' => __('Pilih warna teks header', 'gusviradigital'),
            'desc'     => __('Pastikan kontras dengan background', 'gusviradigital'),
            'default'  => '#333333',
        ),

        // 6. Menu Hover Color - Interaktivitas menu
        array(
            'id'       => 'menu_hover_color',
            'type'     => 'color',
            'title'    => __('Menu Hover Color', 'gusviradigital'),
            'subtitle' => __('Warna saat menu dihover', 'gusviradigital'),
            'desc'     => __('Pilih warna yang kontras untuk feedback visual', 'gusviradigital'),
            'default'  => '#007bff',
        ),

        // 7. Sticky Header - Fitur navigasi
        array(
            'id'       => 'sticky_header',
            'type'     => 'switch',
            'title'    => __('Sticky Header', 'gusviradigital'),
            'subtitle' => __('Header tetap terlihat saat scroll', 'gusviradigital'),
            'desc'     => __('Meningkatkan kemudahan navigasi', 'gusviradigital'),
            'default'  => true
        ),

        // 8. Header Button - CTA di header
        array(
            'id'       => 'header_button',
            'type'     => 'switch',
            'title'    => __('Header Button', 'gusviradigital'),
            'subtitle' => __('Tampilkan tombol CTA di header', 'gusviradigital'),
            'desc'     => __('Tombol untuk aksi utama website', 'gusviradigital'),
            'default'  => true
        ),

        // 9. Button Text - Teks tombol CTA
        array(
            'id'       => 'header_button_text',
            'type'     => 'text',
            'title'    => __('Button Text', 'gusviradigital'),
            'subtitle' => __('Teks untuk tombol CTA', 'gusviradigital'),
            'desc'     => __('Gunakan kata-kata yang mengajak', 'gusviradigital'),
            'default'  => __('Contact Us', 'gusviradigital'),
            'required' => array('header_button', '=', true)
        ),

        // 10. Button URL - Link tombol CTA
        array(
            'id'       => 'header_button_url',
            'type'     => 'text',
            'title'    => __('Button URL', 'gusviradigital'),
            'subtitle' => __('Link untuk tombol CTA', 'gusviradigital'),
            'desc'     => __('Masukkan URL lengkap dengan http/https', 'gusviradigital'),
            'default'  => '#',
            'required' => array('header_button', '=', true)
        ),

        // 11. Contact Info Switch - Informasi kontak
        array(
            'id'       => 'header_contact_info',
            'type'     => 'switch',
            'title'    => __('Contact Info', 'gusviradigital'),
            'subtitle' => __('Tampilkan informasi kontak', 'gusviradigital'),
            'desc'     => __('Nomor telepon dan email di header', 'gusviradigital'),
            'default'  => true
        ),

        // 12. Phone Number - Nomor kontak
        array(
            'id'       => 'header_phone',
            'type'     => 'text',
            'title'    => __('Phone Number', 'gusviradigital'),
            'subtitle' => __('Nomor telepon yang bisa dihubungi', 'gusviradigital'),
            'desc'     => __('Format: +62xxx-xxxx-xxxx', 'gusviradigital'),
            'default'  => '+1234567890',
            'required' => array('header_contact_info', '=', true)
        ),

        // 13. Email Address - Alamat email
        array(
            'id'       => 'header_email',
            'type'     => 'text',
            'title'    => __('Email Address', 'gusviradigital'),
            'subtitle' => __('Alamat email kontak', 'gusviradigital'),
            'desc'     => __('Gunakan email aktif', 'gusviradigital'),
            'default'  => 'info@example.com',
            'required' => array('header_contact_info', '=', true)
        ),
    )
));