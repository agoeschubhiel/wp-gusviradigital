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

class Gdp_service2 extends Widget_Base {

    public function get_name() {
        return 'gdp_service2';
    }

    public function get_title() {
        return 'GDP Interactive Services';
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return ['gdp-category'];
    }

    public function get_script_depends() {
        return ['gsap'];
    }

    public function get_style_depends() {
        return ['animate-css'];
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
            'title',
            [
                'label' => 'Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Our Creative Services',
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => 'Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'We offer a wide range of creative services to help your business thrive in the digital world.',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'service_icon',
            [
                'label' => 'Service Icon',
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
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
            'service_link',
            [
                'label' => 'Service Link',
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $this->add_control(
            'services',
            [
                'label' => 'Services',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'service_icon' => [
                            'value' => 'fas fa-palette',
                            'library' => 'solid',
                        ],
                        'service_title' => 'Graphic Design',
                        'service_description' => 'Create stunning visuals that captivate your audience.',
                        'service_link' => [
                            'url' => '#',
                        ],
                    ],
                    [
                        'service_icon' => [
                            'value' => 'fas fa-code',
                            'library' => 'solid',
                        ],
                        'service_title' => 'Web Development',
                        'service_description' => 'Build responsive and user-friendly websites.',
                        'service_link' => [
                            'url' => '#',
                        ],
                    ],
                    [
                        'service_icon' => [
                            'value' => 'fas fa-bullhorn',
                            'library' => 'solid',
                        ],
                        'service_title' => 'Digital Marketing',
                        'service_description' => 'Boost your online presence and reach your target audience.',
                        'service_link' => [
                            'url' => '#',
                        ],
                    ],
                ],
                'title_field' => '{{{ service_title }}}',
            ]
        );

        $this->end_controls_section();

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
                'selector' => '{{WRAPPER}} .gdp-services-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => 'Description Typography',
                'selector' => '{{WRAPPER}} .gdp-services-description',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'service_title_typography',
                'label' => 'Service Title Typography',
                'selector' => '{{WRAPPER}} .gdp-service-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'service_description_typography',
                'label' => 'Service Description Typography',
                'selector' => '{{WRAPPER}} .gdp-service-description',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="gdp-services-container py-16 px-4">
            <div class="max-w-6xl mx-auto">
                <h2 class="gdp-services-title text-4xl font-bold text-center mb-4 animate__animated animate__fadeInDown"><?php echo $settings['title']; ?></h2>
                <p class="gdp-services-description text-xl text-center mb-12 animate__animated animate__fadeInUp"><?php echo $settings['description']; ?></p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($settings['services'] as $index => $service) : 
                        $link_url = $service['service_link']['url'];
                        $link_target = $service['service_link']['is_external'] ? ' target="_blank"' : '';
                        $link_nofollow = $service['service_link']['nofollow'] ? ' rel="nofollow"' : '';
                    ?>
                        <div class="gdp-service-card bg-white rounded-lg shadow-lg overflow-hidden transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                            <a href="<?php echo esc_url($link_url); ?>"<?php echo $link_target . $link_nofollow ; ?>>
                                <div class="gdp-service-icon px-8 text-4xl text-blue-500 mb-4">
                                    <?php \Elementor\Icons_Manager::render_icon($service['service_icon'], ['aria-hidden' => 'true']); ?>
                                </div>
                                <h3 class="gdp-service-title px-8 text-2xl font-bold mb-4">
                                    <?php echo $service['service_title']; ?>
                                </h3>
                                <p class="gdp-service-description px-6 text-lg text-gray-600 mb-8">
                                    <?php echo $service['service_description']; ?>
                                </p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php
    }
}