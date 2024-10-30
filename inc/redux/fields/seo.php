<?php
Redux::setSection($opt_name, array(
    'title'      => 'SEO Settings',
    'id'         => 'seo_settings',
    'icon'       => 'el el-search',
    'desc'       => __('Pengaturan Search Engine Optimization', 'gusviradigital'),
    'fields'     => array(

        // 1. General SEO Settings
        array(
            'id'       => 'enable_seo',
            'type'     => 'switch',
            'title'    => __('Enable SEO Features', 'gusviradigital'),
            'subtitle' => __('Aktifkan fitur SEO', 'gusviradigital'),
            'default'  => true
        ),

        array(
            'id'       => 'seo_separator',
            'type'     => 'select',
            'title'    => __('Title Separator', 'gusviradigital'),
            'subtitle' => __('Pemisah judul halaman', 'gusviradigital'),
            'options'  => array(
                '|' => '|',
                '-' => '-',
                '·' => '·',
                '/' => '/',
                '»' => '»',
                '«' => '«'
            ),
            'default'  => '|'
        ),

        // 2. Homepage SEO
        array(
            'id'       => 'homepage_seo',
            'type'     => 'section',
            'title'    => __('Homepage SEO', 'gusviradigital'),
            'subtitle' => __('Pengaturan SEO halaman utama', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'homepage_title',
            'type'     => 'text',
            'title'    => __('Homepage Title', 'gusviradigital'),
            'subtitle' => __('Title tag halaman utama', 'gusviradigital'),
            'default'  => get_bloginfo('name')
        ),

        array(
            'id'       => 'homepage_meta_description',
            'type'     => 'textarea',
            'title'    => __('Homepage Meta Description', 'gusviradigital'),
            'subtitle' => __('Deskripsi meta halaman utama', 'gusviradigital'),
            'validate' => 'no_html',
            'default'  => get_bloginfo('description')
        ),

        // 3. Social Media SEO
        array(
            'id'       => 'social_seo',
            'type'     => 'section',
            'title'    => __('Social Media SEO', 'gusviradigital'),
            'subtitle' => __('Pengaturan SEO social media', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'og_tags',
            'type'     => 'switch',
            'title'    => __('Open Graph Tags', 'gusviradigital'),
            'subtitle' => __('Aktifkan Open Graph tags', 'gusviradigital'),
            'default'  => true
        ),

        array(
            'id'       => 'twitter_cards',
            'type'     => 'switch',
            'title'    => __('Twitter Cards', 'gusviradigital'),
            'subtitle' => __('Aktifkan Twitter cards', 'gusviradigital'),
            'default'  => true
        ),

        // 4. Schema Markup
        array(
            'id'       => 'schema_settings',
            'type'     => 'section',
            'title'    => __('Schema Markup', 'gusviradigital'),
            'subtitle' => __('Pengaturan Schema.org markup', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'enable_schema',
            'type'     => 'switch',
            'title'    => __('Enable Schema Markup', 'gusviradigital'),
            'subtitle' => __('Aktifkan Schema.org markup', 'gusviradigital'),
            'default'  => true
        ),

        array(
            'id'       => 'organization_type',
            'type'     => 'select',
            'title'    => __('Organization Type', 'gusviradigital'),
            'subtitle' => __('Tipe organisasi untuk Schema', 'gusviradigital'),
            'options'  => array(
                'Organization' => 'Organization',
                'Corporation' => 'Corporation',
                'LocalBusiness' => 'Local Business'
            ),
            'default'  => 'Organization'
        ),

        // 5. Robots.txt Settings
        array(
            'id'       => 'robots_settings',
            'type'     => 'section',
            'title'    => __('Robots.txt Settings', 'gusviradigital'),
            'subtitle' => __('Pengaturan file robots.txt', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'custom_robots',
            'type'     => 'switch',
            'title'    => __('Custom Robots.txt', 'gusviradigital'),
            'subtitle' => __('Gunakan robots.txt kustom', 'gusviradigital'),
            'default'  => false
        ),

        array(
            'id'       => 'robots_content',
            'type'     => 'ace_editor',
            'title'    => __('Robots.txt Content', 'gusviradigital'),
            'subtitle' => __('Isi file robots.txt', 'gusviradigital'),
            'mode'     => 'text',
            'theme'    => 'monokai',
            'default'  => "User-agent: *\nDisallow: /wp-admin/\nAllow: /wp-admin/admin-ajax.php"
        ),

        // 6. Sitemap Settings
        array(
            'id'       => 'sitemap_settings',
            'type'     => 'section',
            'title'    => __('XML Sitemap', 'gusviradigital'),
            'subtitle' => __('Pengaturan XML Sitemap', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'enable_sitemap',
            'type'     => 'switch',
            'title'    => __('Enable XML Sitemap', 'gusviradigital'),
            'subtitle' => __('Aktifkan XML Sitemap', 'gusviradigital'),
            'default'  => true
        ),

        array(
            'id'       => 'sitemap_priority',
            'type'     => 'select',
            'title'    => __('Post Priority', 'gusviradigital'),
            'subtitle' => __('Prioritas posting di sitemap', 'gusviradigital'),
            'options'  => array(
                '0.1' => '0.1',
                '0.3' => '0.3',
                '0.5' => '0.5',
                '0.7' => '0.7',
                '0.9' => '0.9'
            ),
            'default'  => '0.5'
        ),

        // 7. Advanced Settings
        array(
            'id'       => 'advanced_seo',
            'type'     => 'section',
            'title'    => __('Advanced SEO', 'gusviradigital'),
            'subtitle' => __('Pengaturan SEO lanjutan', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'noindex_archives',
            'type'     => 'switch',
            'title'    => __('NoIndex Archives', 'gusviradigital'),
            'subtitle' => __('Tambahkan noindex pada halaman arsip', 'gusviradigital'),
            'default'  => false
        ),

        array(
            'id'       => 'noindex_author',
            'type'     => 'switch',
            'title'    => __('NoIndex Author Pages', 'gusviradigital'),
            'subtitle' => __('Tambahkan noindex pada halaman penulis', 'gusviradigital'),
            'default'  => false
        ),

        // 8. Canonical URL Settings
        array(
            'id'       => 'canonical_settings',
            'type'     => 'section',
            'title'    => __('Canonical URLs', 'gusviradigital'),
            'subtitle' => __('Pengaturan URL kanonik', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'enable_canonical',
            'type'     => 'switch',
            'title'    => __('Enable Canonical URLs', 'gusviradigital'),
            'subtitle' => __('Aktifkan URL kanonik otomatis', 'gusviradigital'),
            'default'  => true
        ),

        array(
            'id'       => 'canonical_https',
            'type'     => 'switch',
            'title'    => __('Force HTTPS Canonical', 'gusviradigital'),
            'subtitle' => __('Paksa URL kanonik menggunakan HTTPS', 'gusviradigital'),
            'default'  => true
        ),

        // 9. Breadcrumb Settings
        array(
            'id'       => 'breadcrumb_settings',
            'type'     => 'section',
            'title'    => __('Breadcrumbs', 'gusviradigital'),
            'subtitle' => __('Pengaturan breadcrumb navigation', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'enable_breadcrumbs',
            'type'     => 'switch',
            'title'    => __('Enable Breadcrumbs', 'gusviradigital'),
            'subtitle' => __('Aktifkan navigasi breadcrumb', 'gusviradigital'),
            'default'  => true
        ),

        array(
            'id'       => 'breadcrumb_separator',
            'type'     => 'text',
            'title'    => __('Breadcrumb Separator', 'gusviradigital'),
            'subtitle' => __('Karakter pemisah breadcrumb', 'gusviradigital'),
            'default'  => '›'
        ),

        // 10. Knowledge Graph Settings
        array(
            'id'       => 'knowledge_graph',
            'type'     => 'section',
            'title'    => __('Knowledge Graph', 'gusviradigital'),
            'subtitle' => __('Pengaturan Google Knowledge Graph', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'company_name',
            'type'     => 'text',
            'title'    => __('Company Name', 'gusviradigital'),
            'subtitle' => __('Nama perusahaan untuk Knowledge Graph', 'gusviradigital'),
            'default'  => get_bloginfo('name')
        ),

        array(
            'id'       => 'company_logo',
            'type'     => 'media',
            'title'    => __('Company Logo', 'gusviradigital'),
            'subtitle' => __('Logo perusahaan untuk Knowledge Graph', 'gusviradigital'),
        ),

        // 11. Analytics Integration
        array(
            'id'       => 'analytics_settings',
            'type'     => 'section',
            'title'    => __('Analytics Integration', 'gusviradigital'),
            'subtitle' => __('Pengaturan integrasi analytics', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'google_analytics_id',
            'type'     => 'text',
            'title'    => __('Google Analytics ID', 'gusviradigital'),
            'subtitle' => __('ID Google Analytics (GA4)', 'gusviradigital'),
            'placeholder' => 'G-XXXXXXXXXX'
        ),

        array(
            'id'       => 'google_search_console',
            'type'     => 'text',
            'title'    => __('Google Search Console', 'gusviradigital'),
            'subtitle' => __('Meta tag verifikasi Search Console', 'gusviradigital'),
        ),

        // 12. Performance Settings
        array(
            'id'       => 'seo_performance',
            'type'     => 'section',
            'title'    => __('SEO Performance', 'gusviradigital'),
            'subtitle' => __('Pengaturan performa SEO', 'gusviradigital'),
            'indent'   => true
        ),

        // 13. Local SEO
        array(
            'id'       => 'local_seo',
            'type'     => 'section',
            'title'    => __('Local SEO', 'gusviradigital'),
            'subtitle' => __('Pengaturan SEO lokal', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'business_address',
            'type'     => 'textarea',
            'title'    => __('Business Address', 'gusviradigital'),
            'subtitle' => __('Alamat bisnis lengkap', 'gusviradigital'),
        ),

        array(
            'id'       => 'business_phone',
            'type'     => 'text',
            'title'    => __('Business Phone', 'gusviradigital'),
            'subtitle' => __('Nomor telepon bisnis', 'gusviradigital'),
        ),

        array(
            'id'       => 'business_hours',
            'type'     => 'textarea',
            'title'    => __('Business Hours', 'gusviradigital'),
            'subtitle' => __('Jam operasional bisnis', 'gusviradigital'),
        )
    )
));

// SEO Advanced Settings Section
Redux::setSection($opt_name, array(
    'title' => __('Advanced SEO Settings', 'gdp-seo'),
    'id' => 'advanced_seo',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'enable_meta_robots',
            'type' => 'switch',
            'title' => __('Enable Meta Robots', 'gdp-seo'),
            'default' => true,
        ),
        array(
            'id' => 'noindex_search',
            'type' => 'switch',
            'title' => __('NoIndex Search Results', 'gdp-seo'),
            'default' => true,
            'required' => array('enable_meta_robots', '=', true),
        ),
        array(
            'id' => 'noindex_archive',
            'type' => 'switch',
            'title' => __('NoIndex Archive Pages', 'gdp-seo'),
            'default' => true,
            'required' => array('enable_meta_robots', '=', true),
        ),
    )
));

// Focus Keyword Settings
Redux::setSection($opt_name, array(
    'title' => __('Focus Keyword Settings', 'gdp-seo'),
    'id' => 'focus_keyword',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'enable_focus_keyword',
            'type' => 'switch',
            'title' => __('Enable Focus Keyword Analysis', 'gdp-seo'),
            'default' => true,
        ),
        array(
            'id' => 'keyword_density_target',
            'type' => 'slider',
            'title' => __('Keyword Density Target (%)', 'gdp-seo'),
            'default' => 2,
            'min' => 0,
            'max' => 5,
            'step' => 0.1,
            'required' => array('enable_focus_keyword', '=', true),
        ),
        array(
            'id' => 'minimum_word_count',
            'type' => 'spinner',
            'title' => __('Minimum Word Count', 'gdp-seo'),
            'default' => 300,
            'min' => 100,
            'max' => 1000,
            'step' => 50,
            'required' => array('enable_focus_keyword', '=', true),
        ),
    )
));

// Social Preview Settings
Redux::setSection($opt_name, array(
    'title' => __('Social Preview Settings', 'gdp-seo'),
    'id' => 'social_preview',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'enable_social_preview',
            'type' => 'switch',
            'title' => __('Enable Social Preview', 'gdp-seo'),
            'default' => true,
        ),
        array(
            'id' => 'default_facebook_image',
            'type' => 'media',
            'title' => __('Default Facebook Image', 'gdp-seo'),
            'subtitle' => __('Default image for Facebook sharing (min. 1200x630px)', 'gdp-seo'),
            'required' => array('enable_social_preview', '=', true),
        ),
        array(
            'id' => 'default_twitter_image',
            'type' => 'media',
            'title' => __('Default Twitter Image', 'gdp-seo'),
            'subtitle' => __('Default image for Twitter sharing (min. 1024x512px)', 'gdp-seo'),
            'required' => array('enable_social_preview', '=', true),
        ),
    )
));

// Schema Settings
Redux::setSection($opt_name, array(
    'title' => __('Schema Settings', 'gdp-seo'),
    'id' => 'schema_settings',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'enable_breadcrumbs_schema',
            'type' => 'switch',
            'title' => __('Enable Breadcrumbs Schema', 'gdp-seo'),
            'default' => true,
        ),
        array(
            'id' => 'organization_type',
            'type' => 'select',
            'title' => __('Organization Type', 'gdp-seo'),
            'options' => array(
                'Organization' => __('Organization', 'gdp-seo'),
                'LocalBusiness' => __('Local Business', 'gdp-seo'),
                'Corporation' => __('Corporation', 'gdp-seo'),
                'NewsMediaOrganization' => __('News Media Organization', 'gdp-seo'),
            ),
            'default' => 'Organization',
        ),
        array(
            'id' => 'company_name',
            'type' => 'text',
            'title' => __('Company Name', 'gdp-seo'),
            'default' => get_bloginfo('name'),
        ),
        array(
            'id' => 'company_logo',
            'type' => 'media',
            'title' => __('Company Logo', 'gdp-seo'),
            'subtitle' => __('Logo for Schema markup (min. 112x112px)', 'gdp-seo'),
        ),
    )
));

// RSS Feed Settings
Redux::setSection($opt_name, array(
    'title' => __('RSS Feed Settings', 'gdp-seo'),
    'id' => 'rss_settings',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'optimize_rss',
            'type' => 'switch',
            'title' => __('Optimize RSS Feed', 'gdp-seo'),
            'default' => true,
        ),
        array(
            'id' => 'rss_copyright_text',
            'type' => 'editor',
            'title' => __('RSS Copyright Text', 'gdp-seo'),
            'default' => sprintf(
                __('Copyright © %s %s. All rights reserved.', 'gdp-seo'),
                date('Y'),
                get_bloginfo('name')
            ),
            'required' => array('optimize_rss', '=', true),
        ),
        array(
            'id' => 'add_featured_image_to_rss',
            'type' => 'switch',
            'title' => __('Add Featured Image to RSS', 'gdp-seo'),
            'default' => true,
            'required' => array('optimize_rss', '=', true),
        ),
    )
));

// Internal Linking Settings
Redux::setSection($opt_name, array(
    'title' => __('Internal Linking', 'gdp-seo'),
    'id' => 'internal_linking',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'enable_internal_linking',
            'type' => 'switch',
            'title' => __('Enable Internal Linking Suggestions', 'gdp-seo'),
            'default' => true,
        ),
        array(
            'id' => 'max_suggestions',
            'type' => 'spinner',
            'title' => __('Maximum Suggestions', 'gdp-seo'),
            'default' => 5,
            'min' => 1,
            'max' => 10,
            'required' => array('enable_internal _linking', '=', true),
        ),
    )
));