<?php
namespace Elementor_Custom_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH')) exit;

class Gdp_hero4 extends Widget_Base {

    public function get_name() {
        return 'gdp_hero4';
    }

    public function get_title() {
        return __('GDP Creative Hero 4', 'gdp');
    }

    public function get_icon() {
        return 'eicon-header';
    }

    public function get_categories() {
        return ['gdp_widget'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'gdp'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'pre_title',
            [
                'label' => __('Pre Title', 'gdp'),
                'type' => Controls_Manager::TEXT,
                'default' => __('WELCOME TO', 'gdp'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'gdp'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Our Creative Agency', 'gdp'),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Description', 'gdp'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('We craft digital experiences that inspire and innovate. Let\'s bring your vision to life.', 'gdp'),
            ]
        );

        $this->add_control(
            'primary_button_text',
            [
                'label' => __('Primary Button Text', 'gdp'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Get Started', 'gdp'),
            ]
        );

        $this->add_control(
            'primary_button_link',
            [
                'label' => __('Primary Button Link', 'gdp'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'gdp'),
            ]
        );

        $this->add_control(
            'secondary_button_text',
            [
                'label' => __('Secondary Button Text', 'gdp'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Our Work', 'gdp'),
            ]
        );

        $this->add_control(
            'secondary_button_link',
            [
                'label' => __('Secondary Button Link', 'gdp'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'gdp'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'gdp'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'label' => __('Background', 'gdp'),
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .hero-background',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Title Typography', 'gdp'),
                'selector' => '{{WRAPPER}} .hero-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'title_text_shadow',
                'selector' => '{{WRAPPER}} .hero-title',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="relative min-h-screen flex items-center justify-center overflow-hidden">
            <div class="hero-background absolute inset-0 bg-cover bg-center transform scale-105 transition-transform duration-1000 hover:scale-110"></div>
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="relative z-10 text-center text-white p-8 max-w-4xl mx-auto">
                <span class="inline-block px-4 py-2 bg-blue-600 text-sm font-semibold rounded-full mb-4 animate__animated animate__fadeInDown"><?php echo esc_html($settings['pre_title']); ?></span>
                <h1 class="hero-title text-6xl font-extrabold mb-6 animate__animated animate__fadeInUp"><?php echo wp_kses_post($settings['title']); ?></h1>
                <p class="text-xl mb-10 animate__animated animate__fadeInUp animate__delay-1s"><?php echo esc_html($settings['description']); ?></p>
                <div class="flex flex-wrap justify-center gap-4 animate__animated animate__fadeInUp animate__delay-2s">
                    <?php if ($settings['primary_button_text']) : ?>
                        <a href="<?php echo esc_url($settings['primary_button_link']['url']); ?>" class="group relative inline-flex items-center px-8 py-4 bg-blue-600 overflow-hidden rounded-full">
                            <span class="absolute w-full h-full bg-blue-700 left-0 -translate-x-full group-hover:translate-x-0 transition-transform duration-300"></span>
                            <span class="relative flex items-center gap-2 text-white font-semibold">
                                <?php echo esc_html($settings['primary_button_text']); ?>
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </span>
                        </a>
                    <?php endif; ?>
                    <?php if ($settings['secondary_button_text']) : ?>
                        <a href="<?php echo esc_url($settings['secondary_button_link']['url']); ?>" class="group inline-flex items-center px-8 py-4 border-2 border-white/30 hover:border-white/60 rounded-full transition-colors">
                            <span class="flex items-center gap-2 text-white font-semibold">
                                <?php echo esc_html($settings['secondary_button_text']); ?>
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <style>
            @keyframes gradientAnimation { 0% { background-position: 0% 50%; } 
                100% { background-position: 100% 50%; } 
            }
            .hero-background {
                animation: gradientAnimation 3s ease infinite;
                background-size: 200% 200%;
            }
        </style>
        <?php
    }
}