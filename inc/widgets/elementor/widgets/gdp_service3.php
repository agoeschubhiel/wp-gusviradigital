<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Utils;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Gdp_service3 extends Widget_Base {

    public function get_name() {
        return 'gdp_service3';
    }

    public function get_title() {
        return 'GDP Modern Services';
    }

    public function get_icon() {
        return 'eicon-columns';
    }

    public function get_categories() {
        return ['gdp-category'];
    }

    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'content_section',
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
                'default' => 'Our Premium Services',
            ]
        );

        $this->add_control(
            'section_subtitle',
            [
                'label' => 'Section Subtitle',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Discover how we can help transform your business',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'service_image',
            [
                'label' => 'Service Image',
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'service_title',
            [
                'label' => 'Service Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Service Title',
            ]
        );

        $repeater->add_control(
            'service_description',
            [
                'label' => 'Service Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Service description goes here.',
            ]
        );

        $repeater->add_control(
            'service_price',
            [
                'label' => 'Starting Price',
                'type' => Controls_Manager::TEXT,
                'default' => '$999',
            ]
        );

        $repeater->add_control(
            'button_text',
            [
                'label' => 'Button Text',
                'type' => Controls_Manager::TEXT,
                'default' => 'Learn More',
            ]
        );

        $repeater->add_control(
            'button_link',
            [
                'label' => 'Button Link',
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'services_list',
            [
                'label' => 'Services',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'service_title' => 'Brand Strategy',
                        'service_description' => 'Develop a comprehensive brand strategy that sets you apart from competitors.',
                        'service_price' => '$1,499',
                        'button_text' => 'Learn More',
                    ],
                    [
                        'service_title' => 'Web Development',
                        'service_description' => 'Custom web solutions built with the latest technologies.',
                        'service_price' => '$2,999',
                        'button_text' => 'Learn More',
                    ],
                    [
                        'service_title' => 'Digital Marketing',
                        'service_description' => 'Results-driven digital marketing campaigns.',
                        'service_price' => '$999',
                        'button_text' => 'Learn More',
                    ],
                ],
                'title_field' => '{{{ service_title }}}',
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => 'Style',
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => 'Section Title Typography',
                'selector' => '{{WRAPPER}} .gdp-section-title',
            ]
        );

        $this->end_controls_section();
    }

    protected function render () {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="gdp-services-section bg-gradient-to-br from-gray-900 to-blue-900 py-20 relative overflow-hidden">
            <!-- Animated Background -->
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-pattern opacity-10"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent"></div>
            </div>

            <div class="container mx-auto px-4 relative z-10">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <h2 class="gdp-section-title text-5xl font-bold text-white mb-6 opacity-0 transform translate-y-8" 
                        data-aos="fade-up">
                        <?php echo wp_kses_post($settings['section_title']); ?>
                    </h2>
                    <p class="text-xl text-gray-300 max-w-3xl mx-auto opacity-0 transform translate-y-8" 
                        data-aos="fade-up" data-aos-delay="200">
                        <?php echo wp_kses_post($settings['section_subtitle']); ?>
                    </p>
                </div>

                <!-- Services Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($settings['services_list'] as $index => $service) : 
                        $link_url = $service['button_link']['url'];
                        $link_target = $service['button_link']['is_external'] ? ' target="_blank"' : '';
                        $link_nofollow = $service['button_link']['nofollow'] ? ' rel="nofollow"' : '';
                    ?>
                        <div class="service-card group" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                            <div class="relative overflow-hidden bg-white rounded-2xl transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                                <!-- Service Image -->
                                <div class="relative h-64 overflow-hidden">
                                    <img src="<?php echo esc_url($service['service_image']['url']); ?>" 
                                         alt="<?php echo wp_kses_post($service['service_title']); ?>"
                                         class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70  to-transparent"></div>
                                </div>

                                <!-- Service Content -->
                                <div class="p-8 relative">
                                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                                        <?php echo wp_kses_post($service['service_title']); ?>
                                    </h3>
                                    <p class="text-gray-600 mb-8">
                                        <?php echo wp_kses_post($service['service_description']); ?>
                                    </p>
                                    <div class="flex justify-between items-center mb-4">
                                        <span class="text-lg font-bold text-gray-900">
                                            <?php echo wp_kses_post($service['service_price']); ?>
                                        </span>
                                        <a href="<?php echo esc_url($link_url); ?>" 
                                           class="inline-block py-2 px-4 bg-orange-500 hover:bg-orange-700 text-white font-bold rounded-lg transition-all duration-300"
                                           <?php echo $link_target . $link_nofollow; ?>>
                                            <?php echo wp_kses_post($service['button_text']); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php
    }
}