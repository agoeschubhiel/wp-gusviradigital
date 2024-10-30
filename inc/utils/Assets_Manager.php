<?php
// inc/utils/Assets_Manager.php

class GDP_Assets_Manager {
    private static $instance = null;
    private $styles = [];
    private $scripts = [];
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function register_style($handle, $src, $deps = [], $ver = false, $media = 'all') {
        $this->styles[$handle] = [
            'src' => $src,
            'deps' => $deps,
            'ver' => $ver ?: GDP_VERSION,
            'media' => $media
        ];
        
        wp_register_style($handle, $src, $deps, $ver, $media);
    }
    
    public function register_script($handle, $src, $deps = [], $ver = false, $in_footer = true) {
        $this->scripts[$handle] = [
            'src' => $src,
            'deps' => $deps,
            'ver' => $ver ?: GDP_VERSION,
            'in_footer' => $in_footer
        ];
        
        wp_register_script($handle, $src, $deps, $ver, $in_footer);
    }
    
    public function enqueue_registered_assets() {
        foreach ($this->styles as $handle => $style) {
            wp_enqueue_style($handle);
        }
        
        foreach ($this->scripts as $handle => $script) {
            wp_enqueue_script($handle);
        }
    }
}