<?php
Redux::setSection($opt_name, array(
    'title'      => 'Security Settings',
    'id'         => 'security_settings',
    'icon'       => 'el el-lock',
    'desc'       => __('Pengaturan keamanan website', 'gusviradigital'),
    'fields'     => array(
        // SSL Security
        array(
            'id'       => 'force_ssl',
            'type'     => 'switch',
            'title'    => 'Force SSL/HTTPS',
            'subtitle' => 'Paksa website menggunakan HTTPS',
            'default'  => true
        ),

        // Login Security
        array(
            'id'       => 'limit_login_attempts',
            'type'     => 'spinner',
            'title'    => 'Login Attempt Limit',
            'subtitle' => 'Jumlah maksimal percobaan login',
            'default'  => 3,
            'min'      => 1,
            'max'      => 10
        ),
        array(
            'id'       => 'lockout_duration',
            'type'     => 'spinner',
            'title'    => 'Lockout Duration (minutes)',
            'subtitle' => 'Durasi penguncian setelah melewati batas percobaan',
            'default'  => 30,
            'min'      => 5,
            'max'      => 1440
        ),

        // File Security
        array(
            'id'       => 'secure_file_permissions',
            'type'     => 'switch',
            'title'    => 'Secure File Permissions',
            'subtitle' => 'Atur permission file secara aman',
            'default'  => true
        ),
        array(
            'id'       => 'disable_xmlrpc',
            'type'     => 'switch',
            'title'    => 'Disable XML-RPC',
            'subtitle' => 'Nonaktifkan XML-RPC untuk keamanan',
            'default'  => true
        ),

        // File Upload Security
        array(
            'id'       => 'allowed_file_types',
            'type'     => 'select',
            'title'    => 'Allowed File Types',
            'subtitle' => 'Pilih tipe file yang diizinkan',
            'multi'    => true,
            'options'  => array(
                'image' => 'Images',
                'document' => 'Documents',
                'audio' => 'Audio',
                'video' => 'Video'
            ),
            'default'  => array('document')
        ),
        array(
            'id'       => 'max_upload_size',
            'type'     => 'spinner',
            'title'    => 'Max Upload Size (MB)',
            'subtitle' => 'Ukuran maksimal file upload',
            'default'  => 5,
            'min'      => 1,
            'max'      => 100
        ),

        // Header Security
        array(
            'id'       => 'enable_security_headers',
            'type'     => 'switch',
            'title'    => 'Enable Security Headers',
            'subtitle' => 'Aktifkan header keamanan',
            'default'  => true
        ),
        array(
            'id'       => 'content_security_policy',
            'type'     => 'textarea',
            'title'    => 'Content Security Policy',
            'subtitle' => 'Atur Content Security Policy header'
        ),
        array(
            'id'       => 'blocked_headers',
            'type'     => 'multi_text',
            'title'    => 'Blocked Headers',
            'subtitle' => 'Header yang akan diblokir'
        ),

        // Database Security
        array(
            'id'       => 'enable_db_security',
            'type'     => 'switch',
            'title'    => 'Enable Database Security',
            'subtitle' => 'Aktifkan keamanan database',
            'default'  => true
        ),
        array(
            'id'       => 'disable_db_error_reporting',
            'type'     => 'switch',
            'title'    => 'Disable DB Error Reporting',
            'subtitle' => 'Nonaktifkan pelaporan error database',
            'default'  => true
        ),
        array(
            'id'       => 'check_table_prefix',
            'type'     => 'switch',
            'title'    => 'Check Table Prefix',
            'subtitle' => 'Periksa prefix tabel database',
            'default'  => true
        ),
        array(
            'id'       => 'prevent_default_prefix',
            'type'     => 'switch',
            'title'    => 'Prevent Default Prefix',
            'subtitle' => 'Cegah penggunaan prefix default wp_',
            'default'  => true
        ),
        array(
            'id'       => 'optimize_database',
            'type'     => 'switch',
            'title'    => 'Optimize Database',
            'subtitle' => 'Aktifkan optimasi database otomatis',
            'default'  => true
        ),
        array(
            'id'       => 'db_optimization_interval',
            'type'     => 'select',
            'title'    => 'Database Optimization Interval',
            'options'  => array(
                'daily' => 'Daily',
                'weekly' => 'Weekly'
            ),
            'default'  => 'weekly'
        ),

        // Security Logging
        array(
            'id'       => 'security_logging',
            'type'     => 'switch',
            'title'    => 'Enable Security Logging',
            'subtitle' => 'Aktifkan pencatatan keamanan',
            'default'  => true
        ),
        array(
            'id'       => 'log_retention',
            'type'     => 'spinner',
            'title'    => 'Log Retention (days)',
            'subtitle' => 'Lama penyimpanan log',
            'default'  => 30,
            'min'      => 1,
            'max'      => 365
        ),

        // Two Factor Authentication
        array(
            'id'       => 'enable_2fa',
            'type'     => 'switch',
            'title'    => 'Enable Two-Factor Authentication',
            'subtitle' => 'Aktifkan autentikasi dua faktor',
            'default'  => true
        ),
        array(
            'id'       => '2fa_method',
            'type'     => 'select',
            'title'    => '2FA Method',
            'options'  => array(
                'email' => 'Email',
                'app'   => 'Authenticator App',
                'sms'   => 'SMS'
            ),
            'default'  => 'email'
        ),
        array(
            'id'       => 'twilio_sid',
            'type'     => 'text',
            'title'    => 'Twilio SID',
            'subtitle' => 'SID untuk SMS authentication',
            'required' => array('2fa_method', 'equals', 'sms')
        ),
        array(
            'id'       => 'twilio_token',
            'type'     => 'text',
            'title'    => 'Twilio Token',
            'subtitle' => 'Token untuk SMS authentication',
            'required' => array('2fa_method', 'equals', 'sms')
        ),
        array(
            'id'       => 'twilio_number',
            'type'     => 'text',
            'title'    => 'Twilio Number',
            'subtitle' => 'Nomor Twilio untuk SMS',
            'required' => array ('2fa_method', 'equals', 'sms')
        ),

        // Anti-Spam
        array(
            'id'       => 'enable_anti_spam',
            'type'     => 'switch',
            'title'    => 'Enable Anti-Spam',
            'subtitle' => 'Aktifkan fitur anti-spam',
            'default'  => true
        ),
        array(
            'id'       => 'spam_keywords',
            'type'     => 'multi_text',
            'title'    => 'Spam Keywords',
            'subtitle' => 'Daftar kata kunci spam'
        ),
        array(
            'id'       => 'blacklist_ips',
            'type'     => 'multi_text',
            'title'    => 'Blacklisted IPs',
            'subtitle' => 'Daftar IP yang diblokir'
        ),
        array(
            'id'       => 'email_domain_blacklist',
            'type'     => 'multi_text',
            'title'    => 'Email Domain Blacklist',
            'subtitle' => 'Daftar domain email yang diblokir'
        ),
        array(
            'id'       => 'min_comment_length',
            'type'     => 'spinner',
            'title'    => 'Min Comment Length',
            'subtitle' => 'Panjang minimal komentar',
            'default'  => 10,
            'min'      => 1,
            'max'      => 100
        ),
        array(
            'id'       => 'max_comment_links',
            'type'     => 'spinner',
            'title'    => 'Max Comment Links',
            'subtitle' => 'Jumlah maksimal link di komentar',
            'default'  => 2,
            'min'      => 1,
            'max'      => 10
        ),

        // Firewall Settings
        array(
            'id'       => 'enable_firewall',
            'type'     => 'switch',
            'title'    => 'Enable Firewall',
            'subtitle' => 'Aktifkan firewall keamanan',
            'default'  => true
        ),
        array(
            'id'       => 'block_suspicious_queries',
            'type'     => 'switch',
            'title'    => 'Block Suspicious Queries',
            'default'  => true
        ),
        array(
            'id'       => 'country_blocking',
            'type'     => 'select',
            'title'    => 'Block Countries',
            'multi'    => true,
            'options'  => array(
                // Daftar negara
            )
        ),
        array(
            'id'       => 'allowed_methods',
            'type'     => 'select',
            'title'    => 'Allowed Methods',
            'multi'    => true,
            'options'  => array(
                'GET' => 'GET',
                'POST' => 'POST',
                'PUT' => 'PUT',
                'DELETE' => 'DELETE'
            ),
            'default'  => array('GET', 'POST')
        ),

        // Backup Settings
        array(
            'id'       => 'encrypt_backups',
            'type'     => 'switch',
            'title'    => 'Encrypt Backups',
            'subtitle' => 'Enkripsi file backup',
            'default'  => true
        ),
        array(
            'id'       => 'backup_directory',
            'type'     => 'text',
            'title'    => 'Backup Directory',
            'subtitle' => 'Lokasi penyimpanan backup'
        ),
        array(
            'id'       => 'enable_auto_backup',
            'type'     => 'switch',
            'title'    => 'Enable Auto Backup',
            'subtitle' => 'Aktifkan backup otomatis',
            'default'  => true
        ),

        // Emergency Contact
        array(
            'id'       => 'security_email',
            'type'     => 'text',
            'title'    => 'Security Email',
            'subtitle' => 'Email untuk notifikasi keamanan',
            'validate' => 'email'
        )
    )
));