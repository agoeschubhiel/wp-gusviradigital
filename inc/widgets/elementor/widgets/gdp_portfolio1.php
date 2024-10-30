<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class GDP_Portfolio1 extends Widget_Base {

    public function get_name() {
        return 'gdp_portfolio1';
    }

    public function get_title() {
        return 'GDP Portfolio Showcase';
    }

    public function get_icon() {
        return 'eicon-gallery-masonry';
    }

    public function get_categories() {
        return ['gdp-category'];
    }

    public function get_script_depends() {
        return ['isotope', 'animated'];
    }

    public function get_style_depends() {
        return ['animated-css'];
    }

    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => 'Content Settings',
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label' => 'Section Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Our Portfolio',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'section_subtitle',
            [
                'label' => 'Section Subtitle',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Discover our amazing work',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => 'Number of Projects',
                'type' => Controls_Manager::NUMBER,
                'default' => 6,
                'min' => 1,
                'max' => 12,
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => 'Columns',
                'type' => Controls_Manager::SELECT,
                'default' => '4',
                'options' => [
                    '2' => '2 Columns',
                    '3' => '3 Columns',
                    '4' => '4 Columns',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => 'Style Settings',
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => 'Title Color',
                'type' => Controls_Manager::COLOR,
                'default' => '#1a1a1a',
                'selectors' => [
                    '{{WRAPPER}} .portfolio-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label' => 'Subtitle Color',
                'type' => Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .portfolio-subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        // Get portfolio categories
        $portfolio_categories = get_terms([
            'taxonomy' => 'portfolio_category',
            'hide_empty' => true,
        ]);

        // Query portfolio items
        $args = [
            'post_type' => 'portfolio',
            'posts_per_page' => $settings['posts_per_page'],
            'orderby' => 'date',
            'order' => 'DESC',
        ];
        $portfolio_query = new \WP_Query($args);

        // Define grid classes based on columns setting
        $flex_classes = 'flex flex-wrap -mx-4';
        $item_classes = 'px-4 mb-8 w-full ';
        switch ($settings['columns']) {
            case '2':
                $item_classes .= 'sm:w-1/2';
                break;
            case '3':
                $item_classes .= 'sm:w-1/2 lg:w-1/3';
                break;
            case '4':
                $item_classes .= 'sm:w-1/2 lg:w-1/3 xl:w-1/4';
                break;
            default:
                $item_classes .= 'sm:w-1/2 lg:w-1/3 xl:w-1/4';
        }
        ?>

        <div class="gdp-portfolio py-16 md:py-24">
            <!-- Header Section -->
            <div class="container mx-auto px-4 mb-12 md:mb-16 text-center">
                <h2 class="portfolio-title text-3xl md:text-4xl lg:text-5xl font-bold mb-4 animate__animated animate__fadeInDown">
                    <?php echo esc_html($settings['section_title']); ?>
                </h2>
                <p class="portfolio-subtitle text-lg md:text-xl text-gray-600 max-w-2xl mx-auto mb-12 animate__animated animate__fadeInUp">
                    <?php echo esc_html($settings['section_subtitle']); ?>
                </p>

                <!-- Filter Buttons -->
                <?php if (!empty($portfolio_categories)) : ?>
                <div class="flex flex-wrap justify-center gap-3 mb-12 animate__animated animate__fadeInUp">
                    <button class="filter-btn active px-6 py-2.5 rounded-full text-sm font-medium transition-all duration-300 
                             bg-purple-600 text-white hover:bg-purple-700" data-filter="*">
                        All Projects
                    </button>
                    <?php foreach ($portfolio_categories as $category) : ?>
                        <button class="filter-btn px-6 py-2.5 rounded-full text-sm font-medium transition-all duration-300 
                                 bg-gray-100 text-gray-700 hover:bg-purple-600 hover:text-white"
                                data-filter=".<?php echo esc_attr($category->slug); ?>">
                            <?php echo esc_html($category->name); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Portfolio Flex Container -->
            <div class="container mx-auto px-4">
                <div class="portfolio-container <?php echo esc_attr($flex_classes); ?>">
                    <?php 
                    if ($portfolio_query->have_posts()) :
                        while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
                            $categories = get_the_terms(get_the_ID(), 'portfolio_category');
                            $category_classes = '';
                            if ($categories && !is_wp_error($categories)) {
                                $category_slugs = wp_list_pluck($categories, 'slug');
                                $category_classes = implode(' ', $category_slugs);
                            }
                    ?>
                        <div class="portfolio-item <?php echo esc_attr($item_classes . ' ' . $category_classes); ?> animate__animated animate__fadeIn">
                            <div class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 h-full">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="aspect-w-16 aspect-h-12">
                                        <img src="<?php the_post_thumbnail_url('large'); ?>" 
                                             alt="<?php the_title(); ?>" 
                                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    </div>
                                <?php endif; ?>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300">
                                    <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                                        <h3 class="text-lg font-bold mb-2"><?php the_title(); ?></h3>
                                        <p class="text-sm text-gray-300 mb-4"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                        <a href="<?php the_permalink(); ?>" class="inline-block bg-purple-600 text-white py-2 px-4 rounded-full hover:bg-purple-700 transition-colors duration-300">
                                            View Project
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </div>

        <script>
            jQuery(document).ready(function($) {
                var $container = $('.portfolio-container');
                $container.isotope({
                    itemSelector: '.portfolio-item',
                    percentPosition: true
                });

                $('.filter-btn').on('click', function() {
                    var filterValue = $(this).attr('data-filter');
                    $container.isotope({ filter: filterValue });
                    $('.filter-btn').removeClass('bg-purple-600 text-white').addClass('bg-gray-100 text-gray-700');
                    $(this).removeClass('bg-gray-100 text-gray-700').addClass('bg-purple-600 text-white');
                });

                // Trigger Isotope layout after images are loaded
                $container.imagesLoaded().progress(function() {
                    $container.isotope('layout');
                });
            });
        </script>
    <?php
    }
}