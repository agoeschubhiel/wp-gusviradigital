<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Repeater;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class GDP_Proses3 extends Widget_Base {

    public function get_name() {
        return 'gdp-proses3';
    }

    public function get_title() {
        return 'GDP Proses 3';
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
        // Content Section
        $this->start_controls_section(
            'section_content',
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
            'step_title',
            [
                'label' => 'Step Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Step Title',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'step_description',
            [
                'label' => 'Step Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Step Description',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'step_icon',
            [
                'label' => 'Step Icon',
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],
            ]
        );

        $repeater->add_control(
            'step_color',
            [
                'label' => 'Step Color',
                'type' => Controls_Manager::COLOR,
                'default' => '#4A90E2',
            ]
        );

        $this->add_control(
            'steps',
            [
                'label' => 'Process Steps',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'step_title' => 'Research',
                        'step_description' => 'We conduct thorough research to understand your needs.',
                        'step_icon' => ['value' => 'fas fa-search'],
                        'step_color' => '#4A90E2',
                    ],
                    [
                        'step_title' => 'Plan',
                        'step_description' => 'We create a detailed plan tailored to your goals.',
                        'step_icon' => ['value' => 'fas fa-tasks'],
                        'step_color' => '#27AE60',
                    ],
                    [
                        'step_title' => 'Execute',
                        'step_description' => 'We implement the plan with precision and care.',
                        'step_icon' => ['value' => 'fas fa-cogs'],
                        'step_color' => '#E67E22',
                    ],
                    [
                        'step_title' => 'Deliver',
                        'step_description' => 'We deliver outstanding results that exceed expectations.',
                        'step_icon' => ['value' => 'fas fa-check-circle'],
                        'step_color' => '#8E44AD',
                    ],
                ],
                'title_field' => '{{{ step_title }}}',
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
            'layout',
            [
                'label' => 'Layout',
                'type' => Controls_Manager::SELECT,
                'default' => 'vertical',
                'options' => [
                    'vertical' => 'Vertical',
                    'horizontal' => 'Horizontal',
                ],
            ]
        );

        $this->add_control(
            'animation_effect',
            [
                'label' => 'Animation Effect',
                'type' => Controls_Manager::SELECT,
                'default' => 'fade-up',
                'options' => [
                    'fade-up' => 'Fade Up',
                    'fade-down' => 'Fade Down',
                    'fade-left' => 'Fade Left',
                    'fade-right' => 'Fade Right',
                    'zoom-in' => 'Zoom In',
                    'zoom-out' => 'Zoom Out',
                    'flip-left' => 'Flip Left',
                    'flip-right' => 'Flip Right',
                ],
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

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => 'Box Shadow',
                'selector' => '{{WRAPPER}} .gdp-process-item',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'label' => 'Border',
                'selector' => '{{WRAPPER}} .gdp-process-item',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => 'Border Radius',
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .gdp-process-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $layout_class = $settings['layout'] === 'horizontal' ? 'flex-row' : 'flex-col';
        ?>
        <div class="gdp-process3 container mx-auto px-4 py-12">
            <!-- Heading Section -->
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl font-bold mb-4"><?php echo $settings['title']; ?></h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto"><?php echo $settings['description']; ?></p>
            </div>

            <!-- Process Steps -->
            <div class="relative <?php echo $layout_class; ?>">
                <!-- Vertical Timeline Line -->
                <div class="hidden md:block absolute left-1/2 transform -translate-x-1/2 w-1 bg-gray-200 h-full"></div>

                <?php foreach ($settings['steps'] as $index => $step) : 
                    $isEven = $index % 2 === 0;
                    $fadeDirection = $isEven ? 'fade-right' : 'fade-left';
                    $stepNumber = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                ?>
                    <div class="relative flex <?php echo $layout_class; ?> mb-16" data-aos="<?php echo $fadeDirection; ?>" data-aos-delay="<?php echo $index * 100; ?>">
                        <!-- Timeline Number Circle -->
                        <div class="hidden md:flex absolute left-1/2 transform -translate-x-1/2 z-10">
                            <div class="gdp-process-number w-12 h-12 bg-<?php echo $step['step_color']; ?> rounded-full flex items-center justify-center text-white font-bold border-4 border-white">
                                <?php echo $stepNumber; ?>
                            </div>
                        </div>

                        <!-- Content Box -->
                        <div class="w-full md:w-5/12 <?php echo $isEven ? 'md:pr-16' : 'md:pl-16 md:ml-auto'; ?>">
                            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-all duration-300">
                                <!-- Mobile Number (visible only on mobile) -->
                                <div class="md:hidden w-8 h-8 bg-<?php echo $step['step_color']; ?> rounded-full flex items-center justify-center text-white font-bold mb-4 mx-auto">
                                    <?php echo $stepNumber; ?>
                                </div>
                                
                                <div class="gdp-process-icon text-4xl mb-4 animate__animated animate__bounceIn" style="color: <?php echo $step['step_color']; ?>">
                                    <?php \Elementor\Icons_Manager::render_icon($step['step_icon'], ['aria-hidden' => 'true']); ?>
                                </div>
                                <h3 class="gdp-process-title text-2xl font-bold mb-2"><?php echo $step['step_title']; ?></h3>
                                <p class="gdp-process-description text-gray-600"><?php echo $step['step_description']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <style>
            .gdp-process3 .gdp-process-item {
                position: relative;
                z-index: 1;
            }
            
            .gdp-process3 .gdp-process-number {
                box-shadow: 0 0 0 4px #fff;
            }
            
            /* Hover effect for process boxes */
            .gdp-process3 .bg-white:hover {
                transform: translateY(-5px);
            }

            /* Vertical timeline line */
            .gdp-process3 .relative::before {
                content: '';
                position: absolute;
                left: 50%;
                transform: translateX(-50%);
                width: 2px;
                background-color: #e5e7eb;
                height: calc(100% - 50px);
                top: 25px;
            }

            @media (max-width: 768px) {
                .gdp-process3 .relative::before {
                    display: none;
                }
            }
        </style>

        <script>
        jQuery(document).ready(function($) {
            $('.gdp-process3').imagesLoaded(function() {
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