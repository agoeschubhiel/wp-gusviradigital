<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Gdp_service5 extends Widget_Base {

    public function get_name() {
        return 'gdp_service5';
    }

    public function get_title() {
        return 'GDP Service Showcase';
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return ['gdp-category'];
    }

    protected function register_controls() {
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
                'default' => 'Our Innovative Services',
            ]
        );

        $this->add_control(
            'section_subtitle',
            [
                'label' => 'Section Subtitle',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Discover our cutting-edge solutions',
            ]
        );

        $repeater = new Repeater();

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
            'service_icon',
            [
                'label' => 'Icon',
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],
            ]
        );

        $repeater->add_control(
            'service_image',
            [
                'label' => 'Background Image',
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
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
                        'service_title' => 'AI Solutions',
                        'service_description' => 'Cutting-edge AI integration for your business needs.',
                    ],
                    [
                        'service_title' => 'Blockchain Development',
                        'service_description' => 'Secure and innovative blockchain solutions.',
                    ],
                    [
                        'service_title' => 'IoT Integration',
                        'service_description' => 'Connect and optimize your devices with IoT.',
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
                'label' => 'Title Typography',
                'selector' => '{{WRAPPER}} .gdp-service-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => 'Description Typography',
                'selector' => '{{WRAPPER}} .gdp-service-description',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'section_background',
                'label' => 'Section Background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .gdp-service-showcase',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="gdp-service-showcase py-24">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="gdp-service-title text-4xl md:text-5xl font-extrabold mb-4" data-aos="fade-up">
                        <?php echo wp_kses_post($settings['section_title']); ?>
                    </h2>
                    <p class="gdp-service-description text-xl text-gray-600" data-aos="fade-up" data-aos-delay="100">
                        <?php echo wp_kses_post($settings['section_subtitle']); ?>
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($settings['services_list'] as $index => $service) : ?>
                        <div class="gdp-service-card" data-aos="flip-left" data-aos-delay="<?php echo $index * 100; ?>">
                            <div class="gdp-service-card-inner">
                                <div class="gdp-service-card-front" style="background-image: url('<?php echo $service['service_image']['url']; ?>');">
                                    <div class="gdp-service-card-content">
                                        <div class="text-4xl mb-4">
                                            <?php \Elementor\Icons_Manager::render_icon( $service['service_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                        </div>
                                        <h3 class="text-2xl font-bold mb-2"><?php echo wp_kses_post($service['service_title']); ?></h3>
                                    </div>
                                </div>
                                <div class="gdp-service-card-back">
                                    <div class="gdp-service-card-content">
                                        <h3 class="text-2xl font-bold mb-4"><?php echo wp_kses_post($service['service_title']); ?></h3>
                                        <p class="mb- 4"><?php echo wp_kses_post($service['service_description']); ?></p>
                                        <?php if (!empty($service['button_text'])) : ?>
                                            <a href="<?php echo esc_url($service['button_link']['url']); ?>" 
                                               class="inline-block bg-purple-600 text-white py-2 px-4 rounded-full hover:bg-purple-700 transition-colors duration-300">
                                                <?php echo esc_html($service['button_text']); ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <script>
        jQuery(document).ready(function($) {
            AOS.init({
                duration: 1000,
                once: true,
            });
        });
        </script>
        <?php
    }
}