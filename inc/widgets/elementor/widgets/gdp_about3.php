<?php

namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Gdp_about3 extends Widget_Base {

    public function get_name() {
        return 'gdp_about3';
    }

    public function get_title() {
        return 'GDP About Section 3';
    }

    public function get_icon() {
        return 'eicon-person';
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
                'default' => 'Meet Our Team',
            ]
        );

        $this->add_control(
            'section_description',
            [
                'label' => 'Section Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'We are a group of passionate individuals dedicated to delivering excellence.',
            ]
        );

        // Team Members
        $repeater = new Repeater();

        $repeater->add_control(
            'name',
            [
                'label' => 'Name',
                'type' => Controls_Manager::TEXT,
                'default' => 'John Doe',
            ]
        );

        $repeater->add_control(
            'position',
            [
                'label' => 'Position',
                'type' => Controls_Manager::TEXT,
                'default' => 'CEO',
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => 'Image',
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'team_members',
            [
                'label' => 'Team Members',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'name' => 'John Doe',
                        'position' => 'CEO',
                    ],
                    [
                        'name' => 'Jane Smith',
                        'position' => 'Creative Director',
                    ],
                ],
                'title_field' => '{{{ name }}} - {{{ position }}}',
            ]
        );

        // Company Values
        $values_repeater = new Repeater();

        $values_repeater->add_control(
            'value_title',
            [
                'label' => 'Value Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Innovation',
            ]
        );

        $values_repeater->add_control(
            'value_description',
            [
                'label' => 'Value Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'We constantly push boundaries and embrace new ideas.',
            ]
        );

        $this->add_control(
            'company_values',
            [
                'label' => 'Company Values',
                'type' => Controls_Manager::REPEATER,
                'fields' => $values_repeater->get_controls(),
                'default' => [
                    [
                        'value_title' => 'Innovation',
                        'value_description' => 'We constantly push boundaries and embrace new ideas.',
                    ],
                    [
                        'value_title' => 'Collaboration',
                        'value_description' => 'We believe in the power of teamwork and shared success.',
                    ],
                ],
                'title_field' => '{{{ value_title }}}',
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

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="gdp-about-section-3 bg-gray-50 py-20">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="gdp-section-title text-4xl font-bold mb-6 animate__animated animate__fadeInDown"><?php echo $settings['section_title']; ?></h2>
                    <p class="gdp-section-description text-xl text-gray-600 max-w-3xl mx-auto animate__animated animate__fadeInUp"><?php echo $settings['section_description']; ?></p>
                </div>

                <!-- Team Members -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-20">
                    <?php foreach ($settings['team_members'] as $index => $member) : ?>
                        <div class="team-member text-center animate__animated animate__fadeInUp" data-wow-delay="<?php echo 0.2 * $index; ?>s">
                            <div class="relative overflow-hidden rounded-full mb-6 mx-auto w-48 h-48">
                                <img src="<?php echo $member['image']['url']; ?>" alt="<?php echo $member['name']; ?>" class="object-cover w-full h-full transition-transform duration-300 transform hover:scale-110">
                            </div>
                            <h3 class="text-2xl font-semibold mb-2"><?php echo $member['name']; ?></h3>
                            <p class="text-gray-600"><?php echo $member['position']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Company Values -->
                <div class="bg-white rounded-lg shadow-lg p-10">
                    <h3 class="text-3xl font-bold mb-8 text-center">Our Core Values</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <?php foreach ($settings['company_values'] as $index => $value) : ?>
                            <div class="value-card p-6 border-2 border-gray-200 rounded-lg transition-all duration-300 hover:border-blue-500 animate__animated animate__fadeInUp" data-wow-delay="<?php echo 0.2 * $index; ?>s">
                                <h4 class="text-xl font-semibold mb-4"><?php echo $value['value_title']; ?></h4>
                                <p class="text-gray-600"><?php echo $value['value_description']; ?></p>
                             </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}