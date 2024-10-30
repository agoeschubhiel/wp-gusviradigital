<?php

namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Gdp_about1 extends Widget_Base {

    public function get_name() {
        return 'gdp_about1';
    }

    public function get_title() {
        return 'GDP About Section 1';
    }

    public function get_icon() {
        return 'eicon-info-box';
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

        // Company Story
        $this->add_control(
            'company_story_title',
            [
                'label' => 'Story Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Our Story'
            ]
        );

        $this->add_control(
            'company_story_desc',
            [
                'label' => 'Story Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Share your company\'s journey here...'
            ]
        );

        // Core Values
        $this->add_control(
            'core_values_title',
            [
                'label' => 'Core Values Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Our Core Values'
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'value_title',
            [
                'label' => 'Value Title',
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'value_description',
            [
                'label' => 'Value Description',
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        $repeater->add_control(
            'value_icon',
            [
                'label' => 'Icon',
                'type' => Controls_Manager::ICONS,
            ]
        );

        $this->add_control(
            'core_values_list',
            [
                'label' => 'Core Values',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'value_title' => 'Innovation',
                        'value_description' => 'Pushing boundaries with creative solutions',
                    ],
                ],
                'title_field' => '{{{ value_title }}}',
            ]
        );

        // Stats Section
        $stats_repeater = new Repeater();

        $stats_repeater->add_control(
            'stat_number',
            [
                'label' => 'Number',
                'type' => Controls_Manager::NUMBER,
                'default' => 100
            ]
        );

        $stats_repeater->add_control(
            'stat_title',
            [
                'label' => 'Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Projects'
            ]
        );

        $this->add_control(
            'stats_list',
            [
                'label' => 'Statistics',
                'type' => Controls_Manager::REPEATER,
                'fields' => $stats_repeater->get_controls(),
                'default' => [
                    [
                        'stat_number' => '100',
                        'stat_title' => 'Projects Completed',
                    ],
                ],
                'title_field' => '{{{ stat_title }}}',
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
        <div class="gdp-about-section container mx-auto px-4 py-20">
            <!-- Story Section -->
            <div class="gdp-story-section mb-16 text-center animate__animated animate__fadeIn">
                <h2 class="gdp-section-title text-3xl font-bold mb-6"><?php echo $settings['company_story_title']; ?></h2>
                <p class="gdp-story-desc text-lg max-w-2xl mx-auto"><?php echo $settings['company_story_desc']; ?></p>
            </div>

            <!-- Core Values Section -->
            <div class="gdp-values-section mb-16 animate__animated animate__fadeInUp" data-wow-delay="0.3s">
                <h2 class="gdp-section-title text-3xl font-bold mb-8 text-center"><?php echo $settings['core_values_title']; ?></h2>
                <div class="gdp-values-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($settings['core_values_list'] as $index => $value) : ?>
                        <div class="gdp-value-card bg-white rounded-lg shadow-md p-6 transition-transform duration-300 hover:scale-105 animate__animated animate__fadeInLeft" data-wow-delay="<?php echo 0.2 * $index; ?>s">
                            <div class="text-4xl mb-4">
                                <?php Icons_Manager::render_icon($value['value_icon'], ['aria-hidden' => 'true']); ?>
                            </div>
                            <h3 class="text-xl font-semibold mb-2"><?php echo $value['value_title']; ?></h3>
                            <p class="text-gray-600"><?php echo $value['value_description']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="gdp-stats-section animate__animated animate__fadeInUp" data-wow-delay="0.6s">
                <div class="gdp-stats-grid grid grid-cols-2 md:grid-cols-4 gap-8">
                    <?php foreach ($settings['stats_list'] as $index => $stat) : ?>
                        <div class="gdp-stat-card text-center animate__animated animate__zoomIn" data-wow-delay="<?php echo 0.2 * $index; ?>s">
                            <span class="gdp-stat-number text-4xl font-bold block mb-2"><?php echo $stat['stat_number']; ?>+</span>
                            <h4 class="text-lg text-gray-600"><?php echo $stat['stat_title']; ?></h4>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php
    }
}