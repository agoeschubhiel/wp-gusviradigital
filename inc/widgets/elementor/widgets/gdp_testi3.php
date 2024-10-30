<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class GDP_Testi3 extends Widget_Base {
    public function get_name() { return 'gdp-testimonials3'; }
    public function get_title() { return 'GDP Testimonials 3'; }
    public function get_icon() { return 'eicon-testimonial-carousel'; }
    public function get_categories() { return ['gdp-widgets']; }

    public function get_script_depends() {
        return ['isotope', 'gsap', 'scrolltrigger'];
    }

    public function get_style_depends() {
        return ['animate-css'];
    }

    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'section_content',
            [
                'label' => 'Content',
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label' => 'Section Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'What Our Clients Say',
            ]
        );

        $this->add_control(
            'testimonials',
            [
                'label' => 'Testimonials',
                'type' => Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'client_name',
                        'label' => 'Client Name',
                        'type' => Controls_Manager::TEXT,
                        'default' => 'John Doe',
                    ],
                    [
                        'name' => 'client_position',
                        'label' => 'Client Position',
                        'type' => Controls_Manager::TEXT,
                        'default' => 'CEO, Company Inc.',
                    ],
                    [
                        'name' => 'client_feedback',
                        'label' => 'Feedback',
                        'type' => Controls_Manager::TEXTAREA,
                        'default' => 'This is a fantastic service! Highly recommend it.',
                    ],
                    [
                        'name' => 'client_image',
                        'label' => 'Client Image',
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => 'https://example.com/client-image.jpg',
                        ],
                    ],
                    [
                        'name' => 'client_rating',
                        'label' => 'Rating',
                        'type' => Controls_Manager::NUMBER,
                        'min' => 1,
                        'max' => 5,
                        'step' => 0.1,
                        'default' => 5,
                    ],
                    [
                        'name' => 'category',
                        'label' => 'Category',
                        'type' => Controls_Manager::SELECT,
                        'options' => [
                            'all' => 'All',
                            'product' => 'Product',
                            'service' => 'Service',
                            'support' => 'Support',
                        ],
                        'default' => 'all',
                    ],
                ],
                'title_field' => '{{{ client_name }}}',
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style',
            [
                'label' => 'Style',
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => 'Background Color',
                'type' => Controls_Manager::COLOR,
                'default' => '#f9f9f9',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => 'Text Color',
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => 'Content Typography',
                'selector' => '{{WRAPPER}} .gdp-testimonials3 .testimonial-content',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'testimonial_box_shadow',
                'label' => 'Box Shadow',
                'selector' => '{{WRAPPER}} .gdp-testimonials3 .testimonial-item',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="gdp-testimonials3 py-16 lg:py-24" style="background-color: <?php echo esc_attr($settings['background_color']); ?>" data-aos="fade-up">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-center mb-12 text-<?php echo esc_attr($settings['text_color']); ?> animate__animated animate__fadeIn">
                    <?php echo esc_html($settings['section_title']); ?>
                </h2>

                <div class="testimonial-filters mb-8 text-center">
                    <button class="filter-btn active" data-filter="*">All</button>
                    <button class="filter-btn" data-filter=".product">Product</button>
                    <button class="filter-btn" data-filter=".service">Service</button>
                    <button class="filter-btn" data-filter=".support">Support</button>
                </div>

                <div class="testimonial-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($settings['testimonials'] as $index => $testimonial) : ?>
                        <div class="testimonial-item <?php echo esc_attr($testimonial['category']); ?> bg-white p-6 rounded-lg shadow-lg transition-all duration-300 hover:shadow-xl" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                            <div class="testimonial-header flex items-center mb-4">
                                <img src="<?php echo esc_url($testimonial['client_image']['url']); ?>" alt="<?php echo esc_attr($testimonial['client_name']); ?>" class="w-16 h-16 rounded-full mr-4 object-cover">
                                <div>
                                    <h3 class="text-lg font-semibold"><?php echo esc_html($testimonial['client_name']); ?></h3>
                                    <p class="text-sm text-gray-600"><?php echo esc_html($testimonial['client_position']); ?></p>
                                </div>
                            </div>
                            <div class="testimonial-content mb-4">
                                <p class="text-<?php echo esc_attr($settings['text_color']); ?>"><?php echo esc_html($testimonial ['client_feedback']); ?></p>
                            </div>
                            <div class="testimonial-footer flex items-center">
                                <div class="rating flex items-center">
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                        <i class="fas fa-star <?php echo $i <= $testimonial['client_rating'] ? 'text-yellow-400' : 'text-gray-400'; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <script>
            $(document).ready(function($) {
                var $grid = $('.testimonial-grid');
                var iso = new Isotope($grid[0], {
                    itemSelector: '.testimonial-item',
                    layoutMode: 'fitRows'
                });

                $('.filter-btn').on('click', function() {
                    $('.filter-btn').removeClass('active');
                    $(this).addClass('active');
                    iso.arrange({ filter: $(this).attr('data-filter') });
                });
            });
        </script>
        <?php
    }
}