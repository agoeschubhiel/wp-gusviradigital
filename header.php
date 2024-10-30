<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php
// Header template
    // Get header settings
    $header_layout = GDP_Theme_Support::gdp_option('header_layout');
    $header_style = GDP_Theme_Support::gdp_option('header_style');
    $sticky_header = GDP_Theme_Support::gdp_option('sticky_header');
    $site_layout = GDP_Theme_Support::gdp_option('site_layout');
    $container_width = GDP_Theme_Support::gdp_option('container_width');
    
    // Generate dynamic classes
    $header_classes = [
        'w-full',
        'bg-white',
        'dark:bg-gray-900',
        ($sticky_header) ? 'sticky top-0 z-50' : '',
        ($site_layout === 'boxed') ? 'max-w-7xl mx-auto' : 'w-full',
    ];

    // Container class based on layout
    $container_class = match($site_layout) {
        'boxed' => "max-w-[{$container_width}px] mx-auto px-4",
        'wide' => "container mx-auto px-4",
        'fullwidth' => "w-full px-4",
        default => "container mx-auto px-4"
    };
?>

<header class="<?php echo implode(' ', $header_classes); ?>">
    <?php if($header_style === 'style1'): ?>
        <!-- Top Bar -->
        <?php if(GDP_Theme_Support::gdp_option('header_contact_info')): ?>
        <div class="bg-gray-100 dark:bg-gray-800">
            <div class="<?php echo $container_class; ?>">
                <div class="flex justify-between items-center h-10">
                    <div class="flex items-center space-x-4">
                        <?php if(!empty(GDP_Theme_Support::gdp_option('header_phone'))): ?>
                        <a href="tel:<?php echo GDP_Theme_Support::gdp_option('header_phone'); ?>" 
                           class="text-sm text-gray-600 dark:text-gray-300 hover:text-primary transition-colors">
                            <i class="fas fa-phone mr-2"></i>
                            <?php echo GDP_Theme_Support::gdp_option('header_phone'); ?>
                        </a>
                        <?php endif; ?>
                        
                        <?php if(!empty(GDP_Theme_Support::gdp_option('header_email'))): ?>
                        <a href="mailto:<?php echo GDP_Theme_Support::gdp_option('header_email'); ?>" 
                           class="text-sm text-gray-600 dark:text-gray-300 hover:text-primary transition-colors">
                            <i class="fas fa-envelope mr-2"></i>
                            <?php echo GDP_Theme_Support::gdp_option('header_email'); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Main Header -->
        <div class="<?php echo $container_class; ?>">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <?php if(wp_is_mobile()): ?>
                        <img src="<?php echo GDP_Theme_Support::gdp_option('site_logo_light')['url']; ?>" 
                             alt="<?php echo get_bloginfo('name'); ?>"
                             class="h-[<?php echo GDP_Theme_Support::gdp_option('logo_height'); ?>px] w-auto block dark:hidden">
                        <img src="<?php echo GDP_Theme_Support::gdp_option('site_logo_dark')['url']; ?>" 
                             alt="<?php echo get_bloginfo('name'); ?>"
                             class="h-[<?php echo GDP_Theme_Support::gdp_option('logo_height'); ?>px] w-auto hidden dark:block">
                    <?php else: ?>
                        <img src="<?php echo GDP_Theme_Support::gdp_option('site_logo_dark')['url']; ?>" 
                             alt="<?php echo get_bloginfo('name'); ?>"
                             class="h-[<?php echo GDP_Theme_Support::gdp_option('logo_height'); ?>px] w-auto block dark:hidden">
                        <img src="<?php echo GDP_Theme_Support::gdp_option('site_logo_light')['url']; ?>" 
                             alt="<?php echo get_bloginfo('name'); ?>"
                             class="h-[<?php echo GDP_Theme_Support::gdp_option('logo_height'); ?>px] w-auto hidden dark:block">
                    <?php endif; ?>
                </div>

                <!-- Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container' => false,
                        'menu_class' => 'flex items-center space-x-8',
                        'link_class' => 'text-gray-700 dark:text-gray-300 hover:text-primary transition-colors',
                    ));
                    ?>
                    
                    <?php if(GDP_Theme_Support::gdp_option('header_button')): ?>
                    <a href="<?php echo GDP_Theme_Support::gdp_option('header_button_url'); ?>" 
                       class="inline-flex items-center px-6 py-2.5 rounded-full bg-primary hover:bg-primary-dark text-white transition-colors">
                        <?php echo GDP_Theme_Support::gdp_option('header_button_text'); ?>
                    </a>
                    <?php endif; ?>
                </nav>

                <!-- Mobile Menu Button -->
                <button class="md:hidden inline-flex items-center p-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none" 
                        id="mobile-menu-button">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'space-y-2',
                    'link_class' => 'block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-primary hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors',
                ));
                ?>
                
                <?php if(GDP_Theme_Support::gdp_option('header_button')): ?>
                <a href="<?php echo GDP_Theme_Support::gdp_option('header_button_url'); ?>" 
                   class="block w-full text-center px-6 py-2.5 rounded-full bg-primary hover:bg-primary-dark text-white transition-colors mt-4">
                    <?php echo GDP_Theme_Support::gdp_option('header_button_text'); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</header>

<script>
document.getElementById('mobile-menu -button').addEventListener('click', function() {
    document.getElementById('mobile-menu').classList.toggle('hidden');
});
</script>
