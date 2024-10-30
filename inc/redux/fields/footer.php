<?php
// Footer Settings Section - Mengatur konfigurasi footer website
Redux::setSection($opt_name, array(
    'title'  => 'Footer Settings', // Judul section
    'id'     => 'footer_settings', // ID unik section
    'icon'   => 'el el-arrow-down', // Icon section
    'fields' => array(
        
        // 1. Footer Style - Mengatur tampilan dasar footer
        array(
            'id'       => 'footer_style',
            'type'     => 'select',
            'title'    => __('Footer Style', 'gusviradigital'),
            'subtitle' => __('Pilih style footer yang akan digunakan', 'gusviradigital'),
            'desc'     => __('Style menentukan layout dan tampilan dasar footer', 'gusviradigital'),
            'options'  => array(
                'style1' => 'Style 1', // Layout default
                'style2' => 'Style 2', // Layout alternatif 1
                'style3' => 'Style 3'  // Layout alternatif 2
            ),
            'default'  => 'style1'
        ),

        // 2. Footer Columns - Mengatur jumlah kolom footer
        array(
            'id'       => 'footer_columns', 
            'type'     => 'select',
            'title'    => __('Footer Columns', 'gusviradigital'),
            'subtitle' => __('Tentukan jumlah kolom pada footer', 'gusviradigital'),
            'desc'     => __('Jumlah kolom mempengaruhi pembagian konten footer', 'gusviradigital'),
            'options'  => array(
                '2' => '2 Columns', // 2 pembagian area
                '3' => '3 Columns', // 3 pembagian area  
                '4' => '4 Columns'  // 4 pembagian area
            ),
            'default'  => '4'
        ),

        // 3. Footer Logo - Upload logo untuk footer
        array(
            'id'       => 'footer_logo',
            'type'     => 'media',
            'title'    => __('Footer Logo', 'gusviradigital'),
            'subtitle' => __('Upload logo yang akan ditampilkan di footer', 'gusviradigital'),
            'desc'     => __('Rekomendasi ukuran: 200x80px, format: PNG/SVG', 'gusviradigital')
        ),

        // 4. Footer Background - Warna latar footer
        array(
            'id'       => 'footer_background',
            'type'     => 'color',
            'title'    => __('Footer Background Color', 'gusviradigital'),
            'subtitle' => __('Pilih warna latar belakang footer', 'gusviradigital'),
            'desc'     => __('Warna akan diterapkan ke seluruh area footer', 'gusviradigital'),
            'default'  => '#333333',
        ),

        // 5. Footer Text Color - Warna teks footer
        array(
            'id'       => 'footer_text_color',
            'type'     => 'color',
            'title'    => __('Footer Text Color', 'gusviradigital'),
            'subtitle' => __('Pilih warna teks footer', 'gusviradigital'),
            'desc'     => __('Pastikan warna kontras dengan background', 'gusviradigital'),
            'default'  => '#ffffff',
        ),

        // 6. Footer Copyright - Teks copyright
        array(
            'id'       => 'footer_copyright',
            'type'     => 'editor',
            'title'    => __('Copyright Text', 'gusviradigital'),
            'subtitle' => __('Masukkan teks copyright', 'gusviradigital'),
            'desc'     => __('Gunakan {year} untuk tahun otomatis', 'gusviradigital'),
            'default'  => '© ' . date('Y') . ' ' . get_bloginfo('name') . '. All Rights Reserved.'
        ),

        // 7. Footer About - Deskripsi footer
        array(
            'id'       => 'footer_about',
            'type'     => 'textarea',
            'title'    => __('Footer About Text', 'gusviradigital'),
            'subtitle' => __('Masukkan deskripsi singkat', 'gusviradigital'),
            'desc'     => __('Maksimal 200 karakter', 'gusviradigital'),
            'default'  => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'gusviradigital')
        ),

        // 8. Footer Social Links - Link sosial media
        array(
            'id'       => 'footer_social_links',
            'type'     => 'multi_text',
            'title'    => 'Footer Social Links',
            'subtitle' => 'Tambahkan link sosial media',
            'desc'     => 'Masukkan URL lengkap (contoh: https://facebook.com/username)',
            'default'  => array(
                'https://facebook.com/gusviradigital',
                'https://twitter.com/gusviradigital', 
                'https://instagram.com/gusviradigital'
            )
        )
    )
));