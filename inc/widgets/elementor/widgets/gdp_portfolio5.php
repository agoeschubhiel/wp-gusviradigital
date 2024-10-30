<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) exit;

class GDP_Portfolio5 extends Widget_Base {
    // Bagian dasar widget sama seperti sebelumnya
    public function get_name() { return 'gdp-portfolio5'; }
    public function get_title() { return 'GDP Portfolio 5'; }
    public function get_icon() { return 'eicon-gallery-grid'; }
    public function get_categories() { return ['gdp-widgets']; }
    public function get_script_depends() { return ['isotope', 'imagesloaded', 'aos']; }
    public function get_style_depends() { return ['aos']; }

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
            'hover_effect',
            [
                'label' => 'Hover Effect',
                'type' => Controls_Manager::SELECT,
                'default' => 'effect1',
                'options' => [
                    'effect1' => 'Zoom In',
                    'effect2' => 'Slide Up',
                    'effect3' => 'Rotate',
                    'effect4' => 'Flip',
                ],
            ]
        );

        $this->add_control(
            'card_style',
            [
                'label' => 'Card Style',
                'type' => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => 'Minimal',
                    'style2' => 'Bordered',
                    'style3' => 'Shadow',
                    'style4' => 'Gradient',
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
                'max' => 100,
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

        $this->add_control(
            'show_load_more',
            [
                'label' => 'Show Load More',
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

        // Tambahan kontrol style
        $this->add_control(
            'overlay_type',
            [
                'label' => 'Overlay Type',
                'type' => Controls_Manager::SELECT,
                'default' => 'gradient',
                'options' => [
                    'solid' => 'Solid Color',
                    'gradient' => 'Gradient',
                ],
            ]
        );

        $this->add_control(
            'overlay_gradient_angle',
            [
                'label' => 'Gradient Angle',
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 45,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 360,
                    ],
                ],
                'condition' => [
                    'overlay_type' => 'gradient',
                ],
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

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => 'Title Typography',
                'selector' => '{{WRAPPER}} .portfolio-item h3',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'category_typography',
                'label' => 'Category Typography',
                'selector' => '{{WRAPPER}} .portfolio-item .category',
            ]
        );

        $this->add_control(
            'overlay_color',
            [
                'label' => 'Overlay Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .portfolio-item .overlay' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'label' => 'Item Border',
                'selector' => '{{WRAPPER}} .portfolio-item',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_box_shadow',
                'label' => 'Item Box Shadow',
                'selector' => '{{WRAPPER}} .portfolio-item',
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

        if ($portfolio_query->have_posts()) {
            ?>
            <div class="gdp-portfolio-5 <?php echo esc_attr($settings['card_style']); ?>">
                <?php if ($settings['show_filters']) : ?>
                    <div class="filter-container animate">
                        <div class="filter-wrapper">
                            <button class="filter-btn active" data-filter="*">
                                <span class="filter-text">All</span>
                            </button>
                            <?php
                            $categories = get_terms(['taxonomy' => 'portfolio_category', 'hide_empty' => true]);
                            foreach ($categories as $category) {
                                echo '<button class="filter-btn" data-filter=".' . esc_attr($category->slug) . '">
                                        <span class="filter-text">' . esc_html($category->name) . '</span>
                                      </button>';
                            }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="portfolio-grid <?php echo esc_attr($settings['hover_effect']); ?> animate">
                    <?php
                    while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
                        $categories = get_the_terms(get_the_ID(), 'portfolio_category');
                        $category_classes = '';
                        if ($categories) {
                            $category_slugs = wp_list_pluck($categories, 'slug');
                            $category_classes = implode(' ', $category_slugs);
                        }
                        ?>
                        <div class="portfolio-item <?php echo esc_attr($category_classes); ?>">
                            <div class="portfolio-item-inner">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="portfolio-image">
                                        <?php the_post_thumbnail('large'); ?>
                                        <div class="portfolio-overlay">
                                            <div class="overlay-content">
                                                <h3><?php the_title(); ?></h3>
                                                <?php if ($categories) : ?>
                                                    <div class="portfolio-category">
                                                        <?php echo esc_html($categories[0]->name); ?>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="portfolio-links">
                                                    <a href="<?php the_permalink(); ?>" class="portfolio-link">
                                                        <i class="fas fa-link"></i>
                                                    </a>
                                                    <a href="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" class="portfolio-lightbox">
                                                        <i class="fas fa-search"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>

                <?php if ($settings['show_load_more']) : ?>
                    <div class="load-more-container">
                        <button class="load-more-btn" data-aos="fade-up">
                            <span class="btn-text">Load More</span>
                            <span class="btn-icon"><i class="fas fa-spinner fa-spin"></i></span>
                        </button>
                    </div>
                <?php endif; ?>
            </div>

            <style>
                .gdp-portfolio-5 {
                    --primary-color: #007bff;
                    --secondary-color: #6c757d;
                    --overlay-color: rgba(0, 0, 0, 0.7); /* overlay color */
                }

                .gdp-portfolio-5.style1 {
                    --card-background-color: #fff;
                    --card-border-color: #ddd;
                }

                .gdp-portfolio-5.style2 {
                    --card-background-color: #f7f7f7;
                    --card-border-color: #ccc;
                }

                .gdp-portfolio-5.style3 {
                    --card-background-color: #fff;
                    --card-border-color: #ddd;
                    --card-box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }

                .gdp-portfolio-5.style4 {
                    --card-background-color: #fff;
                    --card-border-color: #ddd;
                    --card-gradient-color: linear-gradient(45deg, #007bff, #6c757d);
                }

                .portfolio-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                    grid-gap: 20px;
                }

                .portfolio-item {
                    position: relative;
                    overflow: hidden;
                    border-radius: 10px;
                    box-shadow: var(--card-box-shadow);
                    background-color: var(--card-background-color);
                    border: 1px solid var(--card-border-color);
                }

                .portfolio-item-inner {
                    padding: 20px;
                }

                .portfolio-image {
                    position: relative;
                    overflow: hidden;
                    border-radius: 10px 10px 0 0;
                }

                .portfolio-overlay {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: var(--overlay-color);
                    opacity: 0;
                    transition: opacity 0.3s ease;
                }

                .portfolio-overlay:hover {
                    opacity: 1;
                }

                .overlay-content {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    text-align: center;
                }

                .portfolio-category {
                    font-size: 14px;
                    color: var(--secondary-color);
                }

                .portfolio-links {
                    margin-top: 10px;
                }

                .portfolio-link {
                    margin-right: 10px;
                }

                .load-more-container {
                    text-align: center;
                    margin-top: 20px;
                }

                .load-more-btn {
                    background-color: var(--primary-color);
                    color: #fff;
                    border: none;
                    padding: 10px 20px;
                    font-size: 16px;
                    cursor: pointer;
                }

                .load-more-btn:hover {
                    background-color: var(--primary-color);
                }

                .btn-icon {
                    margin-left: 10px;
                }
                .animate {
                    opacity: 0;
                    transform: translateY(20px);
                    transition: opacity 0.6s ease-out, transform 0.6s ease-out;
                }

                .animate.show {
                    opacity: 1;
                    transform: translateY(0);
                }

                /* Animasi untuk item portfolio */
                .portfolio-item {
                    opacity: 0;
                    transform: translateY(20px);
                    transition: opacity 0.6s ease-out, transform 0.6s ease-out;
                }

                .portfolio-item.show {
                    opacity: 1;
                    transform: translateY(0);
                }

                /* Animasi stagger untuk item portfolio */
                @media (prefers-reduced-motion: no-preference) {
                    .portfolio-item {
                        transition-delay: calc(var(--item-index) * 100ms);
                    }
                }

                /* Hover effects */
                .portfolio-item:hover .portfolio-overlay {
                    opacity: 1;
                }

                .portfolio-item:hover .portfolio-image img {
                    transform: scale(1.1);
                }

                /* Tambahkan animasi untuk filter buttons */
                .filter-btn {
                    transform: translateY(20px);
                    opacity: 0;
                    animation: fadeInUp 0.6s ease-out forwards;
                }

                @keyframes fadeInUp {
                    from {
                        opacity: 0;
                        transform: translateY(20px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .load-more-btn {
                    position: relative;
                    overflow: hidden;
                }

                .load-more-btn.loading {
                    pointer-events: none;
                    opacity: 0.7;
                }

                .load-more-btn.loading .btn-icon {
                    display: inline-block;
                    animation: spin 1s linear infinite;
                }

                @keyframes spin {
                    from { transform: rotate(0deg); }
                    to { transform: rotate(360deg); }
                }

                /* Stagger animation untuk filter buttons */
                .filter-btn:nth-child(1) { animation-delay: 0.1s; }
                .filter-btn:nth-child(2) { animation-delay: 0.2s; }
                .filter-btn:nth-child(3) { animation-delay: 0.3s; }
                .filter-btn:nth-child(4) { animation-delay: 0.4s; }
                .filter-btn:nth-child(5) { animation-delay: 0.5s; }
            </style>

            <script>
                jQuery(document).ready(function($) {
                    // Intersection Observer untuk animasi scroll
                    const observerOptions = {
                        threshold: 0.1,
                        rootMargin: '0px 0px -50px 0px'
                    };

                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('show');
                            }
                        });
                    }, observerOptions);

                    // Observe semua elemen dengan class animate
                    document.querySelectorAll('.animate').forEach(el => observer.observe(el));

                    // Observe portfolio items
                    document.querySelectorAll('.portfolio-item').forEach((el, index) => {
                        el.style.setProperty('--item-index', index);
                        observer.observe(el);
                    });

                    // Isotope initialization
                    var $grid = $('.portfolio-grid').isotope({
                        itemSelector: '.portfolio-item',
                        layoutMode: 'fitRows',
                        percentPosition: true,
                        transitionDuration: '0.6s',
                        stagger: 30,
                        hiddenStyle: {
                            opacity: 0,
                            transform: 'translateY(20px)'
                        },
                        visibleStyle: {
                            opacity: 1,
                            transform: 'translateY(0)'
                        }
                    });

                    // Tunggu gambar dimuat
                    $grid.imagesLoaded().progress(function() {
                        $grid.isotope('layout');
                    });

                    // Filter buttons
                    $('.filter-btn').on('click', function() {
                        var filterValue = $(this).attr('data-filter');
                        $grid.isotope({ filter: filterValue });
                        $('.filter-btn').removeClass('active');
                        $(this).addClass('active');
                    });

                    // Load more functionality
                    $('.load-more-btn').on('click', function() {
                        var $this = $(this);
                        $this.addClass('loading');
                        
                        // Simulasi loading (ganti dengan AJAX call sesuai kebutuhan)
                        setTimeout(function() {
                            // Add new items (contoh)
                            var $newItems = $('<div class="portfolio-item">...</div>');
                            $grid.append($newItems)
                                .isotope('appended', $newItems);
                            
                            $this.removeClass('loading');
                        }, 1000);
                    });

                    // Refresh layout Isotope saat window resize
                    $(window).on('resize', function() {
                        $grid.isotope('layout');
                    });
                });
            </script>
            <?php
        } else {
            echo '<p>No portfolio items found.</p>';
        }
    }
}