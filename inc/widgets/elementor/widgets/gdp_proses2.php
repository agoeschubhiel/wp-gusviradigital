<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class GDP_Proses2 extends Widget_Base {

    public function get_name() {
        return 'gdp-proses2';
    }

    public function get_title() {
        return 'GDP Proses 2';
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
        // Heading Section
        $this->start_controls_section(
            'section_heading',
            [
                'label' => 'Heading',
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

        $this->end_controls_section();

        // Process Steps Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => 'Process Steps',
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'step_number',
            [
                'label' => 'Step Number',
                'type' => Controls_Manager::TEXT,
                'default' => '01',
            ]
        );

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
                        'step_number' => '01',
                        'title' => 'Discovery',
                        'description' => 'Initial consultation and project scoping',
                        'icon' => ['value' => 'fas fa-search'],
                    ],
                    [
                        'step_number' => '02',
                        'title' => 'Planning',
                        'description' => 'Strategic planning and resource allocation',
                        'icon' => ['value' => 'fas fa-tasks'],
                    ],
                    [
                        'step_number' => '03',
                        'title' => 'Execution',
                        'description' => 'Implementation and development phase',
                        'icon' => ['value' => 'fas fa-cogs'],
                    ],
                    [
                        'step_number' => '04',
                        'title' => 'Delivery',
                        'description' => 'Final delivery and project handover',
                        'icon' => ['value' => 'fas fa-check-circle'],
                    ],
                ],
                'title_field' => '{{{ title }}}',
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

        $this->add_control(
            'primary_color',
            [
                'label' => 'Primary Color',
                'type' => Controls_Manager::COLOR,
                'default' => '#4A90E2',
                'selectors' => [
                    '{{WRAPPER}} .gdp-process-timeline' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .gdp-process-number' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .gdp-process-dot' => 'background-color: {{VALUE}};',
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

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="gdp-process2 container mx-auto px-4 py-12">
            <!-- Heading Section -->
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl font-bold mb-4"><?php echo $settings['title']; ?></h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto"><?php echo $settings['description']; ?></p>
            </div>

            <!-- Timeline Container -->
            <div class="relative">
                <!-- Vertical Timeline Line -->
                <div class="hidden md:block absolute left-1/2 transform -translate-x-1/2 h-full">
                    <div class="gdp-process-timeline w-1 h-full bg-blue-500"></div>
                </div>

                <!-- Process Steps -->
                <?php foreach ($settings['process_list'] as $index => $item) : 
                    $isEven = $index % 2 === 0;
                    $fadeDirection = $isEven ? 'fade-right' : 'fade-left';
                    $stepNumber = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                ?>
                    <div class="relative flex md:flex-row flex-col mb-16" data-aos="<?php echo $fadeDirection; ?>" data-aos-delay="<?php echo $index * 100; ?>">
                        <!-- Timeline Number Circle -->
                        <div class="hidden md:flex absolute left-1/2 transform -translate-x-1/2 z-10">
                            <div class="gdp-process-number w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold border-4 border-white">
                                <?php echo $stepNumber; ?>
                            </div>
                        </div>

                        <!-- Content Box -->
                        <div class="w-full md:w-5/12 <?php echo $isEven ? 'md:pr-16' : 'md:pl-16 md:ml-auto'; ?>">
                            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-all duration-300">
                                <!-- Mobile Number (visible only on mobile) -->
                                <div class="md:hidden w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold mb-4 mx-auto">
                                    <?php echo $stepNumber; ?>
                                </div>
                                
                                <div class="gdp-process-icon text-4xl mb-4 animate__animated animate__bounceIn">
                                    <?php \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true']); ?>
                                </div>
                                <h3 class="gdp-process-title text-2xl font-bold mb-2"><?php echo $item['title']; ?></h3>
                                <p class="gdp-process-description text-gray-600"><?php echo $item['description']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <style>
            .gdp-process2 .gdp-process-item {
                position: relative;
                z-index: 1;
            }
            
            .gdp-process2 .gdp-process-number {
                box-shadow: 0 0 0 4px #fff;
            }
            
            /* Hover effect for process boxes */
            .gdp-process2 .bg-white:hover {
                transform: translateY(-5px);
            }
            
            /* Timeline line style */
            .gdp-process-timeline {
                position: absolute;
                left: 50%;
                transform: translateX(-50%);
                width: 2px;
                background-color: #4A90E2;
                height: calc(100% - 50px);
                margin-top: 25px;
            }
            
            @media (max-width: 768px) {
                .gdp-process-timeline {
                    display: none;
                }
            }
        </style>

        <script>
        jQuery(document).ready(function($) {
            $('.gdp-process2').imagesLoaded(function() {
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