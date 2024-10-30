<?php
Redux::setSection($opt_name, array(
    'title'      => 'Translations Settings',
    'id'         => 'translations_settings',
    'icon'       => 'el el-globe',
    'desc'       => __('Pengaturan terjemahan dan multi-bahasa website', 'gusviradigital'),
    'fields'     => array(

        // 1. Basic Language Settings
        array(
            'id'       => 'default_language',
            'type'     => 'select',
            'title'    => __('Default Language', 'gusviradigital'),
            'subtitle' => __('Pilih bahasa default website', 'gusviradigital'),
            'options'  => array(
                'en' => 'English',
                'id' => 'Indonesian',
                'es' => 'Spanish',
                'fr' => 'French',
                'de' => 'German'
            ),
            'default'  => 'en'
        ),

        array(
            'id'       => 'enabled_languages',
            'type'     => 'checkbox',
            'title'    => __('Enabled Languages', 'gusviradigital'),
            'subtitle' => __('Pilih bahasa yang tersedia', 'gusviradigital'),
            'options'  => array(
                'en' => 'English',
                'id' => 'Indonesian',
                'es' => 'Spanish',
                'fr' => 'French',
                'de' => 'German'
            ),
            'default'  => array('en' => '1', 'id' => '1')
        ),

        // 2. Language Switcher
        array(
            'id'       => 'language_switcher',
            'type'     => 'section',
            'title'    => __('Language Switcher', 'gusviradigital'),
            'subtitle' => __('Pengaturan tombol pilihan bahasa', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'show_language_switcher',
            'type'     => 'switch',
            'title'    => __('Show Language Switcher', 'gusviradigital'),
            'subtitle' => __('Tampilkan tombol pilihan bahasa', 'gusviradigital'),
            'default'  => true
        ),

        array(
            'id'       => 'switcher_style',
            'type'     => 'select',
            'title'    => __('Switcher Style', 'gusviradigital'),
            'options'  => array(
                'dropdown' => 'Dropdown',
                'inline'   => 'Inline',
                'flags'    => 'Flags with Text'
            ),
            'default'  => 'dropdown'
        ),

        // 3. URL Structure
        array(
            'id'       => 'url_structure',
            'type'     => 'section',
            'title'    => __('URL Structure', 'gusviradigital'),
            'subtitle' => __('Pengaturan struktur URL multi-bahasa', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'url_format',
            'type'     => 'select',
            'title'    => __('URL Format', 'gusviradigital'),
            'options'  => array(
                'prefix'    => 'Prefix (/en/page)',
                'subdomain' => 'Subdomain (en.site.com)',
                'parameter' => 'Parameter (?lang=en)'
            ),
            'default'  => 'prefix'
        ),

        // 4. Translation Management
        array(
            'id'       => 'translation_management',
            'type'     => 'section',
            'title'    => __('Translation Management', 'gusviradigital'),
            'subtitle' => __('Pengaturan manajemen terjemahan', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'auto_translate',
            'type'     => 'switch',
            'title'    => __('Auto Translation', 'gusviradigital'),
            'subtitle' => __('Terjemahan otomatis konten baru', 'gusviradigital'),
            'default'  => false
        ),

        array(
            'id'       => 'translation_service',
            'type'     => 'select',
            'title'    => __('Translation Service', 'gusviradigital'),
            'options'  => array(
                'google' => 'Google Translate',
                'deepl'  => 'DeepL',
                'manual' => 'Manual Translation'
            ),
            'default'  => 'manual'
        ),

        // 5. Content Synchronization
        array(
            'id'       => 'content_sync',
            'type'     => 'section',
            'title'    => __('Content Synchronization', 'gusviradigital'),
            'subtitle' => __('Sinkronisasi konten antar bahasa', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'sync_media',
            'type'     => 'switch',
            'title'    => __('Sync Media', 'gusviradigital'),
            'subtitle' => __('Sinkronkan media antar bahasa', 'gusviradigital'),
            'default'  => true
        ),

        array(
            'id'       => 'sync_categories',
            'type'     => 'switch',
            'title'    => __('Sync Categories', 'gusviradigital'),
            'subtitle' => __('Sinkronkan kategori antar bahasa', 'gusviradigital'),
            'default'  => true
        ),

        // 6. SEO Settings
        array(
            'id'       => 'translation_seo',
            'type'     => 'section',
            'title'    => __('Translation SEO', 'gusviradigital'),
            'subtitle' => __('Pengaturan SEO multi-bahasa', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'hreflang_tags',
            'type'     => 'switch',
            'title'    => __('Generate hreflang Tags', 'gusviradigital'),
            'subtitle' => __('Generate tag hreflang otomatis', 'gusviradigital'),
            'default'  => true
        ),

        // 7. Fallback Settings
        array(
            'id'       => 'fallback_settings',
            'type'     => 'section',
            'title'    => __('Fallback Settings', 'gusviradigital'),
            'subtitle' => __('Pengaturan fallback bahasa', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'fallback_language',
            'type'     => 'select',
            'title'    => __('Fallback Language', 'gusviradigital'),
            'subtitle' => __('Bahasa alternatif jika terjemahan tidak tersedia', 'gusviradigital'),
            'options'  => array(
                'en' => 'English',
                'id' => 'Indonesian'
            ),
            'default'  => 'en'
        ),

        // 8. Translation Memory
        array(
            'id'       => 'translation_memory',
            'type'     => 'section',
            'title'    => __('Translation Memory', 'gusviradigital'),
            'subtitle' => __('Pengaturan memori terjemahan', 'gusviradigital'),
            'indent'   => true
        ),
        array(
            'id'       => 'enable_translation_memory',
            'type'     => 'switch',
            'title'    => __('Enable Translation Memory', 'gusviradigital'),
            'subtitle' => __('Aktifkan fitur memori terjemahan', 'gusviradigital'),
            'default'  => true
        ),

        array(
            'id'       => 'tm_threshold',
            'type'     => 'slider',
            'title'    => __('Translation Memory Threshold', 'gusviradigital'),
            'subtitle' => __('Minimum kecocokan untuk saran terjemahan (%)', 'gusviradigital'),
            'min'      => 0,
            'max'      => 100,
            'default'  => 75
        ),

        // 9. Custom Translation Rules
        array(
            'id'       => 'custom_translation_rules',
            'type'     => 'section',
            'title'    => __('Custom Translation Rules', 'gusviradigital'),
            'subtitle' => __('Atur aturan khusus untuk terjemahan', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'exclude_translation',
            'type'     => 'textarea',
            'title'    => __('Exclude from Translation', 'gusviradigital'),
            'subtitle' => __('Masukkan kata atau frasa yang tidak perlu diterjemahkan (satu per baris)', 'gusviradigital'),
            'default'  => "Copyright\nTerms & Conditions"
        ),

        // 10. Translation API Settings
        array(
            'id'       => 'translation_api',
            'type'     => 'section',
            'title'    => __('Translation API Settings', 'gusviradigital'),
            'subtitle' => __('Pengaturan API untuk layanan terjemahan', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'google_translate_api_key',
            'type'     => 'text',
            'title'    => __('Google Translate API Key', 'gusviradigital'),
            'subtitle' => __('Masukkan API key Google Translate', 'gusviradigital'),
        ),

        array(
            'id'       => 'deepl_api_key',
            'type'     => 'text',
            'title'    => __('DeepL API Key', 'gusviradigital'),
            'subtitle' => __('Masukkan API key DeepL', 'gusviradigital'),
        ),

        // 11. Cache Settings
        array(
            'id'       => 'translation_cache',
            'type'     => 'section',
            'title'    => __('Translation Cache', 'gusviradigital'),
            'subtitle' => __('Pengaturan cache terjemahan', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'enable_cache_translation',
            'type'     => 'switch',
            'title'    => __('Enable Translation Cache', 'gusviradigital'),
            'subtitle' => __('Aktifkan penyimpanan cache terjemahan', 'gusviradigital'),
            'default'  => true
        ),

        array(
            'id'       => 'cache_lifetime_translation',
            'type'     => 'select',
            'title'    => __('Cache Lifetime', 'gusviradigital'),
            'subtitle' => __('Durasi penyimpanan cache', 'gusviradigital'),
            'options'  => array(
                '3600'    => '1 Hour',
                '86400'   => '1 Day',
                '604800'  => '1 Week',
                '2592000' => '1 Month'
            ),
            'default'  => '86400'
        ),

        // 12. Language Detection
        array(
            'id'       => 'language_detection',
            'type'     => 'section',
            'title'    => __('Language Detection', 'gusviradigital'),
            'subtitle' => __('Pengaturan deteksi bahasa otomatis', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'auto_detect_language',
            'type'     => 'switch',
            'title'    => __('Auto Detect Language', 'gusviradigital'),
            'subtitle' => __('Deteksi bahasa pengunjung secara otomatis', 'gusviradigital'),
            'default'  => true
        ),

        array(
            'id'       => 'detection_method',
            'type'     => 'select',
            'title'    => __('Detection Method', 'gusviradigital'),
            'subtitle' => __('Metode deteksi bahasa', 'gusviradigital'),
            'options'  => array(
                'browser' => 'Browser Language',
                'ip'      => 'IP Location',
                'cookie'  => 'Previous Selection (Cookie)',
                'all'     => 'All Methods'
            ),
            'default'  => 'all'
        )
    )
));