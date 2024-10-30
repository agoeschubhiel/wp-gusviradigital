<?php
function gdp_dynamic_variables() {
    $container_width = GDP_Theme_Support::gdp_option('container_width');
    $logo_height = GDP_Theme_Support::gdp_option('logo_height');
    ?>
    <style>
        :root {
            --container-width: <?php echo $container_width; ?>px;
            --header-height: <?php echo $logo_height + 40; ?>px;
            --color-primary-dark: <?php echo adjustBrightness(GDP_Theme_Support::gdp_option('primary_color'), -20); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'gdp_dynamic_variables');

// Helper function untuk mengatur brightness warna
function adjustBrightness($hex, $steps) {
    // Hapus tanda # jika ada
    $hex = str_replace('#', '', $hex);

    // Convert hex ke RGB
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    // Sesuaikan brightness
    $r = max(0, min(255, $r + $steps));
    $g = max(0, min(255, $g + $steps));
    $b = max(0, min(255, $b + $steps));

    // Convert kembali ke hex
    $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
    $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
    $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

    return '#' . $r_hex . $g_hex . $b_hex;
}

function gdp_preloader() {
    if(GDP_Theme_Support::gdp_option('enable_preloader')): 
    ?>
    <div id="preloader" class="fixed inset-0 z-50 flex items-center justify-center bg-white dark:bg-gray-900">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-primary"></div>
    </div>
    <script>
        window.addEventListener('load', () => {
            const preloader = document.getElementById('preloader');
            preloader.style.opacity = '0';
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 300);
        });
    </script>
    <style>
        #preloader {
            transition: opacity 0.3s ease-out;
        }
    </style>
    <?php
    endif;
}
add_action('wp_body_open', 'gdp_preloader');

function gdp_header_scripts() {
    ?>
    <script>
        // Mobile Menu Toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if(mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('active');
                mobileMenuButton.setAttribute('aria-expanded', 
                    mobileMenuButton.getAttribute('aria-expanded') === 'true' ? 'false' : 'true'
                );
            });
        }

        // Sticky Header
        <?php if(GDP_Theme_Support::gdp_option('sticky_header')): ?>
        const header = document.querySelector('header');
        let lastScroll = 0;

        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;

            if(currentScroll <= 0) {
                header.classList.remove('scroll-up');
                return;
            }

            if(currentScroll > lastScroll && !header.classList.contains('scroll-down')) {
                // Scroll Down
                header.classList.remove('scroll-up');
                header.classList.add('scroll-down');
            } else if(currentScroll < lastScroll && header.classList.contains('scroll-down')) {
                // Scroll Up
                header.classList.remove('scroll-down');
                header.classList.add('scroll-up');
            }
            lastScroll = currentScroll;
        });
        <?php endif; ?>

        // Dark Mode Toggle
        const darkModeToggle = document.getElementById('dark-mode-toggle');
        if(darkModeToggle) {
            darkModeToggle.addEventListener('click', () => {
                document.documentElement.classList.toggle('dark');
                localStorage.setItem('darkMode', 
                    document.documentElement.classList.contains('dark') ? 'dark' : 'light'
                );
            });
        }
    </script>
    <?php
}
add_action('wp_footer', 'gdp_header_scripts');

function gdp_header_dropdown_styles() {
    ?>
    <style>
        /* Dropdown Styles */
        .has-dropdown .sub-menu {
            @apply invisible opacity-0 absolute top-full left-0 min-w-[200px] bg-white dark:bg-gray-800 shadow-lg rounded-lg 
            transition-all duration-200 transform translate-y-2 z-50;
        }

        .has-dropdown:hover .sub-menu {
            @apply visible opacity-100 translate-y-0;
        }

        .has-dropdown .sub-menu li {
            @apply block w-full;
        }

        .has-dropdown .sub-menu a {
            @apply block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 
            whitespace-nowrap transition-colors;
        }

        /* Mobile Menu Animation */
        #mobile-menu {
            transition: max-height 0.3s ease-out;
            max-height: 0;
            overflow: hidden;
        }

        #mobile-menu.active {
            max-height: 100vh;
        }
    </style>
    <?php
}
add_action('wp_head', 'gdp_header_dropdown_styles');

function gdp_header_menu_classes($classes, $item, $args) {
    if($args->theme_location == 'primary') {
        $classes[] = 'group relative';
        
        // Add specific classes for items with children
        if(in_array('menu-item-has-children', $classes)) {
            $classes[] = 'has-dropdown';
        }
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'gdp_header_menu_classes', 10, 3);

// Add arrow for dropdown items
function gdp_header_menu_arrow($item_output, $item, $depth, $args) {
    if($args->theme_location == 'primary' && in_array('menu-item-has-children', $item->classes)) {
        $arrow = '<svg class="w-4 h-4 ml-1 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                 </svg>';
        $item_output = str_replace('</a>', $arrow . '</a>', $item_output);
    }
    return $item_output;
}
add_filter('walker_nav_menu_start_el', 'gdp_header_menu_arrow', 10, 4);

function gdp_custom_colors() {
    ?>
    <style>
        :root {
            --color-primary: <?php echo GDP_Theme_Support::gdp_option('primary_color'); ?>;
            --color-secondary: <?php echo GDP_Theme_Support::gdp_option('secondary_color'); ?>;
            --color-three: <?php echo GDP_Theme_Support::gdp_option('three_color'); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'gdp_custom_colors');

