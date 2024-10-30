<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH')) exit;

class GDP_Portfolio2 extends Widget_Base {

    public function get_name() {
        return 'gdp_portfolio2';
    }

    public function get_title() {
        return 'GDP Portfolio Style 2';
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
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
                'default' => 'Featured Works',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'section_subtitle',
            [
                'label' => 'Section Subtitle',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Explore our creative portfolio',
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
                'default' => '3',
                'options' => [
                    '2' => '2 Columns',
                    '3' => '3 Columns',
                    '4' => '4 Columns',
                ],
            ]
        );

        $this->add_control(
            'show_category',
            [
                'label' => 'Show Category',
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label' => 'Show Excerpt',
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
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

        $this->add_control(
            'overlay_color',
            [
                'label' => 'Overlay Color',
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0, 0, 0, 0.7)',
                'selectors' => [
                    '{{WRAPPER}} .portfolio-overlay' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'accent_color',
            [
                'label' => 'Accent Color',
                'type' => Controls_Manager::COLOR,
                'default' => '#4F46E5',
                'selectors' => [
                    '{{WRAPPER}} .portfolio-category' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .portfolio-button' => 'background-color: {{VALUE}};',
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

        // Define flex classes
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
                $item_classes .= 'sm:w-1/2 lg:w-1/3';
        }
        ?>

        <div class="gdp-portfolio-v2 py-16 md:py-24 bg-gray-50" data-aos="fade-up">
            <!-- Header Section -->
            <div class="container mx-auto px-4 mb-16 text-center" data-aos="fade-up" data-aos-delay="100">
                <h2 class="portfolio-title text-4xl md:text-5xl font-bold mb-4">
                    <?php echo esc_html($settings['section_title']); ?>
                </h2>
                <p class="portfolio-subtitle text-xl text-gray-600 max-w-2xl mx-auto mb-12">
                    <?php echo esc_html($settings['section_subtitle']); ?>
                </p>

                <?php if (!empty($portfolio_categories)) : ?>
                <div class="portfolio-tabs flex flex-wrap justify-center gap-4 mb-12" data-aos="fade-up" data-aos-delay="200">
                    <button class="tab-btn active px-6 py-3 rounded-lg text-sm font-semibold transition-all duration-300 
                             bg-indigo-600 text-white hover:bg-indigo-700" data-filter="*">
                        All Works
                    </button>
                    <?php foreach ($portfolio_categories as $category) : ?>
                        <button class="tab-btn px-6 py-3 rounded-lg text-sm font-semibold transition-all duration-300 
                                 bg-white text-gray-700 hover:bg-indigo-600 hover:text-white shadow-sm"
                                data-filter=".<?php echo esc_attr($category->slug); ?>">
                            <?php echo esc_html($category->name); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Portfolio Grid -->
            <div class="container mx-auto px-4 mb-16">
                <div class="portfolio-grid <?php echo esc_attr($flex_classes); ?>">
                    <?php 
                    $delay = 300;
                    while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
                        $categories = get_the_terms(get_the_ID(), 'portfolio_category');
                        $category_classes = '';
                        if ($categories && !is_wp_error($categories)) {
                            $category_slugs = wp_list_pluck($categories, 'slug');
                            $category_classes = implode(' ', $category_slugs);
                        }
                    ?>
                        <div class="portfolio-item <?php echo esc_attr($item_classes . ' ' . $category_classes); ?>" 
                             data-aos="fade-up" 
                             data-aos-delay="<?php echo esc_attr($delay); ?>">
                            <div class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="aspect-w-16 aspect-h-12">
                                        <?php the_post_thumbnail('large', [
                                            'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-110'
                                        ]); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent 
                                            opacity-0 group-hover:opacity-100 transition-all duration-300">
                                    <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-full 
                                                group-hover:translate-y-0 transition-transform duration-300">
                                        <h3 class="text-xl font-bold text-white mb-2"><?php the_title(); ?></h3>
                                        <?php if ($settings['show_category']) : ?>
                                            <div class="text-sm text-gray-300 mb-3">
                                                <?php
                                                if ($categories) {
                                                    $category_names = wp_list_pluck($categories, 'name');
                                                    echo esc_html(implode(', ', $category_names));
                                                }
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($settings['show_excerpt']) : ?>
                                            <p class="text-sm text-gray-300 mb-4">
                                                <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                                            </p>
                                        <?php endif; ?>
                                        <a href="<?php the_permalink(); ?>" 
                                           class="inline-block bg-indigo-600 text-white py-2 px-4 rounded-lg 
                                                  hover:bg-indigo-700 transition-colors duration-300">
                                            View Project
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php 
                        $delay += 100;
                        endwhile; 
                        wp_reset_postdata(); 
                    ?>
                </div>
            </div>
        </div>
        <script>
            jQuery(document).ready(function($) {
                // Initialize AOS
                AOS.init({
                    duration: 1000,
                    once: true,
                    mirror: false
                });

                // Initialize Isotope
                var $grid = $('.portfolio-grid').isotope({
                    itemSelector: '.portfolio-item',
                    layoutMode: 'fitRows',
                    percentPosition: true,
                    masonry: {
                        columnWidth: '.portfolio-item'
                    }
                });

                // Layout Isotope after images have loaded
                $grid.imagesLoaded().progress(function() {
                    $grid.isotope('layout');
                });

                // Filter items on button click
                $('.portfolio-tabs').on('click', '.tab-btn', function() {
                    var filterValue = $(this).attr('data-filter');
                    
                    // Add/remove active class
                    $('.tab-btn').removeClass('active bg-indigo-600 text-white').addClass('bg-white text-gray-700');
                    $(this).addClass('active bg-indigo-600 text-white').removeClass('bg-white text-gray-700');
                    
                    // Filter items
                    $grid.isotope({ filter: filterValue });
                });

                // Trigger AOS refresh on Isotope filter
                $grid.on('arrangeComplete', function() {
                    AOS.refresh();
                });

                // Optional: Add smooth scroll animation when clicking on filter buttons
                $('.tab-btn').on('click', function(e) {
                    e.preventDefault();
                    var targetOffset = $('.portfolio-grid').offset().top - 100;
                    $('html, body').animate({
                        scrollTop: targetOffset
                    }, 500);
                });

                // Optional: Add hover effect for portfolio items
                $('.portfolio-item').hover(
                    function() {
                        $(this).find('.portfolio-overlay').addClass('opacity-100');
                    },
                    function() {
                        $(this).find('.portfolio-overlay').removeClass('opacity-100');
                    }
                );
            });
        </script>
        <?php
    }
}