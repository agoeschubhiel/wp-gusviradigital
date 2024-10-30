<?php
Redux::setSection($opt_name, array(
    'title'      => 'Custom Code Settings',
    'id'         => 'custom_code_settings',
    'icon'       => 'el el-cogs',
    'desc'       => __('Pengaturan untuk menambahkan kode kustom ke website', 'gusviradigital'),
    'fields'     => array(

        // 1. Custom JavaScript - Paling penting untuk fungsi interaktif
        array(
            'id'       => 'custom_js',
            'type'     => 'ace_editor',
            'title'    => 'Custom JavaScript',
            'subtitle' => __('Tambahkan kode JavaScript kustom', 'gusviradigital'),
            'desc'     => __('Kode JavaScript akan dioptimasi dan diminifikasi secara otomatis. Gunakan untuk menambah fungsi interaktif.', 'gusviradigital'),
            'mode'     => 'javascript',
            'theme'    => 'monokai',
            'default'  => '',
            'validate' => 'js'
        ),

        // 2. Header Code - Penting untuk meta tags dan analytics
        array(
            'id'       => 'custom_code_head',
            'type'     => 'ace_editor',
            'title'    => 'Header Code',
            'subtitle' => __('Kode yang akan ditambahkan di bagian head', 'gusviradigital'),
            'desc'     => __('Tempat ideal untuk menempatkan meta tags, CSS, atau kode tracking. Dieksekusi sebelum halaman dimuat.', 'gusviradigital'),
            'mode'     => 'html',
            'theme'    => 'monokai',
            'default'  => '',
            'validate' => 'html'
        ),

        // 3. Footer Scripts - Penting untuk analytics dan tracking
        array(
            'id'       => 'footer_scripts',
            'type'     => 'ace_editor',
            'title'    => __('Footer Scripts', 'gusviradigital'),
            'subtitle' => __('Kode yang akan ditambahkan sebelum tag body ditutup', 'gusviradigital'),
            'desc'     => __('Tempat ideal untuk script yang tidak menghambat loading halaman. Dieksekusi setelah semua konten dimuat.', 'gusviradigital'),
            'mode'     => 'html',
            'theme'    => 'monokai',
            'default'  => '',
            'validate' => 'html'
        ),

        // 4. Body Code - Untuk kode tambahan di body
        array(
            'id'       => 'custom_code_body',
            'type'     => 'ace_editor',
            'title'    => 'Body Code',
            'subtitle' => __('Kode yang akan ditambahkan di awal body', 'gusviradigital'),
            'desc'     => __('Gunakan untuk menambahkan kode yang perlu dieksekusi segera setelah body tag dibuka.', 'gusviradigital'),
            'mode'     => 'html',
            'theme'    => 'monokai',
            'default'  => '',
            'validate' => 'html'
        ),

        // 5. Custom HTML - Untuk konten HTML tambahan
        array(
            'id'       => 'custom_html',
            'type'     => 'ace_editor',
            'title'    => 'Custom HTML',
            'subtitle' => __('Tambahkan kode HTML kustom', 'gusviradigital'),
            'desc'     => __('Gunakan untuk menambahkan struktur HTML kustom atau widget tambahan.', 'gusviradigital'),
            'mode'     => 'html',
            'theme'    => 'monokai',
            'default'  => '',
            'validate' => 'html'
        ),

        // 6. Code Validation
        array(
            'id'       => 'code_validation',
            'type'     => 'switch',
            'title'    => __('Code Validation', 'gusviradigital'),
            'subtitle' => __('Aktifkan validasi kode', 'gusviradigital'),
            'desc'     => __('Memvalidasi semua kode kustom sebelum disimpan untuk menghindari error', 'gusviradigital'),
            'default'  => true
        ),

        // 7. Code Minification
        array(
            'id'       => 'code_minification',
            'type'     => 'switch',
            'title'    => __('Code Minification', 'gusviradigital'),
            'subtitle' => __('Aktifkan minifikasi kode', 'gusviradigital'),
            'desc'     => __('Mengoptimasi kode dengan menghapus spasi dan komentar yang tidak perlu', 'gusviradigital'),
            'default'  => true
        )
    )
));