<?php
Redux::setSection($opt_name, array(
    'title'  => 'Performance Settings',
    'id'     => 'performance_settings',
    'icon'   => 'el el-dashboard',
    'fields' => array(
        // === CACHE MANAGEMENT ===
        array(
            'id'       => 'cache_section',
            'type'     => 'section',
            'title'    => __('Cache Management', 'gusviradigital'),
            'subtitle' => __('Pengaturan sistem cache untuk meningkatkan performa website', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'enable_cache',
            'type'     => 'switch',
            'title'    => __('Enable Cache System', 'gusviradigital'),
            'subtitle' => __('Aktifkan sistem cache untuk meningkatkan kecepatan loading', 'gusviradigital'),
            'default'  => true,
            'on'       => __('On', 'gusviradigital'),
            'off'      => __('Off', 'gusviradigital'),
        ),

        array(
            'id'       => 'cache_lifetime',
            'type'     => 'slider',
            'title'    => __('Cache Lifetime (Hours)', 'gusviradigital'),
            'subtitle' => __('Durasi penyimpanan cache', 'gusviradigital'),
            'desc'     => __('Semakin lama cache disimpan, semakin cepat loading website. Rekomendasi: 24 jam', 'gusviradigital'),
            'default'  => 24,
            'min'      => 1,
            'max'      => 168,
            'step'     => 1,
            'required' => array('enable_cache', '=', true)
        ),

        array(
            'id'       => 'excluded_urls',
            'type'     => 'textarea',
            'title'    => __('Excluded URLs', 'gusviradigital'),
            'subtitle' => __('URL yang tidak akan di-cache', 'gusviradigital'),
            'desc'     => __('Masukkan satu URL per baris. Contoh: /cart, /checkout, /my-account', 'gusviradigital'),
            'default'  => "/wp-admin\n/wp-login\n/cart\n/checkout\n/my-account",
            'required' => array('enable_cache', '=', true)
        ),

        array(
            'id'       => 'enable_mobile_cache',
            'type'     => 'switch',
            'title'    => __('Separate Mobile Cache', 'gusviradigital'),
            'subtitle' => __('Aktifkan cache terpisah untuk perangkat mobile', 'gusviradigital'),
            'default'  => true,
            'on'       => __('On', 'gusviradigital'),
            'off'      => __('Off', 'gusviradigital'),
            'required' => array('enable_cache', '=', true)
        ),

        array(
            'id'       => 'cache_preload',
            'type'     => 'switch',
            'title'    => __('Cache Preload', 'gusviradigital'),
            'subtitle' => __('Otomatis generate cache setelah cache dihapus', 'gusviradigital'),
            'default'  => false,
            'on'       => __('On', 'gusviradigital'),
            'off'      => __('Off', 'gusviradigital'),
            'required' => array('enable_cache', '=', true)
        ),

        array(
            'id'       => 'cache_gzip',
            'type'     => 'switch',
            'title'    => __('Enable GZIP Compression', 'gusviradigital'),
            'subtitle' => __('Kompres file cache untuk menghemat bandwidth', 'gusviradigital'),
            'default'  => true,
            'on'       => __('On', 'gusviradigital'),
            'off'      => __('Off', 'gusviradigital'),
            'required' => array('enable_cache', '=', true)
        ),

        array(
            'id'       => 'cache_debug',
            'type'     => 'switch',
            'title'    => __('Debug Mode', 'gusviradigital'),
            'subtitle' => __('Tampilkan informasi cache di HTML comment', 'gusviradigital'),
            'default'  => false,
            'on'       => __('On', 'gusviradigital'),
            'off'      => __('Off', 'gusviradigital'),
            'required' => array('enable_cache', '=', true)
        ),

        array(
            'id'       => 'cache_version',
            'type'     => 'text',
            'title'    => __('Cache Version', 'gusviradigital'),
            'subtitle' => __('Versi cache untuk mengontrol invalidasi cache', 'gusviradigital'),
            'default'  => '1.0',
            'required' => array('enable_cache', '=', true)
        ),

        array(
            'id'       => 'page_specific_ttl',
            'type'     => 'slider',
            'title'    => __('Page Specific TTL', 'gusviradigital'),
            'subtitle' => __('TTL untuk halaman tertentu', 'gusviradigital'),
            'desc'     => __('Durasi penyimpanan cache untuk halaman tertentu', 'gusviradigital'),
            'default'  => 24,
            'min'      => 1,
            'max'      => 168,
            'step'     => 1,
            'required' => array('enable_cache', '=', true)
        ),

        array(
            'id'       => 'cache_warmup',
            'type'     => 'switch',
            'title'    => __('Cache Warmup', 'gusviradigital'),
            'subtitle' => __('Aktifkan cache warmup untuk meningkatkan kinerja', 'gusviradigital'),
            'default'  => true,
            'on'       => __('On', 'gusviradigital'),
            'off'      => __('Off', 'gusviradigital'),
            'required' => array('enable_cache', '=', true)
        ),

        array(
            'id'       => 'cache_statistics',
            'type'     => 'switch',
            'title'    => __('Cache Statistics', 'gusviradigital'),
            'subtitle' => __('Aktifkan statistik cache untuk memantau kinerja', 'gusviradigital'),
            'default'  => true,
            'on'       => __('On', 'gusviradigital'),
            'off'      => __('Off', 'gusviradigital'),
            'required' => array('enable_cache', '=', true)
        ),

        // === ASSET OPTIMIZATION ===
        array(
            'id'       => 'asset_section',
            'type'     => 'section',
            'title'    => __('Asset Optimization', 'gusviradigital'),
            'subtitle' => __('Pengaturan optimasi asset', 'gusviradigital'),
            'indent'   => true
        ),
        array(
            'id'       => 'minify_css',
            'type'     => 'switch',
            'title'    => __('Minify CSS', 'gusviradigital'),
            'subtitle' => __('Kompres file CSS', 'gusviradigital'),
            'default'  => false
        ),
        array(
            'id'       => 'minify_js',
            'type'     => 'switch',
            'title'    => __('Minify JS', 'gusviradigital'),
            'subtitle' => __('Kompres file JavaScript', 'gusviradigital'),
            'default'  => false
        ),
        array(
            'id'       => 'combine_css',
            'type'     => 'switch',
            'title'    => __('Combine CSS', 'gusviradigital'),
            'subtitle' => __('Gabungkan semua file CSS', 'gusviradigital'),
            'default'  => false,
            
        ),
        array(
            'id'       => 'combine_js',
            'type'     => 'switch',
            'title'    => __('Combine JS', 'gusviradigital'),
            'subtitle' => __('Gabungkan semua file JavaScript', 'gusviradigital'),
            'default'  => false,
            
        ),
        array(
            'id'       => 'exclude_css',
            'type'     => 'textarea',
            'title'    => __('Exclude CSS Files', 'gusviradigital'),
            'subtitle' => __('Masukkan handle CSS yang tidak ingin dioptimasi (satu per baris)', 'gusviradigital'),
            'default'  => "admin-bar\nwp-block-library",
            
        ),
        array(
            'id'       => 'exclude_js',
            'type'     => 'textarea',
            'title'    => __('Exclude JavaScript Files', 'gusviradigital'),
            'subtitle' => __('Masukkan handle JS yang tidak ingin dioptimasi (satu per baris)', 'gusviradigital'),
            'default'  => "jquery-core\njquery-migrate\nwp-embed",
            
        ),
        array(
            'id'       => 'minify_html',
            'type'     => 'switch',
            'title'    => __('Minify HTML', 'gusviradigital'),
            'subtitle' => __('Kompres kode HTML', 'gusviradigital'),
            'default'  => false
        ),
        array(
            'id'       => 'defer_js',
            'type'     => 'switch',
            'title'    => __('Defer JavaScript', 'gusviradigital'),
            'subtitle' => __('Tunda loading JavaScript', 'gusviradigital'),
            'default'  => false
        ),
        array(
            'id'       => 'cache_assets',
            'type'     => 'switch',
            'title'    => __('Cache Assets', 'gusviradigital'),
            'subtitle' => __('Simpan hasil optimasi dalam cache', 'gusviradigital'),
            'default'  => false,
        ),

        // === IMAGE OPTIMIZATION ===
        array(
            'id'       => 'image_section',
            'type'     => 'section',
            'title'    => __('Image Optimization', 'gusviradigital'),
            'subtitle' => __('Pengaturan optimasi gambar', 'gusviradigital'),
            'indent'   => true
        ),
        array(
            'id'       => 'enable_lazyload',
            'type'     => 'switch',
            'title'    => __('Enable Lazy Loading', 'gusviradigital'),
            'subtitle' => __('Aktifkan lazy loading untuk gambar', 'gusviradigital'),
            'default'  => true
        ),
        array(
            'id'       => 'image_optimization',
            'type'     => 'switch',
            'title'    => __('Auto Image Optimization', 'gusviradigital'),
            'subtitle' => __('Optimasi otomatis saat upload gambar', 'gusviradigital'),
            'default'  => true
        ),
        array(
            'id'       => 'image_quality',
            'type'     => 'slider',
            'title'    => __('Image Quality', 'gusviradigital'),
            'subtitle' => __('Kualitas kompresi gambar (1-100)', 'gusviradigital'),
            'default'  => 82,
            'min'      => 1,
            'max'      => 100,
            'step'     => 1,
            'required' => array('image_optimization', '=', true)
        ),
        array(
            'id'       => 'max_image_width',
            'type'     => 'slider',
            'title'    => __('Max Image Width', 'gusviradigital'),
            'subtitle' => __('Lebar maksimum gambar (pixel)', 'gusviradigital'),
            'default'  => 1920,
            'min'      => 800,
            'max'      => 3840,
            'step'     => 10,
            'required' => array('image_optimization', '=', true)
        ),
        array(
            'id'       => 'webp_support',
            'type'     => 'switch',
            'title'    => __('WebP Conversion', 'gusviradigital'),
            'subtitle' => __('Konversi gambar ke format WebP', 'gusviradigital'),
            'default'  => true
        ),
        array(
            'id'       => 'webp_quality',
            'type'     => 'slider',
            'title'    => __('WebP Quality', 'gusviradigital'),
            'subtitle' => __('Kualitas konversi WebP (1-100)', 'gusviradigital'),
            'default'  => 80,
            'min'      => 1,
            'max'      => 100,
            'step'     => 1,
            'required' => array('webp_support', '=', true)
        ),

        
    )
));