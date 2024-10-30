<?php
/**
 * Template footer utama
 */

// Ambil pengaturan footer dari Redux
$footer_style = GDP_Theme_Support::gdp_option('footer_style', 'style1');
$footer_columns = GDP_Theme_Support::gdp_option('footer_columns', '4');
$footer_logo = GDP_Theme_Support::gdp_option('footer_logo');
$footer_bg = GDP_Theme_Support::gdp_option('footer_background', '#333333');
$footer_text_color = GDP_Theme_Support::gdp_option('footer_text_color', '#ffffff');
$footer_copyright = GDP_Theme_Support::gdp_option('footer_copyright');
$footer_about = GDP_Theme_Support::gdp_option('footer_about');
$footer_social_links = GDP_Theme_Support::gdp_option('footer_social_links');

// Replace {year} dengan tahun saat ini
$footer_copyright = str_replace('{year}', date('Y'), $footer_copyright);

// Grid class berdasarkan jumlah kolom
$grid_class = [
    '2' => 'grid-cols-1 md:grid-cols-2',
    '3' => 'grid-cols-1 md:grid-cols-3',
    '4' => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4'
][$footer_columns];

?>

<footer class="bg-[<?php echo $footer_bg; ?>] text-[<?php echo $footer_text_color; ?>]">
    <?php if($footer_style === 'style1'): ?>
        
        <!-- Footer Style 1 -->
        <div class="container mx-auto px-4 py-12">
            <div class="grid <?php echo $grid_class; ?> gap-8">
                <!-- Column 1: Logo & About -->
                <div class="footer-col">
                    <?php if($footer_logo): ?>
                        <img src="<?php echo $footer_logo['url']; ?>" 
                             alt="<?php echo get_bloginfo('name'); ?>" 
                             class="mb-6 max-h-20">
                    <?php endif; ?>
                    
                    <?php if($footer_about): ?>
                        <p class="mb-6"><?php echo $footer_about; ?></p>
                    <?php endif; ?>

                    <?php if($footer_social_links): ?>
                        <div class="flex space-x-4">
                            <?php foreach($footer_social_links as $social_link): ?>
                                <a href="<?php echo esc_url($social_link); ?>" 
                                   class="hover:text-primary transition-colors"
                                   target="_blank" rel="noopener noreferrer">
                                    <?php echo gdp_get_social_icon($social_link); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Dynamic Footer Widgets -->
                <?php 
                for($i = 2; $i <= $footer_columns; $i++): 
                    if(is_active_sidebar('footer-widget-' . $i)):
                ?>
                    <div class="footer-col">
                        <?php dynamic_sidebar('footer-widget-' . $i); ?>
                    </div>
                <?php 
                    endif;
                endfor; 
                ?>
            </div>
        </div>

    <?php elseif($footer_style === 'style2'): ?>
        
        <!-- Footer Style 2 -->
        <div class="container mx-auto px-4">
            <div class="py-12 border-b border-gray-700">
                <div class="grid <?php echo $grid_class; ?> gap-8">
                    <!-- Similar structure but different styling -->
                    <!-- ... -->
                </div>
            </div>
            <div class="py-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <?php echo $footer_copyright; ?>
                    </div>
                    <?php if($footer_social_links): ?>
                        <div class="flex space-x-4">
                            <?php foreach($footer_social_links as $social_link): ?>
                                <a href="<?php echo esc_url($social_link); ?>" 
                                   class="hover:text-primary transition-colors"
                                   target="_blank" rel="noopener noreferrer">
                                    <?php echo gdp_get_social_icon($social_link); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php else: ?>
        
        <!-- Footer Style 3 -->
        <div class="container mx-auto px-4">
            <div class="py-12">
                <div class="text-center mb-12">
                    <?php if($footer_logo): ?>
                        <img src="<?php echo $footer_logo['url']; ?>" 
                             alt="<?php echo get_bloginfo('name'); ?>" 
                             class="mx-auto mb-6 max-h-20">
                    <?php endif; ?>
                    
                    <?php if($footer_about): ?>
                        <p class="max-w-2xl mx-auto mb-6"><?php echo $footer_about; ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="grid <?php echo $grid_class; ?> gap-8">
                    <?php 
                    for($i = 1; $i <= $footer_columns; $i++): 
                        if(is_active_sidebar('footer-widget-' . $i)):
                    ?>
                        <div class="footer-col">
                            <?php dynamic_sidebar('footer-widget-' . $i); ?>
                        </div>
                    <?php 
                        endif;
                    endfor; 
                    ?>
                </div>
            </div>
            
            <div class="py-6 border-t border-gray-700 text-center">
                <?php echo $footer_copyright; ?>
            </div>
        </div>

    <?php endif; ?>
</footer>

<?php
// Helper function untuk mendapatkan icon social media
function gdp_get_social_icon($url) {
    $icon = '';
    
    if(strpos($url, 'facebook') !== false) {
        $icon = '<i class="fab fa-facebook-f"></i>';
    } elseif(strpos($url, 'twitter') !== false) {
        $icon = '<i class="fab fa-twitter"></i>';
    } elseif(strpos($url, 'instagram') !== false) {
        $icon = '<i class="fab fa-instagram"></i>';
    } elseif(strpos($url, 'linkedin') !== false) {
        $icon = '<i class="fab fa-linkedin-in"></i>';
    } elseif(strpos($url, 'youtube') !== false) {
        $icon = '<i class="fab fa-youtube"></i>';
    }
    
    return $icon;
}

// Register footer widget areas
function gdp_register_footer_widgets() {
    $footer_columns = GDP_Theme_Support::gdp_option('footer_columns', '4');
    
    for($i = 1; $i <= $footer_columns; $i++) {
        register_sidebar(array(
            'name'          => sprintf(__('Footer Widget %d', 'gusviradigital'), $i),
            'id'            => 'footer-widget-' . $i,
            'description'   => sprintf(__('Add widgets here to appear in footer column %d.', 'gusviradigital'), $i),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
             'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        ));
    }
}
add_action('widgets_init', 'gdp_register_footer_widgets');
?>
<?php wp_footer() ?>
</body>
</html>