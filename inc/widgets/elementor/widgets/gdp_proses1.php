<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class GDP_Proses1 extends Widget_Base {

    public function get_name() {
        return 'gdp-proses1';
    }

    public function get_title() {
        return 'GDP Proses 1';
    }

    public function get_icon() {
        return 'eicon-flow';
    }

    public function get_categories() {
        return ['gdp-widgets'];
    }

    public function get_script_depends() {
        return ['imagesloaded', 'aos'];
    }

    public function get_style_depends() {
        return ['animate-css', 'aos'];
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
                'default' => 'Our Process',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => 'Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'How we work to achieve great results',
                'label_block' => true,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => 'Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Process Step',
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => 'Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Description of the process step',
            ]
        );

        $repeater->add_control(
            'icon',
            [
                'label' => 'Icon',
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],
            ]
        );

        $this->add_control(
            'process_list',
            [
                'label' => 'Process Steps',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => 'Step 1',
                        'description' => 'Description of step 1',
                        'icon' => [
                            'value' => 'fas fa-lightbulb',
                            'library' => 'solid',
                        ],
                    ],
                    [
                        'title' => 'Step 2',
                        'description' => 'Description of step 2',
                        'icon' => [
                            'value' => 'fas fa-cogs',
                            'library' => 'solid',
                        ],
                    ],
                    [
                        'title' => 'Step 3',
                        'description' => 'Description of step 3',
                        'icon' => [
                            'value' => 'fas fa-check-circle',
                            'library' => 'solid',
                        ],
                    ],
                ],
                'title_field' => '{{{ title }}}',
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
                'name' => 'main_title_typography',
                'label' => 'Title Typography',
                'selector' => '{{WRAPPER}} .gdp-main-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'main_description_typography',
                'label' => 'Description Typography',
                'selector' => '{{WRAPPER}} .gdp-main-description',
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => 'Heading Color',
                'type' => Controls_Manager::COLOR,
                'default' => '#2B2B2B',
                'selectors' => [
                    '{{WRAPPER}} .gdp-main-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_description_color',
            [
                'label' => 'Description Color',
                'type' => Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .gdp-main-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'primary_color',
            [
                'label' => 'Primary Color',
                'type' => Controls_Manager::COLOR,
                'default' => '#4A90E2',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => 'Title Typography',
                'selector' => '{{WRAPPER}} .gdp-process-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => 'Description Typography',
                'selector' => '{{WRAPPER}} .gdp-process-description',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="gdp-process1 container mx-auto px-4">
            <!-- Heading Section -->
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="gdp-main-title text-4xl font-bold mb-4"><?php echo $settings['title']; ?></h2>
                <p class="gdp-main-description text-xl max-w-3xl mx-auto"><?php echo $settings['description']; ?></p>
            </div>

            <!-- Process Steps -->
            <div class="relative">
                <!-- Timeline Line -->
                <div class="hidden md:block absolute left-1/2 transform -translate-x-1/2 h-full">
                    <div class="w-1 bg-blue-500 h-full"></div>
                </div>

                <div class="flex flex-wrap">
                    <?php foreach ($settings['process_list'] as $index => $item) : 
                        $isEven = $index % 2 === 0;
                        $fadeDirection = $isEven ? 'fade-right' : 'fade-left';
                    ?>
                        <div class="w-full md:w-1/2 <?php echo $isEven ? 'md:pr-16' : 'md:pl-16 md:ml-auto'; ?> mb-12 relative" data-aos="<?php echo $fadeDirection; ?>" data-aos-delay="<?php echo $index * 100; ?>">
                            <!-- Arrow -->
                            <div class="hidden md:block absolute <?php echo $isEven ? 'right-0' : 'left-0'; ?> top-1/2 transform -translate-y-1/2 <?php echo $isEven ? '-translate-x-1/2' : 'translate-x-1/2'; ?>">
                                <div class="w-8 h-8 bg-blue-500 rotate-45 transform <?php echo $isEven ? '-translate-x-1/2' : 'translate-x-1/2'; ?>"></div>
                            </div>

                            <!-- Timeline Dot -->
                            <div class="hidden md:block absolute <?php echo $isEven ? 'right-0' : 'left-0'; ?> top-1/2 transform -translate-y-1/2 <?php echo $isEven ? 'translate-x-1/2' : '-translate-x-1/2'; ?>">
                                <div class="w-4 h-4 bg-blue-500 rounded-full border-4 border-white"></div>
                            </div>

                            <!-- Content Box -->
                            <div class="gdp-process-item bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                                <div class="gdp-process-icon text-4xl mb-4 animate__animated animate__bounceIn" style="color: <?php echo $settings['primary_color']; ?>">
                                    <?php \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true']); ?>
                                </div>
                                <h3 class="gdp-process-title text-xl font-bold mb-2"><?php echo $item['title']; ?></h3>
                                <p class="gdp-process-description text-gray-600"><?php echo $item['description']; ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <style>
            .gdp-process1 .gdp-process-item {
                position: relative;
                z-index: 1;
            }
            
            @media (min-width: 768px) {
                .gdp-process1 .timeline-arrow::before {
                    content: '';
                    position: absolute;
                    width: 20px;
                    height: 20px;
                    background: inherit;
                    transform: rotate(45deg);
                }
            }
        </style>
        <script>
        jQuery(document).ready(function($) {
            $('.gdp-process1').imagesLoaded(function() {
                AOS.init({
                    duration: 1000,
                    once: true,
                    offset: 100,
                });
            });
        });
        </script>
        <?php
    }
}