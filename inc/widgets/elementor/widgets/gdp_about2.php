<?php

namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Gdp_about2 extends Widget_Base {

    public function get_name() {
        return 'gdp_about2';
    }

    public function get_title() {
        return 'GDP About Section 2';
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
                'default' => 'About Our Agency',
            ]
        );

        $this->add_control(
            'section_description',
            [
                'label' => 'Section Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'We are a creative agency passionate about bringing your ideas to life.',
            ]
        );

        $this->add_control(
            'company_image',
            [
                'label' => 'Company Image',
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'company_image',
                'default' => 'large',
                'separator' => 'none',
            ]
        );

        // Milestones
        $repeater = new Repeater();

        $repeater->add_control(
            'year',
            [
                'label' => 'Year',
                'type' => Controls_Manager::TEXT,
                'default' => '2023',
            ]
        );

        $repeater->add_control(
            'milestone',
            [
                'label' => 'Milestone',
                'type' => Controls_Manager::TEXT,
                'default' => 'Reached 1000+ clients',
            ]
        );

        $this->add_control(
            'milestones',
            [
                'label' => 'Milestones',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'year' => '2020',
                        'milestone' => 'Founded our agency',
                    ],
                    [
                        'year' => '2022',
                        'milestone' => 'Expanded to 3 countries',
                    ],
                ],
                'title_field' => '{{{ year }}} - {{{ milestone }}}',
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
                'selector' => '{{WRAPPER}} .gdp-section-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => 'Description Typography',
                'selector' => '{{WRAPPER}} .gdp-section-description',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="gdp-about-section-2 bg-gray-100 py-20">
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap items-center">
                    <div class="w-full lg:w-1/2 mb-12 lg:mb-0">
                        <div class="relative">
                            <?php echo Group_Control_Image_Size::get_attachment_image_html($settings, 'company_image'); ?>
                            <div class="absolute -bottom-10 -right-10 bg-white p-8 shadow-lg animate__animated animate__fadeInUp">
                                <h3 class="text-2xl font-bold mb-4">Our Experience</h3>
                                <p class="text-gray-600">10+ years in creative industry</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-full lg:w-1/2 lg:pl-16">
                        <h2 class="gdp-section-title text-4xl font-bold mb-6 animate__animated animate__fadeInRight"><?php echo $settings['section_title']; ?></h2>
                        <p class="gdp-section-description text-xl text-gray-600 mb-10 animate__animated animate__fadeInRight" data-wow-delay="0.2s"><?php echo $settings['section_description']; ?></p>
                        
                        <div class="gdp-milestones relative">
                            <!-- Timeline line -->
                            <div class="absolute left-9 top-0 bottom-0 w-0.5 bg-blue-500"></div>
                            
                            <?php foreach ($settings['milestones'] as $index => $milestone) : ?>
                                <div class="flex items-center mb-8 relative animate__animated animate__fadeInRight" data-wow-delay="<?php echo 0.2 * ($index + 1); ?>s">
                                    <div class="w-20 h-20 bg-blue-500 text-white rounded-full flex items-center justify-center text-2xl font-bold mr-6 z-10">
                                        <?php echo $milestone['year']; ?>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg shadow-md flex-1">
                                        <p class="text-lg"><?php echo $milestone['milestone']; ?></p>
                                    </div>
                                    <!-- Timeline dot -->
                                    <div class="absolute left-9 w-3 h-3 bg-blue-700 rounded-full transform -translate-x-1/2"></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            @media (max-width: 768px) {
                .gdp-milestones .absolute {
                    left: 10px;
                }
                .gdp-milestones .w-20 {
                    width: 60px;
                    height: 60px;
                    font-size: 1rem;
                }
                .gdp-milestones .mr-6 {
                    margin-right: 1rem;
                }
            }
        </style>
        <?php
    }
}