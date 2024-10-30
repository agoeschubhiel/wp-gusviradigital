<?php
class GDP_Maintenance {
    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        if ($this->is_maintenance_mode()) {
            add_action('template_redirect', array($this, 'show_maintenance_page'));
            add_action('admin_bar_menu', array($this, 'add_maintenance_admin_bar'), 100);
        }
    }

    /**
     * Check if maintenance mode is active
     */
    public function is_maintenance_mode() {
        if (!GDP_Theme_Support::gdp_option('maintenance_mode', false)) {
            return false;
        }

        // Allow access for whitelisted IPs
        if ($this->is_ip_whitelisted()) {
            return false;
        }

        // Allow access for specified user roles
        if ($this->is_user_allowed()) {
            return false;
        }

        return true;
    }

    /**
     * Check if current IP is whitelisted
     */
    private function is_ip_whitelisted() {
        $whitelist_ips = GDP_Theme_Support::gdp_option('whitelist_ips', array());
        
        if (empty($whitelist_ips)) {
            return false;
        }

        $client_ip = $_SERVER['REMOTE_ADDR'];
        return in_array($client_ip, $whitelist_ips);
    }

    /**
     * Check if current user role is allowed
     */
    private function is_user_allowed() {
        if (!is_user_logged_in()) {
            return false;
        }

        $user = wp_get_current_user();
        $allowed_roles = GDP_Theme_Support::gdp_option('bypass_roles', array('administrator'));

        return array_intersect($allowed_roles, $user->roles);
    }

    /**
     * Display maintenance page
     */
    public function show_maintenance_page() {
        if (!is_admin()) {
            $protocol = wp_get_server_protocol();
            header("$protocol 503 Service Unavailable", true, 503);
            header('Content-Type: text/html; charset=utf-8');
            header('Retry-After: 3600');

            // Send notification if enabled
            $this->send_notification();

            // Display maintenance template
            include_once(get_template_directory() . '/template-parts/maintenance.php');
            exit();
        }
    }

    /**
     * Add maintenance mode indicator to admin bar
     */
    public function add_maintenance_admin_bar($wp_admin_bar) {
        $wp_admin_bar->add_node(array(
            'id'    => 'maintenance-mode',
            'title' => __('Maintenance Mode Active', 'gusviradigital'),
            'href'  => admin_url('admin.php?page=theme-options'),
            'meta'  => array(
                'class' => 'maintenance-mode-indicator'
            )
        ));
    }

    /**
     * Send notification email
     */
    private function send_notification() {
        if (!GDP_Theme_Support::gdp_option('enable_notifications', false)) {
            return;
        }

        $notification_email = GDP_Theme_Support::gdp_option('notification_email', get_option('admin_email'));
        
        // Prevent multiple notifications
        $last_notification = get_transient('maintenance_notification');
        if ($last_notification) {
            return;
        }

        $subject = sprintf(__('[%s] Maintenance Mode Access Attempt', 'gusviradigital'), get_bloginfo('name'));
        $message = sprintf(
            __('Someone attempted to access %s while in maintenance mode.\n\nIP: %s\nUser Agent: %s\nTimestamp: %s', 'gusviradigital'),
            get_bloginfo('url'),
            $_SERVER['REMOTE_ADDR'],
            $_SERVER['HTTP_USER_AGENT'],
            current_time('mysql')
        );

        wp_mail($notification_email, $subject, $message);
        set_transient('maintenance_notification', true, HOUR_IN_SECONDS);
    }

    /**
     * Get maintenance settings
     */
    public static function get_settings($key = '') {
        if (empty($key)) {
            return false;
        }
        
        return GDP_Theme_Support::gdp_option($key, '');
    }

    /**
     * Get social media icon SVG
     */
    private function get_social_icon($platform) {
        $icons = array(
            'facebook' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
            </svg>',
            
            'twitter' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
            </svg>',
            
            'instagram' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
            </svg>',
            
            'linkedin' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd" />
            </svg>'
        );

        return isset($icons[$platform]) ? $icons[$platform] : '';
    }
}

// Initialize maintenance mode
add_action('init', array('GDP_Maintenance', 'get_instance'));