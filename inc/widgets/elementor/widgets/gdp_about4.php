<?php

namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Utils;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Gdp_about4 extends Widget_Base {

    public function get_name() {
        return 'gdp_about4';
    }

    public function get_title() {
        return 'GDP About Section 4';
    }

    public function get_icon() {
        return 'eicon-inner-section';
    }

    public function get_categories() {
        return ['gdp-category'];
    }

    public function get_script_depends() {
        return ['vanilla-tilt', 'count-up'];
    }

    protected function register_controls() {
        // Hero Section Controls
        $this->start_controls_section(
            'hero_section',
            [
                'label' => 'Hero Section',
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'background_video',
            [
                'label' => 'Background Video URL',
                'type' => Controls_Manager::MEDIA,
                'media_type' => 'video',
            ]
        );

        $this->add_control(
            'main_heading',
            [
                'label' => 'Main Heading',
                'type' => Controls_Manager::TEXT,
                'default' => 'Transforming Ideas Into Digital Reality',
            ]
        );

        $this->add_control(
            'sub_heading',
            [
                'label' => 'Sub Heading',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Innovation • Creativity • Excellence',
            ]
        );

        $this->end_controls_section();

        // Statistics Section
        $this->start_controls_section(
            'stats_section',
            [
                'label' => 'Statistics',
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'stat_number',
            [
                'label' => 'Number',
                'type' => Controls_Manager::NUMBER,
                'default' => 100,
            ]
        );

        $repeater->add_control(
            'stat_suffix',
            [
                'label' => 'Suffix',
                'type' => Controls_Manager::TEXT,
                'default' => '+',
            ]
        );

        $repeater->add_control(
            'stat_title',
            [
                'label' => 'Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Projects Completed',
            ]
        );

        $this->add_control(
            'statistics',
            [
                'label' => 'Statistics Items',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'stat_number' => '250',
                        'stat_suffix' => '+',
                        'stat_title' => 'Projects Completed',
                    ],
                    [
                        'stat_number' => '50',
                        'stat_suffix' => 'M+',
                        'stat_title' => 'Revenue Generated',
                    ],
                    [
                        'stat_number' => '100',
                        'stat_suffix' => '%',
                        'stat_title' => 'Client Satisfaction',
                    ],
                ],
                'title_field' => '{{{ stat_title }}}',
            ]
        );

        $this->end_controls_section();

        // Features Section
        $this->start_controls_section(
            'features_section',
            [
                'label' => 'Features',
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $features_repeater = new Repeater();

        $features_repeater->add_control(
            'feature_icon',
            [
                'label' => 'Icon',
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],
            ]
        );

        $features_repeater->add_control(
            'feature_title',
            [
                'label' => 'Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Innovation First',
            ]
        );

        $features_repeater->add_control(
            'feature_description',
            [
                'label' => 'Description',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'We bring innovative solutions to every project.',
            ]
        );

        $this->add_control(
            'features',
            [
                'label' => 'Features',
                'type' => Controls_Manager::REPEATER,
                'fields' => $features_repeater->get_controls(),
                'default' => [
                    [
                        'feature_title' => 'Innovation First',
                        'feature_description' => 'We bring innovative solutions to every project.',
                    ],
                    [
                        'feature_title' => 'Client-Centric',
                        'feature_description' => 'Your success is our priority.',
                    ],
                ],
                'title_field' => '{{{ feature_title }}}',
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
                'name' => 'heading_typography',
                'label' => 'Heading Typography',
                'selector' => '{{WRAPPER}} .gdp-main-heading',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <!-- Hero Section with Video Background -->
        <div class="gdp-about-hero relative h-screen">
            <div class="absolute inset-0 overflow-hidden">
                <video class="object-cover w-full h-full" autoplay loop muted playsinline>
                    <source src="<?php echo $settings['background_video']['url']; ?>" type="video/mp4">
                </video>
                <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            </div>
            
            <div class="relative z-10 container mx-auto px-4 h-full flex items-center">
                <div class="text-center mx-auto max-w-4xl">
                    <h1 class="gdp-main-heading text-5xl md:text-7xl font-bold text-white mb-6 animate__animated animate__fadeInDown">
                        <?php echo $settings['main_heading']; ?>
                    </h1>
                    <p class="text-xl md:text-2xl text-white opacity-90 animate__animated animate__fadeInUp">
                        <?php echo $settings['sub_heading']; ?>
                    </p>
                </div>
            </div>
        </div>
                <!-- Statistics Section -->
                <div class="gdp-statistics bg-gradient-to-r from-blue-500 to-purple-600 py-20">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <?php foreach ($settings['statistics'] as $index => $stat) : ?>
                        <div class="text-center animate__animated animate__fadeInUp" data-wow-delay="<?php echo 0.2 * $index; ?>s">
                            <div class="text-5xl font-bold text-white mb-2">
                                <span class="gdp-counter" data-count="<?php echo $stat['stat_number']; ?>">0</span><?php echo $stat['stat_suffix']; ?>
                            </div>
                            <div class="text-xl text-white opacity-80"><?php echo $stat['stat_title']; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="gdp-features bg-gray-100 py-20">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl font-bold text-center mb-16 animate__animated animate__fadeInDown">Our Core Values</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($settings['features'] as $index => $feature) : ?>
                        <div class="bg-white p-8 rounded-lg shadow-lg transition-all duration-300 hover:shadow-xl animate__animated animate__fadeInUp" data-wow-delay="<?php echo 0.2 * $index; ?>s" data-tilt>
                            <div class="text-4xl text-blue-500 mb-4">
                                <?php \Elementor\Icons_Manager::render_icon($feature['feature_icon'], ['aria-hidden' => 'true']); ?>
                            </div>
                            <h3 class="text-2xl font-semibold mb-4"><?php echo $feature['feature_title']; ?></h3>
                            <p class="text-gray-600"><?php echo $feature['feature_description']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <script>
            // Initialize CountUp.js
            document.addEventListener('DOMContentLoaded', function() {
                const counters = document.querySelectorAll('.gdp-counter');
                counters.forEach(counter => {
                    const target = parseInt(counter.getAttribute('data-count'));
                    const countUp = new CountUp(counter, target, {
                        duration: 2.5,
                        separator: ',',
                    });
                    if (!countUp.error) {
                        countUp.start();
                    } else {
                        console.error(countUp.error);
                    }
                });
            });

            // Initialize Vanilla Tilt
            VanillaTilt.init(document.querySelectorAll("[data-tilt]"), {
                max: 15,
                speed: 400,
                glare: true,
                "max-glare": 0.2,
            });
        </script>
        <?php
    }
}