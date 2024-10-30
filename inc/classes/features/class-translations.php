<?php
class GDP_Translations {
    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('init', array($this, 'init_translations'));
        add_action('wp_head', array($this, 'add_hreflang_tags'));
        add_filter('locale', array($this, 'set_locale'));
        add_action('wp_footer', array($this, 'render_language_switcher'));
    }

    /**
     * Initialize translations
     */
    public function init_translations() {
        // Set default language
        $default_lang = GDP_Theme_Support::gdp_option('default_language', 'en');
        if (!defined('WPLANG')) {
            define('WPLANG', $default_lang);
        }

        // Initialize translation memory if enabled
        if (GDP_Theme_Support::gdp_option('enable_translation_memory', true)) {
            $this->init_translation_memory();
        }

        // Setup URL structure
        $this->setup_url_structure();

        // Initialize cache if enabled
        if (GDP_Theme_Support::gdp_option('enable_cache_translation', true)) {
            $this->init_cache();
        }
    }

    /**
     * Setup URL structure based on settings
     */
    private function setup_url_structure() {
        $url_format = GDP_Theme_Support::gdp_option('url_format', 'prefix');
        
        switch ($url_format) {
            case 'prefix':
                add_filter('home_url', array($this, 'modify_url_prefix'), 10, 2);
                break;
            case 'subdomain':
                add_filter('site_url', array($this, 'modify_url_subdomain'), 10, 2);
                break;
            case 'parameter':
                add_filter('query_vars', array($this, 'add_language_query_var'));
                break;
        }
    }

    /**
     * Initialize translation cache
     */
    private function init_cache() {
        $cache_lifetime = GDP_Theme_Support::gdp_option('cache_lifetime_translation', '86400');
        wp_cache_set_global_groups(array('gdp_translations'));
        
        // Clear expired cache
        $this->clear_expired_cache($cache_lifetime);
    }

    /**
     * Add hreflang tags if enabled
     */
    public function add_hreflang_tags() {
        if (!GDP_Theme_Support::gdp_option('hreflang_tags', true)) {
            return;
        }

        $enabled_languages = GDP_Theme_Support::gdp_option('enabled_languages', array('en' => '1'));
        foreach ($enabled_languages as $lang => $enabled) {
            if ($enabled) {
                $url = $this->get_translation_url($lang);
                echo sprintf('<link rel="alternate" hreflang="%s" href="%s" />', esc_attr($lang), esc_url($url));
            }
        }
    }

    /**
     * Render language switcher
     */
    public function render_language_switcher() {
        if (!GDP_Theme_Support::gdp_option('show_language_switcher', true)) {
            return;
        }

        $style = GDP_Theme_Support::gdp_option('switcher_style', 'dropdown');
        $enabled_languages = GDP_Theme_Support::gdp_option('enabled_languages', array('en' => '1'));
        $current_lang = $this->get_current_language();

        include(get_template_directory() . '/template-parts/language/language-switcher-' . $style . '.php');
    }

    /**
     * Get current language
     */
    public function get_current_language() {
        $auto_detect = GDP_Theme_Support::gdp_option('auto_detect_language', true);
        
        if ($auto_detect) {
            return $this->detect_language();
        }

        return GDP_Theme_Support::gdp_option('default_language', 'en');
    }

    /**
     * Detect user language
     */
    private function detect_language() {
        $method = GDP_Theme_Support::gdp_option('detection_method', 'all');
        $detected_lang = '';

        switch ($method) {
            case 'browser':
                $detected_lang = $this->detect_browser_language();
                break;
            case 'ip':
                $detected_lang = $this->detect_ip_language();
                break;
            case 'cookie':
                $detected_lang = $this->detect_cookie_language();
                break;
            case 'all':
                $detected_lang = $this->detect_cookie_language() 
                            || $this->detect_browser_language() 
                            || $this->detect_ip_language();
                break;
        }

        return $detected_lang ?: GDP_Theme_Support::gdp_option('default_language', 'en');
    }

    /**
     * Translate content
     */
    public function translate_content($content, $target_lang) {
        // Check translation memory first
        if (GDP_Theme_Support::gdp_option('enable_translation_memory', true)) {
            $cached_translation = $this->get_from_translation_memory($content, $target_lang);
            if ($cached_translation) {
                return $cached_translation;
            }
        }

        // Use translation service
        $service = GDP_Theme_Support::gdp_option('translation_service', 'manual');
        $translated_content = '';

        switch ($service) {
            case 'google':
                $translated_content = $this->translate_with_google($content, $target_lang);
                break;
            case 'deepl':
                $translated_content = $this->translate_with_deepl($content, $target_lang);
                break;
            default:
                $translated_content = $content; // Manual translation
        }

        // Store in translation memory
        if (GDP_Theme_Support::gdp_option('enable_translation_memory', true)) {
            $this->store_in_translation_memory($content, $translated_content, $target_lang);
        }

        return $translated_content;
    }

    /**
     * Get translation URL for language
     */
    private function get_translation_url($lang) {
        $url_format = GDP_Theme_Support::gdp_option('url_format', 'prefix');
        $current_url = home_url(add_query_arg(array()));

        switch ($url_format) {
            case 'prefix':
                return trailingslashit(home_url($lang)) . ltrim(parse_url($current_url, PHP_URL_PATH), '/');
            case 'subdomain':
                return str_replace(parse_url(home_url(), PHP_URL_HOST), $lang . '.' . parse_url(home_url(), PHP_URL_HOST), $current_url);
            case 'parameter':
                return add_query_arg('lang', $lang, $current_url);
            default:
                return $current_url;
        }
    }

    /**
     * Detect browser language
     */
    private function detect_browser_language() {
        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return false;
        }

        $browser_langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $enabled_languages = GDP_Theme_Support::gdp_option('enabled_languages', array('en' => '1'));
        
        foreach ($browser_langs as $browser_lang) {
            $lang_code = substr($browser_lang, 0, 2);
            if (isset($enabled_languages[$lang_code]) && $enabled_languages[$lang_code]) {
                return $lang_code;
            }
        }

        return false;
    }

    /**
     * Detect language from IP location
     */
    private function detect_ip_language() {
        $ip = $_SERVER['REMOTE_ADDR'];
        $api_url = "http://ip-api.com/json/{$ip}";
        
        $response = wp_remote_get($api_url);
        
        if (is_wp_error($response)) {
            return false;
        }

        $data = json_decode(wp_remote_retrieve_body($response), true);
        
        if (isset($data['countryCode'])) {
            $country_code = strtolower($data['countryCode']);
            $country_lang_map = $this->get_country_language_map();
            
            if (isset($country_lang_map[$country_code])) {
                $lang_code = $country_lang_map[$country_code];
                $enabled_languages = GDP_Theme_Support::gdp_option('enabled_languages', array('en' => '1'));
                
                if (isset($enabled_languages[$lang_code]) && $enabled_languages[$lang_code]) {
                    return $lang_code;
                }
            }
        }

        return false;
    }

    /**
     * Detect language from cookie
     */
    private function detect_cookie_language() {
        if (isset($_COOKIE['gdp_language'])) {
            $cookie_lang = sanitize_text_field($_COOKIE['gdp_language']);
            $enabled_languages = GDP_Theme_Support::gdp_option('enabled_languages', array('en' => '1'));
            
            if (isset($enabled_languages[$cookie_lang]) && $enabled_languages[$cookie_lang]) {
                return $cookie_lang;
            }
        }

        return false;
    }

    /**
     * Initialize translation memory
     */
    private function init_translation_memory() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'gdp_translation_memory';

        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $sql = "CREATE TABLE $table_name (
                id bigint(20) NOT NULL AUTO_INCREMENT,
                source_text text NOT NULL,
                translated_text text NOT NULL,
                language varchar(10) NOT NULL,
                created_at datetime DEFAULT CURRENT_TIMESTAMP,
                updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                hash varchar(32) NOT NULL,
                PRIMARY KEY  (id),
                KEY language (language),
                KEY hash (hash)
            ) $charset_collate;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }

    /**
     * Store translation in translation memory
     */
    private function store_in_translation_memory($source_text, $translated_text, $language) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'gdp_translation_memory';
        
        $hash = md5($source_text);
        
        $wpdb->replace(
            $table_name,
            array(
                'source_text' => $source_text,
                'translated_text' => $translated_text,
                'language' => $language,
                'hash' => $hash
            ),
            array('%s', '%s', '%s', '%s')
        );
    }

    /**
     * Get translation from translation memory
     */
    private function get_from_translation_memory($source_text, $language) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'gdp_translation_memory';
        
        $hash = md5($source_text);
        $threshold = GDP_Theme_Support::gdp_option('tm_threshold', 75);
        
        $result = $wpdb->get_var($wpdb->prepare(
            "SELECT translated_text FROM $table_name 
            WHERE hash = %s AND language = %s",
            $hash,
            $language
        ));

        return $result;
    }

    /**
     * Translate with Google Translate API
     */
    private function translate_with_google($text, $target_lang) {
        $api_key = GDP_Theme_Support::gdp_option('google_translate_api_key');
        
        if (empty($api_key)) {
            return $text;
        }

        $url = 'https://translation.googleapis.com/language/translate/v2';
        $args = array(
            'body' => array(
                'q' => $text,
                'target' => $target_lang,
                'key' => $api_key
            )
        );

        $response = wp_remote_post($url, $args);

        if (is_wp_error($response)) {
            return $text;
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);

        if (isset($body['data']['translations'][0]['translatedText'])) {
            return $body['data']['translations'][0]['translatedText'];
        }

        return $text;
    }

    /**
     * Translate with DeepL API
     */
    private function translate_with_deepl($text, $target_lang) {
        $api_key = GDP_Theme_Support::gdp_option('deepl_api_key');
        
        if (empty($api_key)) {
            return $text;
        }

        $url = 'https://api-free.deepl.com/v2/translate';
        $args = array(
            'body' => array(
                'text' => $text,
                'target_lang' => strtoupper($target_lang),
                'auth_key' => $api_key
            )
        );

        $response = wp_remote_post($url, $args);

        if (is_wp_error($response)) {
            return $text;
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);

        if (isset($body['translations'][0]['text'])) {
            return $body['translations'][0]['text'];
        }

        return $text;
    }

    /**
     * Clear expired cache
     */
    private function clear_expired_cache($lifetime) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'gdp_translation_memory';
        
        $wpdb->query($wpdb->prepare(
            "DELETE FROM $table_name WHERE updated_at < DATE_SUB(NOW(), INTERVAL %d SECOND)",
            $lifetime
        ));
    }

    /**
     * Get country to language mapping
     */
    private function get_country_language_map() {
        return array(
            'us' => 'en', // United States
            'gb' => 'en', // United Kingdom
            'au' => 'en', // Australia
            'ca' => 'en', // Canada
            'id' => 'id', // Indonesia
            'es' => 'es', // Spain
            'mx' => 'es', // Mexico
            'fr' => 'fr', // France
            'de' => 'de', // Germany // Add more mappings as needed
        );
    }

    /**
     * Set the locale for translations
     *
     * @param string $locale Current locale
     * @return string Modified locale
     */
    public function set_locale($locale) {
        // Get current language
        $current_lang = $this->get_current_language();
        
        // Get enabled languages
        $enabled_languages = GDP_Theme_Support::gdp_option('enabled_languages', array('en' => '1'));
        
        // Check if current language is enabled
        if (isset($enabled_languages[$current_lang]) && $enabled_languages[$current_lang]) {
            // Map language codes to WordPress locales
            $locale_map = array(
                'en' => 'en_US',
                'id' => 'id_ID',
                'es' => 'es_ES',
                'fr' => 'fr_FR',
                'de' => 'de_DE'
                // Tambahkan mapping bahasa lainnya sesuai kebutuhan
            );
            
            // Return mapped locale if available
            if (isset($locale_map[$current_lang])) {
                return $locale_map[$current_lang];
            }
        }
        
        // Fallback to default language
        $fallback_lang = GDP_Theme_Support::gdp_option('fallback_language', 'en');
        $locale_map = array(
            'en' => 'en_US',
            'id' => 'id_ID'
        );
        
        return isset($locale_map[$fallback_lang]) ? $locale_map[$fallback_lang] : $locale;
    }

    /**
     * Get locale mapping
     *
     * @return array
     */
    private function get_locale_mapping() {
        return array(
            'en' => array(
                'locale' => 'en_US',
                'name' => 'English (US)',
                'native_name' => 'English'
            ),
            'id' => array(
                'locale' => 'id_ID',
                'name' => 'Indonesian',
                'native_name' => 'Bahasa Indonesia'
            ),
            'es' => array(
                'locale' => 'es_ES',
                'name' => 'Spanish',
                'native_name' => 'Español'
            ),
            'fr' => array(
                'locale' => 'fr_FR',
                'name' => 'French',
                'native_name' => 'Français'
            ),
            'de' => array(
                'locale' => 'de_DE',
                'name' => 'German',
                'native_name' => 'Deutsch'
            )
            // Tambahkan bahasa lain sesuai kebutuhan
        );
    }

    /**
     * Get language name
     *
     * @param string $lang_code Language code
     * @param bool $native Whether to return native name
     * @return string Language name
     */
    public function get_language_name($lang_code, $native = false) {
        $locale_mapping = $this->get_locale_mapping();
        
        if (isset($locale_mapping[$lang_code])) {
            return $native ? $locale_mapping[$lang_code]['native_name'] : $locale_mapping[$lang_code]['name'];
        }
        
        return $lang_code;
    }

    /**
     * Get current locale
     *
     * @return string Current locale
     */
    public function get_current_locale() {
        $current_lang = $this->get_current_language();
        $locale_mapping = $this->get_locale_mapping();
        
        if (isset($locale_mapping[$current_lang])) {
            return $locale_mapping[$current_lang]['locale'];
        }
        
        return 'en_US'; // Default fallback
    }

    // Additional helper methods would go here...
}

// Initialize translations
add_action('init', array('GDP_Translations', 'get_instance'));