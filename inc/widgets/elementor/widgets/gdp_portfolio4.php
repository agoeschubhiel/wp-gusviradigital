<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class GDP_Portfolio4 extends Widget_Base {

    public function get_name() {
        return 'gdp-portfolio4';
    }

    public function get_title() {
        return 'GDP Portfolio 4';
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return ['gdp-widgets'];
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
                'default' => 'grid',
                'options' => [
                    'grid' => 'Grid',
                    'masonry' => 'Masonry',
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

        // Filter Style Section
        $this->start_controls_section(
            'filter_style_section',
            [
                'label' => 'Filter Style',
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_filters' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'filter_typography',
                'label' => 'Filter Typography',
                'selector' => '{{WRAPPER}} .filter-btn',
            ]
        );

        $this->add_control(
            'filter_color',
            [
                'label' => 'Filter Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .filter-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_active_color',
            [
                'label' => 'Filter Active Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .filter-btn.active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'filter_background',
                'label' => 'Filter Background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .filter-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'filter_active_background',
                'label' => 'Filter Active Background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .filter-btn.active',
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
            'orderby' => ' date',
            'order' => 'DESC',
        ];

        $portfolio_query = new \WP_Query($args);

        if ($portfolio_query->have_posts()) {
            ?>
            <div class="gdp-portfolio-4">
                <?php if ($settings['show_filters']) : ?>
                    <div class="filter-container mb-8 text-center" data-aos="fade-up">
                        <button class="filter-btn active" data-filter="*">All</button>
                        <?php
                        $categories = get_terms(['taxonomy' => 'portfolio_category', 'hide_empty' => true]);
                        foreach ($categories as $category) {
                            echo '<button class="filter-btn" data-filter=".' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</button>';
                        }
                        ?>
                    </div>
                <?php endif; ?>

                <div class="portfolio-grid" data-aos="fade-up" data-aos-delay="200">
                    <?php
                    while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
                        $categories = get_the_terms(get_the_ID(), 'portfolio_category');
                        $category_classes = '';
                        if ($categories) {
                            $category_slugs = wp_list_pluck($categories, 'slug');
                            $category_classes = implode(' ', $category_slugs);
                        }
                        ?>
                        <div class="portfolio-item <?php echo esc_attr($category_classes); ?>" data-aos="fade-up">
                            <div class="portfolio-item-inner">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="portfolio-image">
                                        <?php the_post_thumbnail('large'); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="portfolio-info">
                                    <h3><?php the_title(); ?></h3>
                                    <?php if ($categories) : ?>
                                        <div class="portfolio-category">
                                            <?php echo esc_html($categories[0]->name); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>

                <?php if ($settings['show_load_more']) : ?>
                    <div class="load-more-container text-center mt-8">
                        <button class="load-more-btn" data-aos="fade-up">Load More</button>
                    </div>
                <?php endif; ?>
            </div>

            <script>
                jQuery(document).ready(function($) {
                    var $grid = $('.portfolio-grid').isotope({
                        itemSelector: '.portfolio-item',
                        layoutMode: 'fitRows',
                        percentPosition: true,
                        masonry: {
                            columnWidth: '.portfolio-item'
                        }
                    });

                    $grid.imagesLoaded().progress(function() {
                        $grid.isotope('layout');
                    });

                    $('.filter-container').on('click', '.filter-btn', function() {
                        var filterValue = $(this).attr('data-filter');
                        $('.filter-btn').removeClass('active');
                        $(this).addClass('active');
                        $grid.isotope({ filter: filterValue });
                    });

                    $('.load-more-btn').on('click', function() {
                        // Implement load more functionality here
                        // This could involve an AJAX call to load more items
                        console.log('Load more clicked');
                    });

                    $(window).on('resize', function() {
                        $grid.isotope('layout');
                    });

                    AOS.init({
                        duration: 1000,
                        once: true,
                        mirror: false
                    });
                });
            </script>

            <style>
                .gdp-portfolio-4 {
                    --item-gap: <?php echo $settings['item_gap']['size'] . $settings['item_gap']['unit']; ?>;
                }

                .portfolio-grid {
                    display: flex;
                    flex-wrap: wrap;
                    margin: calc(-1 * var(--item-gap));
                }

                .portfolio-item {
                    width: calc(100% / <?php echo $settings['columns']; ?> - (var(--item-gap) * 2));
                    margin: var(--item-gap);
                }

                .portfolio-item-inner {
                    position: relative;
                    overflow: hidden;
                    border-radius: 8px;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                    transition: all 0.3s ease;
                }

                .portfolio-item-inner:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
                }

                .portfolio-image img {
                    width: 100%;
                    height: auto;
                    display: block;
                    transition: transform 0.3s ease;
                }

                .portfolio-item-inner:hover .portfolio-image img {
                    transform: scale(1.1);
                }

                .portfolio-info {
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    padding: 20px;
                    background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0));
                    color: #fff;
                    opacity: 0;
                    transition: opacity 0.3s ease;
                }

                .portfolio-item-inner:hover .portfolio-info {
                    opacity: 1;
                }

                .portfolio-info h3 {
                    margin: 0 0 5px;
                    font-size: 18px;
                }

                .portfolio-category {
                    font-size: 14px;
                    opacity: 0.8;
                }

                .filter-container {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                    margin-bottom: 30px;
                }

                .filter-btn {
                    padding: 8px 16px;
                    margin: 0 5px 10px;
                    background-color: #f0f0f0;
                    border: none;
                    border-radius: 20px;
                    cursor: pointer;
                    transition: all 0.3s ease;
                }

                .filter-btn.active,
                .filter-btn:hover {
                    background-color: #007bff;
                    color: #fff;
                }

                .load-more-btn {
                    padding: 10px 20px;
                    background-color: #007bff;
                    color: #fff;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                 }

                .load-more-btn:hover {
                    background-color: #0069d9;
                }
            </style>
        <?php
        }
    }
}