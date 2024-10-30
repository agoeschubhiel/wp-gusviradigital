<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH')) exit;

class GDP_Portfolio3 extends Widget_Base {

    public function get_name() {
        return 'gdp_portfolio3';
    }

    public function get_title() {
        return 'GDP Portfolio Style 3';
    }

    public function get_icon() {
        return 'eicon-gallery-masonry';
    }

    public function get_categories() {
        return ['gdp-category'];
    }

    public function get_script_depends() {
        return ['isotope', 'imagesloaded', 'aos'];
    }

    public function get_style_depends() {
        return ['aos'];
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
            'layout_style',
            [
                'label' => 'Layout Style',
                'type' => Controls_Manager::SELECT,
                'default' => 'masonry',
                'options' => [
                    'masonry' => 'Masonry',
                    'grid' => 'Grid',
                ],
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => 'Columns',
                'type' => Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-item' => 'width: calc(100% / {{VALUE}} - ({{item_gap.size}}px * 2));',
                ],
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => 'Number of Projects',
                'type' => Controls_Manager::NUMBER,
                'default' => 9,
                'min' => 1,
                'max' => 20,
            ]
        );

        $this->add_control(
            'show_filters',
            [
                'label' => 'Show Filters',
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
            'item_gap',
            [
                'label' => 'Item Gap',
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 30,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // Query portfolio items
        $args = [
            'post_type' => 'portfolio',
            'posts_per_page' => $settings['posts_per_page'],
            'orderby' => 'date',
            'order' => 'DESC',
        ];
        
        $portfolio_query = new \WP_Query($args);
        $categories = get_terms(['taxonomy' => 'portfolio_category']);
        ?>

        <div class="gdp-portfolio-v3">
            <!-- Filter Buttons -->
            <?php if ($settings['show_filters'] && !empty($categories)) : ?>
            <div class="filter-container mb-10" data-aos="fade-up">
                <div class="flex flex-wrap justify-center gap-4">
                    <button class="filter-btn active px-6 py-2 rounded-full text-sm font-medium 
                             bg-gradient-to-r from-purple-600 to-indigo-600 text-white 
                             hover:from-purple-700 hover:to-indigo-700 transition-all duration-300"
                            data-filter="*">
                        All Projects
                    </button>
                    <?php foreach ($categories as $category) : ?>
                        <button class="filter-btn px-6 py-2 rounded-full text-sm font-medium 
                                 bg-white text-gray-700 hover:bg-gradient-to-r hover:from-purple-600 
                                 hover:to-indigo-600 hover:text-white transition-all duration-300 shadow-sm"
                                data-filter=".<?php echo esc_attr($category->slug); ?>">
                            <?php echo esc_html($category->name); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Portfolio Grid -->
            <div class="portfolio-grid flex flex-wrap justify-center" data-aos="fade-up" data-aos-delay="200">
                <?php 
                while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
                    $categories = get_the_terms(get_the_ID(), 'portfolio_category');
                    $category_classes = '';
                    if ($categories) {
                        $category_classes = implode(' ', wp_list_pluck($categories, 'slug'));
                    }
                    ?>
                    <div class="portfolio-item <?php echo esc_attr($category_classes); ?>" data-aos="fade-up">
                        <div class="relative group overflow-hidden rounded-xl m-4">
                            <!-- Thumbnail -->
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="aspect-w-16 aspect-h-12 bg-gray-200">
                                    <?php the_post_thumbnail('large', [
                                        'class' => 'w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700'
                                    ]); ?>
                                </div>
                            <?php endif; ?>

                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-black/50 to-black/80 
                                        opacity-0 group-hover:opacity-100 transition-all duration-500">
                                <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-12 
                                            group-hover:translate-y-0 transition-transform duration-500">
                                    <!-- Categories -->
                                    <?php if ($categories) : ?>
                                        <div class="mb-2">
                                            <?php foreach ($categories as $category) : ?>
                                                <span class="inline-block px-3 py-1 text-xs font-medium text-white 
                                                         bg-purple-600/50 rounded-full mr-2 mb-2">
                                                    <?php echo esc_html($category->name); ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Title -->
                                    <h3 class="text-xl md:text-2xl font-bold text-white mb-2">
                                        <?php the_title(); ?>
                                    </h3>

                                    <!-- Excerpt -->
                                    <p class="text-sm text-gray-300 mb-4 line-clamp-2">
                                        <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                                    </p>

                                    <!-- Button -->
                                    <a href="<?php the_permalink(); ?>" 
                                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white 
                                              bg-gradient-to-r from-purple-600 to-indigo-600 rounded-lg 
                                              hover:from-purple-700 hover:to-indigo-700 transition-all duration-300">
                                        View Project
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke=" currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>

        <style>
            .gdp-portfolio-v3 {
                
            }

            .portfolio-grid {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: var(--gap);
                padding: var(--gap);
            }

            .portfolio-item {
                width: calc(100% / <?php echo $settings['columns']; ?> - (var(--gap) * 2));
                margin-bottom: var(--gap);
            }

            .portfolio-item img {
                width: 100%;
                height: auto;
                display: block;
            }

            /* Hover Effects */
            .portfolio-item:hover .portfolio-overlay {
                opacity: 1;
            }

            .portfolio-item:hover .portfolio-content {
                transform: translateY(0);
            }

            /* Animation Classes */
            .fade-up {
                opacity: 0;
                transform: translateY(20px);
                transition: opacity 0.6s ease, transform 0.6s ease;
            }

            .fade-up.aos-animate {
                opacity: 1;
                transform: translateY(0);
            }
        </style>

        <script>
            jQuery(document).ready(function($) {
                // Initialize AOS
                AOS.init({
                    duration: 800,
                    once: true,
                    offset: 100
                });

                // Filter items on button click
                $('.filter-container').on('click', '.filter-btn', function() {
                    var filterValue = $(this).attr('data-filter');
                    
                    // Update active state
                    $('.filter-btn').removeClass('active bg-gradient-to-r from-purple-600 to-indigo-600 text-white')
                                   .addClass('bg-white text-gray-700');
                    $(this).addClass('active bg-gradient-to-r from-purple-600 to-indigo-600 text-white')
                           .removeClass('bg-white text-gray-700');
                    
                    // Filter items
                    $('.portfolio-grid').isotope({ filter: filterValue });
                });

                // Handle window resize
                $(window).on('resize', function() {
                    $('.portfolio-grid').isotope('layout');
                });

                // Smooth scroll to portfolio section when filter is clicked
                $('.filter-btn').on('click', function(e) {
                    e.preventDefault();
                    var portfolioTop = $('.gdp-portfolio-v3').offset().top - 100;
                    $('html, body').animate({
                        scrollTop: portfolioTop
                    }, 500);
                });

                // Add hover animations
                $('.portfolio-item').hover(
                    function() {
                        $(this).find('.portfolio-overlay').css('opacity', '1');
                        $(this).find('.portfolio-content').css('transform', 'translateY(0)');
                    },
                    function() {
                        $(this).find('.portfolio-overlay').css('opacity', '0');
                        $(this).find('.portfolio-content').css('transform', 'translateY(20px)');
                    }
                );

                // Optional: Add infinite scroll
                var loading = false;
                $(window).scroll(function() {
                    if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
                        if(!loading) {
                            loading = true;
                            // Add your AJAX load more logic here
                            // Remember to set loading = false after AJAX completes
                        }
                    }
                });

                // Refresh AOS on Isotope transitions
                $('.portfolio-grid').on('layoutComplete', function() {
                    AOS.refresh();
                });
            });
        </script>
        <?php
    }
}