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

class Gdp_about5 extends Widget_Base {

    public function get_name() {
        return 'gdp_about5';
    }

    public function get_title() {
        return 'GDP About Section 5 - Vision, Mission & Awards';
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
                'default' => 'Our Vision & Mission',
            ]
        );

        $this->add_control(
            'section_description',
            [
                'label' => 'Section Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Guiding principles that shape our journey and define our purpose.',
            ]
        );

        $this->add_control(
            'vision_title',
            [
                'label' => 'Vision Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Our Vision',
            ]
        );

        $this->add_control(
            'vision_content',
            [
                'label' => 'Vision Content',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'To be the global leader in innovative solutions, empowering businesses and individuals to thrive in the digital age.',
            ]
        );

        $this->add_control(
            'mission_title',
            [
                'label' => 'Mission Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Our Mission',
            ]
        );

        $this->add_control(
            'mission_content',
            [
                'label' => 'Mission Content',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'We are committed to delivering cutting-edge technology solutions that drive growth, foster innovation, and create lasting value for our clients and communities.',
            ]
        );

        $this->end_controls_section();

        // Awards Section
        $this->start_controls_section(
            'awards_section',
            [
                'label' => 'Awards',
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $awards_repeater = new Repeater();

        $awards_repeater->add_control(
            'award_icon',
            [
                'label' => 'Award Icon',
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-trophy',
                    'library' => 'solid',
                ],
            ]
        );

        $awards_repeater->add_control(
            'award_title',
            [
                'label' => 'Award Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Best Innovation Award',
            ]
        );

        $awards_repeater->add_control(
            'award_description',
            [
                'label' => 'Award Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Recognized for our groundbreaking solutions in the tech industry.',
            ]
        );

        $this->add_control(
            'awards_list',
            [
                'label' => 'Awards',
                'type' => Controls_Manager::REPEATER,
                'fields' => $awards_repeater->get_controls(),
                'default' => [
                    [
                        'award_title' => 'Best Innovation Award',
                        'award_description' => 'Recognized for our groundbreaking solutions in the tech industry.',
                    ],
                    [
                        'award_title' => 'Customer Satisfaction Excellence',
                        'award_description' => 'Awarded for maintaining the highest standards of customer service.',
                    ],
                ],
                'title_field' => '{{{ award_title }}}',
            ]
        );

        $this->end_controls_section();

        // Partners Section
        $this->start_controls_section(
            'partners_section',
            [
                'label' => 'Partners',
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $partners_repeater = new Repeater();

        $partners_repeater->add_control(
            'partner_logo',
            [
                'label' => 'Partner Logo',
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $partners_repeater->add_control(
            'partner_name',
            [
                'label' => 'Partner Name',
                'type' => Controls_Manager::TEXT,
                'default' => 'Partner Company',
            ]
        );

        $this->add_control(
            'partners_list',
            [
                'label' => 'Partners',
                'type' => Controls_Manager::REPEATER,
                'fields' => $partners_repeater->get_controls(),
                'default' => [
                    [
                        'partner_name' => 'Partner Company 1',
                    ],
                    [
                        'partner_name' => 'Partner Company 2',
                    ],
                ],
                'title_field' => '{{{ partner_name }}}',
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
                'name' => 'content_typography',
                'label' => 'Content Typography',
                'selector' => '{{WRAPPER}} .gdp-content',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="gdp-about-section-5 bg-gray-100 py-20">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="gdp-section-title text-4xl font-bold mb-6 animate__animated animate__fadeInDown"><?php echo $settings['section_title']; ?></h2>
                    <p class="gdp-content text-xl text-gray-600 max-w-3xl mx-auto animate__animated animate__fadeInUp"><?php echo $settings['section_description']; ?></p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap -12 mb-20">
                    <!-- Vision -->
                    <div class="bg-white p-8 rounded-lg shadow-lg animate__animated animate__fadeInLeft">
                        <h3 class="text-3xl font-bold mb-6 text-blue-600"><?php echo $settings['vision_title']; ?></h3>
                        <p class="gdp-content text-lg text-gray-700"><?php echo $settings['vision_content']; ?></p>
                    </div>

                    <!-- Mission -->
                    <div class="bg-white p-8 rounded-lg shadow-lg animate__animated animate__fadeInRight">
                        <h3 class="text-3xl font-bold mb-6 text-green-600"><?php echo $settings['mission_title']; ?></h3>
                        <p class="gdp-content text-lg text-gray-700"><?php echo $settings['mission_content']; ?></p>
                    </div>
                </div>

                <!-- Awards -->
                <div class="mt-20">
                    <h3 class="text-3xl font-bold mb-12 text-center">Our Awards</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2  lg:grid-cols-3 gap-8">
                        <?php foreach ($settings['awards_list'] as $index => $award) : ?>
                            <div class="bg-white p-8 rounded-lg shadow-lg animate__animated animate__fadeInUp" data-wow-delay="<?php echo 0.2 * $index; ?>s">
                                <div class="text-4xl text-blue-500 mb-4">
                                    <?php \Elementor\Icons_Manager::render_icon($award['award_icon'], ['aria-hidden' => 'true']); ?>
                                </div>
                                <h4 class="text-2xl font-bold mb-4"><?php echo $award['award_title']; ?></h4>
                                <p class="text-lg text-gray-700"><?php echo $award['award_description']; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Partners -->
                <div class="mt-20">
                    <h3 class="text-3xl font-bold mb-12 text-center">Our Partners</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2  lg:grid-cols-3 gap-8">
                        <?php foreach ($settings['partners_list'] as $index => $partner) : ?>
                            <div class="bg-white p-8 rounded-lg shadow-lg animate__animated animate__fadeInUp" data-wow-delay="<?php echo 0.2 * $index; ?>s">
                                <img src="<?php echo $partner['partner_logo']['url']; ?>" alt="<?php echo $partner['partner_name']; ?>" class="w-24 h-24 mb-4">
                                <h4 class="text-2xl font-bold mb-4"><?php echo $partner['partner_name']; ?></h4>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}